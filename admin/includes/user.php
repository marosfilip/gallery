<?php

/**
* User class
*/
class User extends Db_object
{

	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory = "images";
	public $image_placeholder = "http://placehold.it/400x400&text=image";

	public function set_file($file) // This is passing $_FILES['uploaded_file'] as an argument.
	{
		if(empty($file) || !$file || !is_array($file)) {
			$this->errors[] = "There was no file uploaded.";
			return false;
		} elseif ($file['error'] !=0) {
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;
		} else {
			$this->user_image = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
		}
		
	} // End of set_file method

	public function upload_image() {
		if(!empty($this->errors)) {
			return false;
		}

		if (empty($this->user_image) || empty($this->tmp_path)) {
			$this->errors[] = "The file was not available";
			return false;
		}

		$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

		if (file_exists($target_path)) {
			$this->errors[] = "The file {$this->user_image} already exists.";
			return false;
		}

		if (move_uploaded_file($this->tmp_path, $target_path)) {
			if ($this->save()) {
				unset($this->tmp_path);
				return true;
			}
		} else {
			$this->errors[] = "Please check folder permissions.";
			return false;
			}
		}

	public function image_path_placeholder() {
		return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image ; 
	}


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