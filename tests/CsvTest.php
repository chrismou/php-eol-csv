<?php

namespace Chrismou\PhpEolCsv\Tests;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;
use Chrismou\PhpEolCsv\Csv;

class CsvTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('testDir'));
    }

    /**
     * @test
     */
    public function it_creates_the_csv()
    {
        $csv = new Csv();

        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('testFile.csv'));

        $csv->open("testFile", vfsStream::url('testDir/'));
        $csv->write([]);
        $csv->close();

        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('testFile.csv'));
    }

    /**
     * @test
     */
    public function it_writes_to_the_csv()
    {
        $csv = new Csv();

        $csv->open("testFile", vfsStream::url('testDir/'));
        $csv->write(["cell,1", "cell2"]);
        $csv->close();

        $content = file_get_contents(vfsStream::url('testDir/testFile.csv'));

        $this->assertEquals("\"cell,1\",cell2\n", $content);
    }

    /**
     * @test
     */
    public function it_writes_multiple_rows_to_the_csv()
    {
        $csv = new Csv();

        $csv->open("testFile", vfsStream::url('testDir/'));
        $csv->write(["cell1", "cell2"]);
        $csv->write(["cell3", "cell4"]);
        $csv->close();

        $content = file_get_contents(vfsStream::url('testDir/testFile.csv'));

        $this->assertEquals("cell1,cell2\ncell3,cell4\n", $content);
    }

    /**
     * @test
     */
    public function it_writes_a_custom_eol_character()
    {
        $csv = new Csv();

        $csv->open("testFile", vfsStream::url('testDir/'), "\r\n");
        $csv->write(["cell1", "cell2"]);
        $csv->close();

        $content = file_get_contents(vfsStream::url('testDir/testFile.csv'));

        $this->assertEquals("cell1,cell2\r\n", $content);
    }

    /**
     * @test
     */
    public function it_uses_a_custom_delimiter()
    {
        $csv = new Csv();

        $csv->open("testFile", vfsStream::url('testDir/'), "\n", ":");
        $csv->write(["cell1", "cell2"]);
        $csv->close();

        $content = file_get_contents(vfsStream::url('testDir/testFile.csv'));

        $this->assertEquals("cell1:cell2\n", $content);
    }

    /**
     * @test
     */
    public function it_uses_a_custom_enclosure()
    {
        $csv = new Csv();

        $csv->open("testFile", vfsStream::url('testDir/'), "\n", ",", "'");
        $csv->write(["cell,1", "cell2"]);
        $csv->close();

        $content = file_get_contents(vfsStream::url('testDir/testFile.csv'));

        $this->assertEquals("'cell,1',cell2\n", $content);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_writes_to_output_buffer()
    {
        $csv = new Csv();

        $csv->open("testFile", false);
        $csv->write(["cell1", "cell2"]);

        $content = ob_get_contents();

        ob_clean();

        $this->assertEquals("cell1,cell2\n", $content);
    }
}
