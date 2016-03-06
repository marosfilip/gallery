<?php


class Db_object {

	protected static $db_table = "users";

	public $errors = array();
	public $upload_errors_array = array(
			UPLOAD_ERR_OK			=> "There is no error.",
			UPLOAD_ERR_INI_SIZE		=> "upload_max_filesize exceeded.",
			UPLOAD_ERR_FORM_SIZE	=> "MAX_FILE_SIZE exceeded.",
			UPLOAD_ERR_PARTIAL		=> "File uploaded ONLY partially.",
			UPLOAD_ERR_NO_FILE		=> "No file selected for upload. Please select a file.",
			UPLOAD_ERR_NO_TMP_DIR	=> "Missing temporary folder.",
			UPLOAD_ERR_CANT_WRITE	=> "Writing to disc FAILED.",
			UPLOAD_ERR_EXTENSION	=> "PHP extension stopped file upload."
			);

	public static function find_all()
	{
		return static::find_by_query("SELECT * FROM " . static::$db_table ." ");
	}

	public static function find_by_id($id)
	{
		global $database;
		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table ." WHERE id=$id LIMIT 1");

		return !empty($the_result_array) ? array_shift($the_result_array) : false;

	}

	public static function find_by_query($sqlstring)
	{
		global $database;
		$result_set = $database->db_query($sqlstring);
		$the_object_array = array();

		while ($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = static::instantiation($row);
		}

		return $the_object_array;
	}

	public static function instantiation($found_user)
	{
		$calling_class = get_called_class();
		$user_object = new $calling_class;

		foreach ($found_user as $attribute => $value) {
			if ($user_object->has_attribute($attribute)) {
				$user_object->$attribute = $value;

			}
			
		}
		return $user_object;
	}

		private function has_attribute($attribute)
	{
		$object_properties = get_object_vars($this);
		return array_key_exists($attribute, $object_properties);
	}

		protected function properties()
	{
		$properties = array();
		foreach (static::$db_table_fields as $db_field) {
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
	} // End of clean_properties

	public function create()
	{
		global $database;
		$properties = $this->clean_properties();

		$sqlstring = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
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

		$sqlstring = "UPDATE " . static::$db_table . " SET ";
		$sqlstring .= implode(", ", $properties_pairs);
		$sqlstring .= " WHERE id= " . $database->escape_string($this->id);

		$database->db_query($sqlstring);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;

	} // End of update method

	public function delete()
	{
		global $database;

		$sqlstring = "DELETE FROM " . static::$db_table . " WHERE " . "id= '" . $database->escape_string($this->id) . "' ";
		$database->db_query($sqlstring);
		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	} // End of delete method














































}


?>