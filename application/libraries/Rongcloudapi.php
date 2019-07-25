<?php
	require_once(APPPATH."helpers/http_helper.php");
	class Rongcloudapi {
		private $appkey = 'x4vkb1qpvx6zk';
		private $appsecret = 'ExhA5v1jNGMOC';
		public function __construct($config = null) {
			if($config) {
				$this->appkey = $config['rc_appkey'];
				$this->appsecret = $config['rc_appsecret'];
			} 
		}
		/*
		*	获取融云token
		*/

		public function get_rctoken($user_id, $nickname, $headimg) {
			$data_rc = 'userId='.$user_id.'&name='.$nickname.'&portraitUri='.$headimg;
			$timestamp = time();
			$nonce = rand();
			$singnature = sha1($this->appsecret.$nonce.$timestamp);
			$headers = array(
					'App-Key:'.$this->appkey,
					'Nonce:'.$nonce,
					'Timestamp:'.$timestamp,
					'Signature:'.$singnature,
					'Content-Type: application/x-www-form-urlencoded',
				);

			$url = 'https://api.cn.ronghub.com/user/getToken.json';
			$sJson = http_request($url, $data_rc, $headers);
			$data_json = json_decode($sJson, true);
			if($data_json['code'] != "200") 
			{
				return  null;
			}
			return $data_json['token'];
		}
		
		public function get_chatroom_user($chatRoomId, $count, $order) {
			$data_rc = 'chatroomId='.$chatRoomId.'&count='.$count.'&order='.$order;
			$timestamp = time();
			$nonce = rand();
			$singnature = sha1($this->appsecret.$nonce.$timestamp);
			$headers = array(
					'App-Key:'.$this->appkey,
					'Nonce:'.$nonce,
					'Timestamp:'.$timestamp,
					'Signature:'.$singnature,
					'Content-Type: application/x-www-form-urlencoded',
				);

			$url = "http://api.cn.ronghub.com/chatroom/user/query.json";
			$sJson = http_request($url, $data_rc, $headers);
			$data_json = json_decode($sJson, true);
			if($data_json['code'] != "200") {
				return  null;
			}
			return $data_json['users'];
		}
		
		public function send_checkcode($mobile, $templateId, $region) {
			$timestamp = time();
			$nonce = rand();
			$singnature = sha1($this->appsecret.$nonce.$timestamp);
			$headers = array(
					'App-Key:'.$this->appkey,
					'Nonce:'.$nonce,
					'Timestamp:'.$timestamp,
					'Signature:'.$singnature,
					'Content-Type: application/x-www-form-urlencoded',
				);
			
			$param = 'mobile='.$mobile.'&templateId='.$templateId.'&region='.$region;
			//echo $param;
			$url = "http://api.sms.ronghub.com/sendCode.json";
			$sJson = http_request($url, $param, $headers);
			return $sJson;
			
			$data_json = json_decode($sJson, true);
			//var_dump($data_json);
//			if($data_json['code'] != "200") {
//				return  null;
//			}
//			return $data_json['sessionId'];
		}
		
		public function verify_code($sessionId, $code) {
			$timestamp = time();
			$nonce = rand();
			$singnature = sha1($this->appsecret.$nonce.$timestamp);
			$headers = array(
					'App-Key:'.$this->appkey,
					'Nonce:'.$nonce,
					'Timestamp:'.$timestamp,
					'Signature:'.$singnature,
					'Content-Type: application/x-www-form-urlencoded',
				);
			
			$param = 'sessionId='.$sessionId.'&code='.$code;
			//echo $param;
			$url = "http://api.sms.ronghub.com/verifyCode.json";
			$sJson = http_request($url, $param, $headers);
			$data_json = json_decode($sJson, true);
			if($data_json['code'] != 200) {
				return false;
			}
			
			if(!$data_json['success']) {
				return false;
			}
			return true;
		}
	}
?>