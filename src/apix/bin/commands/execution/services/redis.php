<?php

namespace Src\App\__projectName__\V1\Config;

class Redis
{

    /**
     * project app.
     *
     * redis access for every service.
     * @return array
     */
    public static function redisConnection()
    {

        //redis settings
        $redis['connection']['host']=env('redis_host', '127.0.0.1');
        $redis['connection']['port']=env('redis_port', '6379');
        $redis['connection']['scheme']=env('redis_scheme', 'tcp');

        //select database names
        //$redis['databases']['redisDb::log']=env('redisDb::log',1);

        //return redis
        return $redis;
    }
}
