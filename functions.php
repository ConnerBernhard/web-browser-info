<?php
	
	$specs = array();

	function getOS() {
		global $user_agent;
		$os_platform    =   "Unknown OS Platform";
		$os_array       =   array(
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);
		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$os_platform = $value;
			}
		}
		return $os_platform;
	}
	
	function getOS_type($CurrOS) {
		
		if(strpos(strtolower($CurrOS), 'iphone') > -1)
			$CurrOS_type = 'iphone';
		if(strpos(strtolower($CurrOS), 'ipod') > -1)
			$CurrOS_type = 'ipod';
		if(strpos(strtolower($CurrOS), 'ipad') > -1)
			$CurrOS_type = 'ipad';
		if(strpos(strtolower($CurrOS), 'android') > -1)
			$CurrOS_type = 'android';
		if(strpos(strtolower($CurrOS), 'blackberry') > -1)
			$CurrOS_type = 'blackberry';
		if(strpos(strtolower($CurrOS), 'mobile') > -1)
			$CurrOS_type = 'mobile';
		if(strpos(strtolower($CurrOS), 'ubuntu') > -1)
			$CurrOS_type = 'ubuntu';
		if(strpos(strtolower($CurrOS), 'linux') > -1)
			$CurrOS_type = 'linux';
		elseif(strpos(strtolower($CurrOS), 'mac') > -1)
			$CurrOS_type = 'mac';
		else
			$CurrOS_type = 'win';
		
		return $CurrOS_type;
	}
	
	function get_browser_type($browser_name) {
		$browser_name = strtolower($browser_name);
		if(strpos($browser_name, 'internet') > -1)
			$browser_type = 'ie';
		elseif(strpos($browser_name, 'opera') > -1)
			$browser_type = 'op';
		elseif(strpos($browser_name, 'safari') > -1)
			$browser_type = 'sf';
		else
			$browser_type = 'ff';
	}
	
	function Find_IP(){
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$localip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		$localip = $_SERVER['REMOTE_ADDR'];
		}
		return $localip;
	}
?>