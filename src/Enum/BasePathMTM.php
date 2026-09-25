<?php

namespace ASB\MorphMTM\Enum;


class BasePathMTM
{

    public const CommandTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'command.php';
    public const FacadeTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'facade.php';
    public const MigrationBasicTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'migration.php';
    public const ModelTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'model.php';
    public const ObserverTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'observer.php';
    public const RequestTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'request.php';
    public const TraitTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'trait.php';
    public const ProviderTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'provider.php';
    public const RouteTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'route.php';
    public const ControllerTemplate = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'Builder' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'controller.php';
    public const Prefix = 'MTM';
    public const PrefixNameSpaceServiceProvider = 'Rack\\Morph\\MTM\\';
    public const MiddleNameSpaceServiceProvider = '\\Providers\\';
    public const SpaceNameServiceProvider = self::PrefixNameSpaceServiceProvider . '%s' . self::MiddleNameSpaceServiceProvider . '%sServiceProvider';

    public static function __callStatic($name, $arguments)
    {
        if (method_exists(static::class, $name)) {
            return static::$name();
        }
        return null;
    }

    public static function Rack(): string
    {
        return base_path('Rack') . DIRECTORY_SEPARATOR;
    }

    public static function Morph(): string
    {
        return self::Rack() . "Morph" . DIRECTORY_SEPARATOR;
    }

    public static function Package(): string
    {
        return self::Morph() . "MTM" . DIRECTORY_SEPARATOR;
    }

    public static function ModuleDirectory(): string
    {
        return self::Package() . '%s' . DIRECTORY_SEPARATOR;
    }

    public static function App()
    {
        return self::ModuleDirectory() . "App" . DIRECTORY_SEPARATOR;
    }

    public static function Http()
    {
        return self::App() . "Http" . DIRECTORY_SEPARATOR;
    }

    public static function Model()
    {
        return self::App() . "Models" . DIRECTORY_SEPARATOR;
    }
    public static function Observer()
    {
        return self::App() . "Observers" . DIRECTORY_SEPARATOR;
    }

    public static function Controller()
    {
        return self::Http() . "Controllers" . DIRECTORY_SEPARATOR;
    }

    public static function Request()
    {
        return self::Http() . "Requests" . DIRECTORY_SEPARATOR;
    }

    public static function Commands()
    {

        return self::App() . "Commands" . DIRECTORY_SEPARATOR;
    }

    public static function Facade()
    {
        return self::ModuleDirectory() . "Facades" . DIRECTORY_SEPARATOR;
    }

    public static function Database()
    {
        return self::ModuleDirectory() . "database" . DIRECTORY_SEPARATOR;
    }

    public static function Migration()
    {
        return self::Database() . "migrations" . DIRECTORY_SEPARATOR;
    }

    public static function Trait()
    {
        return self::ModuleDirectory() . "Traits" . DIRECTORY_SEPARATOR;
    }

    public static function Route()
    {
        return self::ModuleDirectory() . "routes" . DIRECTORY_SEPARATOR;
    }

    public static function Provider()
    {
        return self::ModuleDirectory() . "Providers" . DIRECTORY_SEPARATOR;
    }
}
