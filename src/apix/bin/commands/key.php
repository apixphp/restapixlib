<?php
namespace Apix\Bin\Commands;

use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
use Symfony\Component\Yaml\Yaml;

class Key extends Console {

    /**
     * @var string
     */
    public $encryptFile;

    /**
     * Key constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->encryptFile=StaticPathModel::getEncryptFilePath();
    }

    public function generate(){

        if(!file_exists($this->encryptFile)){

            $yaml = Yaml::dump(['key'=>$this->generateRandomKey()]);

            file_put_contents($this->encryptFile, $yaml);

            echo $this->classical('Application key '.$this->generateRandomKey().' set successfully.');
        }
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return base64_encode(random_bytes(16));
    }
}