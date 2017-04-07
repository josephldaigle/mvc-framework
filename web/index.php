<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //initialize class autoloader
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    
    
    
    use Symfony\Component\HttpFoundation\Request;
    
    define('HOME_DIR', dirname(__DIR__));
    
    //create the request
    $request = Request::createFromGlobals();

    //load DI container
    $container = require_once HOME_DIR . '/src/container.php';
    $app = $container->get('gsc.framework');

    //handle the request
    $app->handle($request)->send();