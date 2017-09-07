<?php namespace apix\boot;

use Apix\Utils;
use Apix\StaticPathModel;
use Apix\Connection;
use Symfony\Component\HttpFoundation\Request;

class checkForToken extends Connection {

    /**
     * get token classes.
     * @return mixed
     */
    public function boot(){

        //get token
        $token="".staticPathModel::$appNamespace."\\".app."\\".version."\\serviceTokenController";
        $token=utils::resolve($token);

        $tokenhandle=$token->handle(\Apix\environment::get());
        $this->serviceDump(null,null,['token'=>$tokenhandle['status']]);

        $tokenexcept=$token->except();

        if(!$tokenhandle['status']){
            //return token provision
            return true;

        }

        $queryParams=$this->getQueryParamsFromRoute();

        if($token->status['method']==="header" and service!=="doc"){
            $request=Request::createFromGlobals();
            $headers=$request->headers->all();

            $queryParams=[];
            if(array_key_exists("token",$headers)){
                $queryParams=[
                    '_token'=>$headers['token'][0]
                ];
            }
        }


        //token provision
        if(array_key_exists("_token",$queryParams)){

            if(in_array($queryParams['_token'],$tokenhandle['tokens'])){
                if(!array_key_exists($queryParams['_token'],$tokenhandle['clientIp'])){
                    //return token provision
                    return true;

                }
                if(array_key_exists($queryParams['_token'],$tokenhandle['clientIp']) && $tokenhandle['clientIp'][$queryParams['_token']]==$_SERVER['REMOTE_ADDR']){
                    //return token provision
                    return true;
                }

            }
        }

        //except provision
        if(in_array(app.'/'.service.'/'.method.'',$tokenexcept) OR in_array(app.'/'.service.'',$tokenexcept)){
            //return token provision
            return true;
        }

        //except provision clientIp
        if(array_key_exists($_SERVER['REMOTE_ADDR'],$tokenexcept['clientIp'])){
            if(in_array(app.'/'.service.'/'.method.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']]) OR in_array(app.'/'.service.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']])){
                //return token provision
                return true;
            }
        }

        throw new \LogicException('Token Provision Error');



    }
}