<?php
	require_once(APPPATH.'libraries/Https.php');
	class Westart_api {
		private static $URL_QUERY_COMS_CONFIG = 'http://gomeao.net/offical/queryComConfig';

		public function __construct()
		{
		}

		public static function queryComConfig($vid, $token) {
			$url = self::$URL_QUERY_COMS_CONFIG;
			$post_data['token'] = $token;
			$post_data['vid'] = $vid;
			$res = Https::https_request($url, http_build_query($post_data));
			$json = json_decode($res, true);
			return $json;
		}
	}
?>