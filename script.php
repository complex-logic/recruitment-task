#!/usr/local/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 12:45
 */
require_once 'vendor/autoload.php';
use ThirdBridge\Task;

error_reporting(E_ERROR);


$task = new Task();

if (count($argv) > 1) {
    $task->readFile($argv);
}