<?php

class Redirect {
	
	public static function to($path) {
		header("location: " . Config::get('URL') . $path);
		exit();
	}
	
	public static function home() {
		header("location: " . Config::get('URL'));
		exit();
	}
}