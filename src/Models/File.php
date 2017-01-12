<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 13:18
 */

namespace ThirdBridge\Models;

use Symfony\Component\Yaml\Parser;

/**
 * Class File
 * @package ThirdBridge\Models
 */
class File implements FilesInterface
{
    const CSV_FILE_EXT = 'csv';
    const XML_FILE_EXT = 'xml';
    const YML_FILE_EXT = 'yml';

    const FILE_COL_ID_NAME = 0;
    const FILE_COL_ID_ACTIVE = 1;
    const FILE_COL_ID_VALUE = 2;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $result;

    /**
     * File constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }


    /**
     * This function will call readfile function based on file extension
     *
     * @throws \Exception
     */
    public function read()
    {
        $filePath = $this->parameters[0];

        switch (strtolower($this->getFileType($filePath))) {
            case $this::CSV_FILE_EXT:
               $this->readFileCsv($filePath);
                break;
            case $this::XML_FILE_EXT:
                $this->readFileXml($filePath);
                break;
            case $this::YML_FILE_EXT:
                $this->readFileYml($filePath);
                break;
            default:
                throw new \Exception('Input file extension not supported');
        }

    }

    /**
     * This function will display value output
     *
     * @return null|integer
     */
    public function output()
    {
        if (isset($this->parameters[1])) {
            $this->writeOutputFile($this->parameters[1]);
            return null;
        } else {
            return $this->result;
        }
    }

    /**
     * This function will write results in text file
     * @param string $file
     */
    public function writeOutputFile ($file)
    {
        $file = fopen($file, "w") or die("Unable to open file!");
        fwrite($file, $this->result);
        fclose($file);
    }

    /**
     * @param string $file
     * @return string
     */
    public function getFileType($file)
    {
        $info = new \SplFileInfo($file);
        return $info->getExtension();

    }

    /**
     * This function will read csv file and calculate total values
     *
     * @param string $file
     */
    public function readFileCsv($file)
    {
        $count = 0;
        $fields = true;
        if (($file = fopen($file, "r")) !== FALSE) {
            while (! feof($file)) {

                $data = fgetcsv($file);

                // ignore first heading row
                if ($fields) {
                    $fields = false;
                    continue;
                }

                if ($data[$this::FILE_COL_ID_ACTIVE] === 'true') {
                    $count += $data[$this::FILE_COL_ID_VALUE];
                }
            }

            fclose($file);
        }
        $this->result = $count;
    }

    /**
     * This function will read xml file and calculate total values
     *
     * @param string $file
     */
    public function readFileXml($file)
    {
        $count = 0;
        $xml = simplexml_load_file($file);
        for ($i=0; $i<count($xml->user); $i++) {
            $user = $xml->user[$i];
            if ($user->active == 'true') {
                $count += $user->value;
            }
        }

        $this->result = $count;
    }

    /**
     * This function will read yml file and calculate total values
     *
     * @param string $file
     */
    public function readFileYml($file)
    {
        $count = 0;
        $yaml = new Parser();
        $data = $yaml->parse(file_get_contents($file));
        foreach ($data['users'] as $user) {
            if ($user['active']) {
                $count += $user['value'];
            }
        }
        $this->result = $count;

    }
}