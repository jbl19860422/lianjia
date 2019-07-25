<?php
	class RedisCache 
	{
		private $REDIS_IP = '39.108.167.62';
		private $REDIS_PORT = 6379;
		private $redis = null;
		private static $_instance;
		private function __construct()
		{
			$this->redis = new Redis();
			$retCode = $this->redis->connect($this->REDIS_IP, $this->REDIS_PORT);
			if(!$retCode)
			{
				$this->redis = null;
			}
		}

		private function __clone() 
		{

		}

		public static function getInstance()
		{
			if(!self::$_instance instanceof self)
			{
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function set_cache($key, $data, $expiretime) 
		{
			if(!$this->redis)
			{
				return false;
			}

			$this->redis->set($key, $data);
			if($expiretime > 0)
			{
				$this->redis->expire($key, $expiretime);
			}
			return true;
		}

		public function get_cache($key)
		{
			if(!$this->redis)
			{
				return null;
			}
			return $this->redis->get($key);
		}
	}

	class Wxapi 
	{
		const URL_GET_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token';
		const URL_DELIVER_NOTIFY = 'https://api.weixin.qq.com/pay/deliverynotify';

		private $WX_APPID;
		private $WX_SECRET;
		public function __construct($appid, $secret)
		{
			$this->WX_APPID = $appid;
			$this->WX_SECRET = $secret;
		}

		public function get_access_token() 
		{
			$cache = RedisCache::getInstance();
			$access_token = $cache->get_cache('access_token');
			if(!$access_token)
			{
				$url = self::URL_GET_TOKEN.'?grant_type=client_credential&appid='.$this->WX_APPID.'&secret='.$this->WX_SECRET;
				$res = Https::https_request($url);
				$json = json_decode($res, true);
				$access_token = $json['access_token'];
				if($access_token)
				{
					$cache->set_cache('access_token', $access_token, 3600);
				}
			}

			return $access_token;
		}

		public function deliver_notify()
		{
			echo'<xml> 
			  		<return_code><![CDATA[SUCCESS]]></return_code>
			   		<return_msg><![CDATA[OK]]></return_msg>
				</xml>';

			return true;
		}

		private function getSignature($arrdata, $method="sha1") 
		{
			if (!function_exists($method)) 
			{
				return false;
			}	
			ksort($arrdata);
			$paramstring = "";
			foreach($arrdata as $key => $value)
			{
				if(strlen($paramstring) == 0)
					$paramstring .= $key . "=" . $value;
				else
					$paramstring .= "&" . $key . "=" . $value;
			}
			$Sign = $method($paramstring);
			return $Sign;
		}
	}
?>