<?php

declare(strict_types=1);

namespace Puwnz\GoogleMapsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GoogleMapsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('google_maps', $config);
        $this->setParameters($config, 'google_maps', $container);
    }

    private function setParameters(array $parameters, string $base, ContainerBuilder $container): void
    {
        foreach ($parameters as $key => $value) {
            $namespace = $base . '.' . $key;
            $container->setParameter($namespace, $value);

            if (\is_array($value)) {
                $this->setParameters($value, $namespace, $container);
            }
        }
    }
}
