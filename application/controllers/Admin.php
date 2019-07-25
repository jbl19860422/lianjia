<?php
	require_once('ControllerBase.php');
	class Admin extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function index_page() {
			$this->load->view('admin/index_page.php');
		}
		
 
		public function login_page() {
			session_start();
			if($_SESSION['user_info']) {
				header("location: my_app_page");
				return;
			}
			$this->load->view('admin/login_page.php');
		}
		
		public function my_app_page() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				header('location: login_page');
				return;
			}
			
			$data['user_info'] = $_SESSION['user_info'];
			$this->load->model('userapp_model');
			$apps = $this->userapp_model->query(null);
			
			$data['apps'] = $apps;
			$this->load->view('admin/my_app_page', $data);
		}
		
		public function add_app_page() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				header("location: login_page");
				return;
			}
			
			$data['user_info'] = $_SESSION['user_info'];
			$this->load->view("admin/add_app_page", $data);
		}
		
		public function app_list_page() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				header("location: login_page");
				return;
			}
			
			$data['user_info'] = $_SESSION['user_info'];
			$this->load->model('userapp_model');
			$token = $_SESSION['user_info']['token'];

			$json = $this->queryAppModel($token);

			if($json['code'] == ERROR_NOT_LOGIN) {
				header("location: login_page");
				return;
			}
			
			$data['app_id'] = $_REQUEST['app_id'];
			$data['apps'] = $json['apps'];
			$this->load->view('admin/app_list_page',$data);
		}
		
		
		public function login() {
			session_start();
			$mobile = $_REQUEST['mobile'];
			$password = $_REQUEST['password'];
			$user_info = $this->loginWeStart($mobile, $password);
			if(!$user_info) {
				$this->load->view('admin/login_page.php');
				return;
			} 
			
			$_SESSION['user_info'] = $user_info;
			$data['user_info'] = $_SESSION['user_info'];
			header('location: my_app_page');
		}
		
		public function logout() {
			session_start();
			unset($_SESSION['user_info']); 
    		session_destroy();
    		header("location: login_page");
		}
		
		public function get_qiniu_upload_token() {
			session_start();
			$app_id = $_SESSION['app_id'];
			$this->load->model('userapp_model');
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
		
			$qiniu_config['ak'] = $app['cdn_ak'];
			$qiniu_config['sk'] = $app['cdn_sk'];
			$this->load->library('qiniuauth', $qiniu_config);
			$randkey = null;
			$expires = 3600*24*960;
			$upload_token = $this->qiniuauth->uploadToken($app['cdn_bucket'], $randkey, $expires);
			$ret['uptoken'] = $upload_token;
			echo json_encode($ret);
		}
		
		public function get_appcover_upload_token() {
			session_start();
			$this->load->library('qiniuauth');
			$randkey = null;
			$expires = 3600*24*960;
			$upload_token = $this->qiniuauth->uploadToken('yihui', $randkey, $expires);
			$ret['uptoken'] = $upload_token;
			echo json_encode($ret);
		}
		
		public function upload_file() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			if($_FILES["file"]["type"] == "text/plain" && ($_FILES["file"]["size"] < 20000)){
				if ($_FILES["file"]["error"] > 0) {
					$ret['code'] = -10001;
					$ret['msg'] = "Error: " . $_FILES["file"]["error"];
					echo json_encode($ret);
					return;
				} else {
			    if (file_exists($ROOT  . $_FILES["file"]["name"])){
		      	$ret['msg'] = $_FILES["file"]["name"] . " already exists. ";
		      	$ret['code'] = -10002;
		      	echo json_encode($ret);
		      	return;
		      } else {
		      	$code = move_uploaded_file($_FILES["file"]["tmp_name"],
		      	$ROOT . $_FILES["file"]["name"]);
		      	$ret['errcode'] = $code;
		      	$ret['msg'] = "Stored in: " . $ROOT . $_FILES["file"]["name"];
		      	$ret['code'] = 0;
		      	echo json_encode($ret);
		      	return;
		      }
			  }
			}
			else {
			  $ret['msg'] = "Invalid file";	
			  $ret['code'] = -10003;
			  echo json_encode($ret);
			  return;
			}
		}
		
		public function addApp() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$app['app_name'] = $_REQUEST['app_name'];
			$app['app_cover'] = $_REQUEST['app_cover'];
			$app['wx_appid'] = $_REQUEST['wx_appid'];
			$app['wx_appsecret']  = $_REQUEST['wx_appsecret'];
			$app['cdn_ak'] = $_REQUEST['cdn_ak'];
			$app['cdn_sk'] = $_REQUEST['cdn_sk'];
			$app['cdn_domain'] = $_REQUEST['cdn_domain'];
			$app['cdn_bucket'] = $_REQUEST['cdn_bucket'];
			//校验7牛云是否可用
			$this->load->helper('qiniusdk');
			$qiniusdk = new Qiniusdk($app);
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			$localPath = $ROOT = $_SERVER['DOCUMENT_ROOT']."/translate_info.txt";
			$qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
			if(!$qiniufile_url) {
				$ret['code'] = ERROR_QINIUCONFIG;
				$ret['msg'] = '七牛云CDN不可用，请确认';
				log_message('error', 'ret='.json_encode($ret));
				echo json_encode($ret);
				
				return;
			}
      
			$app['timestamp'] = time();
			$app['user_id'] = $_SESSION['user_info']['user_id'];
			$app['type'] = '';//必须从应用复制
			$this->load->model('userapp_model');
			$app_id = $this->userapp_model->insert($app);
			
			$ret['code'] = 0;
			$ret['app_id'] = $app_id;
			echo json_encode($ret);
		}
		
		public function copyApp() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
	
			$src_app_id = $_REQUEST['src_app_id'];
			$token = $_SESSION['user_info']['token'];
			$json = $this->queryAppInfo($src_app_id, $token);
			if(!$json) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			} 
			
			if($json['code'] == ERROR_NOT_LOGIN) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$src_app_info = $json['app_info'];
			$src_app = $src_app_info['src_app'];
			$dest_app_id = $_REQUEST['dest_app_id'];
		
			$this->load->model('userapp_model');
			$dst_app = $this->userapp_model->query_one(array('app_id'=>$dest_app_id));
			
			$update['subtype_id'] = $src_app['subtype_id'];
			$update['type'] = $src_app['type'];
			$update['subtype'] = $src_app['subtype'];
			$update['vername'] = $src_app['vername'];
			$update['db_name'] = $src_app['db_name'];

			$this->userapp_model->update(array('app_id'=>$dest_app_id), $update);
			
			$page_groups = $src_app_info['page_groups'];
			$ret['page_groups'] = $page_groups;
			
			$pages = $src_app_info['pages'];
			$ret['pages'] = $pages;

			$this->load->model('pagegroup_model');
			$this->load->model('userpage_model');
			$this->pagegroup_model->remove(array('app_id'=>$dest_app_id));
			$this->userpage_model->remove(array('app_id'=>$dest_app_id));//删除原有页面
			//1.先将页面分组替换掉
			$new_page_groups = [];
			for($i = 0; $i < count($page_groups); $i++) {
				$new = $page_groups[$i];
				unset($new['group_id']);
				$new['app_id'] = $dest_app_id;
				$new['timestamp'] = time();
				$new['user_id'] = '';
				$new['group_id'] = $this->pagegroup_model->insert($new);
				$new['old_group_id'] = $page_groups[$i]['group_id'];
				$new_page_groups[] = $new;
			}
			//2.将页面替换掉
			$new_pages = [];
			for($i = 0; $i < count($pages); $i++) {
				$new = $pages[$i];
				if($new['associate_page_id']) {
					$tmp = strstr($new['page_id'],"_");
					$new['page_id'] = $dest_app_id.$tmp;
					$new['app_id'] = $dest_app_id;
					$new['timestamp'] = time();
					$new['user_id'] = '';
					for($j = 0; $j < count($new_page_groups); $j++) {
						if($new['group_id'] == $new_page_groups[$j]['old_group_id']) {
							$new['group_id'] = $new_page_groups[$j]['group_id'];
							break;
						}
					}
					$this->userpage_model->insert($new);
					$new['old_page_id'] = $pages[$i]['page_id'];
					$new_pages[] = $new;
				} else {
					unset($new['page_id']);
					$new['app_id'] = $dest_app_id;
					$new['timestamp'] = time();
					$new['user_id'] = '';
					for($j = 0; $j < count($new_page_groups); $j++) {
						if($new['group_id'] == $new_page_groups[$j]['old_group_id']) {
							$new['group_id'] = $new_page_groups[$j]['group_id'];
							break;
						}
					}
					$new['page_id'] = $this->userpage_model->insert($new);
					$new['old_page_id'] = $pages[$i]['page_id'];
					$new_pages[] = $new;
				}
			}
			$ret['new_page_groups'] = $new_page_groups;
			$ret['new_pages'] = $new_pages;
			//3.下载应用描述js文件
			$desc_file = "app.js";
			$app_desc = file_get_contents("http://gomeao.net/download/app_desc/".$src_app['type']."/".$src_app['subtype']."/".$src_app['vername']."/".$desc_file);
			$json_desc = json_decode($app_desc,true);
			//处理数据库
			if($json_desc['sql_source']) {
				//创建该模型需要使用的数据库
				$this->load->model('dbbase_model');
				$ret['db_create'] = $this->dbbase_model->create_db('db_'.$dest_app_id);
				//判断数据是否为空
				$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
				$tables = $this->dbbase_model->list_tables('db_'.$dest_app_id);
				if(count($tables) <= 0) {
					//下载sql文件
					$ret['tables_count'] = 0;
					$sql_filename = "db.sql";
					$sql = file_get_contents($json_desc['sql_source']);
					file_put_contents($ROOT."/".$sql_filename,$sql);
					$exc_sql = 'mysql -uroot -p'.DB_PASSWORD.' --default-character-set=utf8 '.'db_'.$dest_app_id.' < '.$ROOT.$sql_filename." 2>&1";
					exec($exc_sql,$output, $return_val);
					@unlink($ROOT."/".$sql_filename);
				} else {
					$ret['tables_count'] = 1;
				}
			}
			$ret['app_desc'] = $json_desc;
			$this->load->helper('string');
			//处理控制器代码
			if($json_desc['controllers_source']) {
				//先创建目录
				$dir = $ROOT."application/controllers/".$src_app['type']."/".$src_app['subtype']."/".$src_app['vername'];
				mkdirs($dir);
				//下载代码包
				$controllers_source_filename = 'controllers.tar.gz';
				$code = file_get_contents($json_desc['controllers_source']);
				file_put_contents($dir."/".$controllers_source_filename,$code);
				//解压代码包
				$exec_cmd = 'tar -zxvf '.$dir."/".$controllers_source_filename.' -C '.$dir;
				@exec($exec_cmd);
			}
			//处理管理端代码
			if($json_desc['admin_source']) {
				//先创建目录
				log_message('debug', 'process admin_source '.$json_desc['admin_source']);
				$dir = $ROOT."application/views/admin/".$src_app['type']."/".$src_app['subtype']."/".$src_app['vername'];
				mkdirs($dir);
				//下载代码包
				$admin_source_filename = 'admin.view.tar.gz';
				$code = file_get_contents($json_desc['admin_source']);
				file_put_contents($dir."/".$admin_source_filename,$code);
				//加压代码包
				$exec_cmd = 'tar -zxvf '.$dir."/".$admin_source_filename.' -C '.$dir;
				@exec($exec_cmd);
			}
			//处理手机端代码
			if($json_desc['mobile_source']) {
				//先创建目录
				log_message('debug', 'process mobile_source '.$json_desc['mobile_source']);
				$dir = $ROOT."application/views/mobile/".$src_app['type']."/".$src_app['subtype']."/".$src_app['vername'];
				mkdirs($dir);
				//下载代码包
				$mobile_source_filename = 'mobile.view.tar.gz';
				$code = file_get_contents($json_desc['mobile_source']);
				file_put_contents($dir."/".$mobile_source_filename,$code);
				//加压代码包
				$exec_cmd = 'tar -zxvf '.$dir."/".$mobile_source_filename.' -C '.$dir;
				@exec($exec_cmd);
			}
			//处理模型代码
			if($json_desc['models_source']) {
				//先创建目录
				log_message('debug', 'process models_source '.$json_desc['models_source']);
				$dir = $ROOT."application/models/".$src_app['type']."/".$src_app['subtype']."/".$src_app['vername'];
				mkdirs($dir);
				//下载代码包
				$models_source_filename = 'models.tar.gz';
				$code = file_get_contents($json_desc['models_source']);
				file_put_contents($dir."/".$models_source_filename,$code);
				//加压代码包
				$exec_cmd = 'tar -zxvf '.$dir."/".$models_source_filename.' -C '.$dir;
				@exec($exec_cmd);
			}
			//处理组件代码
			//获取组件列表
			$suffix = date('Y_m_d_H_i_s');
			$token = $_SESSION['user_info']['token'];
			$this->load->library('westart_api');
			$json = $this->westart_api->queryComConfig($src_app['subtype_id'], $token);
			$coms = $json['coms'];
			$coms_group = $json['coms_group'];
			$this->load->model('appcomsgroup_model');
			$this->appcomsgroup_model->remove(array('app_id'=>$dest_app_id));
			for($i = 0; $i < count($coms_group); $i++) {
				$old_group_id = $coms_group[$i]['group_id'];
				unset($coms_group[$i]['group_id']);
				$coms_group[$i]['app_id'] = $dest_app_id;
				$coms_group[$i]['new_group_id'] = $this->appcomsgroup_model->insert($coms_group[$i]);
				for($j = 0; $j < count($coms); $j++) {
					if($coms[$j]['group_id'] == $old_group_id) {
						$coms[$j]['group_id'] = $coms_group[$i]['new_group_id'];
					}
				}
			}
			
			$this->load->helper('qiniusdk');
	    	$qiniusdk = new Qiniusdk($dst_app);
			//创建目录存放下载的组件
			$dir = $ROOT."coms/".$dest_app_id."/admin/".$suffix;
			mkdirs($dir);
			//下载组件，要不要上传七牛云呢？必须是复制出来的
			for($i = 0; $i < count($coms); $i++) {
				$com = $coms[$i];
				$code = file_get_contents($com['admin_com_file']);
				$com_name = $com['com_name'];
				file_put_contents($dir."/".$com_name.".js",$code);
				
				$localPath = $dir."/".$com_name.".js";
	      $remotePath = 'coms/admin/'.$suffix.'/'.$com_name.".js";
	      
	      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
	      if(!$qiniufile_url) {
	      	$ret['code'] = ERROR_QINIUCONFIG;
	      	$ret['msg'] = '组件上传失败，请确保七牛云可用';
	      	echo json_encode($ret);
	      	return;
	      }
	      
				$coms[$i]['admin_com_file'] = $qiniufile_url;
			}
			
			
			$dir = $ROOT."coms/".$dest_app_id."/panel/".$suffix;
			mkdirs($dir);
			//下载组件，要不要上传七牛云呢？必须是复制出来的
			for($i = 0; $i < count($coms); $i++) {
				$com = $coms[$i];
				$code = file_get_contents($com['panel_file']);
				log_message('error', $com['panel_file']);
				$com_name = $com['com_name'].'-panel';
				if($code) {
					file_put_contents($dir."/".$com_name.".js",$code);
					
		      $localPath = $dir."/".$com_name.".js";
		      log_message('error', $localPath);
		      $remotePath = 'coms/panel/'.$suffix.'/'.$com_name.".js";
		      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
		      if(!$qiniufile_url) {
		      	$ret['code'] = ERROR_QINIUCONFIG;
		      	$ret['msg'] = '组件上传失败，请确保七牛云可用';
		      	echo json_encode($ret);
		      	return;
		      }
		      
					$coms[$i]['panel_file'] = $qiniufile_url;
				}
			}
			
			//创建目录存放下载的组件
			$dir = $ROOT."coms/".$dest_app_id."/mobile/".$suffix;
			mkdirs($dir);
			
	    $this->load->model('appcoms_model');
	    $this->appcoms_model->remove(array('app_id'=>$dest_app_id));
			//下载组件，要不要上传七牛云呢？这个要
			for($i = 0; $i < count($coms); $i++) {
				$com = $coms[$i];
				$code = file_get_contents($com['mobile_com_file']."?v=".$com['mobile_com_version']);
				$com_name = $com['com_name'];
				file_put_contents($dir."/".$com_name.".js",$code);
				
	      $localPath = $dir."/".$com_name.".js";
	      $remotePath = 'coms/mobile/'.$suffix.'/'.$com_name.".js";
	      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
	      if(!$qiniufile_url) {
	      	$ret['code'] = ERROR_QINIUCONFIG;
	      	$ret['msg'] = '组件上传失败，请确保七牛云可用';
	      	echo json_encode($ret);
	      	return;
	      }
	      
	      $coms[$i]['app_id'] = $dest_app_id;
	      $coms[$i]['mobile_com_file'] = $qiniufile_url;
	      unset($coms[$i]['id']);
	      $this->appcoms_model->insert($coms[$i]);
			}
			
			$this->userapp_model->update(array('app_id'=>$dest_app_id), array('coms_suffix'=>$suffix));
			
			$ret['src_app_id'] = $src_app_id;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		private function mkdirs($dir, $mode = 0777) { 
	    if (is_dir($dir) || @mkdir($dir, $mode)){ 
	        return true; 
	    } 
	    if (!mkdirs(dirname($dir), $mode)){ 
	        return false; 
	    } 
	    return @mkdir($dir, $mode); 
	  } 
	  
	  public function addAssociatePage() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_info']['user_id'];
			$app_id = $_SESSION['app_id'];
			$this->load->model('userapp_model');
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			
			$associate_page_id = $_REQUEST['associate_page_id'];
			$page_id = $app_id.'_'.$associate_page_id;
			$this->load->model('pagegroup_model');
			$page_groups = $this->pagegroup_model->query(array('app_id'=>$app_id));
			$has_system_gen_group = false;
			$group_id = 0;
			for($i = 0; $i < count($page_groups); $i++) {
				if($page_groups[$i]['system_gen'] == 1) {
					$has_system_gen_group = true;
					$group_id = $page_groups[$i]['group_id'];
					break;
				}
			}
			
			if(!$has_system_gen_group) {//没有自动生成页面分组，则添加
				$new_group['app_id'] = $app_id;
				$new_group['group_name'] = '系统生成';
				$new_group['timestamp'] = time();
				$new_group['system_gen'] = 1;
				$new_group['group_id'] = $this->pagegroup_model->insert($new_group);
				$group_id = $new_group['group_id'];
				$ret['new_group'] = $new_group;
			}
			
			
			$new_page['page_name'] = $_REQUEST['page_info']['name'];//$associate_page['page_name'];
			$new_page['group_id'] = $group_id;
			$new_page['app_id'] = $app_id;
			$new_page['timestamp'] = time();
			$new_page['debug_page_version'] = time();
			$new_page['public_page_version'] = time();
			$new_page['auto_gen'] = 1;
			$new_page['page_id'] = $page_id;
			$page_info = $_REQUEST['page_info'];
			
			$new_page['debug_page_title'] = $page_info['title'];
			$new_page['debug_background'] = '#fff';
			$new_page['shareable'] = $page_info['shareable'];
			$new_page['debug_must_login'] = $page_info['must_login'];
			if($new_page['shareable'] == 1) {
				$new_page['debug_share_title'] = $page_info['share_title'];
				$new_page['debug_share_img'] = $page_info['share_img'];
				$new_page['debug_share_desc'] = $page_info['share_desc'];
			}
