<?php

namespace Src\App\__projectName__\V1;

use Src\Store\Services\Httprequest as Request;
use Apix\Utils;

class ServiceBaseController
{
    //response object
    public $response='json';

    //default lang name
    public $lang='tr';

    //data log
    public $log=true;

    //cache Adapter
    public $cacheAdapter='file';

    //data object Loader
    public $objectLoader=false;

    //default search driver
    public $search='elasticSearch';

    //default model
    public $model='__orm__';

    //platform config
    public $platform=false;

    //throttle status
    public $throttle;

    //node list
    public $nodes=[];

    //source
    public $source;

    //query
    public $query;

    //main
    public $main;

    //mongo
    public $mongo;

    //webservice
    public $webservice;

    //symfony request
    public $request;

    //http get object
    public $get;

    //http post object
    public $post;

    //http headers object
    public $headers;


    /**
     * Constructor.
     * main loader as construct method
     */
    public function __construct()
    {
        $this->throttle=$this->throttle();
        $this->request=new Request();
        $this->get=$this->request->query();
        $this->post=$this->request->input();
        $this->headers=$this->request->getHeaders();
    }

    /**
     * localization features provide a convenient way to retrieve strings in various languages,
     * allowing you to easily support multiple languages within your application.
     * Language strings are stored in files within the src/app/project_name/storage directory.
     * Within this directory there should be a subdirectory for each language supported by the application:
     * @return string
     */
    public function getLocalization()
    {
        return $this->lang;
    }

    /**
     * service rate limit query,
     * @return boolean
     */
    public function throttle()
    {
        return false;
    }

    /**
     * getExtensionsLoaded.
     * get your extensions loaded for php system
     */
    public function getExtensionsLoaded()
    {
        return $this->response(phpinfo(),'html');
    }

    /**
     * @param $data
     * @param null $output
     * @return mixed
     */
    public function response($data, $output=null){

        return (new \Response($output))->out($data);
    }


    /**
     * @method getClass
     * @return string
     */
    public function getClass(){

        //get class name
        return get_called_class();
    }


    /**
     * Branch Inıtialize.
     * source,main,query
     */
    public function branchInitialize()
    {
        $this->source       =\branch::source();
        $this->query        =\branch::query();
        $this->main         =\branch::main();
        $this->mongo        =\branch::mongo();
        $this->webservice   =\branch::webservice();
    }


    /**
     * Get a unique fingerprint for the request / route / IP address.
     * if show paremeter is false,it returns md5 value
     * if show paremeter is true,it returns array values
     * @param $show boolean
     * @return array
     */
    public function fingerPrint($show=false)
    {
        $request=new Request();
        $list=[
            'ip'                =>$request->getClientIp(),
            'getHost'           =>$request->getHost(),
            'getBasePath'       =>$request->getBasePath(),
            'deviceToken'       =>\app::deviceToken(),
            'service'           =>service,
            'method'            =>Utils::cleanActionMethod(method),
            'request'           =>request,
            'version'           =>version,
            'token'             =>\app::checkToken(),
            'isSecure'          =>$request->isSecure()

        ];

        if ($show===false) {
            return md5(implode("|", $list));
        }
        return $list;
    }


    /**
     * The EventDispatcher component provides tools that allow your application
     * components to communicate with each other by dispatching events and listening to them.
     * event param src/store/services/event
     *
     * @return array
     */
    public function event()
    {
        $events =[
            'eventName'=>function () { }
        ];

        return $events;
    }

    /**
     * The setNode component provides tools that allow your application
     * components to communicate with each other by setNode events and nodejs to them.
     *
     * @return array
     */
    public function setNode($key,$callback)
    {
        $this->nodes[]=$key;
        $query=(new Request())->query();

        if($query['node']==$key){
            $this->nodes['result']=call_user_func($callback);
        }


    }

}
