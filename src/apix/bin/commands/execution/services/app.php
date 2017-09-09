<?php
/*
 * This file is app class extended of the __projectName__ service.
 *
 * every service is extends app class as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\__version__\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\__version__\__call\__serviceName__\app
 */

namespace src\app\__projectName__\__version__\__call\__serviceName__;

use src\app\__projectName__\__version__\serviceBaseController as base;

/**
 * Represents a app helper class.
 * it is helper for main file
 */

class app extends base
{
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
