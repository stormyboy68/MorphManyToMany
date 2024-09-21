<?php

namespace ASB\MorphMTM\Console\Commands;


use ASB\MorphMTM\Builder\CommandBuilder;
use ASB\MorphMTM\Builder\ControllerBuilder;
use ASB\MorphMTM\Builder\FacadeBuilder;
use ASB\MorphMTM\Builder\MigrationBuilder;
use ASB\MorphMTM\Builder\ModelBuilder;
use ASB\MorphMTM\Builder\operation\Provider;
use ASB\MorphMTM\Builder\ProviderBuilder;
use ASB\MorphMTM\Builder\RequestBuilder;
use ASB\MorphMTM\Builder\RouteBuilder;
use ASB\MorphMTM\Builder\TraitBuilder;
use ASB\MorphMTM\Enum\BasePathMTM;
use ASB\MorphMTM\utility\CheckFile;
use ASB\MorphMTM\Utility\File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Str;

class build extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtm:build
                            {module : the Module Name}
                            {--force : Create the Module of files even if them already exists}
                            {--migrate : Run the database migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the model with its MorphByMany-MorphedByMany relations';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $force = $this->option('force');
        $data['module'] = $this->argument('module');
        if (CheckFile::checkModuleExists($data) && !$force) {
            $this->components->error('Module is exist');
            die;
        }

        $data['model'] = $this->ask('What is the Model Name', ucfirst(strtolower($this->argument('module'))));
        $data['plural'] = $this->ask('What is the Model Plural Name', Str::plural(strtolower($this->argument('module'))));
        $data['relationName'] = $this->ask('What is the Model Relation Name', strtolower($this->argument('module')) . 'able');
        $data['pluralRelation'] = Str::plural($data['relationName']);
        File::initializeDirectories($data);

        $res['Model'] = ModelBuilder::handle($data);
        $res['Migration'] = MigrationBuilder::handle($data);
        $res['Facade'] = FacadeBuilder::handle($data);
        $res['Commands'] = CommandBuilder::handle($data);
        $res['Controller'] = ControllerBuilder::handle($data);
        $res['Trait'] = TraitBuilder::handle($data);
        $res['Request'] = RequestBuilder::handle($data);
        $res['router'] = RouteBuilder::handle($data);
        $res['Provider'] = ProviderBuilder::handle($data);

        Provider::addProviderToConfigFile(rtrim(sprintf(BasePathMTM::SpaceNameServiceProvider, $data['model'], $data['model']), DIRECTORY_SEPARATOR));
        !in_array(false, $res) ?: $this->components->error(sprintf('%s [%s] %s unsuccessfully.', 'Model ', $data['model'],
            $force ? 'recreated' : 'created'));
        in_array(false, $res) ?: $this->components->info(sprintf('%s [%s] %s successfully.', 'Model ', $data['model'],
            $force ? 'recreated' : 'created'));

        $this->migration();
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'module' => [' enter Module name do you want create?', '']
        ];
    }

    /**
     * @return void
     */
    public function migration(): void
    {
        if ($this->option('migrate')) {
            $this->call('migrate');
        }
    }

}
