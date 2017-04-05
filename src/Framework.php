<?php

namespace Gordon\MVC;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Framework.
 *
 * @author Joseph Daigle
 */
class Framework extends HttpKernel implements ContainerAwareInterface
{
    public $container;
    
    /**
     * Sets the container.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->$container = $container;
    }

}
