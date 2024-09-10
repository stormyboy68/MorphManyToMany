<?php

namespace ASB\MorphToMany\Console\Commands;

use App\Providers\AppServiceProvider;
use ASB\MorphToMany\Builder\CommandBuilder;
use ASB\MorphToMany\Builder\ControllerBuiler;
use ASB\MorphToMany\Builder\FacadeBuilder;
use ASB\MorphToMany\Builder\MigrationBuilder;
use ASB\MorphToMany\Builder\ModelBuilder;
use ASB\MorphToMany\Builder\ProviderBuilder;
use ASB\MorphToMany\Builder\RequestBuilder;
use ASB\MorphToMany\Builder\ResolveRelBuilder;
use ASB\MorphToMany\Builder\RouteBuilder;
use ASB\MorphToMany\Builder\SingletonBuilder;
use ASB\MorphToMany\Builder\TraitBuilder;
use ASB\MorphToMany\Enum\BasePathMTM;
use ASB\MorphToMany\utility\CheckFile;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class build extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtm:build
                            {--force : Create the Model of files even if them already exists}
                            {--migrate : Run the database migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the model with its MorphByMany-MorphedByMany relations';

    private static function initializeDirectories($val): void
    {
        $paths = [
            'ModuleDirectory' => sprintf(BasePathMTM::ModuleDirectory, $val['model']),

            'App' => sprintf(BasePathMTM::App, $val['model']),
            'Commands' => sprintf(BasePathMTM::Commands, $val['model']),
            'Models' => sprintf(BasePathMTM::Model, $val['model']),

            'Http' => sprintf(BasePathMTM::Http, $val['model']),
            'Controller' => sprintf(BasePathMTM::Controller, $val['model']),
            'Request' => sprintf(BasePathMTM::Request, $val['model']),


            'database' => sprintf(BasePathMTM::Database, $val['model']),
            'migration' => sprintf(BasePathMTM::Migration, $val['model']),

            'facade' => sprintf(BasePathMTM::Facade, $val['model']),
            'trait' => sprintf(BasePathMTM::Trait, $val['model']),
            'routes' => sprintf(BasePathMTM::Route, $val['model']),
            'provider' => sprintf(BasePathMTM::Provider, $val['model']),

        ];
        foreach ($paths as $item) {
            if (!file_exists($item)) {
                mkdir($item);
            }
        }
    }

    private static function init(): void
    {
        if (!file_exists(BasePathMTM::External)) {
            mkdir(BasePathMTM::External);
        }
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $counter = 0;
        $models = config('mtm.models');
        $force = $this->option('force');
        self::init();
        foreach ($models as $val) {
            $val['model'] = ucfirst(strtolower($val['model']));
            $val['plural'] = Str::plural(strtolower(($val['model'])));
            $val['pluralRelation'] = Str::plural($val['relationName']);
            if (CheckFile::checkFilesModelExists($val) && !$force) continue;
            self::initializeDirectories($val);
            $counter++;

            $res['Model'] = ModelBuilder::handle($val);
            $res['Migration'] = MigrationBuilder::handle($val);
            $res['Facade'] = FacadeBuilder::handle($val);
            $res['Commands'] = CommandBuilder::handle($val);
            $res['Controller'] = ControllerBuiler::handle($val);
            $res['Trait'] = TraitBuilder::handle($val);
            $res['Request'] = RequestBuilder::handle($val);
            $res['router'] = RouteBuilder::handle($val);
            $res['Provider'] = ProviderBuilder::handle($val);

            ServiceProvider::addProviderToBootstrapFile(
                rtrim(sprintf(BasePathMTM::SpaceNameServiceProvider, $val['model'], $val['model']),DIRECTORY_SEPARATOR),
                $this->laravel->getBootstrapProvidersPath(),
            );

            !in_array(false, $res) ?: $this->components->error(sprintf('%s [%s] %s unsuccessfully.', 'Model ', $val['model'],
                $force ? 'recreated' : 'created'));
            in_array(false, $res) ?: $this->components->info(sprintf('%s [%s] %s successfully.', 'Model ', $val['model'],
                $force ? 'recreated' : 'created'));
        }
        if (!$counter) {
            $this->components->info('Nothing to create');
            die;
        }
        $this->migration();
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
