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


class Source extends console {

    public $fileprocess;

    public function __construct(){

        parent::__construct();
        $this->fileprocess=$this->fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        //using : api Source create projectName:ServiceName bundle:bundleName || src:bundleSrc || src:bundleSrcSrcFile


        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                foreach ($value as $project=>$service){
                    $project=ucfirst($project);
                    $service=ucfirst($service);
                    $version=ucfirst(utils::getAppVersion($project));
                    $list=[];

                    if(!file_exists('./src/app/'.$project.'/'.$version.'/__Call/'.$service.'/Source')){
                        $this->fileprocess->mkdir_path('./src/app/'.$project.'/'.$version.'/__Call/'.$service.'/Source/');
                    }

                    if(array_key_exists(2,$this->getParams($data)) && array_key_exists("src",$this->getParams($data)[2])){

                        $srcBundle=explode("/",$this->getParams($data)[2]['src']);
                        if(!file_exists('./src/app/'.$project.'/'.$version.'/__Call/'.$service.'/Source/'.$this->getParams($data)[1]['source'].'/src/'.ucfirst($srcBundle[0]).'/'.ucfirst($srcBundle[0]).'.php')){
                            $list[]=$this->mkdir($project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'/Src/'.ucfirst($srcBundle[0]));
                        }

                        if(array_key_exists(1,$srcBundle)){

                            $bundleParamsIndexSrc['execution']='services/SourceBundleSrcIndex';
                            $bundleParamsIndexSrc['params']['projectName']=$project;
                            $bundleParamsIndexSrc['params']['serviceName']=$service;
                            $bundleParamsIndexSrc['params']['bundleName']=ucfirst($this->getParams($data)[1]['source']);
                            $bundleParamsIndexSrc['params']['srcName']=ucfirst($srcBundle[0]);
                            $bundleParamsIndexSrc['params']['className']=ucfirst($srcBundle[1]);
                            $bundleParamsIndexSrc['params']['version']=$version;
                            $list[]=$this->touch($project.'/'.$version.'/__Call/'.$service.'/Source/'.$this->getParams($data)[1]['source'].'/Src/'.ucfirst($srcBundle[0]).'/'.ucfirst($srcBundle[1]).'.php',$bundleParamsIndexSrc);

                            $requestBundleFile='./src/app/'.$project.'/'.$version.'/__Call/'.$service.'/Source/'.$this->getParams($data)[1]['source'].'/index.php';
                            $this->fileprocess->changeClass($requestBundleFile,['use Src\App\\'.$project.'\\'.$version.'\__Call\\'.$service.'\App;'=>'use Src\App\\'.$project.'\\'.$version.'\__Call\\'.$service.'\App;'.PHP_EOL.'use Src\\App\\'.$project.'\\'.$version.'\\__Call\\'.$service.'\\Source\\'.ucfirst($this->getParams($data)[1]['source']).'\\Src\\'.ucfirst($srcBundle[0]).'\\'.ucfirst($srcBundle[1]).';'
                            ]);

                        }
                        else{
                            $bundleParamsIndexSrc['execution']='services/SourceBundleSrcIndex';
                            $bundleParamsIndexSrc['params']['projectName']=$project;
                            $bundleParamsIndexSrc['params']['serviceName']=$service;
                            $bundleParamsIndexSrc['params']['bundleName']=ucfirst($this->getParams($data)[1]['source']);
                            $bundleParamsIndexSrc['params']['srcName']=ucfirst($srcBundle[0]);
                            $bundleParamsIndexSrc['params']['className']=ucfirst($srcBundle[0]);
                            $bundleParamsIndexSrc['params']['version']=$version;
                            $list[]=$this->touch($project.'/'.$version.'/__Call/'.$service.'/Source/'.$this->getParams($data)[1]['source'].'/src/'.ucfirst($srcBundle[0]).'/'.ucfirst($srcBundle[0]).'.php',$bundleParamsIndexSrc);

                            $requestBundleFile='./src/app/'.$project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'/Index.php';
                            $this->fileprocess->changeClass($requestBundleFile,['use Src\App\\'.$project.'\\'.$version.'\__Call\\'.$service.'\App;'=>'use Src\App\\'.$project.'\\'.$version.'\__Call\\'.$service.'\App;'.PHP_EOL.'use Src\\App\\'.$project.'\\'.$version.'\\__Call\\'.$service.'\\Source\\'.ucfirst($this->getParams($data)[1]['source']).'\\Src\\'.ucfirst($srcBundle[0]).'\\'.ucfirst($srcBundle[0]).';'
                            ]);
                        }
                    }
                    else{
                        $list[]=$this->mkdir($project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'');

                        $list[]=$this->mkdir($project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'/Src');
                        $list[]=$this->touch($project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'/Src/index.html',null);

                        $bundleParamsIndex['execution']='services/SourceBundleIndex';
                        $bundleParamsIndex['params']['projectName']=$project;
                        $bundleParamsIndex['params']['serviceName']=$service;
                        $bundleParamsIndex['params']['bundleName']=ucfirst($this->getParams($data)[1]['source']);
                        $bundleParamsIndex['params']['version']=$version;
                        $list[]=$this->touch($project.'/'.$version.'/__Call/'.$service.'/Source/'.ucfirst($this->getParams($data)[1]['source']).'/Index.php',$bundleParamsIndex);

                        $bundleParamsInterface['execution']='services/SourceBundleInterface';
                        $bundleParamsInterface['params']['projectName']=$project;
                        $bundleParamsInterface['params']['serviceName']=$service;
                        $bundleParamsInterface['params']['bundleName']=ucfirst($this->getParams($data)[1]['source']);
                        $bundleParamsInterface['params']['version']=$version;
                        $list[]=$this->touch($project.'/'.$version.'/__Call/'.$service.'/Source/'.$this->getParams($data)[1]['source'].'/'.ucfirst($this->getParams($data)[1]['source']).'Interface.php',$bundleParamsInterface);


                        $this->setAnnotation([
                            'project'=>$project,
                            'version'=>$version,
                            'service'=>$service,
                            'bundle'=>ucfirst($this->getParams($data)[1]['source'])
                            ]);

                    }


                    return $this->fileProcessResult($list,function(){
                        echo $this->info('------------------------------------------------------------------------------');
                        echo $this->classical('Source Successfully Has Been Created');
                        echo $this->info('------------------------------------------------------------------------------');
                    });
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


    public function setAnnotation($annotation=array()){

        utils::changeClass(root.'/src/app/'.$annotation['project'].'/'.$annotation['version'].'/serviceAnnotationsController.php',[

            '* Trait ServiceAnnotationsController' => '* Trait ServiceAnnotationsController     
 * @method \Src\App\\'.$annotation['project'].'\\'.$annotation['version'].'\__Call\\'.ucfirst($annotation['service']).'\Source\\'.strtolower($annotation['bundle']).'\\Index source'.ucfirst($annotation['bundle']).'  '
        ]);

    }

}