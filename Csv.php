<?php

class Csv
{
    private $fh;
    protected $eol;
    protected $delimiter;
    protected $enclosure;

    /**
     * Constructor method
     *
     * @param string  $fileName name of file
     * @param boolean $savePath destination path of output file
     * @param string  $eol end of line character
     * @param string  $delimiter delimiter character
     * @param string  $enclosure characters that will enclose each field
     */
    public function __construct($fileName = '', $savePath = false, $eol = "\n", $delimiter = ",", $enclosure = '"')
    {
        if ($fileName) {
            $this->fileName = $fileName;
        }

        // NOTE: I don't think custom new lines work with direct downloads
        // In these cases, you may need to save the file first then manually serve it for download
        $this->eol = $eol;
        $this->delimiter = $delimiter;
        if ($savePath) {
            $this->fh = fopen($savePath.$fileName.".csv", 'w');
        } else {
            $this->fh = fopen('php://output', 'w');

            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename={$fileName}.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
        }
    }

    /**
     * Write a line to the csv file
     *
     * @param array $fields row of data fields
     */
    public function write($fields = array())
    {
        fputcsv($this->fh, $fields, $this->delimiter, $this->enclosure);

        // Have we specified a custom EOL? If so, apply to the row
        if ("\n" != $this->eol && 0 === fseek($this->fh, -1, SEEK_CUR)) {
            fwrite($this->fh, $this->eol);
        }
    }

    /**
     * Close csv file which is open for writing
     */
    public function close()
    {
        fclose($this->fh);
    }
}
