<?php

namespace ASB\MorphMTM\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class UpgradeUniqueCommand extends Command
{
    protected $signature = 'mtm:upgrade-unique
                            {--dry-run : Show what would be done without executing}';

    protected $description = 'Drop old database-level unique indexes on MTM tables (from v1.x)';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $tables = $this->detectMtmTables();

        if (empty($tables)) {
            $this->warn('No MTM tables found. Nothing to do.');
            return self::SUCCESS;
        }

        $this->info('Found ' . count($tables) . ' MTM table(s):');
        foreach ($tables as $t) {
            $this->line("  - {$t}");
        }

        if ($dryRun) {
            $this->comment('Dry-run mode. No changes made.');
            return self::SUCCESS;
        }

        if (! $this->confirm('Proceed to drop unique indexes?', true)) {
            return self::SUCCESS;
        }

        foreach ($tables as $table) {
            $this->dropUniqueIndexes($table);
        }

        $this->info('✅ Done.');
        return self::SUCCESS;
    }

    protected function detectMtmTables(): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $rows = DB::select("
                SELECT DISTINCT TABLE_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE COLUMN_NAME = 'model_type'
                  AND TABLE_SCHEMA = DATABASE()
            ");
            return array_column($rows, 'TABLE_NAME');
        }

        if ($driver === 'pgsql') {
            $rows = DB::select("
                SELECT DISTINCT table_name
                FROM information_schema.columns
                WHERE column_name = 'model_type'
                  AND table_schema = 'public'
            ");
            return array_column($rows, 'table_name');
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("
                SELECT name FROM sqlite_master
                WHERE type='table' AND sql LIKE '%model_type%'
            ");
            return array_column($rows, 'name');
        }

        return [];
    }

    protected function dropUniqueIndexes(string $table): void
    {
        $this->line("Processing: {$table}");

        foreach ($this->getIndexes($table) as $index) {
            if (! $index['unique'] || $index['name'] === 'PRIMARY') continue;

            try {
                Schema::table($table, function ($t) use ($index) {
                    $t->dropUnique($index['name']);
                });
                $this->info("  ✓ Dropped unique: {$index['name']}");
            } catch (\Throwable $e) {
                $this->error("  ✗ Failed: {$e->getMessage()}");
            }
        }

        try {
            Schema::table($table, function ($t) {
                $t->index(['title', 'model_type', 'deleted_at']);
            });
            $this->info("  ✓ Added regular index");
        } catch (\Throwable $e) {
            $this->line("  · Index skipped");
        }
    }

    protected function getIndexes(string $table): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $rows = DB::select("SHOW INDEX FROM `{$table}`");
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row->Key_name] = [
                    'name'   => $row->Key_name,
                    'unique' => ! $row->Non_unique,
                ];
            }
            return array_values($grouped);
        }

        if ($driver === 'pgsql') {
            $rows = DB::select("
                SELECT indexname AS name, indexdef
                FROM pg_indexes WHERE tablename = ?
            ", [$table]);
            return array_map(fn ($r) => [
                'name'   => $r->name,
                'unique' => str_contains(strtolower($r->indexdef), 'unique'),
            ], $rows);
        }

        if ($driver === 'sqlite') {
            $rows = DB::select("PRAGMA index_list('{$table}')");
            return array_map(fn ($r) => [
                'name'   => $r->name,
                'unique' => (bool) $r->unique,
            ], $rows);
        }

        return [];
    }

}
