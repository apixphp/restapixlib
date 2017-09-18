<?php namespace apix\bin\commands;

use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class resourches extends console {

    public $fileprocess;

    public function __construct(){

        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }

    //project create command
    public function clear ($data){

                $this->getProjectName($data);
                utils::symfonyProcess('sudo rm -rf '.staticPathModel::getResourchesPath().'/*');
                touch(staticPathModel::getResourchesPath().'/index.html');
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('Resourches has been successfully cleared');
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->info('------------------------------------------------------------------------------');

    }


    //get project name
    public function getProjectName($data){
        //get project name
        foreach ($data as $key=>$value){
            define('app',$key);
            return $key;
        }
    }


}