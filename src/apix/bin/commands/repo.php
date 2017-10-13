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


class repo extends Console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        //using : api repo create projectName repo:repoName || src:repoSrc || src:repoSrc/repoSrcFile

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                $project=null;
                foreach($value as $project){
                    $project=$project;
                }

                if(!array_key_exists("repo",$this->getParams($data)[1])){
                    return 'error : project null or no repo key';
                }

                $project=ucfirst($project);
                $version=ucfirst(utils::getAppVersion($project));
                $list=[];

                if(array_key_exists(2,$this->getParams($data)) && array_key_exists("src",$this->getParams($data)[2])){

                    $srcBundle=explode("/",$this->getParams($data)[2]['src']);

                    if(!file_exists(root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'')){
                        $list[]=$this->mkdir_path(root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0]);
                    }


                    if(array_key_exists(1,$srcBundle)){

                        $bundleParamsIndexSrc['execution']='services/repoBundleSrcIndex';
                        $bundleParamsIndexSrc['params']['projectName']=$project;
                        $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['repo'];
                        $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                        $bundleParamsIndexSrc['params']['className']=$srcBundle[1];
                        $list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'/'.$srcBundle[1].'.php',$bundleParamsIndexSrc);

                        $requestBundleFile=root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/index.php';
                        $this->fileprocess->changeClass($requestBundleFile,['use Collection;'=>'use Collection;'.PHP_EOL.'use src\app\\'.$project.'\\'.$version.'\\optional\repository\\'.$this->getParams($data)[1]['repo'].'\\src\\'.$srcBundle[0].'\\'.$srcBundle[1].';'
                        ]);
                    }
                    else{

                        $bundleParamsIndexSrc['execution']='services/repoBundleSrcIndex';
                        $bundleParamsIndexSrc['params']['projectName']=$project;
                        $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['repo'];
                        $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                        $bundleParamsIndexSrc['params']['className']='index';
                        $list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'/index.php',$bundleParamsIndexSrc);
                    }
                }
                else{
                    $list[]=$this->mkdir_path(root.'/src/app/'.$project.'/'.$version.'/Optional/Repository/'.ucfirst($this->getParams($data)[1]['repo']).'');
                    //$list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/optional/repository/'.$this->getParams($data)[1]['repo'].'/index.html',null);

                    $list[]=$this->mkdir_path(root.'/src/app/'.$project.'/'.$version.'/Optional/Repository/'.ucfirst($this->getParams($data)[1]['repo']).'/Src');
                    $list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/Optional/Repository/'.ucfirst($this->getParams($data)[1]['repo']).'/Src/index.html',null);

                    $bundleParamsIndex['execution']='services/repoBundleIndex';
                    $bundleParamsIndex['params']['projectName']=$project;
                    $bundleParamsIndex['params']['version']=$version;
                    $bundleParamsIndex['params']['bundleName']=ucfirst($this->getParams($data)[1]['repo']);
                    $list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/Optional/Repository/'.ucfirst($this->getParams($data)[1]['repo']).'/Index.php',$bundleParamsIndex);

                    $bundleParamsInterface['execution']='services/repoBundleInterface';
                    $bundleParamsInterface['params']['projectName']=$project;
                    $bundleParamsInterface['params']['version']=$version;
                    $bundleParamsInterface['params']['bundleName']=ucfirst($this->getParams($data)[1]['repo']);
                    $list[]=$this->touch_path(root.'/src/app/'.$project.'/'.$version.'/Optional/Repository/'.ucfirst($this->getParams($data)[1]['repo']).'/'.ucfirst($this->getParams($data)[1]['repo']).'Interface.php',$bundleParamsInterface);


                    $this->setAnnotation([
                        'project'=>$project,
                        'version'=>$version,
                        'repo'=>ucfirst($this->getParams($data)[1]['repo'])
                    ]);


                }


                return $this->fileProcessResult($list,function(){
                    echo $this->info('------------------------------------------------------------------------------');
                    echo $this->blue('REPOSITORY HAS SUCCESSFULLY BEEN CREATED IN OPTIONAL/REPOSITORY ');
                    echo $this->info('------------------------------------------------------------------------------');
                });
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


    //set mkdir_path
    public function mkdir_path($data){

        return $this->fileprocess->mkdir_path($data);
    }

    //set mkdir_path
    public function touch_path($data,$param){

        return $this->fileprocess->touch_path($data,$param);
    }

    //mkdir_path process result
    public function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return $this->error('Repository fail');
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


    public function setAnnotation($annotation=array()){

        utils::changeClass(root.'/src/app/'.$annotation['project'].'/'.$annotation['version'].'/serviceAnnotationsController.php',[

            '//annotationController' => '
            
    /**
     * @var $repo'.ucfirst($annotation['repo']).' \src\app\\'.$annotation['project'].'\\'.$annotation['version'].'\Optional\Repository\\'.$annotation['repo'].'\Index
     */
     public $repo'.ucfirst($annotation['repo']).';
     
   
     public function getRepo'.ucfirst($annotation['repo']).'(){

         $this->repo'.ucfirst($annotation['repo']).'=\Repo::'.strtolower($annotation['repo']).'();
         return $this->repo'.ucfirst($annotation['repo']).';
     }
             
     //annotationController
            
            '
        ]);

    }

}