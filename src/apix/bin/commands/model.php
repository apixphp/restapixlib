<?php namespace apix\bin\commands;
use Apix\Console;
use Apix\StaticPathModel;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class model extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                foreach ($value as $project=>$service){
                    $version=require ('./src/app/'.$project.'/version.php');
                    $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                    $list=[];


                    if(file_exists('./src/app/'.$project.'/'.$version.'/model/eloquent')){


                        $modelControlPath='./src/app/'.$project.'/'.$version.'/model/eloquent/'.$this->getParams($data)[1]['file'].'.php';

                        if(!file_exists($modelControlPath)){
                            $modelParamsBuilder['execution']='services/eloquentmodelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/eloquent/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                            $modelParams['execution']='services/eloquentmodel';
                            $modelParams['params']['projectName']=$project;
                            $modelParams['params']['className']=$this->getParams($data)[1]['file'];
                            $modelParams['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/eloquent/'.$this->getParams($data)[1]['file'].'.php',$modelParams);
                        }
                        else{
                            return $this->error($this->getParams($data)[1]['file'].' model is already available');
                        }


                    }


                    if(file_exists('./src/app/'.$project.'/'.$version.'/model/sudb')){

                        $modelControlPath='./src/app/'.$project.'/'.$version.'/model/sudb/'.$this->getParams($data)[1]['file'].'.php';

                        if(!file_exists($modelControlPath)){

                            $modelParamsBuilder['execution']='services/modelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/sudb/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                            $modelParams['execution']='services/model';
                            $modelParams['params']['projectName']=$project;
                            $modelParams['params']['className']=$this->getParams($data)[1]['file'];
                            $modelParams['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/sudb/'.$this->getParams($data)[1]['file'].'.php',$modelParams);


                        }
                        else{
                            return $this->error($this->getParams($data)[1]['file'].' model is already available');
                        }

                    }

                    return $this->fileProcessResult($list,function() use($data,$project,$version){
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->classical('MODEL GENERATOR : '.$this->getParams($data)[1]['file'].' --- '.$this->getParams($data)[2]['table'].'');
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->success('You can see in the src/app/'.$project.'/'.$version.'/model Directory');
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

            return 'service fail';
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