<?php

class Photo extends Db_object {


	protected static $db_table = "photos";
	protected static $db_table_fields = array('id', 'title', 'description', 'filename', 'type', 'size', 'alternate_text', 'caption');
	public $id;
	public $title;
	public $description;
	public $filename;
	public $type;
	public $size;
	public $alternate_text;
	public $caption;

	public $tmp_path;
	public $upload_directory = "images";
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

	public function set_file($file) // This is passing $_FILES['uploaded_file'] as an argument.
	{
		if(empty($file) || !$file || !is_array($file)) {
			$this->errors[] = "There was no file uploaded.";
			return false;
		} elseif ($file['error'] !=0) {
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;
		} else {
			$this->filename = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
		}
		
	} // End of set_file method

	public function picture_path()
	{
		return $this->upload_directory.DS.$this->filename;
	}

	public function save() {
		if ($this->id) {
			$this->update();
		} else {
				if(!empty($this->errors)) {
					return false;
				}

				if (empty($this->filename) || empty($this->tmp_path)) {
					$this->errors[] = "The file was not available";
					return false;
				}

				$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

				if (file_exists($target_path)) {
					$this->errors[] = "The file {$this->filename} already exists.";
					return false;
				}

				if (move_uploaded_file($this->tmp_path, $target_path)) {
					if ($this->create()) {
						unset($this->tmp_path);
						return true;
					}
				} else {
					$this->errors[] = "Please check folder permissions.";
					return false;
					}
				}
	}

	public function delete_photo_1() {
		if ($this->delete()) {
			$target_path = SITE_ROOT . DS .'admin' . DS . $this->picture_path();
			return unlink($target_path) ? true : false;
		} else {
			return false;
		}
	}

	public static function display_sidebar_data($photo_id) {

		$photo = Photo::find_by_id($photo_id);

		$output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}'>";
		$output .= "<p>{$photo->filename}</p>";
		$output .= "<p>{$photo->type}</p>";
		$output .= "<p>{$photo->size}</p>";

		echo $output;



	}




} // End of Photo class




?>