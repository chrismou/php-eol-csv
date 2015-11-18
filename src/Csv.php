<?php

namespace Chrismou\PhpEolCsv;

class Csv
{
    /**
     * @var resource
     */
    private $fileHandler;

    /**
     * @var string
     */
    protected $eol;

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var string
     */
    protected $enclosure;

    /**
     * Initialise the file handler
     *
     * @param string  $fileName name of file
     * @param boolean $savePath destination path of output file (false triggers a direct download)
     * @param string  $eol end of line character
     * @param string  $delimiter delimiter character
     * @param string  $enclosure characters that will enclose each field
     */
    public function open($fileName, $savePath = false, $eol = "\n", $delimiter = ",", $enclosure = '"')
    {
        $this->eol = $eol;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;

        if ($savePath) {
            $this->fileHandler = fopen($savePath . $fileName . ".csv", 'w');
        } else {
            $this->fileHandler = fopen('php://output', 'w');
            $this->setStreamHeaders($fileName);
        }
    }

    /**
     * Write a line to the csv file
     *
     * @param array $fields row of data fields
     */
    public function write($fields = array())
    {
        fputcsv($this->fileHandler, $fields, $this->delimiter, $this->enclosure);

        // Have we specified a custom EOL? If so, apply to the row
        if ("\n" != $this->eol && 0 === fseek($this->fileHandler, -1, SEEK_CUR)) {
            fwrite($this->fileHandler, $this->eol);
        }
    }

    /**
     * Close csv file handler
     */
    public function close()
    {
        fclose($this->fileHandler);
    }

    /**
     * Set the stream headers for direct download
     */
    protected function setStreamHeaders($fileName)
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
