<?php
/*
 * Middleware provide a convenient mechanism for filtering HTTP requests entering your application. For example,
 * Apix includes a middleware that verifies the user of your application is authenticated. If the user is not authenticated,
 * the middleware will redirect the user to the login screen.
 * However, if the user is authenticated, the middleware will allow the request to proceed further into the application. .
 * middleware command
 * auth
 */

return [

    /**
     * middleware validator
     * value restrictions
     * array | string['all']
     * array service:request:method | service:request | service
     */
    'validator'=>'all',
    'authenticate'=>'all',

    /**
     * exclude
     * it excludes middleware
     * * array service:request:method | service:request | service
     */
    'exclude'=>[
        'validator'=>[],
        'authenticate'=>['login','logout']
    ]
];
