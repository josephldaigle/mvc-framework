<?php

/**
 * DiContainerTest.
 * 
 * Tests the baseline contianer configuration behaves as expected, and has
 * all expected parameters and services configured.
 *
 * @author Joseph Daigle
 */
class DiContainerTest extends PHPUnit_Framework_TestCase
{
    
//    public function __construct($name = null, array $data = array(), $dataName = '')
//    {
//        parent::__construct($name, $data, $dataName);
//        
//    }
    public function setUp()
    {
        parent::setUp();

    }
    
    
    public function testContainerTypeIsCorrect()
    {
        $container = require_once dirname(dirname(__DIR__)).'/src/container.php';

        //test type
        $this->assertInstanceOf(Symfony\Component\DependencyInjection\ContainerBuilder::class, $container);
        
        
        
    }
    
}
