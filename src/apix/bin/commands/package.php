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

class package {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function auto ($data){

        $list=[];
        if(!file_exists('./src/store/packages/auto/'.$this->getProjectName($data))){


            $list[]=$this->mkdir_path('./src/store/packages/auto/'.$this->getProjectName($data));


            $touchPackage['execution']='package_auto';
            $touchPackage['params']['packageName']=$this->getProjectName($data);
            $list[]=$this->touch_path('./src/store/packages/auto/'.$this->getProjectName($data).'/'.$this->getProjectName($data).'.php',$touchPackage);

            return $this->fileProcessResult($list,function(){
                return 'auto package has been created';
            });
        }

        return 'auto package  fail';

    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir($data);
    }

    //set mkdir
    public function mkdir_path($data){

        return $this->fileprocess->mkdir_path($data);
    }

    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->touch($data,$param);
    }

    //set mkdir
    public function touch_path($data,$param){

        return $this->fileprocess->touch_path($data,$param);
    }

    //mkdir process result
    public function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return 'project fail';
        }
        else {

            return call_user_func($callback);
        }

    }

    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }

    //file process
    public  function fileprocess(){

        //file process new instance
        $libconf=require("".staticPathModel::$binCommandsPath."/lib/conf.php");
        $file=$libconf['libFile'];
        return new $file();

    }
}