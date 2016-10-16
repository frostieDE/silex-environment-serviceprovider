<?php

namespace FrostieDE\Silex;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EnvironmentServiceProvider implements ServiceProviderInterface  {

    /**
     * @var string
     */
    private $variableName;

    /**
     * @var string
     */
    private $defaultEnvironment;

    /**
     * @var string
     */
    private $devEnvironment;

    /**
     * @param string $variableName The name of the environment variable which is used to switch environments
     * @param string $defaultEnvironment The name of the default environment which is used if the environment variable is empty
     * @param string $devEnvironment The name of the development environment
     */
    public function __construct($variableName = 'APP_ENV', $defaultEnvironment = 'prod', $devEnvironment = 'dev') {
        if(empty($variableName)) {
            throw new \InvalidArgumentException('$variableName must not be empty');
        }

        if(empty($defaultEnvironment)) {
            throw new \InvalidArgumentException('$defaultEnvironment must not be empty');
        }

        if(empty($devEnvironment)) {
            throw new \InvalidArgumentException('$devEnvironment must not be empty');
        }

        $this->variableName = (string)$variableName;
        $this->defaultEnvironment = (string)$defaultEnvironment;
        $this->devEnvironment = (string)$devEnvironment;
    }

    /**
     * @inheritDoc
     */
    public function register(Container $app) {
        $app['cli'] = function() {
            if(php_sapi_name() === 'cli') {
                return true;
            }

            return false;
        };

        $app['env'] = function() {
            $env = getenv($this->variableName);

            if($env === false) {
                $env = $this->defaultEnvironment;
            }

            return $env;
        };

        if($app['env'] === $this->devEnvironment) {
            $app['debug'] = true;
        } else {
            $app['debug'] = false;
        }
    }
}