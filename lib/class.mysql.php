<?


/**


 *


 * @product:	CTC-Aspire v1.0


 * @copyright: 	Copyright © 2011 CTC-Aspire (Gibraltar) Limited. All rights reserved.


 *


 **/


 


class mySQL{


	var $last_error;


	var $last_errornumber;


	var $dbServer;


	var $dbLogonName;


	var $dbPassword;


	var $dbDatabase;





	// constructor function


	function mySQL($database=''){


		if($database==''){


			if(($_SERVER["SERVER_ADDR"]=="127.0.0.1") || ($_SERVER['SERVER_ADDR'] == "::1")){


				$this->dbServer 	= DB_HOST;


				$this->dbLogonName 	= DB_USER;


				$this->dbPassword 	= DB_PASSWORD;


				$this->dbDatabase 	= DB_NAME;


			


			}else{


				$this->dbServer 	= DB_HOST_LIVE;


				$this->dbLogonName 	= DB_USER_LIVE;


				$this->dbPassword 	= DB_PASSWORD_LIVE;


				$this->dbDatabase 	= DB_NAME_LIVE;


			}


		}


		


		$last_error="";


		$last_errornumber=0;


	}





	function getLastError(){


		return $this->last_error;


	}





	function getLastErrornumber(){


		return $this->last_errornumber;


	}





	function halt(){


		echo('<hr>');


		echo('ERROR ('.$this->last_errornumber.')');


		echo(' '.$this->last_error);


		echo('<hr>');


		exit;


	}





	function execute($sql,&$result,&$affected_rows=0){


		$result = false;





		$con = mysql_pconnect($this->dbServer,$this->dbLogonName,$this->dbPassword);


		if(!$con){


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}





		$db = mysql_select_db($this->dbDatabase,$con);


		if(!$db){


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}





		$result = mysql_query($sql,$con);

		if(!$result){


			echo("[".$sql."]");


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}else{


			$affected_rows=mysql_affected_rows($con);


		}


		


		mysql_close($con);





		$this->last_error = 'Execution was sucessfull';


		$this->last_errornumber = 0;


		return true;


	}





	function execute_with_id($sql,&$result,&$insert_id){


		$result = false;





		$con = mysql_pconnect($this->dbServer,$this->dbLogonName,$this->dbPassword);


		if(!$con){


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}





		$db = mysql_select_db($this->dbDatabase,$con);


		if(!$db){


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}





		$result = mysql_query($sql,$con);


		if(!$result){


			$this->last_error = mysql_error();


			$this->last_errornumber = mysql_errno();


			$this->halt();


		}





		$insert_id = mysql_insert_id($con);





		mysql_close($con);





		$this->last_error = 'Execution was sucessfull';


		$this->last_errornumber = 0;


		return true;


	}





}//:mySQL


?>