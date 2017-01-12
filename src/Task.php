<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 13:18
 */

namespace ThirdBridge;

use ThirdBridge\Models\File;
use ThirdBridge\Models\InputParameters;

/**
 * Class Task
 * @package ThirdBridge
 */
class Task
{
    /**
     * @var InputParameters
     */
    private $inputParameters;

    /**
     * @var File
     */
    private $file;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->inputParameters = new InputParameters();
        $this->file = new File();
    }

    /**
     * This function will call read and output functions
     * and perform some validation checks
     *
     * @param array $parameters
     */
    public function readFile(array $parameters)
    {
        $this->inputParameters->setArguments($parameters);

        /** parseInput function will render input parameters */
        $this->inputParameters->parseInput();

        if ($this->inputParameters->validateInput()) {

            if($this->inputParameters->isDataFileExist()) {

                // set file input parameters
                $this->file->setParameters($this->inputParameters->getArgumentOptions());

                // read input file
                $this->file->read();

                // this function will display or save output value in given file
                fwrite(STDOUT, $this->file->output());

            } else {
                fwrite(STDOUT, "Data file does not exist\n");
            }

        } else {
            fwrite(STDOUT, "Wrong input parameter\n");
        }

    }

}