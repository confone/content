<?php
class Utility {

    public static function getRawRequestData() {
        return file_get_contents('php://input');
    }

    public static function getJsonRequestData() {
        $rawData = file_get_contents('php://input');
        return json_decode($rawData, TRUE);
    }

    public static function getClientIp() {
        $head = apache_request_headers();
        $ip = (isset($head['CONFONE_FORWARDED_IP']) ? $head['CONFONE_FORWARDED_IP'] : '');

        if (empty($ip)) { 
            $ip = (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '');
        }
        if (empty($ip)) { 
            $ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '');
        }
        if (empty($ip)) {
            $ip = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }

        return $ip;
    }

    public static function generateToken($mid='') {
    	$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, rand(7, 10));
    	$token.= $mid;
    	$token.= substr(md5(date('Y-m-d H:i:s')), 0, rand(8, 10));

    	return $token;
    }

    public static function extension($file) {
    	$parts = explode('.', $file);
    	return $parts[count($parts)-1];
    }

	public static function hashString($str) {
		return abs(crc32($str));
	}
}
?>