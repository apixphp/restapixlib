<?php
/*
 * Middleware provide a convenient mechanism for filtering HTTP requests entering your application. For example,
 * Apix includes a middleware that verifies the user of your application is authenticated. If the user is not authenticated,
 * the middleware will redirect the user to the login screen.
 * However, if the user is authenticated, the middleware will allow the request to proceed further into the application. .
 * middleware command
 * __class__
 */

namespace src\app\__projectName__\kernel\middleware;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;


/**
 * Represents a middleware example class.
 * Handle an incoming request.
 * return @class
 */
class __class__  {


    /**
     * Request Object.
     *
     * @class symfony http foundation
     * request object for http
     */
    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){

    }

    /**
     * Represents a middleware method.
     * default method @handle
     * return mixed
     */
    public function handle(){

        //make somethings
        return 'middleware';
    }



}