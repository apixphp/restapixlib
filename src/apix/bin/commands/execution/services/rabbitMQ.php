<?php

namespace Src\App\__projectName__\V1\Config;

class RabbitMQ
{

    /**
     * project app.
     *
     * rabbitMQ access for every service.
     * @return array
     */
    public static function rmqSettings()
    {


        //RMQ settings
        $rmq['rabbitMQ']['host']=env('rabbitMQ_host', '192.168.33.10');
        $rmq['rabbitMQ']['port']=env('rabbitMQ_port', '15672');
        $rmq['rabbitMQ']['user']=env('rabbitMQ_user', 'guest');
        $rmq['rabbitMQ']['password']=env('rabbitMQ_password', 'guest');

        //return db
        return $rmq;
    }
}
