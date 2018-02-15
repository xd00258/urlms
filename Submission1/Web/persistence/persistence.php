<?php

	class Persistence{
		
		private $filename;
		
		/*
		 * Constructor
		 */
		function __construct($filename = -1) {
			if($filename == -1)
				$this->filename = dirname(__FILE__) . '/../persistence/data.txt';
			$this->filename = $filename;
		}
		
		/*
		 * Load data from file
		 */
		function loadDataFromStore() {
			// check if file exists, if yes, unserialize data file
			if (file_exists($this->filename)) {
				$str = file_get_contents($this->filename);
				$urlms = unserialize($str);
			} else {
				// if doesn't exist, create new instances of URLMS and Lab and add lab to URLMS
				$urlms = new URLMS();
				$lab = new Lab("9/10", $urlms);
				$urlms->addLab($lab);
				
				$lab->addFundingAccount(new FundingAccount("Staff Funding", 0, $lab));
				$lab->addFundingAccount(new FundingAccount("Equipment Funding", 0, $lab));
				$lab->addFundingAccount(new FundingAccount("Supply Funding", 0, $lab));
			}
			// return urlms
			return $urlms;
		}
		
		/*
		 * Write data to file
		 */
		function writeDataToStore($urlms) {
			// serialize data and put content to data file
			$str = serialize($urlms);
			file_put_contents($this->filename, $str);
		}
	}
?>