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

class staticprovider {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){


        $version=utils::getAppVersion($this->getProjectName($data));
        $data['version']=$version;

        //usage api staticprovider create project version:versionnumber file:file
        $list=[];
        $touchServiceStaticProviderMe['execution']='static_provider';
        $touchServiceStaticProviderMe['params']['projectName']=$this->getProjectName($data);
        $touchServiceStaticProviderMe['params']['version']=$data['version'];
        $touchServiceStaticProviderMe['params']['file']=$data['file'];
        $list[]=$this->touch($this->getProjectName($data).'/'.$data['version'].'/optional/staticProvider/'.$data['file'].'.php',$touchServiceStaticProviderMe);


        return $this->fileProcessResult($list,function(){
            return 'static provider has been created';
        });

        return 'static provider fail';

    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir($data);
    }

    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->touch($data,$param);
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