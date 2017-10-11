<?php
/**
 * Annotations are meta-data that can be embedded in source code.
 * You may already be familiar with the PHP-DOC flavor of source code annotations, which are seen in most modern PHP codebases - they look like this
 */

namespace src\app\__projectName__\v1;

trait serviceAnnotationsController
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
