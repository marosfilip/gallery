<?php 

require_once("site_config.php");

/**
* Database class
*/
class Database {

	public $connection; // connection to DB
	
	function __construct() // construct to make DB connect automatic
	{
		$this->open_db_connect();
	}

	public function open_db_connect() //opens connection to database
	{
		$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		if($this->connection->connect_errno){
			die("DB connection failed." . " " . $this->connection->connect_error);
			}
	}

	public function db_query($sqlstring) //database query
	{
		$result = $this->connection->query($sqlstring);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result)
	{
		if (!$result) {
			die("Cannot query the database.");
		}
	}

	public function escape_string($string){
		$escaped_string = $this->connection->real_escape_string($string);
		return $escaped_string;
	}

	public function the_insert_id()	
	{
		return $this->connection->insert_id;
	}
}

// instantiate database

$database = new Database();

?>