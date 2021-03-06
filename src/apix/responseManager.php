<?php
namespace Apix;

use Apix\Utils;
use Apix\StaticPathModel;
use Spatie\ArrayToXml\ArrayToXml;
use Apix\ObjectLoader;
use Symfony\Component\HttpFoundation\Request;

class responseManager {


    /**
     * @var $definitor
     */
    public $definitor;

    /**
     * @var $request
     */
    public $request;

    /**
     * get response Out construct.
     * booting resolve
     *
     * outputs get boot.
     *
     * @internal param $string
     */
    public function __construct($responseOutType=null){
        if($responseOutType===null){
            $responseOutType=staticPathModel::getAppServiceBase()->response;
        }
        $this->definitor=$responseOutType;

        $this->request=Request::createFromGlobals();

    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param $data
     * @param null $msg
     * @return mixed
     * @internal param $string
     */
    public function responseManagerBoot($data,$msg=null){

        if(!is_array($data)){
            $data=[$data];
        }

        return $this->getQueryErrorLoad($data,function() use ($data,$msg){
            $developInfo=null;
            if(defined("app") && defined("version") && defined("service")) {
                $developInfo = $this->getDeveloperInformationLoad();
            }

            return $this->getStatusDataEmpty($data,$msg,$developInfo,function() use($data,$msg,$developInfo){

                $httpHeaders=['host','connection','cache-control','accept','upgrade-insecure-requests','user-agent',
                    'accept-encoding','accept-language','cookie','postman-token','content-length','origin','content-type','clientToken'];
                $list=[];
                foreach ($this->request->headers->all() as $key=>$value) {
                    if(!in_array($key,$httpHeaders)){
                        $list[$key]=$value;
                    }
                }

                //get status codes
                $statusCodes=Utils::getConfig('statusCodes');

                $data=['success'=>(bool)true,'statusCode'=>$statusCodes[request],
                        'responseTime'=>microtime(true)-time_start,
                        'requestDate'=>date("Y-m-d H:i:s")]+['data'=>$data,'development'=>$developInfo,'links'=>[
                            'href'=>$this->request->getUri(),
                            'client_get'=> $this->request->query->all(),
                            'client_post'=>$this->request->request->all(),
                            'client_headers'=>$list
                    ]];

                return $this->responseDefinitor($data);
            });

        });
    }


    /**
     * get query error params.
     * for values returning from db vs.
     * query error type array
     *
     * outputs get query error.
     *
     * @param array
     * @return response query error runner
     */
    private function getQueryErrorLoad($data,$callback){
        $queryError=[];
        if(array_key_exists("error",$data)){
            if($data['error']){
                $queryError=['success'=>(bool)false]+['error'=>$data];
            }
        }

        if(count($queryError)){
            return $this->responseDefinitor($queryError);
        }
        else{
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }

    }

    /**
     * get getDeveloperInformationLoad.
     * will be added developer information to responseOut.
     * query type array
     *
     * getDeveloperInformationLoad.
     *
     * @param array
     * @return response query getDeveloperInformationLoad runner
     */
    private function getDeveloperInformationLoad(){
        $developer=[];
        $developInfo=null;
        $developerFile=apiPath.'__call/'.service.'/developer.php';
        if(file_exists($developerFile)){
            $developer=require($developerFile);
        }
        if(is_array($developer) && count($developer)){
            $developInfo=$developer;
        }
        return $developInfo;

    }

    /**
     * get getStatusDataEmpty.
     * if responseOut comes empty.
     * query type array
     *
     * getStatusDataEmpty.
     *
     * @param array
     * @return response query getStatusDataEmpty runner
     */
    private function getStatusDataEmpty($data,$msg,$developInfo,$callback){
        if(is_array($data) && count($data)){
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }

        $msg=($msg!==null) ? $msg : 'data is empty';

        $statusCode=204;

        if(is_array($msg) && !$msg['success']){
            $configException=staticPathModel::getConfigStaticApp('exception');
            if($configException::exceptionTypeCodes($msg['errorType'])!==null){
                $statusCode=$configException::exceptionTypeCodes($msg['errorType']);
            }
        }


        $data=['success'=>(bool)false,'statusCode'=>$statusCode,'responseTime'=>microtime(true)-time_start,
                'requestDate'=>date("Y-m-d H:i:s")]+['message'=>$msg,'development'=>$developInfo];

        return $this->responseDefinitor($data);


    }


    /**
     * get response definitor.
     * if responseOut comes empty.
     * query type definitor
     *
     * get response definitor.
     *
     * @param array
     * @return response query definitor runner
     */
    private function responseDefinitor($data){

        define('outPutter',$this->definitor);

        if($this->definitor=="json" OR $this->definitor=="html"){

            //json encode
            return json_encode($data);
        }

        if($this->definitor=="xml"){

            //json encode
            return ArrayToXml::convert($data);
        }

    }

    /**
     * get response definitor.
     * if responseOut comes empty.
     * query type definitor
     *
     * get response definitor.
     *
     * @param array
     * @return response query definitor runner
     */
    public function out($data,$msg=null){
        return $this->responseManagerBoot($data,$msg);
    }

}