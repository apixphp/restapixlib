<?php

namespace Src\App\__projectName__\V1;

use apix\utils;
use Src\Store\Services\Str;

/**
 * Trait ServiceAnnotationsController
 * @package Src\App\__projectName__\V1
 */
trait ServiceAnnotationsController
{
    /**
     * @var $redis \Src\App\__projectName__\V1\ServiceToolsController
     */
    public $tool;

    public function tool(){

        $toolClass='\Src\App\__projectName__\V1\ServiceToolsController';
        $this->tool=utils::resolve($toolClass);
        return $this->tool;
    }

    /**
     * @var $redis \src\store\services\redis
     */
    public $redis;

    /**
     * @return \src\store\services\redis
     */
    public function redis(){

        $this->redis=app('redis');
        return $this->redis;
    }

    /**
     * @var $session \src\store\services\httpSession
     */
    public $session;

    /**
     * @return \src\store\services\httpSession
     */
    public function session(){

        $this->session=app('session');
        return $this->session;
    }

    /**
     * @var $device \src\store\services\mobileDetect
     */
    public $device;

    /**
     * @return \src\store\services\mobileDetect
     */
    public function device(){

        $this->device=app('device');
        return $this->device;
    }

    /**
     * @var $collection \src\store\services\appCollection
     */
    public $collection;

    /**
     * @return \src\store\services\appCollection
     */
    public function collection(){

        $this->collection=app('collection');
        return $this->collection;
    }

    /**
     * @var $logger \src\app\__projectName__\v1\serviceLogController
     */
    public $logger;

    /**
     * @param $logType string
     * @param $logFile string
     * @return \src\app\__projectName__\v1\serviceLogController
     */
    public function log($logType,$logFile){

        $this->logger=new \Log($logType,$logFile);
        return $this->logger;
    }

    /**
     * @param $name
     * @param $arg
     * @return mixed
     */
    public function __call($name, $arg){

        //if $name starts with $needles for model
        if(Str::startsWith($name,'model')){

            //get model builder query
            return $this->query->{Str::crop($name,'model')}();
        }

        //if $name starts with $needles for source
        if(Str::startsWith($name,'source')){

            //get source bundle
            return $this->source->{Str::crop($name,'source')}();
        }

        //if $name starts with $needles for repo
        if(Str::startsWith($name,'repo')){

            //get repository
            $repo=Str::crop($name,'repo');
            return \Repo::$repo();
        }
    }

    //annotationController
}
