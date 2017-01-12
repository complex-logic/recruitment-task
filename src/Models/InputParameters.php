<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 13:03
 */

namespace ThirdBridge\Models;


/**
 * Class InputParameters
 * @package ThirdBridge\Models
 */
class InputParameters
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $argumentOptions;

    /**
     * ValidateInput constructor.
     * @param array $arguments
     */
    public function __construct(array $arguments = array())
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArgumentOptions()
    {
        return $this->argumentOptions;
    }

    /**
     * @param array $argumentOptions
     */
    public function setArgumentOptions($argumentOptions)
    {
        $this->argumentOptions = $argumentOptions;
    }

    /**
     * Check if data file path exist
     * @return bool
     */
    public function isDataFileExist()
    {
        $parameters =  $this->getArgumentOptions();

        if (!isset($parameters[0]) || !file_exists($parameters[0])) {
            return false;
        }

        return true;
    }

    /**
     * validate input parameters
     * @return bool
     */
    public function validateInput()
    {
        $parameters =  $this->getArgumentOptions();

        if (count($parameters) == 0){
            return false;
        }

        return true;
    }

    /**
     * Parse function will render argv parameters into proper array structure
     * and ignore irrelevent parameters
     */
    public function parseInput()
    {
        $input = array();

        $arguments = $this->arguments;

        array_shift( $arguments );
        while ( $arg = array_shift($arguments) )
        {
            // Is it a command? (prefixed with --)
            if ( substr( $arg, 0, 2 ) === '--' )
            {
                // is it the end of options flag?
                if (!isset ($arg[3]))
                {
                    continue;
                }

                $value = "";
                $com   = substr( $arg, 2 );

                // is it the syntax '--option=argument'?
                if (strpos($com,'='))
                    list($com,$value) = explode("=",$com,2);

                // is the option not followed by another option but by arguments
                elseif (strpos($input[0],'-') !== 0)
                {
                    while (strpos($input[0],'-') !== 0)
                        $value .= array_shift($input).' ';
                    $value = rtrim($value,' ');
                }

                $input[] = !empty($value) ? $value : true;
                continue;

            }

            // Is it a flag or a serial of flags? (prefixed with -)
            if ( substr( $arg, 0, 1 ) === '-' )
            {
                continue;
            }

            // finally, it is not option, nor flag, nor argument
            $input[] = $arg;
            continue;
        }

        $this->setArgumentOptions($input);

    }

}