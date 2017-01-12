<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 13:14
 */

namespace ThirdBridge\Models;


/**
 * Interface FilesInterface
 * @package ThirdBridge\Models
 */
interface FilesInterface
{
    /**
     * @param $file
     * @return string|integer
     */
    public function readFileCsv($file);

    /**
     * @param $file
     * @return string|integer
     */
    public function readFileYml($file);

    /**
     * @param $file
     * @return string|integer
     */
    public function readFileXml($file);

    /**
     * @param $file
     * @return string|integer
     */
    public function getFileType($file);

    /**
     * @param $file
     * @return string|integer
     */
    public function writeOutputFile($file);
}