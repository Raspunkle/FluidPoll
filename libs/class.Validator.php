<?php

//Static Class: Validate

class Validator {
	private static $valid_methods = array(1 => 'addVote');
	private static $usr_err = array();
	
	static function init ($method, $values) {
		if (is_array($values) && !empty($values)) {
			foreach (self::$valid_methods as $value) {
				if ($method = $value) {
					return call_user_func('self::validate' . $method, $values);
				} else {
					echo 'Invalid method';
				}
			}
		} else {
			echo 'Invalid value set';
		}
		
	}
	
	static private function validateaddVote ($input) {
		if (CookiesManager::GetUserState() != 'closed') {
			foreach ($input as $key => $value) {
				switch ($key) {
					case "stance":
						if (is_bool($input[$key])) {
							$validity['stance'] = 'valid';
							break;
						} else { 
							$validity['stance'] = 'invalid';
							break;
						}
					case "comment":
						if (is_string($input[$key])) {
							$input[$key] = trim($input[$key]);
							if (strlen($input[$key]) <= 350) {
								$validity['comment'] = 'valid';
								break;
							} else {
								$validity['comment'] = 'invalid';
								break;
							}
						} else {
							$validity['comment'] = 'invalid';
							break;
						}
					default:
						return false;
				}
			}
			return $validity;
		} else {
			echo CookiesManager::GetUserState();
			return false;
		}
	}
}
?>