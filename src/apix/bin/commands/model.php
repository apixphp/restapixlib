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
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        $getParams=$this->getParams($data);
        
        foreach ($getParams as $key=>$value){
            if($key==0){

                foreach ($value as $project=>$service){

                    $project=ucfirst($project);
                    $version=ucfirst(utils::getAppVersion($project));
                    $service=ucfirst($service);
                    $base=staticPathModel::getAppServiceBase($project,$version);
                    $baseModel=$base->model;

                    if(array_key_exists('set',$getParams[1])){
                        return $this->setModelDirectory($project,$version,$getParams[1]['set']);
                    }
                    $list=[];

                    $tablesYamlPath='./src/app/'.$project.'/'.$version.'/Model/Tables.yaml';

                    if($baseModel==="eloquent"){

                        $modelControlPath='./src/app/'.$project.'/'.$version.'/Model/Eloquent/'.ucfirst($getParams[1]['file']).'.php';

                        if(!file_exists($modelControlPath)){

                            $this->setTableYaml($data,$tablesYamlPath,$getParams);

                            $modelParamsBuilder['execution']='services/eloquentmodelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=ucfirst($getParams[1]['file']);
                            $modelParamsBuilder['params']['version']=$version;
                            //$modelParamsBuilder['params']['tableName']=$getParams[2]['table'];
                            $list[]=$this->fileprocess->touch($project.'/'.$version.'/Model/Eloquent/Builder/'.ucfirst($getParams[1]['file']).'Builder.php',$modelParamsBuilder);

                            $modelParams['execution']='services/eloquentmodel';
                            $modelParams['params']['projectName']=$project;
                            $modelParams['params']['className']=ucfirst($getParams[1]['file']);
                            $modelParams['params']['tableName']=$getParams[2]['table'];
                            $modelParams['params']['version']=$version;
                            $list[]=$this->fileprocess->touch($project.'/'.$version.'/model/eloquent/'.$getParams[1]['file'].'.php',$modelParams);


                            $this->setAnnotation([
                                'project'=>$project,
                                'version'=>$version,
                                'file'=>ucfirst($getParams[1]['file']),
                                'orm'=>'eloquent'
                            ]);
                        }
                        else{
                            return $this->error($getParams[1]['file'].' model is already available');
                        }


                    }


                    if($baseModel==="Sudb"){

                        $modelControlPath='./src/app/'.$project.'/'.$version.'/Model/Sudb/'.ucfirst($getParams[1]['file']).'.php';

                        if(!file_exists($modelControlPath)){

                            $this->setTableYaml($data,$tablesYamlPath,$getParams);

                            $modelParamsBuilder['execution']='services/modelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=ucfirst($getParams[1]['file']);
                            $modelParamsBuilder['params']['version']=$version;
                            //$modelParamsBuilder['params']['tableName']=$getParams[2]['table'];
                            $list[]=$this->fileprocess->touch($project.'/'.$version.'/Model/Sudb/Builder/'.ucfirst($getParams[1]['file']).'Builder.php',$modelParamsBuilder);

                            $modelParams['execution']='services/model';
                            $modelParams['params']['projectName']=$project;
                            $modelParams['params']['className']=ucfirst($getParams[1]['file']);
                            $modelParams['params']['version']=$version;
                            $modelParams['params']['tableName']=$getParams[2]['table'];
                            $list[]=$this->fileprocess->touch($project.'/'.$version.'/Model/Sudb/'.ucfirst($getParams[1]['file']).'.php',$modelParams);

                            $this->setAnnotation([
                                'project'=>$project,
                                'version'=>$version,
                                'file'=>ucfirst($getParams[1]['file']),
                                'orm'=>'sudb'
                            ]);



                        }
                        else{
                            return $this->error($getParams[1]['file'].' model is already available');
                        }

                    }


                    if($baseModel==="doctrine"){

                        $modelControlPath='./src/app/'.$project.'/'.$version.'/model/doctrine/'.$getParams[1]['file'].'.php';

                        if(!file_exists($modelControlPath)){

                            $this->setTableYaml($data,$tablesYamlPath,$getParams);

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



                            $process = new Process('php api doctrine '.$project.' '.$getParams[2]['table']);
                            $process->run();

                            rename(root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.ucfirst($getParams[2]['table']).'.php',
                                root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.$getParams[1]['file'].'.php');

                            utils::changeClass(root.'/src/app/'.$project.'/'.$version.'/model/doctrine/'.$getParams[1]['file'].'.php',[
                               'class '.ucfirst($getParams[2]['table']).''=>'class '.ucfirst($getParams[1]['file']),
                                'private'=>'public'
                            ]);




                            $modelParamsBuilder['execution']='services/doctrineModelBuilder';
                            $modelParamsBuilder['params']['projectName']=$project;
                            $modelParamsBuilder['params']['className']=$getParams[1]['file'];
                            $modelParamsBuilder['params']['version']=$version;
                            //$modelParamsBuilder['params']['tableName']=$getParams[2]['table'];
                            $list[]=$this->fileprocess->touch($project.'/'.$version.'/model/doctrine/builder/'.$getParams[1]['file'].'Builder.php',$modelParamsBuilder);



                            $this->setAnnotation([
                                'project'=>$project,
                                'version'=>$version,
                                'file'=>$getParams[1]['file'],
                                'orm'=>'doctrine'
                            ]);


                        }
                        else{
                            return $this->error($getParams[1]['file'].' model is already available');
                        }

                    }

                    return utils::fileProcessResult($list,function() use($data,$project,$version,$getParams){
                        echo $this->info('-------------------------------------------------------------------------------------------------');
                        echo $this->classical('MODEL GENERATOR : '.$getParams[1]['file'].' --- '.$getParams[2]['table'].'');
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


    private function setTableYaml($data,$tablesYamlPath,$getParams){
        if(!file_exists($tablesYamlPath)){

            utils::dumpYaml(['tables'=>[$getParams[2]['table']]],$tablesYamlPath);
        }
        else{

            $tablesYamlDatas=utils::getYaml($tablesYamlPath);
            $list=[];
            foreach($tablesYamlDatas['tables'] as $tables){
                $list['tables'][]=$tables;
            }

            if(!in_array($getParams[2]['table'],$list['tables'])){
                $list['tables'][]=$getParams[2]['table'];

            }

            utils::dumpYaml($list,$tablesYamlPath);

        }
    }



    private function setModelDirectory($project,$version,$orm){

        if($orm=="sudb" && !file_exists('./src/app/'.$project.'/'.$version.'/model/sudb')){

            $list[]=$this->fileprocess->mkdir($project.'/v1/model/sudb');
            $list[]=$this->fileprocess->touch($project.'/v1/model/sudb/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/v1/model/sudb/builder');
            $list[]=$this->fileprocess->touch($project.'/v1/model/sudb/builder/index.html',null);

            $modelVarLoad['execution']='services/modelVarTrait';
            $modelVarLoad['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/v1/model/modelVar.php',$modelVarLoad);
        }


        if($orm=="eloquent" && !file_exists('./src/app/'.$project.'/'.$version.'/model/eloquent')){
            $list[]=$this->fileprocess->mkdir($project.'/v1/model/eloquent');
            $list[]=$this->fileprocess->touch($project.'/v1/model/eloquent/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/v1/model/eloquent/builder');
            $list[]=$this->fileprocess->touch($project.'/v1/model/eloquent/builder/index.html',null);
        }


        if($orm=="doctrine" && !file_exists('./src/app/'.$project.'/'.$version.'/model/doctrine')){
            $list[]=$this->fileprocess->mkdir($project.'/v1/model/doctrine');
            $list[]=$this->fileprocess->touch($project.'/v1/model/doctrine/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/v1/model/doctrine/builder');
            $list[]=$this->fileprocess->touch($project.'/v1/model/doctrine/builder/index.html',null);
        }

        return utils::fileProcessResult($list,function() use($project,$version,$orm){
            echo $this->info('-------------------------------------------------------------------------------------------------');
            echo $this->classical('ORM '.$orm.' HAS BEEN SUCCESSFULLY CREATED');
            echo $this->info('--------------------------------------------------------------------------------------------------');
        });;
    }


    public function setAnnotation($annotation=array()){

        utils::changeClass(root.'/src/app/'.$annotation['project'].'/'.$annotation['version'].'/serviceAnnotationsController.php',[

            '* Trait ServiceAnnotationsController' => '* Trait ServiceAnnotationsController     
 * @method \Src\App\\'.$annotation['project'].'\\'.$annotation['version'].'\Model\\'.ucfirst($annotation['orm']).'\Builder\\'.strtolower($annotation['file']).'Builder model'.ucfirst($annotation['file']).'  '
        ]);

    }

}