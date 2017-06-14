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
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        foreach ($data as $key=>$value){
            $file=$key;
            break;
        }

        if(count($data)===2){
            $commandDir=staticPathModel::getKernelCommand(end($data)).'/';
        }
        else{
            $commandDir=root.'/'.staticPathModel::$storePath.'/commands/';
        }



        if(!file_exists($commandDir)){
            $this->fileprocess->mkdir_path($commandDir);
        }

        $path=''.$commandDir.''.$file.'.php';

        if(!file_exists($path)){
            //usage api command create file:file
            $list=[];
            $touchServiceCommandMe['execution']=(count($data)===2) ? 'appCommand' : 'command';
            $touchServiceCommandMe['params']['projectName']=end($data);
            $touchServiceCommandMe['params']['class']=$file;
            $list[]=$this->fileprocess->touch_path($path,$touchServiceCommandMe);


            return utils::fileProcessResult($list,function(){
                return 'command has been created';
            });
        }
        else{
            return 'command fail';
        }


    }
}