//			$new_page['debug_page_title'] = $associate_page['page_title'];
//			$new_page['debug_background'] = $associate_page['background'];
//			$new_page['debug_must_login'] = $associate_page['must_login'];
//			$new_page['debug_share_title'] = $associate_page['share_title'];
//			$new_page['debug_share_img'] = $associate_page['share_img'];
//			$new_page['debug_share_desc'] = $associate_page['share_desc'];
//			$new_page['associate_page_id'] = $associate_page_id;
			
			$this->load->helper('qiniusdk');
			$page_conf = $_REQUEST['page_conf'];
			
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			$localPath = $ROOT."confs/pages/debug/".$page_id.".js";
			
			$jsCode = "var g_coms".$page_id."=".$page_conf.";";
			
			$code = file_put_contents($localPath,$jsCode);
			$remotePath = $app_id."/public/".$page_id.".js";
      $qiniusdk = new Qiniusdk($app);
      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
      $new_page['debug_page_conf_file'] = $qiniufile_url;
			//获得组件名称
			$coms = json_decode($page_conf,true);
			$coms_name = [];
			$already_type = [];
			for($i = 0; $i < count($coms); $i++) {
				$parallel = true;
				if($coms[$i]['c_type'] == 'freepanel-com'  || $coms[$i]['c_type'] == 'normalpanel-com') {
					$parallel = false;
					$subcoms = $coms[$i]['prop']['subcoms'];
					for($j = 0; $j < count($subcoms); $j++) {
						if(!in_array($subcoms[$j]['c_type'],$already_type)) {
							$coms_name[] = array('type'=>$subcoms[$j]['c_type'],'par'=>true);
							$already_type[] = $subcoms[$j]['c_type'];
						}
					}
				} else {
					$parallel = true;
				}
				
				if(!in_array($coms[$i]['c_type'],$already_type)) {
					$coms_name[] = array('type'=>$coms[$i]['c_type'],'par'=>$parallel);
					$already_type[] = $coms[$i]['c_type'];
				}
			}
			$new_page['debug_coms'] = json_encode($coms_name);
			
			$remotePath = $app_id."/public/".$page_id.".js";
      $qiniusdk = new Qiniusdk($app);
      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
      $ret['conf_file'] = $qiniufile_url;
                      
			$this->load->model('userpage_model','',$db_config);
			$new_page['public_coms'] = $new_page['debug_coms'];
			
