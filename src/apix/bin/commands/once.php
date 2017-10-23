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

class once extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        $project=ucfirst($this->getProjectName($data));

        $onceDir=''.staticPathModel::getOncePath($project);

        if(!file_exists($onceDir)){
            $this->fileprocess->mkdir_path($onceDir);
        }

        $path=''.$onceDir.''.ucfirst($data['file']).'.php';

        if(!file_exists($path)){
            //usage api command create file:file
            $list=[];
            $touchServiceOnceMe['execution']='once';
            $touchServiceOnceMe['params']['projectName']=$project;
            $touchServiceOnceMe['params']['class']=ucfirst($data['file']);
            $list[]=$this->fileprocess->touch_path($onceDir.'/'.ucfirst($data['file']).'.php',$touchServiceOnceMe);


            $once=$data['file'];
            return utils::fileProcessResult($list,function() use ($once){
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('Once Has Been Successfully Created Named '.$once.'');
                echo $this->info('------------------------------------------------------------------------------');
            });
        }
        else{
            return 'once fail';
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