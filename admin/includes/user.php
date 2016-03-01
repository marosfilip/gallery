<?php

/**
* User class
*/
class User extends Db_object
{

	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;





	public static function verify_user($username, $password){
		global $database;

		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sqlstring = "SELECT * FROM " . self::$db_table ." WHERE ";
		$sqlstring .= "username = '{$username}' ";
		$sqlstring .= "AND password = '{$password}' ";
		$sqlstring .= "LIMIT 1";

		$the_result_array = self::find_by_query($sqlstring);

		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	}









} // End of User class




?>