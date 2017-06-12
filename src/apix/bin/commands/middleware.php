<?php namespace apix\bin\commands;
use Apix\Console;
use Apix\StaticPathModel;
use Apix\Utils;
/**
 * Command write.
 * type array
 * package:middleware runner
 * user apix
 */

class middleware extends console {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){

       $project=$this->getProjectName($data);

        $middlewareDir=''.staticPathModel::getMiddlewarePath($project);

        if(!file_exists($middlewareDir)){
            $this->fileprocess->mkdir_path($middlewareDir);
        }

        $path=''.$middlewareDir.''.$data['file'].'.php';

        if(!file_exists($path)){
            //usage api command create file:file
            $list=[];
            $touchServiceMiddlewareMe['execution']='middleware';
            $touchServiceMiddlewareMe['params']['projectName']=$project;
            $touchServiceMiddlewareMe['params']['class']=$data['file'];
            $list[]=$this->fileprocess->touch_path($middlewareDir.'/'.$data['file'].'.php',$touchServiceMiddlewareMe);


            return utils::fileProcessResult($list,function(){
                return 'middleware has been created';
            });
        }
        else{
            return 'middleware fail';
        }


    }



    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }

}