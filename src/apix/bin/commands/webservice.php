<?php namespace apix\bin\commands;
use Apix\Utils;
use Apix\Console;
use Apix\StaticPathModel;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class webservice extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function request ($data){

        $getParams=$this->getParams($data);

        foreach ($getParams as $key=>$value){
            if($key==0){


                foreach ($value as $project=>$service){

                    $version=utils::getAppVersion($project);

                    if(!file_exists(root.'/src/app/'.$project.'/'.$version.'/optional/webServices/requests')){
                        $this->fileprocess->mkdir_path(root.'/src/app/'.$project.'/'.$version.'/optional/webServices/requests');
                    }

                    $modelControlPath=root.'/src/app/'.$project.'/'.$version.'/optional/webServices/requests/'.$data['group'].'Requests.php';

                    if(!file_exists($modelControlPath)){

                        $modelParamsBuilder['execution']='services/webservicerequestBuilder';
                        $modelParamsBuilder['params']['projectName']=$project;
                        $modelParamsBuilder['params']['className']=$data['group'];
                        $modelParamsBuilder['params']['version']=$version;

                        //dd(root.'/src/app/'.$project.'/'.$version.'/model/mongo/builder/'.$getParams[1]['file'].'Builder.php');
                        $list[]=$this->fileprocess->touch_path(root.'/src/app/'.$project.'/'.$version.'/optional/webServices/requests/'.$data['group'].'Requests.php',$modelParamsBuilder);
                    }
                    else{
                        return $this->error($data['group'].' webservice group request is already available');
                    }

                    return utils::fileProcessResult($list,function() use($data,$project,$version){
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->classical('WEBSERVİCE REQUEST CLIENT GENERATOR : '.$data['group'].'');
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->success('You can see in the src/app/'.$project.'/'.$version.'/optional/webServices/requests/ Directory');
                        echo $this->info('--------------------------------------------------------------------------------------------------');
                    });;






                }
            }
        }

    }




    //get bin params
    public function getParams($data){
        $params=[];
        foreach ($data as $key=>$value){

            $params[]=[$key=>$value];

        }

        return $params;
    }


    //set touch
    public function touch($data,$param){

        return $this->fileprocess->touch($data,$param);
    }


    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }


}