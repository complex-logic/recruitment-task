<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 15:03
 */

namespace ThirdBridge;

use ThirdBridge\Models\InputParameters;

require_once 'vendor/autoload.php';

class InputParametersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var  InputParameters
     */
    private $model;

    /**
     * setup InputParameters model
     */
    protected function setUp()
    {
        $this->model = new InputParameters();
    }

    /**
     * unset InputParameters object
     */
    protected function tearDown()
    {
        $this->model = NULL;
    }

    /**
     * @test
     * Test input parameters
     */
    public function test_set_input_parameters()
    {
        $input = array('script.php', '--input=data/file.xml', '--output=results/result.txt');
        $this->model->setArguments($input);

        $this->assertEquals(3, count($this->model->getArguments()));
    }

    /**
     * @test
     * Test valid input data from parser function
     */
    public function test_parse_input_valid_data()
    {
        $input = array('script.php', 'data/file.xml');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(1, count($this->model->getArgumentOptions()));

    }

    /**
     * @test
     * Test valid input and output file paths
     */
    public function test_parse_input_valid_data_and_output()
    {
        $input = array('script.php', '--input=data/file.xml', '--output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(2, count($this->model->getArgumentOptions()));

    }

    /**
     * @test
     * Test wrong|invalid parameters
     */
    public function test_parse_input_invalid_data_and_output()
    {
        $input = array('script.php', '-input=data/file.xml', '-output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(0, count($this->model->getArgumentOptions()));

    }

    /**
     * @test
     * Test valid input parameters true|false
     */
    public function test_input_valid()
    {
        $input = array('script.php', '--input=data/file.xml', '--output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(true, $this->model->validateInput());

        $input = array('script.php', '-input=data/file.xml', '-output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(false, $this->model->validateInput());

    }

    /**
     * @test
     * Test input file path and check if file exist
     */
    public function test_check_if_data_file_exist()
    {
        $input = array('script.php', '--input=data/file.doc', '--output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(false, $this->model->isDataFileExist());

        $input = array('script.php', '--input=data/file.xml', '--output=results/result.txt');
        $this->model->setArguments($input);
        $this->model->parseInput();

        $this->assertEquals(true, $this->model->isDataFileExist());

    }

}
