<?php 
class  Dbconfig {
	private $hostname;
	private $username;
	private $password;
	private $database;
	private $connect;
	private $select_db;
	
	public function ConnectionOpen() {
	
		$this->hostname = "localhost";
		$this->username = "thinkblu_onestep";
		$this->password = "7I(}@DeV8E^-";
		$this->database = "thinkblu_onestep";

		
		$this->connect = mysql_connect($this->hostname,$this->username,$this->password)or die(mysql_error());
		if(!$this->connect) {
			echo "Mysql Not Connected";
		}/* else {
		echo 'Database connected';
		}*/
		mysql_set_charset('utf8',$this->connect);
		$this->select_db = mysql_select_db($this->database);
		if(!$this->select_db){
			echo "Database Not Connected";
		}
	} // end of connectionopen
	
	public function ConnectionClose() {
		mysql_close($this->connect);
	}
	
	public function GetDb(){
		$this->ConnectionOpen();
		$name = $this->database;
		$this->ConnectionClose();
		
		return $name;
	}

	public function HostName(){
		$this->ConnectionOpen();
		$name = $this->hostname;
		$this->ConnectionClose();
		
		return $name;
	}
	
	public function Password(){
		$this->ConnectionOpen();
		$name = $this->password;
		$this->ConnectionClose();
		
		return $name;
	}
	
	public function User(){
		$this->ConnectionOpen();
		$name = $this->username;
		$this->ConnectionClose();
		
		return $name;
	}
}// end of Class 
?>