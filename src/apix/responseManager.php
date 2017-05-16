<?php
/*
 * This file is response method for every service
 * default : response data array
 * managed as webservice response method in main controller
 * return @array
 */
namespace apix;

class responseManager {

    /**
     * @return string
     */
    public function test(){
        return 'apix test';
    }
}