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

class project extends console {

    public $fileprocess;

    public function __construct(){

        parent::__construct();
        $this->fileprocess=utils::fileprocess();
        require("".staticPathModel::$binCommandsPath."/lib/getEnv.php");
    }

    //project create command
    public function create ($data){

        $list=[];

        echo $this->info('------------------------------------------------------------------------------');
        echo $this->classical('HI DEVELOPER! WE WANT TO ASK SOME QUESTİONS BEFORE STARTING');
        $Composer=$this->ReadStdin('Do you want to use Composer in the your project? ["Y","N"]',null,'N');
        $orm=$this->ReadStdin('Which orm do you want to use in the your project? ["Sudb","Doctrine","Eloquent"]',null,'Sudb');

        $project=ucfirst($this->getProjectName($data));

        if($this->fileprocess->mkdir($project)){

            $touchServiceVersionMe['execution']='project_version';
            $touchServiceVersionMe['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/Version.php',$touchServiceVersionMe);

            $touchServicePublishMe['execution']='project_publish';
            $touchServicePublishMe['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/Publish.php',$touchServicePublishMe);


            $list[]=$this->fileprocess->mkdir($project.'/Storage');


            $list[]=$this->fileprocess->mkdir($project.'/Kernel');

            $middlewareValidator['execution']='project_middleware_validator';
            $middlewareValidator['params']['projectName']=$project;
            $list[]=$this->fileprocess->mkdir($project.'/Kernel/Middleware');
            $list[]=$this->fileprocess->touch($project.'/Kernel/Middleware/Validator.php',$middlewareValidator);

            $list[]=$this->fileprocess->mkdir($project.'/Kernel/Node');

            $node['execution']='project_node';
            $node['params']['projectName']=null;
            $list[]=$this->fileprocess->touch($project.'/Kernel/Node/App.js',$node);

            $list[]=$this->fileprocess->mkdir($project.'/Kernel/Stubs');
            $list[]=$this->fileprocess->touch($project.'/Kernel/Stubs/index.html',null);

            $touchKernel['execution']='kernel';
            $touchKernel['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/Kernel/Kernel.php',$touchKernel);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Lang');
            $list[]=$this->fileprocess->touch($project.'/Storage/Lang/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Resourches');
            $list[]=$this->fileprocess->touch($project.'/Storage/Resourches/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Jobs');
            $list[]=$this->fileprocess->touch($project.'/Storage/Jobs/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Session');
            $list[]=$this->fileprocess->touch($project.'/Storage/Session/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Logs');
            $list[]=$this->fileprocess->touch($project.'/Storage/Logs/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/Storage/Env');
            $list[]=$this->fileprocess->touch($project.'/Storage/Env/index.html',null);

            if($Composer=="y"){

                $list[]=$this->fileprocess->mkdir($project.'/Composer');
                $list[]=$this->fileprocess->touch($project.'/Composer/index.html',null);

                $list[]=$this->fileprocess->touch($project.'/Composer.json',null);

                $touchProjectComposer['execution']='project_Composer';
                $touchProjectComposer['params']['projectName']=$project;
                $list[]=$this->fileprocess->touch($project.'/Composer.json',$touchProjectComposer);
            }



            $list[]=$this->fileprocess->mkdir($project.'/V1');
            $list[]=$this->fileprocess->touch($project.'/.gitignore',null);

            $touchProjectGitignore['execution']='project_gitignore';
            $touchProjectGitignore['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/.gitignore',$touchProjectGitignore);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional');
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/index.html',null);


            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/WebServices');

            $webServiceConfigParams['execution']='webservice_Config';
            $webServiceConfigParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/WebServices/Config.php',$webServiceConfigParams);

            $webServiceConnectorParams['execution']='webservice_Connector';
            $webServiceConnectorParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/WebServices/Connector.php',$webServiceConnectorParams);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Jobs');
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Jobs/index.html',null);

            $touchServiceBaseControllerParams['execution']='ServiceBaseController';
            $touchServiceBaseControllerParams['params']['orm']=$orm;
            $touchServiceBaseControllerParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/ServiceBaseController.php',$touchServiceBaseControllerParams);

            $touchServiceAnnotationsControllerParams['execution']='ServiceAnnotationsController';
            $touchServiceAnnotationsControllerParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/ServiceAnnotationsController.php',$touchServiceAnnotationsControllerParams);

            $touchServiceTokenControllerParams['execution']='serviceTokenController';
            $touchServiceTokenControllerParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/serviceTokenController.php',$touchServiceTokenControllerParams);


            $ServiceLogController['execution']='ServiceLogController';
            $ServiceLogController['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/ServiceLogController.php',$ServiceLogController);

            $ServicePackageDevController['execution']='ServicePackageDevController';
            $ServicePackageDevController['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/ServicePackageDevController.php',$ServicePackageDevController);

            $serviceMiddleController['execution']='ServiceMiddlewareController';
            $serviceMiddleController['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/ServiceMiddlewareController.php',$serviceMiddleController);

            $list[]=$this->fileprocess->mkdir($project.'/V1/__Call');
            $list[]=$this->fileprocess->touch($project.'/V1/__Call/index.html',null);
            $list[]=$this->fileprocess->mkdir($project.'/V1/Config');

            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Repository');
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Repository/index.html',null);


            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Provisions');

            $touchprovisionindex['execution']='services/provision';
            $touchprovisionindex['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Provisions/Index.php',$touchprovisionindex);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Provisions/Limitation');

            $touchprovisionLimitationaccess['execution']='services/accessRules';
            $touchprovisionLimitationaccess['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Provisions/Limitation/accessRules.php',$touchprovisionLimitationaccess);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Provisions/Limitation/Yaml');
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Provisions/Limitation/Yaml/index.html',null);

            /*$touchprovisionobjectloader['execution']='services/objectloader';
            $touchprovisionobjectloader['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Provisions/objectloader.php',$touchprovisionobjectloader);*/


            $touchServiceApp['execution']='App';
            $touchServiceApp['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/App.php',$touchServiceApp);

            $touchAuthApp['execution']='Auth';
            $touchAuthApp['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/Auth.php',$touchAuthApp);


            $touchServiceSocialize['execution']='services/socialize';
            $touchServiceSocialize['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/Socialize.php',$touchServiceSocialize);


            $touchServiceException['execution']='services/exception';
            $touchServiceException['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/Exception.php',$touchServiceException);

            $database['execution']='services/database';
            $database['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/Database.php',$database);


            $list[]=$this->fileprocess->mkdir($project.'/V1/Optional/Platform');
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Platform/index.html',null);

            $PlatformServiceConfParams['execution']='services/Platform_Config';
            $PlatformServiceConfParams['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Optional/Platform/Config.php',$PlatformServiceConfParams);

            $database['execution']='services/rabbitMQ';
            $database['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/RabbitMQ.php',$database);

            $redis['execution']='services/redis';
            $redis['params']['projectName']=$project;
            $list[]=$this->fileprocess->touch($project.'/V1/Config/Redis.php',$redis);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Migrations');
            $list[]=$this->fileprocess->touch($project.'/V1/Migrations/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Migrations/Schemas');
            $list[]=$this->fileprocess->touch($project.'/V1/Migrations/Schemas/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Migrations/Seeds');
            $list[]=$this->fileprocess->touch($project.'/V1/Migrations/Seeds/index.html',null);

            $list[]=$this->fileprocess->mkdir($project.'/V1/Model');

            if($orm=="Sudb"){
                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Sudb');


                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Sudb/Builder');
                $list[]=$this->fileprocess->touch($project.'/V1/Model/Sudb/Builder/index.html',null);

                $ModelVarLoad['execution']='services/ModelVarTrait';
                $ModelVarLoad['params']['projectName']=$project;
                $list[]=$this->fileprocess->touch($project.'/V1/Model/ModelVar.php',$ModelVarLoad);
            }


            if($orm=="Eloquent"){
                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Eloquent');

                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Eloquent/Builder');
                $list[]=$this->fileprocess->touch($project.'/V1/Model/Eloquent/Builder/index.html',null);
            }


            if($orm=="Doctrine"){
                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Doctrine');

                $list[]=$this->fileprocess->mkdir($project.'/V1/Model/Doctrine/Builder');
                $list[]=$this->fileprocess->touch($project.'/V1/Model/Doctrine/Builder/index.html',null);
            }



            return utils::fileProcessResult($list,function() use($data,$project) {
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('WELCOME TO '.$project.' PROJECT ');
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->success('+++ Your project has been created succesfully...');
                echo $this->info('------------------------------------------------------------------------------');
            });
        }

        return $this->error('project fail');

    }


    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }


}