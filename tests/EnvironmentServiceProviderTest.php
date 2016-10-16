<?php

namespace FrostieDE\Silex\Tests;

use FrostieDE\Silex\EnvironmentServiceProvider;
use Pimple\Container;

class EnvironmentServiceProviderTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        putenv('APP_ENV'); // Remove variable
    }

    public function testDefaultEnv() {
        $app = new Container();
        $app->register(new EnvironmentServiceProvider());
        $this->assertEquals('prod', $app['env']);
    }

    public function testSetProdEnv() {
        putenv('APP_ENV=prod');
        
        $app = new Container();
        $app->register(new EnvironmentServiceProvider());
        
        $this->assertEquals('prod', $app['env']);
        $this->assertFalse($app['debug']);
    }

    public function testSetDevEnv() {
        putenv('APP_ENV=dev');
        
        $app = new Container();
        $app->register(new EnvironmentServiceProvider());
        
        $this->assertEquals('dev', $app['env']);
        $this->assertTrue($app['debug']);
    }

    public function testCli() {
        $app = new Container();
        $app->register(new EnvironmentServiceProvider());

        if(php_sapi_name() === 'cli') {
            $this->assertTrue($app['cli']);
        } else {
            $this->assertFalse($app['cli']);
        }
    }
}