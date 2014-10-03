<?php

class Csv {

	private $fh;
	protected $eol;
	protected $delimiter;
	protected $enclosure;

	function __construct($fileName = '', $savePath = false, $eol = "\n", $delimiter = ",", $enclosure = '"') {

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

	function write($fields = array()) {
		fputcsv($this->fh, $fields, $this->delimiter, $this->enclosure);

		// Have we specified a custom EOL? If so, apply to the row
		if("\n" != $this->eol && 0 === fseek($this->fh, -1, SEEK_CUR)) {
			fwrite($this->fh, $this->eol);
		}
	}

	function close() {
		fclose($this->fh);
	}

}
