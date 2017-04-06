<?php

/**
 * This is the DI Container for the gscweb/mvc-framework project.
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Create the container.
 */
$container = new ContainerBuilder();

/**
 * Configure the container.
 */
$loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/config'));

//load application configuration
$container->setParameter('gsc.config', Yaml::parse(file_get_contents(HOME_DIR . '/config/application.yml')));

//load services
$loader->load('services.yml');


$container->register('gsc.framework', Gordon\MVC\Framework::class)
        ->setArguments(array(
            new Symfony\Component\EventDispatcher\EventDispatcher(),
            new \Symfony\Component\HttpKernel\Controller\ControllerResolver()
        ))
        ->addMethodCall('setContainer', array($container));

/**
 * Return the contianer.
 */
$container->compile();
return $container;