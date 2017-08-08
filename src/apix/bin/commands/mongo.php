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


class mongo extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        $getParams=$this->getParams($data);

        foreach ($getParams as $key=>$value){
            if($key==0){

                if(!array_key_exists(2,$getParams) OR !array_key_exists('collection',$getParams[2])){
                    return $this->error('Collection key is missing');
                }

                foreach ($value as $project=>$service){

                    $version=utils::getAppVersion($project);

                    if(!file_exists(root.'/src/app/'.$project.'/'.$version.'/model/mongo')){
                        $this->fileprocess->mkdir_path(root.'/src/app/'.$project.'/'.$version.'/model/mongo');
                    }

                    $modelControlPath=root.'/src/app/'.$project.'/'.$version.'/model/mongo/'.$getParams[1]['file'].'Collection.php';

                    if(!file_exists($modelControlPath)){

                        $modelParamsBuilder['execution']='services/mongoModelBuilder';
                        $modelParamsBuilder['params']['projectName']=$project;
                        $modelParamsBuilder['params']['className']=$getParams[1]['file'];
                        $modelParamsBuilder['params']['tableName']=$getParams[2]['collection'];
                        $modelParamsBuilder['params']['version']=$version;

                        //dd(root.'/src/app/'.$project.'/'.$version.'/model/mongo/builder/'.$getParams[1]['file'].'Builder.php');
                        $list[]=$this->fileprocess->touch_path(root.'/src/app/'.$project.'/'.$version.'/model/mongo/'.$getParams[1]['file'].'Collection.php',$modelParamsBuilder);
                    }
                    else{
                        return $this->error($getParams[1]['file'].' mongo model is already available');
                    }

                    return utils::fileProcessResult($list,function() use($data,$project,$version,$getParams){
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->classical('MONGO MODEL GENERATOR : '.$getParams[1]['file'].' --- '.$getParams[2]['collection'].'');
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->success('You can see in the src/app/'.$project.'/'.$version.'/model/mongo Directory');
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