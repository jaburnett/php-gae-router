<?php
/**
 * Filename: gethistory.php
 * Description:
 * 	Sample php-gae-router module: A basic proxy script that retrieves
 * 		market data from Yahoo Finance.
 *
 * Author: Joe Burnett <info@audiopoison.com>
 * 
 */

namespace php-gae-router\gethistory;

class gethistory {
	private $data_r = array();
	private $data = array();
	
	function __construct($query_string) {
		try {
			header("Content-type: text/plain");
			header("Access-Control-Allow-Origin: *");
		} catch(Exception $e) {
			// Don't send headers...
		}
		
		// Parse query string and make RPC call to YQL for `yahoo.finance.historicaldata'
		parse_str($query_string, $query_r);
		if (!isset($query_r["s"]) || !isset($query_r["e"])
				|| !isset($query_r["symbol"])) {
			print "Error: invalid arguments!\n";
			exit(-1);
		}
		$symbol = $query_r["symbol"];
		$start_date = $query_r["s"];
		$end_date = $query_r["e"];
		$url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20"
        	. "symbol%20=%20\"".$symbol."\"%20and%20"
        	. "startDate%20=%20\"".$start_date."\"%20and%20"
        	. "endDate%20=%20\"".$end_date."\"&"
        	. "format=json&diagnostics=true&env=store://datatables.org/alltableswithkeys";
		
		$this->data_r = file($url);
		$this->data = implode("", $this->data_r);
	}
	
	function display() {		
		//print json_encode($this->data->{"query"}, true);
		// Right now, the data should already be formatted as a JSON string.
		print $this->data;
	}
}

?>
