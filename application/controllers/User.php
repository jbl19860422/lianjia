<?php
	require_once('ControllerBase.php');
	class User extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function login_page() {
			$this->load->view('users/login_page');
		}
		
		public function register_page() {
			$this->load->view('users/register_page', $data);
		}
		
		public function modify_password_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$this->load->view('users/modify_password_page');
		}

		public function forget_password_page() {
			$this->load->view('users/forget_password_page');
		}

		public function user_modify_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$this->load->view('users/user_modify_page');
		}

		public function appsee_detail_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$this->load->model('user/appsee_model');
			$data['appsee'] = $this->appsee_model->query_one(array('see_id'=>$_REQUEST['see_id']));
			
			$data['appsee']['appsee_houses'] = json_decode($data['appsee']['appsee_houses'], true);
			$appsee_houses = $data['appsee']['appsee_houses'];
			$house_ids = [];
			$this->load->model('houseinfo/house_info_model');
			for($i = 0; $i < count($appsee_houses); $i++) {
				$data['appsee']['appsee_houses'][$i]['house'] = $this->house_info_model->query_one(array('house_info_id'=>$appsee_houses[$i]['house_info_id']));
			}
			
			$this->load->view('users/appsee_detail_page', $data);
		}
		
		public function setFollow() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee = $_SESSION['employee'];
			
			$s = $_REQUEST['s'];
			$this->load->model('user/house_follow_model');
			if($s == 1) {
				$f['employee_id'] = $employee['employee_id'];
				$f['house_info_id'] = $_REQUEST['house_info_id'];
				$f['create_time'] = time();
				$f['follow_id'] = $this->house_follow_model->insert($f);
				$ret['code'] = 0;
				$ret['follow'] = $f;
				echo json_encode($ret);
			} else if(s == 0) {
				$this->house_follow_model->remove(array('follow_id'=>$_REQUEST['follow']['follow_id']));
				$ret['code'] = 0;
				echo json_encode($ret);
			}
		}
		
		public function modifyPassword() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$user['password'] = md5($_REQUEST['new_password']);
			
			$this->load->model('user/employee_model');
			$this->employee_model->update(array('employee_id'=>$employee['employee_id']), $user);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function registerUser() {
			session_start();
			$this->load->model('user/employee_model');
			$user['mobile'] = $_REQUEST['mobile'];
			$user['password'] = md5($_REQUEST['password1']);
			$user['nickname'] = $_REQUEST['nickname'];
			//$user['sex'] = $_REQUEST['sex'];
			$where['mobile'] = $user['mobile'];
			$users = $this->employee_model->query($where);
			if($users) {
				$ret['code'] = ERROR_USER_EXIST;
				echo json_encode($ret);
				return;
			}
			//校验验证码
			$this->load->library('rongcloudapi');
			$checkcode = $_REQUEST['checkcode'];
			$sessionId = $_REQUEST['sessionId'];
			$res = $this->rongcloudapi->verify_code($sessionId, $checkcode);
			if(!$res) {
				$ret['checkcode'] = $checkcode;
				$ret['sessionId'] = $sessionId;
				$ret['code'] = ERROR_VERIFY_FAILED;//校验失败
				echo json_encode($ret);
				return; 
			}
			
			$user['reg_time'] = time();
			$user['employee_id'] = $this->employee_model->insert($user);
			$ret['employee'] = $user;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addTeam() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('user/message_model');
			//查询商圈的管理员
			$ta_id = $employee['ta_id'];
			if(0 == $ta_id) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			$this->load->model('city/trade_area_model');
			$ta = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			
			$msg['type'] = MSG_CREATE_TEAM;
			$msg['create_time'] = time();
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $ta['employee_id'];
			$msg['brocast'] = 0;
			$msg['bro_type'] = 0;
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			
			if($employee['ta_id'] == 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			$team['ta_id'] = $employee['ta_id'];
			$team['name'] = $_REQUEST['name'];
			$team['employee_id'] = $msg['from_employee_id'];
			$msg['content'] = json_encode($team);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowCreateTeam() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['employee_id'] = $_REQUEST['from_employee_id'];
			$this->load->model('user/team_model');
			$t['employee_id'] = $_REQUEST['from_employee_id'];
			$t['team_name'] = $_REQUEST['content']['name'];
			$t['ta_id'] = $_REQUEST['content']['ta_id'];
			$t['valid'] = 1;
			$t['create_time'] = time();
			
			$team_id = $this->team_model->insert($t);

			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			
			$this->load->model('user/employee_model');
			$e['team_creator'] = 1;
			$e['joined_team'] = 0;
			$e['team_id'] = $team_id;
			$e['team_name'] = $t['team_name'];
			$this->employee_model->update(array('employee_id'=>$_REQUEST['from_employee_id']), $e);
			
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function my_team_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('user/employee_model');
			$this->load->model('user/team_employee_model');
			$employee = $_SESSION['employee'];
			$where['employee_id'] = $employee['employee_id'];
			$this->load->model('user/team_model');
			$data['my_team'] = $this->team_model->query_one($where);
			if($data['my_team']) {
				$e = $this->team_employee_model->query(array('team_id'=>$data['my_team']['team_id']));
				$emps = [];
				for($i = 0; $i < count($e); $i++) {
					$t= $this->employee_model->query_one(array('employee_id'=>$e[$i]['employee_id']));
					unset($t['password']);
					$emps[] = $t;
				}
				
				$data['my_team']['employees'] = $emps;
			}
			
			$t = $this->team_employee_model->query_one($where);
			if($t) {
				$data['join_team'] = $this->team_model->query_one(array('team_id'=>$t['team_id']));
			}

			$this->load->view('users/my_team_page', $data);
		}
		
		public function user_center_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			/*
			$this->load->model('user/message_model');
			$sql_msg = 'select * from tb_message where to_employee_id='.$_SESSION['employee']['employee_id'].' or (brocast=1 and bro_type='.$_SESSION['employee']['type'].')';
			$data['messages'] = $this->message_model->raw_query($sql_msg);
			*/
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$data['employee'] = $_SESSION['employee'];

			$this->load->model('user/team_model');
			if($_SESSION['employee']['team_id'] != 0) {
				$data['team'] = $this->team_model->query_one(array('team_id'=>$_SESSION['employee']['team_id']));
			} else {
				$data['team'] = null;
			}
			
			$this->load->view('users/user_center_page', $data);
		}
		
		public function user_verified_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			$this->load->view('users/user_verified_page');
		}

		public function user_realinfo_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			$this->load->view('users/user_realinfo_page');
		}
		
		public function user_message_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$data['employee'] = $employee;
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->view('users/user_message_page', $data);
		}

		public function verifyUserOk() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$where['employee_id'] = $_REQUEST['employee_id'];
			$this->load->model('user/employee_model');
			$e['real_checked'] = true;
			$e['real_info'] = json_encode($_REQUEST['real_info']);
			$e['name'] = $_REQUEST['real_info']['realname'];
			$this->employee_model->update($where, $e);

			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function verifyUser() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('user/message_model');
			$msg['brocast'] = 1;
			$msg['bro_type'] = ADMIN_TYPE_A;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['type'] = MSG_VERIFY_USER;
			$msg['content'] = json_encode($_REQUEST);
			$this->load->model('user/employee_model');
			//$rootUsers = $this->employee_model->query(array('type'=>10));
			//for($i = 0; $i < count($rootUsers); $i++) {
			$msg['to_employee_id'] = 0;
			$this->message_model->insert($msg);
			//}
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function applyModifyUserRealInfo() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('user/message_model');
			$msg['brocast'] = 1;
			$msg['bro_type'] = ADMIN_TYPE_A;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['type'] = MSG_APPLY_MODIFY_REALINFO;
			$msg['content'] = json_encode($_REQUEST);
			$this->load->model('user/employee_model');
			//$rootUsers = $this->employee_model->query(array('type'=>10));
			//for($i = 0; $i < count($rootUsers); $i++) {
			$msg['to_employee_id'] = 0;
			$this->message_model->insert($msg);
			//}
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyForAgent() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('user/message_model');

			$msg['brocast'] = 1;
			$msg['bro_type'] = ADMIN_TYPE_A;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['type'] = MSG_APPLY_AGENT;
			$msg['content'] = json_encode($_REQUEST);
			$msg['to_employee_id'] = 0;
			$this->message_model->insert($msg);

			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyProfessionalAgent() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('user/message_model');

			$msg['brocast'] = 1;
			$msg['bro_type'] = ADMIN_TYPE_A;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['type'] = 14;
			$msg['content'] = json_encode($_REQUEST);
			$msg['to_employee_id'] = 0;
			$this->message_model->insert($msg);

			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function checkAgentOK(){
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$where['employee_id'] = $_REQUEST['from_employee_id'];
			$this->load->model('user/employee_model');
			$e['role'] = ROLE_DEP_AGENT;
			$e['area_id'] = $_REQUEST['content']['area_id'];
			$e['ta_id'] = $_REQUEST['content']['ta_id'];
			
			$this->employee_model->update($where, $e);

			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		
		public function checkProfessionalAgentOK(){
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$where['employee_id'] = $_REQUEST['from_employee_id'];
			$this->load->model('user/employee_model');
			$e['role'] = ROLE_IND_AGENT;
			
			$this->employee_model->update($where, $e);

			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function logout_page() {
			session_start();
			unset($_SESSION['employee']);
			unset($_SESSION['employee_id']);
			header("location: login_page");
		}
		
		public function updateUser() {
			session_start();
			if(!isset($_SESSION['employee_id'])) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			$this->load->model('user/employee_model');
			$where['employee_id'] = $_SESSION['employee_id'];
			$user['name'] = $_REQUEST['name'];
			$user['headimg'] = $_REQUEST['headimg'];
			$user['sex'] = $_REQUEST['sex'];
			$user['work_no'] = $_REQUEST['work_no'];
			
			$this->employee_model->update($where,$user);
			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function modifyUser() {
			session_start();
			if(!isset($_SESSION['employee_id'])) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			$this->load->model('user/employee_model');
			$where['employee_id'] = $_SESSION['employee_id'];
			$user = $this->employee_model->query_one($where);
			if(!$user) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}

			if($user['mobile'] != $_REQUEST['mobile']) {
				$new_user['mobile'] = $_REQUEST['mobile'];
				//校验验证码
				$this->load->library('rongcloudapi');
				$checkcode = $_REQUEST['checkcode'];
				$sessionId = $_REQUEST['sessionId'];
				$res = $this->rongcloudapi->verify_code($sessionId, $checkcode);
				if(!$res) {
					$ret['checkcode'] = $checkcode;
					$ret['sessionId'] = $sessionId;
					$ret['code'] = ERROR_VERIFY_FAILED;//校验失败
					echo json_encode($ret);
					return; 
				}
			}

			$new_user['nickname'] = $_REQUEST['nickname'];
			$new_user['mobile'] = $_REQUEST['mobile'];
			$new_user['sex'] = $_REQUEST['sex'];
			
			$this->employee_model->update($where,$new_user);

			$_SESSION['employee']['mobile'] = $new_user['mobile'];
			$_SESSION['employee']['nickname'] = $new_user['nickname'];
			$_SESSION['employee']['sex'] = $new_user['sex'];
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function updateUserHeadImg() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			$this->load->model('user/employee_model');
			$where['employee_id'] = $_SESSION['employee']['employee_id'];
			$user['headimg'] = $_REQUEST['headimg'];
			$this->employee_model->update($where,$user);
			$_SESSION['employee']['headimg'] = $_REQUEST['headimg'];
			$ret['headimg'] = $_REQUEST['headimg'];
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function loginUser() {
			session_start();
			$where['mobile'] = $_REQUEST['mobile'];
			$where['password'] = md5($_REQUEST['password']);
			
			$this->load->model('user/employee_model');
			$user = $this->employee_model->query_one($where);
			if(!$user) {
				$ret['code'] = ERROR_USER_NOT_EXIST;
				echo json_encode($ret);
				return;
			}
			/*去掉审核流程
			if($user['valid'] == 0) {
				$ret['code'] = ERROR_USER_NOT_VALID;
				echo json_encode($ret);
				return;
			}
			*/
			$_SESSION['employee_id'] = $user['employee_id'];
			unset($user['password']);
			$_SESSION['employee'] = $user;
			$ret['province_id'] = $province_id;
			$ret['user'] = $user;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		public function sendRegisterCheckCode() {
			if(!isset($_REQUEST['mobile'])) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			
			$mobile = $_REQUEST['mobile'];
			$region = "86";
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$templateId = $this->config->item('REGISTER_TEMP_ID');
			$this->load->library('rongcloudapi');
			$sJson = $this->rongcloudapi->send_checkcode($mobile, $templateId, $region);
			$data_json = json_decode($sJson, true);
			if($data_json['code'] == 1008) {
				$ret['code'] = ERROR_SEND_CHECKCODE_TOOOFTEN;
				echo json_encode($ret);
				return;
			} else if($data_json['code'] != 200) {
				$ret['code'] = ERROR_UNKNOWN_ERROR;
				echo json_encode($ret);
				return;
			}
			
			$ret['code'] = 0;
			$ret['sessionId'] = $data_json['sessionId'];
			echo json_encode($ret);
		}

		public function sendForgetPwdCheckCode() {
			if(!isset($_REQUEST['mobile'])) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			
			$mobile = $_REQUEST['mobile'];
			$region = "86";
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$templateId = $this->config->item('REGISTER_TEMP_ID');
			$this->load->library('rongcloudapi');
			$sJson = $this->rongcloudapi->send_checkcode($mobile, $templateId, $region);
			$data_json = json_decode($sJson, true);
			if($data_json['code'] == 1008) {
				$ret['code'] = ERROR_SEND_CHECKCODE_TOOOFTEN;
				echo json_encode($ret);
				return;
			} else if($data_json['code'] != 200) {
				$ret['code'] = ERROR_UNKNOWN_ERROR;
				echo json_encode($ret);
				return;
			}
			
			$ret['code'] = 0;
			$ret['sessionId'] = $data_json['sessionId'];
			echo json_encode($ret);
		}
	}
?>
