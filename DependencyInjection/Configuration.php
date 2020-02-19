<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('google_maps');

        $treeBuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('api_key')->defaultValue('%env(GOOGLE_API_KEY)%')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
