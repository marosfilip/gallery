<?php

class Photo extends Db_object {


	protected static $db_table = "photos";
	protected static $db_table_fields = array('photo_id', 'title', 'description', 'filename', 'type', 'size');
	public $photo_id;
	public $title;
	public $description;
	public $filename;
	public $type;
	public $size;

	public $tmp_path;
	public $upload_directory = "images";
	public $errors = array();
	public $upload_errors_array = array(
		UPLOAD_ERR_OK			=> "There is no error.",
		UPLOAD_ERR_INI_SIZE		=> "upload_max_filesize exceeded.",
		UPLOAD_ERR_FORM_SIZE	=> "MAX_FILE_SIZE exceeded.",
		UPLOAD_ERR_PARTIAL		=> "File uploaded ONLY partially.",
		UPLOAD_ERR_NO_FILE		=> "No file uploaded.",
		UPLOAD_ERR_NO_TMP_DIR	=> "Missing temporary folder.",
		UPLOAD_ERR_CANT_WRITE	=> "Writing to disc FAILED.",
		UPLOAD_ERR_EXTENSION	=> "PHP extension stopped file upload."
		);

	public function set_file($file) // This is passing $_FILES['uploaded_file'] as an argument.
	{
		if(empty($file)) || !$file || !is_array($file) {
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








} // End of Photo class




?>