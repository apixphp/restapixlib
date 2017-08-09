<?php namespace apix\bin\commands;
use Illuminate\Database\Connectors\Connector;
use Apix\Utils;
use Apix\Console;
use Apix\StaticPathModel;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\HttpFoundation\Request;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class service extends console {

    public $fileprocess;
    public $request;

    public function __construct(){
        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        $this->request=Request::createFromGlobals();
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }


    //service create command
    public function create ($data){

       foreach ($this->getParams($data) as $key=>$value){
           if($key==0){
               foreach ($value as $project=>$service){
                   $version=utils::getAppVersion($project);
                   $list=[];


                   if(file_exists('./src/app/'.$project.'/'.$version.'/__call/'.$service)){

                       if(array_key_exists('file',$data)){
                           if(!file_exists('./src/app/'.$project.'/'.$version.'/__call/'.$service.'/'.$data['file'].'Service.php')){
                                $touchServicePostParams['execution']='services/serviceFilePut';
                                $touchServicePostParams['params']['projectName']=$project;
                                $touchServicePostParams['params']['serviceName']=$service;
                                $touchServicePostParams['params']['version']=$version;
                                $touchServicePostParams['params']['method']=$data['file'];

                                $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/'.$data['file'].'Service.php',$touchServicePostParams);


                               $touchServiceInterfaceParams['execution']='services/fileServiceInterface';
                               $touchServiceInterfaceParams['params']['projectName']=$project;
                               $touchServiceInterfaceParams['params']['serviceName']=$service;
                               $touchServiceInterfaceParams['params']['version']=$version;
                               $touchServiceInterfaceParams['params']['file']=$data['file'];
                               $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/'.$data['file'].'ServiceInterface.php',$touchServiceInterfaceParams);


                               return utils::fileProcessResult($list,function() use($service,$project,$data) {
                                   echo $this->info('-------------------------------------------------------------------------------------------------');
                                   echo $this->classical('CONGRATULATİONS! YOU HAVE CREATED A SERVICE FILE NAMED '.$data['file'].'Service FOR '.$service.' IN THE '.$project.' PROJECT ');
                                   echo $this->info('-------------------------------------------------------------------------------------------------');
                                   echo $this->success('Request : http:ip/[-company]/service/'.$project.'/'.$service.'/index');
                                   echo $this->info('--------------------------------------------------------------------------------------------------');
                               });
                           }
                       }

                   }

                   if($this->fileprocess->mkdir(''.$project.'/'.$version.'/__call/'.$service)){

                       $touchServiceGetParams['execution']='services/getservice';
                       $touchServiceGetParams['params']['projectName']=$project;
                       $touchServiceGetParams['params']['serviceName']=$service;
                       $touchServiceGetParams['params']['version']=$version;
                       $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/getService.php',$touchServiceGetParams);

                       $touchServiceGetInterfaceParams['execution']='services/getserviceInterface';
                       $touchServiceGetInterfaceParams['params']['projectName']=$project;
                       $touchServiceGetInterfaceParams['params']['serviceName']=$service;
                       $touchServiceGetInterfaceParams['params']['version']=$version;
                       $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/getServiceInterface.php',$touchServiceGetInterfaceParams);

                       $touchdeveloperParams['execution']='services/developer';
                       $touchdeveloperParams['params']['projectName']=$project;
                       $touchdeveloperParams['params']['serviceName']=$service;
                       $touchdeveloperParams['params']['version']=$version;
                       $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/developer.php',$touchdeveloperParams);


                       $touchappParams['execution']='services/app';
                       $touchappParams['params']['projectName']=$project;
                       $touchappParams['params']['serviceName']=$service;
                       $touchappParams['params']['version']=$version;
                       $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/app.php',$touchappParams);


                       $touchServiceConfParams['execution']='services/serviceConf';
                       $touchServiceConfParams['params']['projectName']=$project;
                       $touchServiceConfParams['params']['serviceName']=$service;
                       $touchServiceConfParams['params']['version']=$version;
                       $list[]=$this->fileprocess->touch($project.'/'.$version.'/__call/'.$service.'/serviceConf.php',$touchServiceConfParams);


                       return utils::fileProcessResult($list,function() use($service,$project) {
                           echo $this->info('-------------------------------------------------------------------------------------------------');
                           echo $this->classical('CONGRATULATİONS! YOU HAVE CREATED A SERVICE NAMED '.$service.' IN THE '.$project.' PROJECT ');
                           echo $this->info('-------------------------------------------------------------------------------------------------');
                           echo $this->success('Request : http:ip/[-company]/service/'.$project.'/'.$service.'/index');
                           echo $this->info('--------------------------------------------------------------------------------------------------');
                       });

                   }

                   return $this->error('service fail');
               }
           }
       }

    }

    //usage : api service publish project:service names:method1/method2 http:get|post

    //service publish
    public function publish($data){
        foreach ($this->getParams($data) as $key=>$value) {
            if($key==0){


                foreach($value as $project=>$service){
                    $versionPath='./src/app/'.$project.'/version.php';



                    if(!file_exists('./src/app/'.$project.'/declaration')){
                        $this->fileprocess->mkdir_path('./src/app/'.$project.'/declaration');
                        $this->fileprocess->touch_path('./src/app/'.$project.'/declaration/index.html');
                        $this->fileprocess->mkdir_path('./src/app/'.$project.'/declaration/history');
                        $this->fileprocess->touch_path('./src/app/'.$project.'/declaration/history/index.html');
                    }
                    $version=require($versionPath);
                    if(is_array($version) && array_key_exists("version",$version)){
                        $versionNumber=$version['version'];
                    }
                    else{
                        $versionNumber='v1';
                    }



                    $servicePath='\\\\src\\\\app\\\\'.$project.'\\\\'.$versionNumber.'\\\\__call\\\\'.$service.'\\\\'.$this->getParams($data)[2]['http'].'Service';
                    //$names=explode("/",$this->getParams($data)[1]['names']);
                    $list[]=''.$servicePath.'::'.$this->getParams($data)[1]['names'].'';

                    $yamlFilePath=root.'/src/app/'.$project.'/'.$versionNumber.'/__call/'.$service.'/yaml/expected/'.$service.'_'.$this->getParams($data)[2]['http'].'_'.$this->getParams($data)[1]['names'].'.yaml';
                    if(!file_exists($yamlFilePath)){
                        return '!!! No service dump for your service';
                    }

                    $yamlFile=Yaml::parse(file_get_contents($yamlFilePath));

                    $time=time();

                    $yamlFile['publishedDate']=$time;

                    $yamlDump = Yaml::dump($yamlFile);

                    file_put_contents(root.'/src/app/'.$project.'/declaration/history/'.$service.'_'.$this->getParams($data)[2]['http'].'_'.$this->getParams($data)[1]['names'].'.yaml', $yamlDump);

                    unlink($yamlFilePath);

                    $publishPath='./src/app/'.$project.'/publish.php';
                    $publish=require($publishPath);



                    $publishedRoutes=[];
                    foreach($list as $key=>$val){
                        if(array_key_exists("service",$publish)){
                            $valpro=str_replace("\\\\","\\",$val);
                            if(!in_array($valpro,$publish['service']['name'])){
                                $publishedRoutes[]='$publishes["service"]["name"]["'.$service.'"][]="'.$val.'";';;
                            }

                        }
                        else{
                            $publishedRoutes[]='$publishes["service"]["name"]["'.$service.'"][]="'.$val.'";';
                        }

                    }

                    if(count($publishedRoutes)){
                        $dt = fopen($publishPath, "r");
                        $content = fread($dt, filesize($publishPath));
                        fclose($dt);



                        $dt = fopen($publishPath, "w");
$content=str_replace("//publishes","//publishes
".implode("
",$publishedRoutes)."",$content);

                        fwrite($dt, $content);
                        fclose($dt);

                        $this->fileprocess->changeClass(root.'/src/app/'.$project.'/'.$versionNumber.'/__call/'.$service.'/serviceConf.php',[
                            "'dataDump'=>true"=>"'dataDump'=>false"
                        ]);

                        return 'service publish ok';
                    }
                    else{

                        return 'service available';
                    }



                }
            }
        }
    }


    public function dump($data){
        foreach ($this->getParams($data) as $key=>$value) {
            if ($key == 0) {

                foreach ($value as $project => $service) {
                    $versionPath = './src/app/' . $project . '/version.php';

                    $version = require($versionPath);
                    if (is_array($version) && array_key_exists("version", $version)) {
                        $versionNumber = $version['version'];
                    } else {
                        $versionNumber = 'v1';
                    }

                    if(end($data)){
                        $this->fileprocess->changeClass(root.'/src/app/'.$project.'/'.$versionNumber.'/__call/'.$service.'/serviceConf.php',[
                            "'dataDump'=>false"=>"'dataDump'=>".end($data).""
                        ]);
                    }
                    else{
                        $this->fileprocess->changeClass(root.'/src/app/'.$project.'/'.$versionNumber.'/__call/'.$service.'/serviceConf.php',[
                            "'dataDump'=>true"=>"'dataDump'=>".end($data).""
                        ]);
                    }



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

    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }





}