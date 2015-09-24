<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AppExtension extends Extension implements PrependExtensionInterface
{
    private $yaml = null;
    private $cfgDir = '';

    public function __construct()
    {
        $this->yaml = new Parser();
        $this->cfgDir = __DIR__ . '/../Resources/config/';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator($this->cfgDir));
        $loader->load('services.yml');
    }

    /**
     * override global with Bundle-specific configurations
     * see http://symfony.com/doc/current/cookbook/bundles/prepend_extension.html
     * @param ContainerBuilder $container
     */
    // TODO: is this the way to do this?
    public function prepend(ContainerBuilder $container)
    {
        if ($cfg = file_get_contents($this->cfgDir . 'config.yml')) {
            $config = $this->yaml->parse($cfg);
            foreach ($container->getExtensions() as $name => $extension) {
                // override global configurations
                foreach ($config as $key => $values) {
                    if ($key == $name) {
                        $container->prependExtensionConfig($name, $values);
                    }
                }
            }
        }
    }
}
