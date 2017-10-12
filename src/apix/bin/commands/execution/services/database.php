<?php

namespace Src\App\__projectName__\V1\Config;

class Database
{

    /**
     * project app.
     *
     * static call access for every service.
     *
     * @param string
     * @return array
     */
    public static function dbSettings()
    {

        //default connection
        $connection='mysql';

        //local settings
        $db['mysql']['driver']=env('driver', 'mysql');
        $db['mysql']['host']=env('host', 'localhost');
        $db['mysql']['database']=env('database', 'database');
        $db['mysql']['user']=env('user', 'user');
        $db['mysql']['password']=env('password', 'password');

        //return db
        return $db[$connection];
    }
}
