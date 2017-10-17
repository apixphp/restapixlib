<?php

namespace Src\App\__projectName__\V1;

trait ServiceAnnotationsController
{
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

    //annotationController
}
