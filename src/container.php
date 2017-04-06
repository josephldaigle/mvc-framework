<?php

/**
 * This is the DI Container for the gscweb/mvc-framework project.
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;
/**
 * Create the container.
 */
$container = new ContainerBuilder();

/**
 * Configure the container.
 */

// Register mailer
$container->register('gsc.mailer', PHPMailer::class)
        ->addMethodCall('isSMTP')
        ->addMethodCall('isHtml', array(true))
        ->addMethodCall('setFrom', array('noreply@gordonstate.edu', 'Gordon State College'))
        ->setProperty('Host', 'condor.gordonstate.edu');
        
$container->setParameter('gsc.app.config', Yaml::parse(file_get_contents(HOME_DIR . '/config/services/mailer.yml')));


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