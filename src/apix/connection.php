<?php
namespace Apix;

use Src\Store\Services\Httprequest as Request;
use Apix\BaseDefinitor as Definitor;

class Connection extends Definitor {

    /**
     * @method __construct
     */
    public function __construct(){

        /**
         * getServiceNameAndMethodFromRequestUri
         * connection run getClassDependencyResolver
         * get service and file method from request uri
         * for service base controller
         */
        self::$service=$this->getServiceNameAndMethodFromRequestUri();

        /**
         * getPureMethodNameFromService
         * connection run getPureMethodNameFromService
         * get only method name from service
         * for service base controller
         */
        self::$serviceMethod=$this->getPureMethodNameFromService();

        /**
         * getQueryParamsFromRoute
         * connection run getQueryParamsFromRoute
         * get query params from service
         * for service base controller
         */
        self::$queryParams=$this->getQueryParamsFromRoute();

        /**
         * getVersionForProject
         * connection run getVersionForProject
         * assign version number
         * for service base controller
         */
        self::$getVersion=$this->getVersionForProject();
    }

    /**
     * connect to api service (created service).
     * @return mixed
     */
    public static function run() {

        /**
         * @var $instance \Apix\Connection
         * @var $service
         * @var $serviceMethod
         * @var $getVersion
         */
        $instance=self::getInstance();
        $service=self::$service;
        $serviceMethod=self::$serviceMethod;
        $getVersion=self::$getVersion;

        return $instance->checkServiceUrlParamArray(function() use ($service,$serviceMethod,$getVersion,$instance) {

            //kernel booting
            $instance->getAutoLoadsFromServices();
            $instance->setErrorHandlerFormatter($instance);

            return $instance->rateLimiterQuery(function() use ($service,$serviceMethod,$getVersion,$instance) {

                $instance->booting($instance);
                $instance->serviceMiddlewareRun();

                        //check package auto service and method
                if($instance->checkPackageAuto($service)['status']){
                    $packageAuto=utils::resolve($instance->checkPackageAuto($service)['class']);
                    return $instance->responseOutRedirect($instance,$packageAuto->$serviceMethod(),true);

                }

                        //check package dev service and method
                        if($instance->checkPackageDev($service)['status']){
                            $cDev=$instance->checkPackageDev($service);
                            $packageDev=utils::resolve($cDev['class']);
                            define("devPackage",true);
                            return $instance->responseOutRedirect($instance,$packageDev->$serviceMethod());
                        }

                        $serviceNo=$instance->getFixLog('serviceNo');
                        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'')){
                            return $instance->responseOutRedirect($instance,$serviceNo,false);
                        }

                        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php')){
                            return $instance->responseOutRedirect($instance,$serviceNo,false);

                        }

                        //service main file extends this file
                        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php');

                        //$service Base
                        $serviceBase=utils::resolve(api."serviceBaseController");

                        //apix resolve
                        $apix=utils::resolve("\\src\\app\\".$service[0]."\\".$getVersion."\\__call\\".$service[1]."\\".strtolower(request)."Service");


                        $requestServiceMethod=$serviceMethod;
                        if(method_exists($apix,$requestServiceMethod)){
                            if(property_exists($apix,"forbidden") && \Apix\environment::get()=="production"){
                                if($apix->forbidden){
                                    return $instance->responseOutRedirect($instance,$instance->getFixLog('noaccessright'),false);
                                }
                            }
                            //call service
                            $restrictions=$apix->restrictions();
                            $restrictionsStatus=true;
                            $restrictionsServiceMethod=Utils::cleanActionMethod($requestServiceMethod);
                            if(is_array($restrictions) && array_key_exists($restrictionsServiceMethod,$restrictions)){
                                $restrictionsStatus=$restrictions[$restrictionsServiceMethod];
                            }
                            if($restrictionsStatus){
                                $serviceBasePlatformStatus=$serviceBase->platform;


                                $memoryGetUsage = memory_get_usage();

                                $requestServiceMethodReal=null;
                                if($serviceBasePlatformStatus){
                                    $servicePlatform=utils::resolve(staticPathModel::$apiPlatformNamespace);
                                    $serviceBasePlatformConfig='\\src\\app\\'.app.'\\'.version.'\\optional\platform\config';
                                    $platformDirectoryCallStaticVariable=utils::resolve($serviceBasePlatformConfig)->handle();

                                    if($platformDirectoryCallStaticVariable!==null){
                                        $requestServiceMethodReal=$servicePlatform->$platformDirectoryCallStaticVariable()->take(function() use(&$requestServiceMethodReal,$apix,$requestServiceMethod,$instance){
                                            return $instance->responseOutRedirect($instance,$apix->$requestServiceMethod(),true);
                                        });

                                    }


                                }

                                if($requestServiceMethodReal===null){
                                    $requestServiceMethodReal=$apix->$requestServiceMethod();
                                }


                                $ClassMethodMemoryGetUsage = memory_get_usage()-$memoryGetUsage;

                                $instance->refreshRouterList($apix,$ClassMethodMemoryGetUsage);


                                $instance->serviceDump($requestServiceMethodReal,$requestServiceMethod);

                                if($serviceBase->log){

                                    return $instance->logging($requestServiceMethodReal,function() use ($instance,$requestServiceMethodReal){
                                        return $instance->responseOutRedirect($instance,$requestServiceMethodReal,true);
                                    });
                                }
                                else{

                                    return $instance->responseOutRedirect($instance,$requestServiceMethodReal,true);

                                }

                            }

                            return $instance->responseOutRedirect($instance,$instance->getFixLog('serviceRestrictions'),false);

                        }
                        else{

                            return $instance->responseOutRedirect($instance,$instance->getFixLog('invalidservice'),false);
                        }

                    });



        });
    }

    /**
     * @param string
     * @return mixed
     */
    public function getVersionForProject(){

        //get version number from config
        $defaultVersionCheck=$this->getConfigVersionNumber(['serviceName'=>self::$service[0]]);
        return (array_key_exists("version",self::$queryParams)) ? self::$queryParams['version'] : $defaultVersionCheck;

    }

    /**
     * get service autoloads classes.
     *
     * outputs get autoloads.
     *
     * @param string
     * @return response autoloads runner
     */
    public function getAutoLoadsFromServices(){

        //get defines
        $this->getDefinitions();

        //get preloader classes
        $this->getPreLoaderClasses();

        //check environment
        \Apix\environment::config();

        $projectComposerPath=root.'/'.src.'/'.app.'/composer/autoload.php';
        if(file_exists($projectComposerPath)){
            require_once $projectComposerPath;
        }


    }


    /**
     * get definitions classes.
     *
     * outputs get definitive.
     *
     * @param string
     * @return response define runner
     */
    public function getDefinitions(){

        $request=new request();
        $basePath=$request->getHost().''.$request->getBasePath();

        //define project
        define("basePath",$basePath);
        define("app",ucfirst(self::$service[0]));
        self::$service[1]=(array_key_exists(1,self::$service)) ? self::$service[1] :null;
        define("service",self::$service[1]);
        define("version",ucfirst(self::$getVersion));
        define("method",self::$serviceMethod);
        define("application",root.'/'.src.'/'.app.'');
        define("api","\\src\\app\\".app."\\".version."\\");
        define("apiPath",root."/src/app/".app."/".version."/");
        define("request",$_SERVER['REQUEST_METHOD']);
        $this->getAppDefinitionLoader();


    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    public function checkServiceUrlParamArray($callback){
        if(strlen(self::$service[0])==0){
            return $this->responseOut([],$this->getFixLog('projectPathError'));
        }
        if(!file_exists(root . '/'.src.'/'.self::$service[0].'')){
            return $this->responseOut([],$this->getFixLog('projectNo'));
        }
        return call_user_func($callback);
    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    public static function getInstance(){
        if(self::$_instance==null){ self::$_instance=new self;}
        return self::$_instance;

    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    public function setErrorHandler($errNo=null, $errStr=null, $errFile=null, $errLine=null, array $errContext){

        //get App Exception Config Class
        $exception='\\src\\app\\'.app.'\\'.version.'\\config\\exception';

        $appExceptionSuccess=['success'=>false];

        $errType='Undefined';
        if(preg_match('@(.*?):@is',$errStr,$errArr)){
            $errType=trim(str_replace('Uncaught','',$errArr[1]));
        }

        if(preg_match('@(.*?):(.*?)in@is',$errStr,$errStrRealArray)){
            $errStrReal=trim($errStrRealArray[2]);
        }

        if($errType==="Undefined"){
            $errStrReal=$errStr;
        }
        else{
            $errContext['trace']=$errStr;
        }



        $appException=$appExceptionSuccess+$exception::handler($errNo,$errStrReal,$errFile,$errLine,$errType,$errContext);

        if(environment()!=='local'){
            $appException=[];
            $appException=$appExceptionSuccess+['errorType'=>$errType,'errorString'=>$errStrReal];
        }


        staticPathModel::getAppServiceLog('error')->handle($appException);

        //set json app exception
        echo $this->responseOutRedirect($this,$appException,false);
        exit();


    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    public function fatalErrorShutdownHandler(){

        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            $this->setErrorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line'],[]);
        }
    }

    public function getDeclarationApi(){
        if(self::$service[1]=="doc"){
            header("Content-Type: text/html");
            $apiDoc=staticPathModel::$apiDocNamespace;
            echo utils::resolve($apiDoc)->index();
            die();
        }
    }













}