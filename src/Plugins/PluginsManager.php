<?php

namespace MvcLite\Plugins;

use MvcliteCore\Plugins\Exceptions\NotFoundPluginException;
use MvcliteCore\Plugins\Exceptions\PluginAlreadyExistsException;

class PluginsManager
{
    private static array $loadedPlugins = [];

    /**
     * Load all existing enabled plugins.
     */
    public static function loadPlugins(): void
    {
        foreach (self::getEnabledPlugins() as $plugin)
        {
            if (!self::isPluginExists($plugin))
            {
                $error = new NotFoundPluginException($plugin);
                $error->render();
            }

            if (self::isPluginLoaded($plugin))
            {
                $error = new PluginAlreadyExistsException($plugin);
                $error->render();
            }

            $pluginName = (new $plugin())
                ->getName();

            self::$loadedPlugins[$pluginName] = $plugin;
        }
    }

    /**
     * @return array Enabled plugins array
     */
    private static function getEnabledPlugins(): array
    {
        return include "plugins.php";
    }

    /**
     * @param string $plugin Plugin class name
     * @return bool If the given plugin class exists
     */
    public static function isPluginExists(string $plugin): bool
    {
        return class_exists($plugin);
    }

    /**
     * @param string $plugin Plugin class name
     * @return bool If the given plugin class is already
     *              loaded
     */
    public static function isPluginLoaded(string $plugin): bool
    {
        return in_array($plugin, self::getLoadedPlugins());
    }

    /**
     * @return array Loaded plugins array
     */
    public static function getLoadedPlugins(): array
    {
        return self::$loadedPlugins;
    }

    /**
     * @param string $eventMethodName Event plugin method
     *                                name
     */
    public static function loadEvent(string $eventMethodName): void
    {
        foreach (self::getLoadedPlugins() as $plugin)
        {
            $pluginInstance = new $plugin();
            $pluginInstance->{$eventMethodName}();
        }
    }
}