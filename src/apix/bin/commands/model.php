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

                    $tablesYamlPath='./src/app/'.$project.'/'.$version.'/model/tables.yaml';

                    if(file_exists('./src/app/'.$project.'/'.$version.'/model/eloquent')){


                        $modelControlPath='./src/app/'.$project.'/'.$version.'/model/eloquent/'.$this->getParams($data)[1]['file'].'.php';

                        if(!file_exists($modelControlPath)){

                            $this->setTableYaml($data,$tablesYamlPath);

                            $modelParamsBuilder['execution']='services/eloquentmodelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/eloquent/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                            $modelParamsAdapter['execution']='services/modelAdapter';
                            $modelParamsAdapter['params']['projectName']=$project;
                            $modelParamsAdapter['params']['orm']='eloquent';
                            $modelParamsAdapter['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/eloquent/adapter/'.$this->getParams($data)[1]['file'].'Adapter.php',$modelParamsAdapter);

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

                            $this->setTableYaml($data,$tablesYamlPath);

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



                            $modelParamsAdapter['execution']='services/modelAdapter';
                            $modelParamsAdapter['params']['orm']='sudb';
                            $modelParamsAdapter['params']['projectName']=$project;
                            $modelParamsAdapter['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/sudb/adapter/'.$this->getParams($data)[1]['file'].'Adapter.php',$modelParamsAdapter);




                        }
                        else{
                            return $this->error($this->getParams($data)[1]['file'].' model is already available');
                        }

                    }


                    if(file_exists('./src/app/'.$project.'/'.$version.'/model/doctrine')){

                        $modelControlPath='./src/app/'.$project.'/'.$version.'/model/doctrine/'.$this->getParams($data)[1]['file'].'.php';

                        if(!file_exists($modelControlPath)){

                            $this->setTableYaml($data,$tablesYamlPath);

                            $config="\\src\\app\\".$project."\\".$version."\\config\\database";
                            $configdb=$config::dbsettings();

                            if(!file_exists(root.'/src/store/packages/providers/database/doctrine/bootstrap.php')){

                                copy(root.'/src/store/packages/providers/database/doctrine/bootstrap.dist.php',root.'/src/store/packages/providers/database/doctrine/bootstrap.php');

                                utils::changeClass(root.'/src/store/packages/providers/database/doctrine/bootstrap.php',[

                                    "'driver'=>'driver'"=>"'driver'=>'pdo_".$configdb['driver']."'",
                                    "'user'=>'user'"=>"'user'=>'".$configdb['user']."'",
                                    "'host'=>'host'"=>"'host'=>'".$configdb['host']."'",
                                    "'dbname'=>'dbname'"=>"'dbname'=>'".$configdb['database']."'",
                                    "'password'=>'password'"=>"'password'=>'".$configdb['password']."'",

                                ]);
                            }



                            $process = new Process('php api doctrine '.$project.' '.$this->getParams($data)[2]['table']);
                            $process->run();

                            rename(root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.ucfirst($this->getParams($data)[2]['table']).'.php',
                                root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.$this->getParams($data)[1]['file'].'.php');

                            utils::changeClass(root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.$this->getParams($data)[1]['file'].'.php',[
                               'class '.ucfirst($this->getParams($data)[2]['table']).''=>'class '.ucfirst($this->getParams($data)[1]['file']),
                                'private'=>'public'
                            ]);




                            $modelParamsBuilder['execution']='services/doctrineModelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/doctrine/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                            $modelParamsAdapter['execution']='services/doctrineModelAdapter';
                            $modelParamsAdapter['params']['orm']='doctrine';
                            $modelParamsAdapter['params']['projectName']=$project;
                            $modelParamsAdapter['params']['className']=$this->getParams($data)[1]['file'];
                            //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                            $list[]=$this->touch($project.'/'.$version.'/model/doctrine/adapter/'.$this->getParams($data)[1]['file'].'Adapter.php',$modelParamsAdapter);




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

    private function setTableYaml($data,$tablesYamlPath){
        if(!file_exists($tablesYamlPath)){

            utils::dumpYaml(['tables'=>[$this->getParams($data)[2]['table']]],$tablesYamlPath);
        }
        else{

            $tablesYamlDatas=utils::getYaml($tablesYamlPath);
            $list=[];
            foreach($tablesYamlDatas['tables'] as $tables){
                $list['tables'][]=$tables;
            }
            $list['tables'][]=$this->getParams($data)[2]['table'];

            utils::dumpYaml($list,$tablesYamlPath);

        }
    }

}