<?php

namespace Apix;

use Symfony\Component\Yaml\Yaml;

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
            throw new \InvalidArgumentException('Encrypt error for application');
        }

        //get encrypt file path and encrypt object for parsing
        $encryptFilePath    =file_get_contents($file);
        $this->encrypt      =Yaml::parse($encryptFilePath);

    }

    public function boot(){

    }
}