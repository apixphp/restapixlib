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
use Log;


/**
 * Represents a middleware example class.
 * Handle an incoming request.
 * return @class
 */
class __class__  {


    /**
     * Constructor.
     *
     * type dependency injection and middleware construct
     * main loader as construct method
     */
    public function __construct(){}

    /**
     * Represents a middleware method.
     * default method
     * return mixed
     */
    public function handle(){

        //make somethings
    }



}