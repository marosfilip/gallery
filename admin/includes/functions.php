<?php 

function classAutoLoader($class){
	$class = strtolower($class);
	$the_path = INCLUDES_PATH . "includes/{$class}.php";

	if(is_file($the_path) && !class_exists($class)){
		include $the_path;
	}


}

spl_autoload_register("classAutoLoader");

function redirect($location){
	header("Location: {$location}");
}


?>