//			$new_page['public_page_title'] = $new_page['debug_page_title'];
//			$new_page['public_background'] = $new_page['debug_background'];
//			$new_page['public_must_login'] = $new_page['debug_must_login'];
//			$new_page['public_page_conf_file'] = $qiniufile_url;
//			$new_page['public_page_version'] = $new_page['debug_page_version'];
//			$new_page['public_share_title'] = $new_page['debug_share_title'];
//			$new_page['public_share_img'] = $new_page['debug_share_img'];
//			$new_page['public_share_desc'] = $new_page['debug_share_desc'];
			
			$this->load->model('userpage_model');
			$insert_ret = $this->userpage_model->insert($new_page);
			$ret['insert_ret'] = $insert_ret;
			$ret['new_page'] = $new_page;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		public function savePage() {
			session_start();
		
			$this->load->model('userapp_model');
			$page_id = $_REQUEST['page_id'];
			$page_conf = $_REQUEST['page_conf'];
			$app_id = $_SESSION['app_id'];
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			
			$this->load->helper('qiniusdk');
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			
			$localPath = $ROOT."confs/pages/debug/".$page_id.".js";
			$remotePath = "/".$app_id."/debug/".$page_id.".js";
			//获得组件名称
			$coms = json_decode($page_conf,true);
			$coms_name = [];
			$already_type = [];
			$depend_files = [];
			$this->load->model('appcoms_model');
			for($i = 0; $i < count($coms); $i++) {
				$parallel = true;
				$com = $this->appcoms_model->query_one(array('app_id'=>$app_id,'com_name'=>$coms[$i]['c_type']));
				$ret['coms'][] = $coms[$i]['c_type'];
				$ret['app_id'] = $app_id;
				if($com['depend_files']) {
					$depend_files[] = $com['depend_files'];
				}
				
				if($coms[$i]['c_type'] == 'freepanel-com'  || $coms[$i]['c_type'] == 'normalpanel-com') {
					$parallel = false;
					$subcoms = $coms[$i]['prop']['subcoms'];
					for($j = 0; $j < count($subcoms); $j++) {
						if(!in_array($subcoms[$j]['c_type'],$already_type)) {
							$coms_name[] = array('type'=>$subcoms[$j]['c_type'],'par'=>true);
							$already_type[] = $subcoms[$j]['c_type'];
						}
					}
				} else {
					$parallel = true;
				}
				
				if(!in_array($coms[$i]['c_type'],$already_type)) {
					$coms_name[] = array('type'=>$coms[$i]['c_type'],'par'=>$parallel);
					$already_type[] = $coms[$i]['c_type'];
				}
			}
			
			$jsCode = "var g_coms".$page_id."=".$page_conf.";";
			$jsCode1 = "";
			if(isset($_REQUEST['page_info'])) {
				log_message('error', 'page_info='.$_REQUEST['page_info']);
				$page_info = $_REQUEST['page_info'];
				$jsCode1 = "var g_pageinfo".$page_id."=".json_encode($page_info).";";
			}

			$code = file_put_contents($localPath,$jsCode.$jsCode1);
      if($code) {
        $qiniusdk = new Qiniusdk($app);
        $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
        $ret['conf_file'] = $qiniufile_url;
      }

			$this->load->model('userpage_model');
			$page = $this->userpage_model->query_one(array('page_id'=>$page_id));
			$page['depend_files'] = implode("|",$depend_files);
			$page['debug_coms'] = json_encode($coms_name);
			$page['debug_page_version'] = time();
			$page['debug_page_conf_file'] = $qiniufile_url;
			$this->userpage_model->update(array('page_id'=>$page_id), $page);
			$ret['app'] = $app;
			$ret['page_id'] = $page_id;
			$ret['page'] = $page;
			$ret['code'] = $code;
			$ret['localPath'] = $localPath;
			echo json_encode($ret);
		}
		public function savePublicPage() {
			session_start();
		
			$this->load->model('userapp_model');
			$page_id = $_REQUEST['page_id'];
			$page_conf = $_REQUEST['page_conf'];
			$app_id = $_SESSION['app_id'];
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			
			$this->load->helper('qiniusdk');
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			
			$localPath = $ROOT."confs/pages/debug/".$page_id.".js";
			$remotePath = "/".$app_id."/debug/".$page_id.".js";
			//获得组件名称
			$coms = json_decode($page_conf,true);
			$coms_name = [];
			$already_type = [];
			$depend_files = [];
			$this->load->model('appcoms_model');
			for($i = 0; $i < count($coms); $i++) {
				$parallel = true;
				$com = $this->appcoms_model->query_one(array('app_id'=>$app_id,'com_name'=>$coms[$i]['c_type']));
				$ret['coms'][] = $coms[$i]['c_type'];
				$ret['app_id'] = $app_id;
				if($com['depend_files']) {
					$depend_files[] = $com['depend_files'];
				}
				
				if($coms[$i]['c_type'] == 'freepanel-com'  || $coms[$i]['c_type'] == 'normalpanel-com') {
					$parallel = false;
					$subcoms = $coms[$i]['prop']['subcoms'];
					for($j = 0; $j < count($subcoms); $j++) {
						if(!in_array($subcoms[$j]['c_type'],$already_type)) {
							$coms_name[] = array('type'=>$subcoms[$j]['c_type'],'par'=>true);
							$already_type[] = $subcoms[$j]['c_type'];
						}
					}
				} else {
					$parallel = true;
				}
				
				if(!in_array($coms[$i]['c_type'],$already_type)) {
					$coms_name[] = array('type'=>$coms[$i]['c_type'],'par'=>$parallel);
					$already_type[] = $coms[$i]['c_type'];
				}
			}
			
			$jsCode = "var g_coms".$page_id."=".$page_conf.";";
			$jsCode1 = "";
			if(isset($_REQUEST['page_info'])) {
				log_message('error', 'page_info='.$_REQUEST['page_info']);
				$page_info = $_REQUEST['page_info'];
				$jsCode1 = "var g_pageinfo".$page_id."=".json_encode($page_info).";";
			}

			$code = file_put_contents($localPath,$jsCode.$jsCode1);
			$qiniusdk = new Qiniusdk($app);
      if($code) {
        $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
        $ret['conf_file'] = $qiniufile_url;
      }

			$this->load->model('userpage_model');
			$page = $this->userpage_model->query_one(array('page_id'=>$page_id));
			$page['depend_files'] = implode("|",$depend_files);
			$page['debug_coms'] = json_encode($coms_name);
			$page['debug_page_version'] = time();
			$page['debug_page_conf_file'] = $qiniufile_url;
			
			$remotePath = "/".$app_id."/public/".$page_id.".js";
      $qiniufile_public_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
      $ret['conf_file'] = $qiniufile_url;
      log_message('error','qiniufile='.$qiniufile_url);                 
			$page['public_coms'] = $page['debug_coms'];
			$page['public_page_title'] = $page['debug_page_title'];
			$page['public_background'] = $page['public_background'];
			$page['public_must_login'] = $page['debug_must_login'];
			$page['public_page_conf_file'] = $qiniufile_public_url;
			$page['public_page_version'] = $page['debug_page_version'];
			$page['public_share_title'] = $page['debug_share_title'];
			$page['public_share_img'] = $page['debug_share_img'];
			$page['public_share_desc'] = $page['debug_share_desc'];
			$page['public_coms'] = $page['debug_coms'];
			
			$this->userpage_model->update(array('page_id'=>$page_id), $page);
			$ret['app'] = $app;
			$ret['page_id'] = $page_id;
			$ret['page'] = $page;
			$ret['code'] = $code;
			$ret['localPath'] = $localPath;
			echo json_encode($ret);
		}

		
		public function publicPage() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			
			$page_id = $_REQUEST['page_id'];
			$app_id = $_SESSION['app_id'];
			$this->load->model('userapp_model');
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			
			$localPath = $ROOT."confs/pages/debug/".$page_id.".js";
			if(!file_exists($localPath)) {
				log_message('error',$localPath);
				$ret['code'] = -9030;
				echo json_encode($ret);
				return;
			}
			$remotePath = "/".$app_id."/public/".$page_id.".js";
			$this->load->helper('qiniusdk');
      $qiniusdk = new Qiniusdk($app);
      $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
      $ret['conf_file'] = $qiniufile_url;
      log_message('error','qiniufile='.$qiniufile_url);                 
			$this->load->model('userpage_model');
			$page = $this->userpage_model->query_one(array('app_id'=>$app_id,'page_id'=>$page_id));
			$page['public_coms'] = $page['debug_coms'];
			$page['public_page_title'] = $page['debug_page_title'];
			$page['public_background'] = $page['public_background'];
			$page['public_must_login'] = $page['debug_must_login'];
			$page['public_page_conf_file'] = $qiniufile_url;
			$page['public_page_version'] = $page['debug_page_version'];
			$page['public_share_title'] = $page['debug_share_title'];
			$page['public_share_img'] = $page['debug_share_img'];
			$page['public_share_desc'] = $page['debug_share_desc'];
			$page['public_coms'] = $page['debug_coms'];
			
			if($this->userpage_model->update(array('app_id'=>$app_id,'page_id'=>$page_id), $page)) {
				$ret['code'] = 0;
			} else {
				$ret['code'] = ERROR_UNKNOWN;
			}
			$ret['page'] = $page;
			$ret['localPath'] = $localPath;
			echo json_encode($ret);
		}
		
		public function editDebugPageInfo() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$app_id = $_SESSION['app_id'];
			$page_id = $_REQUEST['page_id'];
			$page['debug_page_title'] = $_REQUEST['debug_page_title'];
			$page['debug_background'] = $_REQUEST['debug_background'];
			$page['debug_must_login'] = $_REQUEST['debug_must_login'];
			$page['debug_share_title'] = $_REQUEST['debug_share_title'];
			$page['debug_share_img'] = $_REQUEST['debug_share_img'];
			$page['debug_share_desc'] = $_REQUEST['debug_share_desc'];
			$page['shareable'] = $_REQUEST['shareable'];
			
			$where['page_id'] = $page_id;
			$where['app_id'] = $app_id;
			$this->load->model('userpage_model');
			
			$this->userpage_model->update($where, $page);
			$ret['page_id'] = $page_id;
			$ret['page'] = $page;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delApp() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$app_id = $_REQUEST['app_id'];
			$this->load->model('userapp_model');
			$update['deleted'] = 1;
			if($this->userapp_model->update(array('app_id'=>$app_id),$update)) {
				$ret['code'] = 0;
			} else {
				$ret['code'] = ERROR_UNKNOWN;
			}
			echo json_encode($ret);
		}
		
		public function addPic() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$app_id = $_SESSION['app_id'];
			
			$this->load->model('userpic_model');
			$pic['url'] = $_REQUEST['url'];
			$pic['cate_id'] = $_REQUEST['cate_id'];
			$pic['app_id'] = $app_id;
			$pic['timestamp'] = time();
			$pic['pic_id'] = $this->userpic_model->insert($pic);
			$ret['code'] = 0;
			$ret['pic'] = $pic;
			echo json_encode($ret);
		}
		
		public function addPicCategory() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_info']['user_id'];
			$app_id = $_SESSION['app_id'];
			
			$category['name'] = $_REQUEST['name'];
			$category['user_id'] = $user_id;
			$category['app_id'] = $app_id;
			
			$this->load->model('piccate_model');
			$cate_id = $this->piccate_model->insert($category);
			$ret['code'] = 0;
			$ret['cate_id'] = $cate_id;
			echo json_encode($ret);
		}
		
		public function createPicCate() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$app_id = $_SESSION['app_id'];
			
			$pic_cate['name'] = $_REQUEST['cate_name'];
			$pic_cate['app_id'] = $app_id;
			$this->load->model('piccate_model');
			$pic_cate['cate_id'] = $this->piccate_model->insert($pic_cate);
			$ret['code'] = 0;
			$ret['pic_cate'] = $pic_cate;
			echo json_encode($ret);
		}
		
		public function delPicCategory() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$app_id = $_SESSION['app_id'];
		
			$this->load->model('piccate_model');
			$cate['cate_id'] = $_REQUEST['cate_id'];
			$cate['app_id'] = $app_id;
			
			$this->piccate_model->remove($cate);
			
			$this->load->model('userpic_model');
			$this->userpic_model->update(array('cate_id'=>$cate['cate_id'],'app_id'=>$app_id),array('cate_id'=>0));
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function createPageGroup() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_info']['user_id'];
			$app_id = $_SESSION['app_id'];
			
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			$db_config['hostname'] = '127.0.0.1';
			$db_config['username'] = 'root';
			$db_config['password'] = DB_PASSWORD;
			$db_config['database'] = 'db_'.$app_id;
			$db_config['dbdriver'] = 'mysqli';
			$db_config['port'] = 3306;
			
			$this->load->model('pagegroup_model');
			
			$group_name = $_REQUEST['group_name'];
			
			$group['group_name'] = $group_name;
			$group['app_id'] = $app_id;
			
			$group['group_id'] = $this->pagegroup_model->insert($group);
			$ret['code'] = 0;
			$ret['group'] = $group;
			echo json_encode($ret);
		}
		
		public function createPage() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_info']['user_id'];
			$app_id = $_SESSION['app_id'];

			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			$this->load->model('userpage_model');
			$page['page_name'] = $_REQUEST['page_name'];
			$page['group_id'] = $_REQUEST['group_id'];
			$page['app_id'] = $app_id;
			$page['timestamp'] = time();
			$page['debug_page_version'] = time();
			$page['public_page_version'] = time();
			$page['page_id'] = $this->userpage_model->insert($page);
			$ret['code'] = 0;
			$ret['page'] = $page;
			echo json_encode($ret);
		}
		
		public function updatePageGroupName() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_id'];
			
			$app_id = $_SESSION['app_id'];
			$group_id = $_REQUEST['group_id'];
			$where['group_id'] = $group_id;
			$where['app_id'] = $app_id;
			$group['group_name'] = $_REQUEST['group_name'];
			
			$this->load->model('pagegroup_model');
			$this->pagegroup_model->update($where,$group);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function updatePageName() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['page_id'] = $page_id;
			$group['page_name'] = $_REQUEST['page_name'];
			
			$this->load->model('userpage_model');
			$this->userpage_model->update($where,$group);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delPage() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$app_id = $_SESSION['app_id'];
	
			$page_id = $_REQUEST['page_id'];
			$this->load->model('userpage_model');
			$where['app_id'] = $app_id;
			$where['page_id'] = $page_id;
			$this->userpage_model->remove($where);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delPageGroup() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$app_id = $_SESSION['app_id'];
			$group_id = $_REQUEST['group_id'];

			$this->load->model('pagegroup_model');
			$where['app_id'] = $app_id;
			$where['group_id'] = $group_id;
			$this->pagegroup_model->remove($where);
			
			$this->load->model('userpage_model');
			$this->userpage_model->remove($where);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function copyPage() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$user_id = $_SESSION['user_info']['user_id'];
			$app_id = $_SESSION['app_id'];

			$this->load->model('userpage_model');
			$src_page = $_REQUEST['page'];
			$src_page_id = $src_page['page_id'];
			$src_page_info = $this->userpage_model->query_one(array('page_id'=>$src_page_id));
			$dst_page = $src_page_info;
			$dst_page['debug_page_version'] = time();
			$dst_page['timestamp'] = time();
			$dst_page['public_page_conf_file'] = '';
			$dst_page['public_page_version'] = time();
			$dst_page['page_name'] = $dst_page['page_name']."_copy";
			unset($dst_page['page_id']);
			$page_id = $this->userpage_model->insert($dst_page);
			if(!$page_id) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			$dst_page['page_id'] = $page_id;
			$page_conf = $_REQUEST['page_conf'];
			
			$ROOT = $_SERVER['DOCUMENT_ROOT']."/";
			$localPath = $ROOT."confs/pages/debug/".$page_id.".js";
			$remotePath = "/".$app_id."/debug/".$page_id.".js";
			$code = file_put_contents($localPath,"var g_coms".$page_id."=".$page_conf.";");
      if($code) {
      	$app_id = $_SESSION['app_id'];
				$this->load->model('userapp_model');
				$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
      	$this->load->helper('qiniusdk');
        $qiniusdk = new Qiniusdk($app);
        $qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*100,array("scope"=>$app['cdn_bucket'].":".$remotePath,"insertOnly"=> 0));
        $ret['conf_file'] = $qiniufile_url;
      }
      
      $where['page_id'] = $page_id;
      $dst_page['debug_page_conf_file'] = $qiniufile_url;
      $this->userpage_model->update($where, $dst_page);   
	
			$ret['page'] = $dst_page;
			$ret['app'] = $app;
			$ret['write_code'] = $code;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function saveMenu() {
			session_start();
			if(!isset($_SESSION['user_info'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				return;
			}
			
			$app_id = $_SESSION['app_id'];
			$this->load->model('userapp_model');
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			
			$options['token'] = 'weixin';
			$options['encodingaeskey'] = 'znAtltMaA9JMe2QHYcq2jCJbtbl5QjE6Cn4yC2LjhT0';
			$options['appid'] = $app['wx_appid'];
			$options['appsecret'] = $app['wx_appsecret'];
			$options['redis_ip'] = '127.0.0.1';
			$options['redis_port'] = 6380;
			$options['myappid'] = $app_id;
			$menu_conf = $_REQUEST['menu_conf'];
			//$ret['options'] = $options;
			$this->load->library('wechat', $options);
			$result = $this->wechat->createMenu($menu_conf);
			if($result) {
				$this->load->library('redisclient',$options);
				$this->redisclient->setMenu($app_id, json_encode($menu_conf));
				$ret['code'] = 0;
				echo json_encode($ret);
				return;
			}
			
			$ret['result'] = $result;
			$ret['code'] = ERROR_UNKNOWN;
			echo json_encode($ret);
		}
		
		public function wechat() {
			if(!isset($_REQUEST['app_id'])) {
				return;
			}
			
			$app_id = $_REQUEST['app_id'];
			$this->load->model('userapp_model');
			$app = $this->userapp_model->query_one(array('app_id'=>$app_id));
			$options['token'] = 'weixin';
			$options['encodingaeskey'] = 'znAtltMaA9JMe2QHYcq2jCJbtbl5QjE6Cn4yC2LjhT0';
			$options['appid'] = $app['wx_appid'];
			$options['appsecret'] = $app['wx_appsecret'];
			$options['redis_ip'] = '127.0.0.1';
			$options['redis_port'] = 6379;
			$options['redis_passwd'] = 'jiangbaolin';
			$options['myappid'] = $app_id;
			$this->load->library('wechat', $options);
			$this->wechat->valid();
			
			$type = $this->wechat->getRev()->getRevType();
			switch($type) {
    		case Wechat::MSGTYPE_TEXT:
				 	$content = $this->wechat->getRevContent();
				 	//回复文本
    			//$this->wechat->text($content)->reply();
    			//回复图文
//    			$news['Title'] = '标题';
//    			$news['Description'] = '描述';
//    			$news['PicUrl'] = 'http://otf974inp.bkt.clouddn.com/o_1blrnqbdc10o413gckvg1i321jmvr.jpg';
//    			$news['Url'] = 'http://gomeao.net/cultural/media/v1/admin/live_manager_page';
//    			$newsData[] = $news;
//    			$this->wechat->news($newsData)->reply();
					//回复模板消息
					$this->wechat->text('欢迎来到'.$app['app_name']."，您在说什么？")->reply();
					break;
					$templateMsg = [];
					$templateMsg['touser'] = $this->wechat->getRevFrom();
					$templateMsg['template_id'] = 'p9uKefZzy77yJ6iXHBF3uRtgDpS_8d0dbuNEQqL11N4';
					$templateMsg['url'] = 'http://baidu.com';
					$templateMsg['topcolor'] = '#ff0000';
					$templateMsg['data'] = [];
					$templateMsg['data']['first'] = array('value'=>'客户名称','color'=>'#173177');
					$templateMsg['data']['orderMoneySum'] = array('value'=>'100','color'=>'#173177');
					$templateMsg['data']['orderProductName'] = array('value'=>'产品名称','color'=>'#173177');
					$templateMsg['data']['Remark'] = array('value'=>'备注','color'=>'#173177'); 
					$access_token = $this->wechat->getAccessToken();
					log_message('error', 'access_token='.$access_token);
					$ret = $this->wechat->sendTemplateMessage($templateMsg);
					log_message('error', json_encode($ret));
    			exit;
    			break;
    		case Wechat::MSGTYPE_EVENT:
    			$revEvent = $this->wechat->getRevEvent();
    			if($revEvent['event'] == 'CLICK') {
    				$key = $revEvent['key'];
    				$this->load->library('redisclient', $options);
	    			$menu_conf = $this->redisclient->getMenu($app_id);
	    			$menu = json_decode($menu_conf,true);
	    			$buttons = $menu['button'];
	    			for($i = 0; $i < count($buttons); $i++) {
	    				$button = $buttons[$i];
	    				if(array_key_exists('sub_button',$button)) {
	    					$sub_button = $button['sub_button'];
	    					for($j = 0; $j < count($sub_button); $j++) {
	    						if($sub_button[$j]['type'] == 'click') {
	    							if($sub_button[$j]['key'] == $key) {
	    								$this->processEvent($sub_button[$j]);
	    							}
	    						}
	    					}
	    				} else {
	    					if($button['key'] == $key) {
	    						$this->processEvent($button);
	    					}
	    				}
	    			}
    			} else {
    				//$this->wechat->text('欢迎来到'.$app['app_name'].'，'.$app['default_reply'])->reply();
    			}
    			break;
   			case Wechat::MSGTYPE_IMAGE:
   				//$this->wechat->text('欢迎来到'.$app['app_name'])->reply();
    			break;
    		default:
    			//$this->wechat->text('欢迎来到'.$app['app_name'])->reply();
    	}
		}
		
		private function processEvent($button) {
			
			if($button['subtype'] == 'text') {
				$this->wechat->text($button['data'])->reply();
			} else if($button['subtype'] == 'news') {
				$news_items = $button['data']['content']['news_item'];
				$newsData = [];
				for($i = 0; $i < count($news_items); $i++) {
					$news['Title'] = $news_items[$i]['title'];
    			$news['Description'] = $news_items[$i]['digest'];
    			$news['PicUrl'] = $news_items[$i]['thumb_url'];
    			$news['Url'] = $news_items[$i]['url'];
    			$newsData[] = $news;
				}
				$this->wechat->news($newsData)->reply();
			} else if($button['subtype'] == 'image') {
				log_message('error', json_encode($button));
				$this->wechat->image($button['data']['media_id'])->reply();
			}
		}
	}
?>
