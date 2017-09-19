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

class eagers extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        $project=$this->getProjectName($data);

        $eagersDir=''.staticPathModel::getEagersPath($project);

        if(!file_exists($eagersDir)){
            $this->fileprocess->mkdir_path($eagersDir);
        }

        $path=''.$eagersDir.'/'.$data['file'].'.php';


        if(!file_exists($path)){
            //usage api command create file:file
            $list=[];
            $touchServiceEagersMe['execution']='eagers';
            $touchServiceEagersMe['params']['projectName']=$project;
            $touchServiceEagersMe['params']['version']=utils::getAppVersion($project);
            $touchServiceEagersMe['params']['class']=$data['file'];
            $list[]=$this->fileprocess->touch_path($eagersDir.'/'.$data['file'].'.php',$touchServiceEagersMe);


            $eagersFile=$data['file'];
            return utils::fileProcessResult($list,function() use ($eagersFile){
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('Eagers Has Been Successfully Created Named '.$eagersFile.'');
                echo $this->info('------------------------------------------------------------------------------');
            });
        }
        else{
            return 'Eagers fail';
        }


    }



    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            define('app',$key);
            define('version',utils::getAppVersion($key));
            return $key;
        }
    }

}