<?php

function replaceDate($datetime){
    $date = new DateTime($datetime);
    return $date->format("d F Y");
}

function replaceDateTime($datetime){
    $date = new DateTime($datetime);
    return $date->format("d F Y h:i:s");
}

function filter($data){
    $filter = stripslashes(strip_tags(htmlspecialchars(htmlentities($data,ENT_QUOTES))));
    return $filter;
}

function enc_id($string) {
    $encrypt = base64_encode(convert_uuencode(gzdeflate($string)));
    return $encrypt;
}

function dec_id($string) {
    $decrypt = gzinflate(convert_uudecode(base64_decode($string)));
    return $decrypt;
}

function random($length) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function random_number($length) {
	$str = "";
	$characters = array_merge(range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}

function hp($hp) {
    // // kadang ada penulisan no hp 0811 239 345
    // $hp = str_replace(" ","",$hp);
    // // kadang ada penulisan no hp (0274) 778787
    // $hp = str_replace("(","",$hp);
    // // kadang ada penulisan no hp (0274) 778787
    // $hp = str_replace(")","",$hp);
    // // kadang ada penulisan no hp 0811.239.345
    // $hp = str_replace(".","",$hp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($hp))){
        // cek apakah no hp karakter 1-3 adalah +62
        
        // cek apakah no hp karakter 1 adalah 0
        if(substr(trim($hp), 0, 1)=='0'){
            $hp = '0'.substr(trim($hp), 1);
        } else if(substr(trim($hp), 0, 2) == '62'){
            $hp = '0'.substr(trim($hp), 2);
        } else if(substr(trim($hp), 0, 3) == '+62'){
            $hp = '0'.substr(trim($hp), 3);
        }
        
    }
    return $hp;
}

function wa($hp) {
    // // kadang ada penulisan no hp 0811 239 345
    // $hp = str_replace(" ","",$hp);
    // // kadang ada penulisan no hp (0274) 778787
    // $hp = str_replace("(","",$hp);
    // // kadang ada penulisan no hp (0274) 778787
    // $hp = str_replace(")","",$hp);
    // // kadang ada penulisan no hp 0811.239.345
    // $hp = str_replace(".","",$hp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($hp))){
        // cek apakah no hp karakter 1-3 adalah +62
        
        // cek apakah no hp karakter 1 adalah 0
        if(substr(trim($hp), 0, 1)=='0'){
            $hp = '62'.substr(trim($hp), 1);
        } else if(substr(trim($hp), 0, 2) == '62'){
            $hp = '62'.substr(trim($hp), 2);
        } else if(substr(trim($hp), 0, 3) == '+62'){
            $hp = '62'.substr(trim($hp), 3);
        }
        
    }
    return $hp;
}

/**
 * @return IP (192.168.1.1)
 */
function ip_user() 
{
	if (! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
    	$ip = $_SERVER['HTTP_CLIENT_IP'];
	
    } elseif (! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	
    } else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	
    }

	return $ip;
}

/**
 * @see http://php.net/manual/en/function.get-browser.php;
 * @return 
 */
function browser_user()
{
	$browser = _userAgent();
	return $browser['name'] . ' v.'.$browser['version'];
}

/**
 * Deteksi UserAgent / Browser yang digunakan
 * @return [type] [description]
 */
function _userAgent()
{
	$u_agent 	= $_SERVER['HTTP_USER_AGENT']; 
    $bname   	= 'Unknown';
    $platform 	= 'Unknown';
    $version 	= "";

	$os_array   =   array(
                    '/windows nt 10.0/i'     =>  'Windows 10',
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

	    if (preg_match($regex, $u_agent)) {
	        $platform    =   $value;
            break;
	    }

	}

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    
    } elseif(preg_match('/Firefox/i',$u_agent)) { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    
    } elseif(preg_match('/Chrome/i',$u_agent)) { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 

    } elseif (preg_match('/Safari/i',$u_agent)) { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 

    } elseif (preg_match('/Opera/i',$u_agent)) { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    
    } elseif (preg_match('/Netscape/i',$u_agent)) { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    }

    //  finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
   
    if (! preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        
        } else {
            $version= $matches['version'][1];
        }
    } else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    $version = ( $version == null || $version == "" ) ? "?" : $version;
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );
}

/**
 * @return name Operating System*/
function os_user()
{
	$OS = _userAgent();
	return $OS['platform'];
}

// log
$ip      = ip_user();
$browser = browser_user();
$os      = os_user();

?>