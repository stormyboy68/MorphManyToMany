<?php

namespace ASB\MorphToMany\Enum;

use ASB\MorphToMany\Console\Commands\build;

class BasePathMTM
{
    public const External = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Rack" . DIRECTORY_SEPARATOR . "MTM" . DIRECTORY_SEPARATOR;
    public const ModuleDirectory = self::External . '%s' . DIRECTORY_SEPARATOR;
    public const App = self::ModuleDirectory . "App" . DIRECTORY_SEPARATOR;
    public const Http = self::App . "Http" . DIRECTORY_SEPARATOR;
    public const Model = self::App . "Models" . DIRECTORY_SEPARATOR;

    public const Controller = self::Http . "Controllers" . DIRECTORY_SEPARATOR;
    public const Request = self::Http . "Requests" . DIRECTORY_SEPARATOR;
    public const Commands = self::App . "Commands" . DIRECTORY_SEPARATOR;
    public const Facade = self::ModuleDirectory . "Facades" . DIRECTORY_SEPARATOR;
    public const Database = self::ModuleDirectory . "database" . DIRECTORY_SEPARATOR;
    public const Migration = self::Database . "migrations" . DIRECTORY_SEPARATOR;
    public const Trait = self::ModuleDirectory . "Traits" . DIRECTORY_SEPARATOR;
    public const Route = self::ModuleDirectory . "routes" . DIRECTORY_SEPARATOR;
    const Provider = self::ModuleDirectory . "Providers" . DIRECTORY_SEPARATOR;
    public const CommandTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'command.php';
    public const FacadeTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'facade.php';
    public const MigrationBasicTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'migrationBasic.php';
    public const MigrationPivotTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'migrationPivot.php';
    public const ModelTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'model.php';
    public const RequestTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'request.php';
    public const TraitTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'trait.php';
    public const ProviderTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'provider.php';
    public const RouteTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'route.php';
    public const ControllerTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'controller.php';
    public const Singleton = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
    . 'Providers' . DIRECTORY_SEPARATOR . 'singleton.php';
    public const Resolve = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
    . 'Providers' . DIRECTORY_SEPARATOR . 'resolveRelation.php';
    public const Prefix = 'MTM';
    const PrefixNameSpaceServiceProvider = 'Rack\\MTM\\';
    const MiddleNameSpaceServiceProvider = '\\Providers\\';
    const SpaceNameServiceProvider = self::PrefixNameSpaceServiceProvider . '%s' . self::MiddleNameSpaceServiceProvider . '%sServiceProvider';
}
