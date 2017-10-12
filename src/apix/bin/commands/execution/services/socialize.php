<?php

namespace Src\App\__projectName__\V1\Config;

class Socialize
{

    /**
     * project socialize git repo config.
     *
     * static call git repo settings for every service.
     * @return array
     */
    public static function gitRepo()
    {
        return [
            'remote'=>[
                'origin'=>[
                    'url'=>null
                ]
            ]
        ];
    }


    /**
     * project socialize facebook config.
     *
     * static call facebook settings for every service.
     * @return array
     */
    public static function facebook()
    {
        return [

            'accessToken'=>'xxx',
            'appId'=>'xxx',
            'appSecret'=>'xxx',
            'appVersion'=>'xxx'
        ];
    }


    /**
     * project socialize instagram config.
     *
     * static call instagram settings for every service.
     * @return array
     */
    public static function instagram()
    {
        return [

        ];
    }


    /**
     * project socialize twitter config.
     *
     * static call twitter settings for every service.
     * @return array
     */
    public static function twitter()
    {
        return [

        ];
    }


    /**
     * project socialize googlePlus config.
     *
     * static call googlePlus settings for every service.
     * @return array
     */
    public static function googlePlus()
    {
        return [

        ];
    }
}
