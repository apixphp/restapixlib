<?php namespace src\app\__projectName__\v1\model\doctrine\builder;

use Src\Store\Packages\Providers\Database\Doctrine\DoctrineEntityManager;

/**
 * Class __className__Builder
 * @package src\app\__projectName__\v1\model\doctrine\builder
 */
class __className__Builder extends DoctrineEntityManager
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $doctrine;

    /**
     * Construct load
     */
    public function __construct(){

        $this->doctrine=$this->getDoctrine();
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->doctrine->findAll();
    }

}
