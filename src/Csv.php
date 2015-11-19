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
     * @var string
     */
    protected $fullFileName;

    /**
     * Initialise the file handler
     *
     * @param string $fileName      The filename to use (not including file extension)
     * @param string $savePath      The path to save the file to. Leaving blank triggers a direct download
     * @param string $eol           The EOL character to use
     * @param string $fileExtension The file extension to use
     * @param string $delimiter     The delimiter to use between fields
     * @param string $enclosure     The enclosure character to use for fields that require it
     */
    public function open(
        $fileName,
        $savePath = '',
        $eol = "\n",
        $fileExtension = 'csv',
        $delimiter = ",",
        $enclosure = '"'
    ) {
        $this->eol = $eol;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->fullFileName = $fileName . "." . $fileExtension;


        if ($savePath) {
            $this->fileHandler = fopen($savePath . $this->fullFileName, 'w');
        } else {
            $this->fileHandler = fopen('php://output', 'w');
            $this->setStreamHeaders();
        }
    }

    /**
     * Write a line to the csv file
     *
     * @param array $row    array of data fields to place on a row
     */
    public function write(array $row = array())
    {
        fputcsv($this->fileHandler, $row, $this->delimiter, $this->enclosure);

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
    protected function setStreamHeaders()
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$this->fullFileName}.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
