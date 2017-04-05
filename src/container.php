<?php

/**
 * This is the DI Container for the gscweb/mvc-framework project.
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Create the container.
 */
$container = new ContainerBuilder();

/**
 * Configure the container.
 */
$container->setParameter('app.name', 'Application Name');

/**
 * Return the contianer.
 */
$container->compile();
return $container;