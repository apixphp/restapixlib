<?php
/*
 * This file is __queueName__ queue command .
 * __queueName__ is a message broker: it accepts and forwards messages
 * You can think about it as a post office: when you put the mail that you want posting in a post box,
 * you can be sure that Mr. Postman will eventually deliver the mail to your recipient
 * In this analogy, __queueName__ is a post box, a post office and a postman
 *
 * publisher class for rabbitMQ
 */

namespace src\app\__projectName__\__version__\optional\jobs\__queueName__\__dir__;

use Src\Store\Services\Httprequest as Request;
use src\app\__projectName__\__version__\serviceLogController as Log;

/**
 * A queue is the name for a post box which lives inside __queueName__ queueu
 * Although messages flow through __queueName__ and your applications,
 * @class publisher
 */
class task {


    //get channel
    public $scheduleTime='* * * *';


    /**
     * Console __queueName__ execute method.
     *
     * directly handle method
     * execute loader as construct method
     * @return string
     */
    public function execute(){

        //make task
    }


}