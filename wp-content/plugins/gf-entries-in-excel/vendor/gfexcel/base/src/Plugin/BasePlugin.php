<?php

namespace GFExcel\Plugin;

use GFExcel\Addon\AddonInterface;
use League\Container\Container;

/**
 * A base for a plugin to extend from.
 * @since $ver$
 */
abstract class BasePlugin
{
    /**
     * The {@see AddonInterface} classes.
     * @since $ver$
     * @var string[]
     */
    protected $addons = [];

    /**
     * The container instance.
     * @since $ver$
     * @var Container
     */
    protected $container;

    /**
     * The assets directory for this plugin.
     * @since $ver$
     * @var string|null
     */
    private $assets_dir;

    /**
     * Creates the plugin.
     * @param Container $container The service container.
     * @param string|null $assets_dir The assets directory.
     */
    public function __construct(Container $container, string $assets_dir = null)
    {
        $this->container = $container;
        $this->assets_dir = $assets_dir;
    }

    /**
     * Register the available add-ons.
     * @since $ver$
     */
    public function registerAddOns(): self
    {
        foreach ($this->addons as $addon) {
            if (!$this->container->has($addon)) {
                throw new \RuntimeException('This add-on does not exist.');
            }

            $instance = $this->container->get($addon);
            if (!$instance instanceof AddonInterface) {
                throw new \RuntimeException(
                    sprintf('This add-on does not implement the "%s" interface.', AddonInterface::class)
                );
            }

            $instance::set_instance($instance);
            \GFAddOn::register($addon);

            if ($this->assets_dir) {
                $instance->setAssetsDir($this->assets_dir);
            }
        }

        return $this;
    }
}
