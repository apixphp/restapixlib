<?php
namespace Apix;

use Apix\Utils;
use Apix\StaticPathModel;
use Apix\RateLimitQuery;
use Apix\ServiceDumpObjects;
use Symfony\Component\HttpFoundation\Request;


/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class BaseDefinitor extends Kernel {

    public $request;
    protected $projectPath='src/app';


    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    protected function getPreLoaderClasses(){
        return $this->getFileClassRequire(root.'/vendor/apixphp/restapixlib/src/apix/appClassAlias.php');

    }

    /**
     * get resolve classes.
     *
     * outputs class resolver.
     *
     * @param string
     * @return response resolve runner
     */

    protected function getClassDependencyResolver(){
        $resolve=$this->getFileClassRequire(root.'/lib/resolver.php');
        return new \classresolver();

    }

    /**
     * get router list classes.
     *
     * outputs class resolver.
     *
     * @param string
     * @return response router lis runner
     */

    protected function refreshRouterList($apix,$memory){
        if(environment()=="local"){
            return utils::refreshServiceRouteList(app,service,version,strtolower(request),$apix,$memory);
        }


    }


    /**
     * get middleware list classes.
     *
     * outputs class middleware.
     *
     * @param string
     * @return response router lis runner
     */

    protected function serviceMiddlewareRun(){
        return (new \Apix\ServiceMiddleware())->handle();
    }





    /**
     * get serviceDump classes.
     *
     * it dumps service objects and service requirements.
     *
     * @param serviceDump
     * @return response serviceDump runner
     */
    protected function serviceDump($requestServiceMethodReal=null,$requestServiceMethod=null,$other=array()){
        return $this->serviceConf(function() use ($requestServiceMethodReal,$requestServiceMethod,$other){
            return new serviceDumpObjects($requestServiceMethodReal,$requestServiceMethod,$other);
        });


    }

    /**
     * get serviceconf classes.
     *
     * outputs class resolver.
     *
     * @param string
     * @return response serviceConf runner
     */
    protected function serviceConf($callback=null){
        $serviceConfFile=apiPath."__call/".service."/serviceConf.php";
        if(file_exists($serviceConfFile)){
            $serviceConf=require($serviceConfFile);
            if($callback==null){
                return $serviceConf;
            }

            if(is_callable($callback)){
                if(is_array($serviceConf) && array_key_exists("dataDump",$serviceConf) && $serviceConf['dataDump'] && environment()=="local"){
                    return call_user_func($callback);
                }
            }
        }
        return [];

    }


    /**
     * get definition classes.
     *
     * outputs class definition.
     *
     * @param string
     * @return response definition runner
     */

    protected function getAppDefinitionLoader(){

        $appDefinition=\src\store\config\app::getAppDefinition();
        $userappDefinitionClass=api."config\\app";
        $userappDefinition=$userappDefinitionClass::getAppDefinition();
        $appDefinition=$appDefinition+$userappDefinition;
        if(count($appDefinition)){
            foreach($appDefinition as $key=>$value){
                define($key,$value);
            }
        }

    }

    /**
     * get directory name.
     *
     * directory name
     *
     * @param string
     * @return directory name runner
     */
    protected function getDirectoryName(){

        $requestUri=explode("/",$this->requestUri());
        $list=[];
        foreach($requestUri as $requestValue){
            if($requestValue=="service"){
                break;
            }

            if(strlen($requestValue)>0){
                $list[]=$requestValue;
            }

        }
        return implode("/",$list);
    }

    /**
     * get request uri.
     *
     * this checks request uri parameter.
     *
     * @param string
     * @return request uri runner
     */

    protected function requestUri(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * compare with root to request uri.
     *
     * compare request uri
     *
     * @param string
     * @return request uri compare runner
     */
    protected function getServiceNameAndMethodFromRequestUri(){
        $service=str_replace("/".$this->getDirectoryName()."/service/","",$this->requestUri());
        return explode("/",$service);
    }


    /**
     * get pure method from service
     *
     * pure method name
     *
     * @param string
     * @return pure method runner
     */
    protected function getPureMethodNameFromService(){
        $service=$this->getServiceNameAndMethodFromRequestUri();
        return preg_replace('@\?(.*)@is','',end($service)).'Action';
    }


    /**
     * get query params
     *
     * query params
     *
     * @param string
     * @return query params runner
     */

    protected function getQueryParamsFromRoute(){

        $service=$this->getServiceNameAndMethodFromRequestUri();
        $params=preg_replace('@'.str_replace("Action","",$this->getPureMethodNameFromService()).'\?@is','',end($service));
        if($params==$this->getPureMethodNameFromService()) {
            return [];
        }
        else {
            $getParams=explode("&",$params);
            $paramlist=[];
            foreach ($getParams as $main){
                $getParamsMain=explode("=",$main);
                if(count($getParamsMain)>0 && array_key_exists(1,$getParamsMain))
                {
                    $paramlist[$getParamsMain[0]]=$getParamsMain[1];
                }

            }
            return $paramlist;
        }
    }


    /**
     * get config version number
     *
     * version number
     *
     * @param string
     * @return get config version runner
     */
    protected function getConfigVersionNumber(array $data){

        $getVersionFile=$this->getProjectVersioning($data);
        if(file_exists($getVersionFile)){
            $version=$this->getFileClassRequire($getVersionFile);
            if(is_array($version) && array_key_exists("version",$version)) {
                return $version['version'];
            }
            return 'v1';
        }
    }


    /**
     * get logging.
     *
     * this checks data uri parameter.
     *
     * @param string
     * @return request logging runner
     */

    protected function logging($data,$callback){
        //this fake
        $instance=$this;
        if(array_key_exists("token",$this->getQueryParamsFromRoute())){
            $token=$this->getQueryParamsFromRoute()['token'];
        }
        else{
            $token=null;
        }
        $logdata=[
            'project'=>app,
            'version'=>version,
            'service'=>service,
            'method'=>method,
            'http'=>request,
            'token'=>$token,
            'data'=>$data
        ];
        $log="\\src\\app\\".app."\\".version."\\serviceLogController";
        $log=utils::resolve($log);
        if($log->handle($logdata)){
            return call_user_func($callback);
        }
        return $instance->responseOut([],'logging false');

    }



    /**
     * response out.
     *
     * outputs last data.
     *
     * @param string
     * @return response out runner
     */

    protected function responseOut($data,$msg=null){

        if(!is_array($data)){
            return $data;
        }
        else{

            $responseManager='\Apix\ResponseManager';

            if(defined('app')){
                $responseManager=new $responseManager();
            }
            else{

                $responseManager=new $responseManager('json');
            }


            return $responseManager->responseManagerBoot($data,$msg);
        }

    }


    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    protected function checkPackageAuto($service){
        if(file_exists(root."/".staticPathModel::$apiPackageAutoPath."/".$service[1]."/".$service[1].".php")){
            return [
                'status'=>true,
                'class'=>"".staticPathModel::$apiPackageAutoNamespace."\\".$service[1]."\\".$service[1]
            ];
        }
        return [
            'status'=>false
        ];
    }



    /**
     * get preloader dev classes.
     *
     * outputs project package dev.
     *
     * @param string
     * @return response package dev runner
     */

    protected function checkPackageDev($service){

        $servicePackageDev=require(root.'/src/app/'.app.'/'.version.'/servicePackageDevController.php');
        if(is_array($servicePackageDev))
        {
            if(!in_array($service[1],$servicePackageDev['packageDevSource']['package'])){
                $service[1]=null;
            }
        }
        if(file_exists(root."/".staticPathModel::$apiPackageDevPath."/".$service[1]."/".request."Service.php")){
            $definitions=(array_key_exists($service[1],$servicePackageDev['packageDevSource']['packageDefinition'])) ? $servicePackageDev['packageDevSource']['packageDefinition'][$service[1]] : null;
            return [
                'status'=>true,
                'definitions'=>$definitions,
                'class'=>"".staticPathModel::$apiPackageDevNamespace."\\".$service[1]."\\".strtolower(request)."Service",
                'service'=>$service[1]
            ];
        }
        return [
            'status'=>false
        ];




    }

    /**
     * bootstrappers
     */
    protected function bootStrap(){
        $boots=\apix\staticPathModel::getSystemKernel()->boot;
        foreach ($boots as $boot){
            utils::resolve($boot)->boot();
        }
    }



    /**
     * get provision classes.
     *
     * outputs provision.
     *
     * @param string
     * @return response class_alias runner
     */

    protected function provision($callback){

        if(!file_exists("./src/app/".app."/".version."/optional/provisions/index.php")){
            return $this->responseOut([],"project or versioning is not valid");
        }
        $serviceprovision="\\src\\app\\".app."\\".version."\\optional\\provisions\\index";
        $serviceprovision=utils::resolve($serviceprovision);
        $serviceprovisionMethod=''.request.'Provision';
        $serviceprovisionExcept=''.request.'Except';
        $spl=$serviceprovision->$serviceprovisionMethod();
        if($spl['success'] OR in_array(service,$serviceprovision->$serviceprovisionExcept())){
            return call_user_func($callback);
        }
        else{
            $message=$spl['message'];
        }

        return $this->responseOut([],$message);

    }

    /**
     * get file fix log params.
     *
     * outputs get file.
     *
     * @param string
     * @return response fix log params runner
     */

    protected function getFixLog($data){
        $fixLog=$this->getFileClassRequire(root.'/vendor/apixphp/restapixlib/src/apix/fixlogparams.php');
        return $fixLog[$data];
    }

    /**
     * get file rateLimiterQuery params.
     *
     * outputs get rateLimiterQuery.
     *
     * @param string
     * @return response rateLimiterQuery params runner
     */

    protected function rateLimiterQuery($callback){
        $throttleStatus=staticPathModel::getAppServiceBase()->throttle;
        if($throttleStatus){
            $status=new rateLimitQuery();
            if($status->handle($throttleStatus) && is_callable($callback)){
                return call_user_func($callback);
            }
            return $this->responseOut([],"you have request limiter in the described time,Please wait and try your request");
        }
        return call_user_func($callback);

    }


    /**
     * get file boot params.
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */

    protected function bootServiceLoader($serviceMethod){
        $appBootLoader=new \Apix\appBootLoader();
        return $appBootLoader->boot($serviceMethod);
    }

    /**
     * get file classes.
     *
     * outputs get file.
     *
     * @param string
     * @return response file runner
     */

    protected function getFileClassRequire($data){
        return require($data);
    }

    /**
     * get version classes.
     *
     * outputs get version.
     *
     * @param string
     * @return response version runner
     */

    protected function getProjectVersioning($data){
        return root.'/'.$this->projectPath.'/'.$data['serviceName'].'/version.php';
    }

    /**
     * get service config classes.
     *
     * outputs get config.
     *
     * @param string
     * @return response service config runner
     */
    protected function getServiceConfig(){
        $serviceConfig=api."config\\app";
        $serviceConfig=new $serviceConfig();
        return $serviceConfig;
    }


    /**
     * get service isJson method.
     *
     * outputs get config.
     *
     * @param string
     * @return response service config runner
     */
    public function isArray($data) {
        if(is_array($data)){
            return true;
        }
        return false;
    }


    public function responseOutRedirect($instance,$requestServiceMethodReal,$type=true){

        $responseOutType=(defined('outPutter')) ? outPutter : utils::responseOutType();
        $responseOutType=(defined('guzzleOutPutter')) ? guzzleOutPutter : $responseOutType;


        if($responseOutType=="html"){
            header('Content-Type: text/'.$responseOutType);
        }
        else{
            header('Content-Type: application/'.$responseOutType);
        }


        if($type){
            return $instance->responseOut($requestServiceMethodReal);
        }
        return $instance->responseOut([],$requestServiceMethodReal);

    }

    public function setErrorHandlerFormatter($instance){
        if(defined('app')){
            set_error_handler([$instance,'setErrorHandler']);
            register_shutdown_function([$instance,'fatalErrorShutdownHandler']);
        }
    }

    public function checkForMaintenance($instance){
        $downPath=StaticPathModel::getProjectPath(app).'/down.yaml';
        if(file_exists($downPath)){
            throw new \LogicException($instance->getFixLog('maintenance'));
        }
    }



}