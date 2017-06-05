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

class command extends console {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){


        foreach ($data as $key=>$value){
            $file=$key;
        }

        $commandDir=root.'/'.staticPathModel::$storePath.'/commands/';

        if(!file_exists($commandDir)){
            $this->mkdir_path($commandDir);
        }

        $path=''.$commandDir.''.$file.'.php';

        if(!file_exists($path)){
            //usage api command create file:file
            $list=[];
            $touchServiceCommandMe['execution']='command';
            $touchServiceCommandMe['params']['class']=$file;
            $list[]=$this->touch(''.$file.'.php',$touchServiceCommandMe);


            return $this->fileProcessResult($list,function(){
                return 'command has been created';
            });
        }
        else{
            return 'command fail';
        }


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

        return $this->fileprocess->command($data,$param);
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