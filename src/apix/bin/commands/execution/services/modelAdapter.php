<?php
namespace src\app\__projectName__\v1\model\__orm__\adapter;

use src\app\__projectName__\v1\model\__orm__\builder\__className__Builder;
use src\app\__projectName__\v1\model\__orm__\__className__;

class __className__Adapter
{

    public $builder;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(__className__Builder $builder){

        $this->builder=$builder;
    }

    /**
     * model __className__ get method
     * @return array @method
     */
    public function get()
    {
        return $this->builder->get();
    }

    /**
     * model __className__ create method
     * @return array @method
     */
    public function create($post=array())
    {
        return $this->builder->create($post);
    }

    /**
     * model __className__ update method
     * @return array @method
     */
    public function update($post=array())
    {
        return $this->builder->update($post);
    }

    /**
     * model __className__ delete method
     * @return array @method
     */
    public function delete($post=array())
    {
        return $this->builder->delete($post);
    }
}
