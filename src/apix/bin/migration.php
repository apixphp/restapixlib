<?php
/*
 * This file is console command .
 * console command
 * test
 */

namespace apix\bin;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Apix\Utils;
use Apix\Console;
use Apix\StaticPathModel;

/**
 * Represents a console command example class.
 * access : api test
 * every method that on this command is called with console method as string on console
 * return type string
 */
class migration extends console {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createSignature = 'api test create key:value';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $createDescription = '';


    /**
     * Represents a create method.
     * api test create --
     * return type string
     */
    public function handle($arguments){

        //make somethings
        $arg=$this->getArg($arguments);
        if(array_key_exists("move",$arg)){
            return $this->moveMigration($arg);
        }
        $migrationPath="\\src\\store\\packages\\providers\\migrations\\manager";
        $migration=new $migrationPath($arg);
        return $migration->handle();
    }


    /**
     * Symfony process handle.
     * new process
     * return type exec
     */
    private function getArg($arguments){
        $list=[];
        foreach($arguments as $key=>$value){
            if($key=="pull" || $key=="push"){
                $list['project']=$value;
                $list['migration']=$key;
            }
            else{
                $list[$key]=$value;
            }
        }

        return $list;

    }


    /**
     * Symfony process handle.
     * new process
     * return type exec
     */
    private function exec($arguments){

        //new process
        $process = new Process($arguments);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }


    /**
     * Symfony process handle.
     * new process
     * return type exec
     */
    private function moveMigration($arguments){

        $migrationPathWillBeMoved=staticPathModel::getProjectPath($arguments['move']).'/'.utils::getAppVersion($arguments['move']).'/migrations/schemas/'.$arguments['schema'];
        $newPath=root.'/'.staticPathModel::$storeMigrationsPath.'/schemas/'.$arguments['schema'];


        $migrationPurePath=str_replace(root.'/','',$migrationPathWillBeMoved);
        $migrationNamespace=str_replace('/','\\',$migrationPurePath);
        $newMigrationNamespace=str_replace('/','\\',str_replace(root.'/','',$newPath));


        if(rename($migrationPathWillBeMoved,$newPath)){

            foreach (glob($newPath."/*.php") as $filename) {
                utils::changeClass($filename,[
                    $migrationNamespace=>$newMigrationNamespace
                ]);
            }

            echo 'migration named '.$arguments['schema'].' in '.$arguments['move'].' project has been successfully moved';
            echo PHP_EOL;
        }


        $migrationSeedPathWillBeMoved=staticPathModel::getProjectPath($arguments['move']).'/'.utils::getAppVersion($arguments['move']).'/migrations/seeds';
        $newSeedPath=root.'/'.staticPathModel::$storeMigrationsPath.'/seeds';


        $migrationSeedPurePath=str_replace(root.'/','',$migrationSeedPathWillBeMoved);
        $migrationSeedNamespace=str_replace('/','\\',$migrationSeedPurePath);
        $newMigrationSeedNamespace=str_replace('/','\\',str_replace(root.'/','',$newSeedPath));

        if(rename($migrationSeedPathWillBeMoved,$newSeedPath)){

            foreach (glob($newSeedPath."/*.php") as $filename) {
                utils::changeClass($filename,[
                    $migrationSeedNamespace=>$newMigrationSeedNamespace
                ]);
            }

            echo 'migration seeds named '.$arguments['schema'].' in '.$arguments['move'].' project has been successfully moved';

        }
    }


}