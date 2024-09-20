<?php

namespace ASB\MorphMTM\Console\Commands;

use ASB\MorphMTM\Builder\operation\Provider;
use ASB\MorphMTM\Utility\CheckFile;
use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\Utility\File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;


class Remove extends Command implements PromptsForMissingInput
{
    protected $signature = 'mtm:remove
                            {module : Module name to be Removed}';

    protected $description = 'Remove a module with its Morph-Many-To-Many relations';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $module = ucfirst(strtolower($this->argument('module')));

        if (!CheckFile::checkModuleExists(['module' => $module])) {
            $this->components->error('the Model Can\'t find.');
            die;
        }
        Provider::removeProviderToConfigFile(sprintf(BasePathMTM::SpaceNameServiceProvider, $module, $module));
        $this->call('config:clear');
        File::removeModuleDirectory(sprintf(BasePathMTM::ModuleDirectory(), $module));
        $this->components->info(sprintf('%s [%s] removed successfully.', 'Model ', $module));
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'module' => ['Which Module do you want remove?', ''],
        ];
    }
}
