<?php
	require_once(APPPATH.'helpers/string_helper.php');
	class Redisclient {
		private $redis;
		private $redis_connect_ret;
		private $redis_ip = "127.0.0.1";
		private $redis_port = 6379;
		private $passwd = 'e05b5071';
		
		private $db_logintoken = "logintoken";
		private $db_page_config='db_page_config';
		private $db_app = 'db_app';
		
		public function __construct($config = null) {
			$this->redis = new Redis();
			if($config) {
				$this->redis_ip = $config['redis_ip'];
				$this->redis_port = $config['redis_port'];
				$this->passwd = $config['redis_passwd'];
			}
			$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			if($this->redis_connect_ret) {
				$this->redis->auth($this->passwd);
			}
		}
		
		/*
		* 获取app
		*/
		public function getApp($app_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if(!$this->redis->hExists($this->db_app, $app_id))
			{
				return null;
			}

			$app = $this->redis->hGet($this->db_app, $app_id);
			return json_decode($app,true);
		}
		
		/*
		* 获取app
		*/
		public function setApp($app_id,$app) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			$this->redis->hSet($this->db_logintoken, $app_id, json_encode($app));
			return $app;
		}
		
		/*
		* 登录key
		*/
		public function getLoginToken($app_id,$user_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if(!$this->redis->hExists($this->db_logintoken, $app_id.'.'.$user_id))
			{
				return null;
			}

			$loginToken = $this->redis->hGet($this->db_logintoken, $app_id.'.'.$user_id);
			return $loginToken;
		}

		public function setLoginToken($app_id, $user_id, $loginToken) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			$this->redis->hSet($this->db_logintoken, $app_id.'.'.$user_id, $loginToken);
		}
		
		public function incPVCounter($key) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			//log_message('debug', 'inc pv'.$key);
			if($this->redis->hExists('db_pv',$key)) {
				//log_message('debug', 'pv exist'.$key);
				$count = $this->redis->hGet('db_pv', $key);
				$count++;
				$this->redis->hSet('db_pv', $key, $count);
			} else {
				//log_message('debug', 'pv not exist'.$key);
				$this->redis->hSet('db_pv', $key, 1);
			}
		}
		
		public function getPVCounter($key) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_pv', $key)) {
				$count = $this->redis->hGet('db_pv', $key);
				return $count;
			} else {
				$this->redis->hSet('db_pv', $key, 0);
				return 0;
			}
		}
		
		public function getUVCounter($key) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_uv', $key)) {
				$count = $this->redis->hGet('db_uv', $key);
				return $count;
			} else {
				$this->redis->hSet('db_uv', $key, 0);
				return 0;
			}
		}
		
		public function incUVCounter($key) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_uv',$key)) {
				$count = $this->redis->hGet('db_uv', $key);
				$count++;
				$this->redis->hSet('db_uv', $key, $count);
			} else {
				$this->redis->hSet('db_uv', $key, 1);
			}
		}
		
		public function setUVCounter($key, $count) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			$this->redis->hSet('db_uv', $key, $count);
		}
		//页面配置相关
		public function getPageConfig($page_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			$config = $this->redis->hGet($this->db_page_config, $page_id);
			if(!$config) {
				return "";
			}
			return $config;
		}
		//设置页面配置
		public function setPageConfig($page_id, $config) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			return $this->redis->hSet($this->db_page_config, $page_id, $config);
		}
		//往redis中添加一个聊天室消息
		public function addChatMsg($chatRoomID, $msg) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			return $this->redis->lPush('cm_'.$chatRoomID, $msg);
		}
		
		public function delChatMsg($chatRoomID, $index) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			$this->redis->lSet('cm_'.$chatRoomID,$index, 'del');
			return $this->redis->lRem('cm_'.$chatRoomID, 'del',0);
		}
		
		//从redis中读取聊天室消息
		public function getChatMsg($chatRoomID) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			return $this->redis->lRange('cm_'.$chatRoomID,0,-1);
		}
		//增加频道观看记数
		public function incrChannelViewCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_ch_viewcount',$ch_id)) {
				$count = $this->redis->hGet('db_ch_viewcount', $ch_id);
				$count++;
				$this->redis->hSet('db_ch_viewcount', $ch_id, $count);
			} else {
				$this->redis->hSet('db_ch_viewcount', $ch_id, 1);
			}
		}
		
		//获取频道观看记数
		public function getChannelViewCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_ch_viewcount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_viewcount', $ch_id);
				return $count;
			} else {
				$this->redis->hSet('db_ch_viewcount', $ch_id, 0);
				return 0;
			}
		}
		
		//增加频道视频数
		public function incrChannelVideoCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_ch_videocount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_videocount', $ch_id);
				$count++;
				$this->redis->hSet('db_ch_videocount', $ch_id, $count);
			} else {
				$this->redis->hSet('db_ch_videocount', $ch_id, 1);
			}
		}
		
		//获取频道视频数
		public function getChannelVideoCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_ch_videocount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_videocount', $ch_id);
				return $count;
			} else {
				$this->redis->hSet('db_ch_videocount', $ch_id, 0);
				return 0;
			}
		}
		
		//增加频道关注数
		public function incrChannelFollowCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_ch_followcount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_followcount', $ch_id);
				$count++;
				$this->redis->hSet('db_ch_followcount', $ch_id, $count);
			} else {
				$this->redis->hSet('db_ch_followcount', $ch_id, 1);
			}
		}
		
		//减少频道关注数
		public function decrChannelFollowCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_ch_followcount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_followcount', $ch_id);
				$count--;
				if($count <= 0) {
					$count = 0;
				}
				$this->redis->hSet('db_ch_followcount', $ch_id, $count);
			} else {
				$this->redis->hSet('db_ch_videocount', $ch_id, 1);
			}
		}
		
		//获取频道关注数
		public function getChannelFollowCount($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_ch_followcount', $ch_id)) {
				$count = $this->redis->hGet('db_ch_followcount', $ch_id);
				return $count;
			} else {
				$this->redis->hSet('db_ch_followcount', $ch_id, 0);
				return 0;
			}
		}
		
		
		//增加频道收益
		public function addChannelIncome($ch_id, $count) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			if($this->redis->hExists('db_ch_income', $ch_id)) {
				$newcount = $this->redis->hGet('db_ch_income', $ch_id);
				$newcount+= $count;
				$this->redis->hSet('db_ch_income', $ch_id, $newcount);
			} else {
				$this->redis->hSet('db_ch_income', $ch_id, $count);
			}
		}
		
		//获取频道收益
		public function getChannelIncome($ch_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}

			if($this->redis->hExists('db_ch_income', $ch_id)) {
				$count = $this->redis->hGet('db_ch_income', $ch_id);
				return $count;
			} else {
				$this->redis->hSet('db_ch_income', $ch_id, 0);
				return 0;
			}
		}
		
		//系统日志
		public function addLog($app_id, $module, $user_id, $content) {
			$time = time();
			$day = date('Ymd',$time);
			$key = 'Log'.$app_id.".".$module.$day;
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			$data['user_id'] = $user_id;
			$data['content'] = $content;
			$data['time'] = $time;
			$this->redis->lPush($key, json_encode($data));
		}
		
		public function getLog($app_id, $module, $day) {
			$key = 'Log'.$app_id.".".$module.$day;
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			return $this->redis->lRange($key, 0, -1);
		}
		
		public function setMenu($app_id, $menu_conf) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			$this->redis->set('menu'.$app_id, $menu_conf);
		}
		
		public function getMenu($app_id) {
			if(!$this->redis_connect_ret) {
				$this->redis_connect_ret = $this->redis->connect($this->redis_ip, $this->redis_port);
			}

			if(!$this->redis_connect_ret) {
				return null;
			} else {
				$this->redis->auth($this->passwd);
			}
			
			return $this->redis->get('menu'.$app_id);
		}
	}
?>
