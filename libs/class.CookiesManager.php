<?php

//Class: CookiesManager

	class CookiesManager {
		
		private static $pCookie;
		private static $vCookie;
		private static $cCookie;
		private static $uState;
		
		public static function init($pID) {
			self::$pCookie = (int)$_COOKIE['pl'];
			self::$vCookie = (int)$_COOKIE['vt'];
			self::$cCookie = $_COOKIE['cmt'];
			
			self::SetUserState($pID);
		}
		
		public static function SetCookies($pID, $vID, $value = 'unset') {
			setcookie('pl', $pID, time()+4838400, '/', '', 0, 0);
			setcookie('vt', $vID, time()+4838400, '/', '', 0, 0);
			setcookie('cmt', $value, time()+4838400, '/', '', 0, 0);
			self::SetUserState($pID);
		}
		
		public static function pGetCookie() {
			return self::$pCookie;
		}
		
		public static function vGetCookie() {
			return self::$vCookie;
		}
		
		public static function cGetCookie() {
			return self::$cCookie;
		}
		
		private static function SetUserState($pID) {
			if (!empty(self::$pCookie)) {
				if (self::$pCookie != $pID) {
					self::$uState = 'new_poll'; 
				} else {
					if (self::$cCookie == 'unset') {
						self::$uState = 'only_voted';
					} else {
						self::$uState = 'closed';
					}
				}
			} else {
				self::$uState = 'new_poll';
			}
		}
		
		public static function GetUserState() {
			return self::$uState;	
		}
		
		public static function redirectURL($path) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			$url = rtrim($url, '/\\');
			return $url.= '/' . $path;
		}
}