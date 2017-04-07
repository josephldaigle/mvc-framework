<?php

/**
 * This is the DI Container for the gscweb/mvc-framework project.
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader as RouteLoader;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Create the container.
 */
$container = new ContainerBuilder();

/**********************
 * Configuration
 *********************/

//create a file locator
$locator = new FileLocator(HOME_DIR . '/config');
$configLoader = new YamlFileLoader($container, $locator);

//load application configuration
$container->setParameter('app.config', new ParameterBag(Yaml::parse(file_get_contents($locator->locate('application.yml')))));

//load configured services
$configLoader->import('services.yml');

//resolve placeholders
$container->resolveEnvPlaceholders('%app.config%');


//register a request stack
$container->register('gsc.request_stack', \Symfony\Component\HttpFoundation\RequestStack::class);
$container->register('gsc.request_context', \Symfony\Component\Routing\RequestContext::class)
        ->addMethodCall('fromRequest', array($request));



/**********************
 * Routing
 *********************/
//load routes
$routeLoader = new RouteLoader($locator);
$routes = new RouteCollectionBuilder($routeLoader);

foreach (glob(HOME_DIR . '/config/routes/*.yml') as $route) {
    $routes->import($route, $container->getParameterBag()->get('app.config')->get('app.name'));
}
$routes = $routes->build();

$container->register("gsc.url_matcher", Symfony\Component\Routing\Matcher\UrlMatcher::class)
        ->setArguments(array(
            $routes, 
            new Reference('gsc.request_context')
        ));

$container->register('gsc.router_listener', \Symfony\Component\HttpKernel\EventListener\RouterListener::class)
        ->setArguments(array(
            new Reference('gsc.url_matcher'),
            new Reference('gsc.request_stack')
        ));



/**********************
 * Controllers
 *********************/
$container->register('gsc.controller_resolver', \Symfony\Component\HttpKernel\Controller\ControllerResolver::class);

$container->register('gsc.argument_resolver', Symfony\Component\HttpKernel\Controller\ArgumentResolver::class);



/**********************
 * Event Dispatcher
 *********************/
$container->register('gsc.event_dispatcher', Symfony\Component\EventDispatcher\EventDispatcher::class)
        ->addMethodCall('addSubscriber', array(new Reference('gsc.router_listener')));

//register the framework class
$container->register('gsc.framework', Gordon\MVC\Framework::class)
        ->setArguments(array(
            new Reference('gsc.event_dispatcher'),
            new Reference('gsc.controller_resolver')
        ))
        ->addMethodCall('setContainer', array($container));





/**********************
 * Build
 *********************/
$container->compile();
return $container;