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
            throw new \LogicException('Once configuration error for application');
        }

        //get once yaml file path and once yaml object for parsing
        $onceFilePath       = file_get_contents($this->file);
        $this->once         = Yaml::parse($onceFilePath);

    }

    public function boot(){

        //process start
        $this->registerOnceProcess();
    }

    /**
     * @method getOnceClasses
     * @return array
     */
    public function getOnceClasses(){

        //get all kernel once file
        return Utils::getGlobFile(StaticPathModel::getOncePath(),'true');
    }

    /**
     * @method registerOnceProcess
     */
    public function registerOnceProcess(){

        //loop all once class
        foreach ($this->getOnceClasses() as $once){

            //for tracking once algorithm,set once key
            //check once key to according to algoritm
            $onceKey=$this->encrypt['key'].':'.md5($once);
            if($this->once===null OR !in_array($onceKey,$this->once)){

                //assign to array once key
                //register boot
                $this->onceList[]=$onceKey;
                $this->registerBoot($once);
            }

        }
    }


    /**
     * @method registerBoot
     * @param $once
     */
    private function registerBoot($once){

        //check once key
        if(!isset($this->once[$this->encrypt['key']][$once])){

            //once class boot
            //write to yaml file
            Utils::resolve($once)->boot();
            Utils::dumpYaml($this->onceList,$this->file);
        }
    }


}