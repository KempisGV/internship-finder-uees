<?php

class Text {

	public static $texts;

	public static function get($key) {

		if(!$key) {
			return null;
		}

		if (!self::$texts) {
			$json = file_get_contents('../application/config/texts.json');
			self::$texts = json_decode($json, true);
		}
		
		$keys_arr = explode('/', $key);
		$text_arr = self::$texts;

		foreach ($keys_arr as $key) {
			if (array_key_exists($key, $text_arr)) {
				$text_arr = $text_arr[$key];
			} else {
				return null;
			}
		}

		return $text_arr;
	}
	
	public static function setText() {
		$json = file_get_contents('../application/config/texts.' . Session::get('lang') . '.json');
		self::$texts = json_decode($json, true);
	}
}