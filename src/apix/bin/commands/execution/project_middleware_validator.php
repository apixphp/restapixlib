<?php
/*
 * Middleware provide a convenient mechanism for filtering HTTP requests entering your application. For example,
 * Apix includes a middleware that verifies the user of your application is authenticated. If the user is not authenticated,
 * the middleware will redirect the user to the login screen.
 * However, if the user is authenticated, the middleware will allow the request to proceed further into the application. .
 * middleware command
 * validator
 */

namespace src\app\__projectName__\kernel\middleware;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;
use Log;


/**
 * Represents a middleware example class.
 * Handle an incoming request.
 * return @class
 */
class validator  {

    /*
     * @var $request
     */
    public $request;

    /**
     * @var $query
     */
    public $query;

    /**
     * Constructor.
     *
     * type dependency injection and middleware construct
     * main loader as construct method
     */
    public function __construct(){

        //request component
        $this->request=new Request();
        $this->query=$this->request->query();
    }

    /**
     * Represents a middleware method.
     * default method
     * return mixed
     */
    public function handle(){

        //validator : page url
        $this->getUrlPageControl();
    }

    /**
     * get url page control.
     * it is page value on the url
     */
    public function getUrlPageControl(){

        //check page on the url
        if(isset($this->query['page'])){
            if(!is_numeric($this->query['page'])){
                throw new \InvalidArgumentException('page value on the url is not valid');
            }
        }
    }



}