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




	protected function properties()
	{
		$properties = array();
		foreach (self::$db_table_fields as $db_field) {
			if(property_exists($this, $db_field)) {
				$properties[$db_field] = $this->$db_field;
			}
		}
		return $properties;
	}

	protected function clean_properties() 
	{
		global $database;

		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			$clean_properties[$key] = $database->escape_string($value);
		}
		return $clean_properties;
	}

	public function create()
	{
		global $database;
		$properties = $this->clean_properties();

		$sqlstring = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ")";
		$sqlstring .= "VALUES ('". implode("','", array_values($properties)) ."')";

		if($database->db_query($sqlstring)) {
			$this->id = $database->the_insert_id();
			return true;
		} else {
			return false;
		}
	} // End of create method

	public function save()
	{
		return isset($this->id) ? $this->update() : $this->create();
	} // End of save method

	public function update()
	{
		global $database;
		$properties = $this->clean_properties();
		$properties_pairs = array();

		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='{$value}'";
		}

		$sqlstring = "UPDATE " . self::$db_table . " SET ";
		$sqlstring .= implode(", ", $properties_pairs);
		$sqlstring .= " WHERE id= " . $database->escape_string($this->id);

		$database->db_query($sqlstring);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	} // End of update method

	public function delete()
	{
		global $database;

		$sqlstring = "DELETE FROM " . self::$db_table . " WHERE " . "id= '" . $database->escape_string($this->id) . "' ";
		$database->db_query($sqlstring);
		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	} // End of delete method


} // End of User class




?>