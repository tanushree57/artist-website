<?php

namespace GFExcel\ServiceProvider;

use GFExcel\Action\ActionAwareInterface;
use League\Container\Definition\DefinitionInterface;
use League\Container\ServiceProvider\AbstractServiceProvider as LeagueAbstractServiceProviderAlias;

/**
 * Abstract service provider that provides helper methods.
 * @since $ver$
 */
abstract class AbstractServiceProvider extends LeagueAbstractServiceProviderAlias
{
    /**
     * Helper method to quickly add an action.
     * @since $ver$
     * @param string $id The id of the definition.
     * @param mixed $concrete The concrete implementation.
     * @param bool|null $shared Whether this is a shared instance.
     * @return DefinitionInterface The definition.
     */
    protected function addAction(string $id, $concrete = null, ?bool $shared = null): DefinitionInterface
    {
        return $this->getLeagueContainer()
            ->add($id, $concrete, $shared)
            ->addTag(ActionAwareInterface::ACTION_TAG);
    }
}
