<?php
namespace src\app\__projectName__\__v1__\model\__orm__\adapter;

use src\app\__projectName__\__v1__\model\__orm__\builder\__className__Builder;

/**
 * Class __className__Adapter
 * @package src\app\__projectName__\v1\model\__orm__\adapter
 */
class __className__Adapter
{

    /**
     * @var __className__Builder
     */
    public $builder;

    /**
     * @param __className__Builder $builder
     */
    public function __construct(__className__Builder $builder){

        $this->builder=$builder;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->builder->get();
    }

}
