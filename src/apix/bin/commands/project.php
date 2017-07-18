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
        require("".staticPathModel::$binCommandsPath."/lib/getenv.php");
    }

    //project create command
    public function create ($data){

        $list=[];

        echo $this->info('------------------------------------------------------------------------------');
        echo $this->classical('HI DEVELOPER! WE WANT TO ASK SOME QUESTİONS BEFORE STARTING');
        $composer=$this->ReadStdin('Do you want to use composer in the your project? ["Y","N"]',null,'N');
        $orm=$this->ReadStdin('Which orm do you want to use in the your project? ["sudb","doctrine","eloquent"]',null,'sudb');

        if($this->fileprocess->mkdir($this->getProjectName($data))){

            $touchServiceVersionMe['execution']='project_version';
            $touchServiceVersionMe['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/version.php',$touchServiceVersionMe);

            $touchServicePublishMe['execution']='project_publish';
            $touchServicePublishMe['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/publish.php',$touchServicePublishMe);


            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/storage');


            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/kernel');

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/kernel/middleware');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/kernel/middleware/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/kernel/loc');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/kernel/loc/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/kernel/stubs');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/kernel/stubs/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/kernel/bootstrap');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/kernel/bootstrap/index.html',null);

            $touchKernel['execution']='kernel';
            $touchKernel['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/kernel/kernel.php',$touchKernel);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/storage/lang');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/storage/lang/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/storage/session');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/storage/session/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/storage/logs');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/storage/logs/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/storage/env');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/storage/env/index.html',null);

            if($composer=="y"){

                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/composer');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/composer/index.html',null);

                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/composer.json',null);

                $touchProjectComposer['execution']='project_composer';
                $touchProjectComposer['params']['projectName']=$this->getProjectName($data);
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/composer.json',$touchProjectComposer);
            }



            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/.gitignore',null);

            $touchProjectGitignore['execution']='project_gitignore';
            $touchProjectGitignore['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/.gitignore',$touchProjectGitignore);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/index.html',null);


            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/webServices');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/webServices/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/jobs');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/jobs/index.html',null);

            $touchServiceBaseControllerParams['execution']='serviceBaseController';
            $touchServiceBaseControllerParams['params']['orm']=$orm;
            $touchServiceBaseControllerParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/serviceBaseController.php',$touchServiceBaseControllerParams);

            $touchServiceAdapterControllerParams['execution']='serviceAdapterController';
            $touchServiceAdapterControllerParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/serviceAdapterController.php',$touchServiceAdapterControllerParams);

            $touchServiceTokenControllerParams['execution']='serviceTokenController';
            $touchServiceTokenControllerParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/serviceTokenController.php',$touchServiceTokenControllerParams);


            $serviceLogController['execution']='serviceLogController';
            $serviceLogController['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/serviceLogController.php',$serviceLogController);

            $servicePackageDevController['execution']='servicePackageDevController';
            $servicePackageDevController['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/servicePackageDevController.php',$servicePackageDevController);

            $serviceMiddleController['execution']='serviceMiddlewareController';
            $serviceMiddleController['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/serviceMiddlewareController.php',$serviceMiddleController);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/staticProvider');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/staticProvider/index.html',null);
            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/__call');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/__call/index.html',null);
            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/config');

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/repository');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/repository/index.html',null);


            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/provisions');

            $touchprovisionindex['execution']='services/provision';
            $touchprovisionindex['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/provisions/index.php',$touchprovisionindex);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/provisions/limitation');

            $touchprovisionlimitationaccess['execution']='services/accessRules';
            $touchprovisionlimitationaccess['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/provisions/limitation/accessRules.php',$touchprovisionlimitationaccess);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/provisions/limitation/yaml');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/provisions/limitation/yaml/index.html',null);

            $touchprovisionobjectloader['execution']='services/objectloader';
            $touchprovisionobjectloader['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/provisions/objectloader.php',$touchprovisionobjectloader);


            $touchServiceApp['execution']='app';
            $touchServiceApp['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/app.php',$touchServiceApp);

            $touchServiceSocialize['execution']='services/socialize';
            $touchServiceSocialize['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/socialize.php',$touchServiceSocialize);


            $touchServiceException['execution']='services/exception';
            $touchServiceException['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/exception.php',$touchServiceException);

            $database['execution']='services/database';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/database.php',$database);


            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/optional/platform');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/platform/index.html',null);

            $platformServiceConfParams['execution']='services/platform_config';
            $platformServiceConfParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/optional/platform/config.php',$platformServiceConfParams);

            $database['execution']='services/rabbitMQ';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/rabbitMQ.php',$database);

            $redis['execution']='services/redis';
            $redis['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/config/redis.php',$redis);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/migrations');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/migrations/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/migrations/schemas');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/migrations/schemas/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/migrations/seeds');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/migrations/seeds/index.html',null);

            $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model');
            $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/index.html',null);

            if($orm=="sudb"){
                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/sudb');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/sudb/index.html',null);


                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/sudb/builder');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/sudb/builder/index.html',null);

                $modelVarLoad['execution']='services/modelVarTrait';
                $modelVarLoad['params']['projectName']=$this->getProjectName($data);
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/modelVar.php',$modelVarLoad);
            }


            if($orm=="eloquent"){
                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/eloquent');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/eloquent/index.html',null);

                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/eloquent/builder');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/eloquent/builder/index.html',null);
            }


            if($orm=="doctrine"){
                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/doctrine');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/doctrine/index.html',null);

                $list[]=$this->fileprocess->mkdir($this->getProjectName($data).'/v1/model/doctrine/builder');
                $list[]=$this->fileprocess->touch($this->getProjectName($data).'/v1/model/doctrine/builder/index.html',null);
            }



            return utils::fileProcessResult($list,function() use($data) {
                echo $this->info('------------------------------------------------------------------------------');
                echo $this->classical('WELCOME TO '.$this->getProjectName($data).' PROJECT ');
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