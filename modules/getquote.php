<?php
/**
 * Filename: getquote.php
 * Description:
 * 	Sample php-gae-router module: A simple proxy script to retrieve
 *		equity data for specific symbols from Yahoo Finance.
 *
 * Author: Joe Burnett <info@audiopoison.com>
 *
 */

namespace php-gae-router\getquote;

class getquote {
	private $data_r = array();
	private $data = array();
	
	function __construct($query_string) {
		try {
			header("Content-type: text/plain");
			header("Access-Control-Allow-Origin: *");
		} catch(Exception $e) {
			// Don't send headers...
		}
		
		parse_str($query_string, $query_r);
		if (!isset($query_r["symbol"])) {
			print "Error: invalid argument\n";
			exit(-1);
		}
		$symbol = $query_r["symbol"];
		
		// Make RPC call to YQL service for `yahoo.finance.quote' data
		$url = "https://query.yahooapis.com/v1/public/yql?"
        	."q=select%20*%20from%20yahoo.finance.quote%20where%20symbol%20in%20(%22".$symbol."%22)"
        	."&format=json"
        	."&diagnostics=true"
        	."&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys"
        	."&callback=";
	        $this->data_r = file($url);
		$this->data = implode("", $this->data_r);
	}
	
	function display() {
		print $this->data;
	}
}

?>
