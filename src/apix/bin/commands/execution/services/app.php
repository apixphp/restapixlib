<?php
/*
 * This file is app class extended of the __projectName__ service.
 *
 * every service is extends app class as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\__version__\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\__version__\__call\__serviceName__\app
 */

namespace Src\App\__projectName__\__version__\__Call\__serviceName__;

use Src\App\__projectName__\__version__\ServiceAnnotationsController;
use Src\App\__projectName__\__version__\ServiceBaseController as Base;

/**
 * Represents a app helper class.
 * it is helper for main file
 */

class App extends Base
{
    //set annotations trait
    use ServiceAnnotationsController;

    /**
     * @var
     */
    public $source;
    /**
     * @var
     */
    public $query;
    /**
     * @var
     */
    public $main;
    /**
     * @var \stdClass
     */
    public $app;

    /**
     * app Constructor.
     *
     * type dependency injection and app class
     * main loader as construct method
     */
    public function __construct()
    {
        parent::__construct();
        $this->branchInitialize();
        $this->app=new \stdClass();
    }


    /**
     * service restrictions method.
     *
     * restrictions for production environment
     * @return array
     */
    public function restrictions()
    {
        return [];
    }
}
