<?php
	class ControllerBase extends CI_Controller {
		public function __construct() {
			session_start();
			parent::__construct();
		}
		
		protected function queryMsgs($employee) {
			$this->load->model('user/message_model');
			$sql_msg = 'select * from tb_message where ((to_employee_id='.$employee['employee_id'].' or (brocast=1 and bro_type='.$employee['type'].')) and valid=1) or (status=1 and from_employee_id='.$employee['employee_id'].')';
			return $this->message_model->raw_query($sql_msg);
		}
		/*
		* 校验某个用户的登陆态
		*/
		protected function checkLogin($app_id) {
			$this->load->library('aes');
			$this->load->helper('http');
			$this->load->library('redisclient');
			if(!isset($_COOKIE['logindata'])) {
				return null;
			}
			$logindata = $this->aes->aes128cbcDecrypt($_COOKIE['logindata']);
			list($user_id, $login_token) = explode("|", $logindata);
			$store_logintoken = $this->redisclient->getLoginToken($app_id,$user_id);
			if(!$store_logintoken) {
				return null;
			}

			if($login_token != $store_logintoken) {
				return null;
			}

			return $user_id;
		}
		
		/*
		* 功能：微视达登录
		* @param[in] user_id
		* @param[in] password
		*/
		protected function loginWeStart($mobile, $password) {
			$this->load->helper('http');
			$url = "http://gomeao.net/offical/getUserInfo?mobile=".$mobile."&password=".$password;
			$ret_json = http_request($url);
			$json = json_decode($ret_json, true);
			log_message('error', 'login ret='.$ret_json);
			if($json['code'] != 0) {
				return null;
			} 
			
			return $json['user_info'];
		}
		
		protected function queryAppModel($token) {
			$this->load->helper('http');
			$url = "http://gomeao.net/offical/queryAppModel?token=".$token;
			$ret_json = http_request($url);
			$json = json_decode($ret_json, true);
			return $json;
		}
		
		protected function queryAppInfo($app_id, $token) {
			$this->load->helper('http');
			$url = "http://gomeao.net/offical/queryAppInfo?app_id=".$app_id."&token=".$token;
			$ret_json = http_request($url);
			$json = json_decode($ret_json, true);
			return $json;
		}
		
		protected function getRandomStr($length = 8) {
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
			$str ="";
			for ( $i = 0; $i < $length; $i++ )  {  
				$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
			} 
			return $str;
		}
	}
?>