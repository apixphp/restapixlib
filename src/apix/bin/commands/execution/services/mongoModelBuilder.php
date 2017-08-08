<?php
namespace src\app\__projectName__\__version__\model\mongo;

class __className__Collection
{

    public $collection;

    public function __construct(){

        $this->collection=(new \Mongo('prosystem'))->collection('__tableName__');
    }

    /**
     * model __className__ get method
     * @return array @method
     */
    public function get()
    {
        return $this->collection->get();
    }
}
