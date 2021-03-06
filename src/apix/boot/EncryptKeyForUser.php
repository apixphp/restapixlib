<?php

namespace Apix\Boot;

use Symfony\Component\Yaml\Yaml;
use Apix\StaticPathModel;

class EncryptKeyForUser {

    /**
     * @var $encrypt
     */
    public $encrypt;

    /**
     * encryptKeyForUser constructor.
     */
    public function __construct() {

        //check static path encrypt
        $file=StaticPathModel::getEncryptFilePath();

        //if there is no encrypt
        if(!file_exists($file)){

            //exception catch blog for encrypt file
            throw new \LogicException('Encrypt file error for application');
        }

        //get encrypt file path and encrypt object for parsing
        $encryptFilePath    = file_get_contents($file);
        $this->encrypt      = Yaml::parse($encryptFilePath);

    }

    public function boot(){

        //check encrypt array for null type and key
        if($this->encrypt===null OR !isset($this->encrypt['key'])){

            //exception catch blog for encrypt file key
            throw new \LogicException('Encrypt key error for application');
        }
    }
}