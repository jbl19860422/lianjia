<?php
	require_once(APPPATH.'libraries/Https.php');
	class Pgyapi {
		private static $usermail = 'jbl19860422@163.com';
		private static $password = 'jbl35270422';
		private static $api_host = "http://open.facebac.com/api/";
		private static $get_token_url = 'manage/user/get_token.do';
		private static $create_url = 'manage/live/create.do';
		private static $enable_url = 'manage/live/enable.do';

		public function __construct()
		{
		}

		public static function get_token() 
		{
			$url = self::$api_host.self::$get_token_url;
			$create_time = time();
			$sCreateTime = date('YmdHis', $create_time); 
			$password_enc = md5(md5(self::$password)."#".$sCreateTime);
			$data = 'user_name='.self::$usermail."&password=".$password_enc."&create_time=".$sCreateTime;
			$res = Https::https_request($url, $data);
			$json = json_decode($res, true);
			if($json['code'] != "200")
			{
				return "";
			}
			else
			{
				return $json['data'];
			}
		}

		public static function create($live_name, $live_text, $isrecord, $live_cover_img) {
			$token = self::get_token();
			$url = self::$api_host.self::$create_url;
			$post_data['token'] = $token;
			$post_data['live_name'] = $live_name;
			$post_data['live_text'] = $live_text;
			$post_data['isrecord'] = $isrecord;
			$post_data['live_cover_img'] = $live_cover_img;
			$res = Https::https_request($url, http_build_query($post_data));
			$json = json_decode($res, true);
			if($json['code'] != "200")
			{
				return null;
			}

			$liveinfo = $json['data'];
			return $liveinfo;
		}
		
		public static function enable($id) {
			$token = self::get_token();
			$url = self::$api_host.self::$enable_url;
			$post_data['token'] = $token;
			$post_data['id'] = $id;
			$res = Https::https_request($url, http_build_query($post_data));
			$json = json_decode($res, true);
			if($json['code'] != "200") {
				return false;
			}

			return true;
		}
	}
?>