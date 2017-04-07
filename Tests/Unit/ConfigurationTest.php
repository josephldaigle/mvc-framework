<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * ConfigurationTest.
 *
 * Tests application configuration settings.
 * 
 * @author Joseph Daigle
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        $configDirectories = array(
            'app' => dirname(dirname(__DIR__)).'/config'
        );
        $this->fileLocator = new FileLocator($configDirectories);
    }
    
    public function tearDown()
    {
        parent::tearDown();
        
        $this->fileLocator = null;
    }
    
    /**
     * Test that applicaiton.yml can be loaded.
     */
    public function testCanLoadApplicationConfig()
    {
        $appConfig = Yaml::parse(file_get_contents($this->fileLocator->locate('application.yml')));

        $this->assertTrue(is_array($appConfig));
        $this->assertArrayHasKey('app.name', $appConfig);
        $this->assertArrayHasKey('app.lang', $appConfig);
    }
}
