<?php

/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 12/01/2017
 * Time: 15:17
 */
namespace ThirdBridge;

use ThirdBridge\Models\File;

require_once 'vendor/autoload.php';

class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var  File
     */
    private $model;

    /**
     * setup file model
     */
    protected function setUp()
    {
        $this->model = new File();
    }

    /**
     * unset model object
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
        $input = array('data/file.xml', 'results/result.txt');
        $this->model->setParameters($input);

        $this->assertEquals(2, count($this->model->getParameters()));
    }

    /**
     * @test
     * Test file extension function
     */
    public function test_get_file_extension()
    {
        $ext = $this->model->getFileType('data/file.xml');
        $this->assertEquals(File::XML_FILE_EXT, $ext);

    }

    /**
     * @test
     * Test csv read file function
     *
     */
    public function test_read_csv_file()
    {
        $this->model->readFileCsv('data/file.csv');
        $this->assertEquals(900, $this->model->getResult());
    }

    /**
     * @test
     * Test xml read file function
     */
    public function test_read_xml_file()
    {
        $this->model->readFileXml('data/file.xml');
        $this->assertEquals(900, $this->model->getResult());
    }

    /**
     * @test
     * Test yml read file function
     */
    public function test_read_yml_file()
    {
        $this->model->readFileYml('data/file.yml');
        $this->assertEquals(900, $this->model->getResult());
    }

    /**
     * @test
     * Test read function throw exception if input file not supported
     * @expectedException \Exception
     */
    public function test_read_unsupported_file()
    {
        $input = array('data/file.doc');
        $this->model->setParameters($input);
        $this->model->read();
    }

    /**
     * @test
     * Test output display on screen if output file path not available
     */
    public function test_output_display_on_screen()
    {
        $input = array('data/file.csv');
        $this->model->setParameters($input);

        $this->model->readFileCsv('data/file.csv');
        $this->assertEquals(900, $this->model->output());
    }

    /**
     * @test
     * Test output file saving total value result
     */
    public function test_output_save_in_file()
    {
        $input = array('data/file.xml', 'results/result.txt');
        $this->model->setParameters($input);

        $this->model->readFileCsv('data/file.csv');
        $this->assertEquals(null, $this->model->output());

        $file = fopen($input[1], "r");
        $result = fread($file,filesize($input[1]));
        fclose($file);

        $this->assertEquals(900, $result);

    }

}