<?php

namespace Gordon\MVC\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * ExampleController.
 *
 * @author Joseph Daigle
 */
class ExampleController
{
    public function indexAction()
    {
        return new Response("This is the index action!", 200);
    }
}
