<?php
/*
 * This file is console command .
 * console command
 * __class__
 */

namespace src\app\__projectName__\kernel\commands;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Src\Store\Services\FileProcess as File;
use Apix\Console;

/**
 * Represents a console command example class.
 * access : api __class__
 * every method that on this command is called with console method as string on console
 * return type string
 */
class __class__ extends  console {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createSignature = 'api __class__ create key:value';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createDescription = '';


    /**
     * Represents a create method.
     * api __class__ create --
     * return type string
     */
    public function handle($arguments){

        //make somethings
        return $this->info('__class__ command');
    }


}