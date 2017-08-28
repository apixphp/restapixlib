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
 * Represents a app abstract class.
 *
 * it is helper for main file
 * return type array
 */

class app extends base
{
    public $source;
    public $query;
    public $main;

    /**
     * Abstract Constructor.
     * main loader as construct method
     */
    public function __construct()
    {
        parent::__construct();
        $this->branchInitialize();
    }


    /**
     * service restrictions method.
     * main overloading method as restrictions
     * @return array
     */
    public function restrictions()
    {
        $list=[];
        return $list;
    }
}
