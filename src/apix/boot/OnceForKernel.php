<?php

namespace Apix\Boot;

use src\store\services\fileProcess;
use Symfony\Component\Yaml\Yaml;
use Apix\StaticPathModel;
use Apix\Utils;
use Apix\Boot\EncryptKeyForUser;

class OnceForKernel extends EncryptKeyForUser {

    /**
     * @var $once
     */
    public $once;

    /**
     * @var $file
     */
    public $file;

    /**
     * @var $onceList
     */
    public $onceList=[];

    /**
     * OnceForKernel constructor.
     */
    public function __construct() {

        //encrypt construct
        parent::__construct();

        //check static path for once yaml
        $this->file=StaticPathModel::getOncePath().'/once.yaml';

        //if there is no encrypt
        if(!file_exists($this->file)){

            //exception catch blog for once yaml file
            throw new \InvalidArgumentException('Once configuration error for application');
        }

        //get once yaml file path and once yaml object for parsing
        $onceFilePath       =file_get_contents($this->file);
        $this->once         =Yaml::parse($onceFilePath);

    }

    public function boot(){

        if($this->once===null OR !isset($this->once[$this->encrypt['key']])){

            $this->registerOnceProcess();
        }
    }

    /**
     * @method getOnceClasses
     * @return array
     */
    public function getOnceClasses(){

        return Utils::getGlobFile(StaticPathModel::getOncePath(),'true');
    }

    /**
     * @method registerOnceProcess
     */
    public function registerOnceProcess(){

        foreach ($this->getOnceClasses() as $once){

           $this->registerBoot($once,$this->onceList);
        }
    }


    /**
     * @param $once
     * @param $yamlList
     */
    private function registerBoot($once, $yamlList){

        if(!isset($this->once[$this->encrypt['key']][$once])){

            Utils::resolve($once)->boot();

            $this->onceList[$this->encrypt['key']][]=$once;
            Utils::dumpYaml($this->onceList,$this->file);
        }
    }


}