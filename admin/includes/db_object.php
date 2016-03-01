<?php


class Db_object {

	protected static $db_table = "users";
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














































}


?>