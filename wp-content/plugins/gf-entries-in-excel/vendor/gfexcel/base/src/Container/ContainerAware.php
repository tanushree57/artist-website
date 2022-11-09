<?php

namespace GFExcel\Container;

use League\Container\Container;
use Psr\Container\ContainerInterface;

/**
 * Trait that makes a class contiainer aware.
 * @since $ver$
 */
trait ContainerAware
{
    /**
     * Holds the container instance.
     * @since $ver$
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container instance for a class.
     * @since $ver$
     * @param ContainerInterface $container The container instance
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get the container instance for this class.
     * @since $ver$
     * @return Container|null The container instance.
     */
    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }
}
