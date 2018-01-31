<?php

global $DBConn;
$DBConn = new DatabaseConnection();

class DatabaseConnection{

	public $connection = NULL;
	
	function __construct() {
	
		if ($connection = mysql_connect(DB_HOST_LIVE, DB_USER_LIVE, DB_PASSWORD_LIVE)){
			mysql_select_db(DB_NAME_LIVE);
			$this->connection = $connection;
		}else{
			return NULL;
		}
	}
	
	function execute_query($query) {
	
		if ($query != ""){
			return mysql_query($query, $this->connection);
		}
	}
	
	function return_mysql_fetched_results($results, $params) {
	
		$i = 0;
		$resulted_array = array();
		if ($results){
			while($row = mysql_fetch_array($results)){
				foreach($params as $eachParam){
					$resulted_array[$i][$eachParam] = $row[$eachParam];
				}$i++;
			}
		}
		return $resulted_array;		
	}

	function return_mysql_fetched_results_to_single_array($results, $params) {
	
		$resulted_array = array();
		if ($results){		
			while($row = mysql_fetch_array($results)){
				foreach($params as $eachParam){
					$resulted_array[$eachParam] = $row[$eachParam];
				}
			}
		}	
		return $resulted_array;
	}
	
	function return_single_result($result) { if (results) return mysql_result($result, 0); }
	
	function checkSomeRecordsAreAvaliable($results) { return (($results != "") && (mysql_num_rows($results) > 0)) ? true : false; }
	
	function getLastInsertedId() { return mysql_insert_id(); }
	
	function getTheNumOfRecords($result) { return mysql_num_rows($result); }
}