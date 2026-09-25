<?php

namespace ASB\MorphMTM\Traits;

use ASB\MorphMTM\Exceptions\DuplicateMtmModelException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait HasMtmModel
{
    protected static function mtmUniqueEnabled(): bool
    {
        return config('mtm.unique', 'check') !== 'none';
    }

    protected static function mtmUniqueUsesLock(): bool
    {
        return config('mtm.unique', 'check') === 'lock';
    }

    public static function mtmExists(string $title, ?string $modelType = null): bool
    {
        return static::query()
            ->where('title', $title)
            ->when($modelType, fn ($q) => $q->where('model_type', $modelType))
            ->whereNull('deleted_at')
            ->exists();
    }

    public static function mtmCreate(string $title, ?string $modelType = null): static
    {
        if (! static::mtmUniqueEnabled()) {
            return static::create(['title' => $title, 'model_type' => $modelType]);
        }

        if (static::mtmUniqueUsesLock()) {
            return static::mtmCreateWithLock($title, $modelType);
        }

        return static::mtmCreateWithCheck($title, $modelType);
    }

    protected static function mtmCreateWithCheck(string $title, ?string $modelType): static
    {
        if (static::mtmExists($title, $modelType)) {
            throw DuplicateMtmModelException::forTitle($title, $modelType);
        }
        return static::create(['title' => $title, 'model_type' => $modelType]);
    }

    protected static function mtmCreateWithLock(string $title, ?string $modelType): static
    {
        $lock = Cache::lock(
            static::mtmLockKey($title, $modelType),
            (int) config('mtm.lock.timeout', 10)
        );

        try {
            $lock->block((int) config('mtm.lock.wait', 3));
        } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
            throw DuplicateMtmModelException::lockFailed($title);
        }

        try {
            return DB::transaction(function () use ($title, $modelType) {
                if (static::mtmExists($title, $modelType)) {
                    throw DuplicateMtmModelException::forTitle($title, $modelType);
                }
                return static::create(['title' => $title, 'model_type' => $modelType]);
            });
        } finally {
            $lock->release();
        }
    }

    protected static function mtmLockKey(string $title, ?string $modelType): string
    {
        $prefix = config('mtm.lock.prefix', 'mtm:unique:');
        return $prefix . md5(static::class . '|' . $title . '|' . ($modelType ?? ''));
    }

    public function mtmUpdate(string $newTitle): static
    {
        if (! static::mtmUniqueEnabled() || $this->title === $newTitle) {
            $this->update(['title' => $newTitle]);
            return $this;
        }

        $modelType = $this->model_type ?? null;

        if (static::mtmUniqueUsesLock()) {
            $lock = Cache::lock(
                static::mtmLockKey($newTitle, $modelType),
                (int) config('mtm.lock.timeout', 10)
            );

            try {
                $lock->block((int) config('mtm.lock.wait', 3));
            } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
                throw DuplicateMtmModelException::lockFailed($this->title);
            }

            try {
                return DB::transaction(function () use ($newTitle, $modelType) {
                    if (static::mtmExists($newTitle, $modelType)) {
                        throw DuplicateMtmModelException::forTitle($newTitle, $modelType);
                    }
                    $this->update(['title' => $newTitle]);
                    return $this;
                });
            } finally {
                $lock->release();
            }
        }

        if (static::mtmExists($newTitle, $modelType)) {
            throw DuplicateMtmModelException::forTitle($newTitle, $modelType);
        }

        $this->update(['title' => $newTitle]);
        return $this;
    }

    public function mtmRestore(): static
    {
        if (! static::mtmUniqueEnabled()) {
            $this->restore();
            return $this;
        }

        $modelType = $this->model_type ?? null;

        if (static::mtmUniqueUsesLock()) {
            $lock = Cache::lock(
                static::mtmLockKey($this->title, $modelType),
                (int) config('mtm.lock.timeout', 10)
            );

            try {
                $lock->block((int) config('mtm.lock.wait', 3));
            } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
                throw DuplicateMtmModelException::lockFailed($this->title);
            }

            try {
                return DB::transaction(function () use ($modelType) {
                    if (static::mtmExists($this->title, $modelType)) {
                        throw DuplicateMtmModelException::cannotRestore($this->title);
                    }
                    $this->restore();
                    return $this;
                });
            } finally {
                $lock->release();
            }
        }

        if (static::mtmExists($this->title, $modelType)) {
            throw DuplicateMtmModelException::cannotRestore($this->title);
        }

        $this->restore();
        return $this;
    }
}
