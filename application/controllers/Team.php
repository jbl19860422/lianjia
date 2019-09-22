<?php
	require_once(dirname(__file__).'/ControllerBase.php');
	class Team extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function team_page() {
			$this->load->view('team/team_page.php');
		}
		
		public function admin_manager_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$areas = $this->area_model->query();
			
			$this->load->model('user/employee_model');
			$employees = $this->employee_model->query();
			for($i = 0; $i < count($employees); $i++) {
				unset($employees[$i]['password']);
			}
			
			$this->load->model('city/trade_area_model');
			$trade_areas = $this->trade_area_model->query();
			
			$data['areas'] = $areas;
			$data['trade_areas'] = $trade_areas;
			$data['employees'] = $employees;
			$this->load->view('team/admin_manager_page', $data);
		}
		
		public function team_detail_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('user/employee_model');
			$this->load->model('user/team_model');
			$team = $this->team_model->query_one(array('team_id'=>$_REQUEST['team_id']));
			
			$data['team_creator'] = $this->employee_model->query_one(array('employee_id'=>$team['employee_id']));
			unset($data['team_creator']['password']);
			$this->load->model('user/team_employee_model');
			$team_employees = $this->team_employee_model->query(array('team_id'=>$_REQUEST['team_id']));
			
			$emps = [];
			for($i = 0; $i < count($team_employees); $i++) {
				$e = $this->employee_model->query_one(array('employee_id'=>$team_employees[$i]['employee_id']));
				unset($e['password']);
				$team_employees[$i]['employee'] = $e;
			}
			
			$data['team_employees'] = $team_employees;
			$this->load->view('team/team_detail_page', $data);
		}
		
		public function team_list_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			$employee = $_SESSION['employee'];
			if(!isset($_REQUEST['pi'])) {
				$_REQUEST['pi'] = 1;
			}
			
			if(!isset($_REQUEST['pc'])) {
				$_REQUEST['pc'] = 12;
			}
			
			$this->load->model('user/team_model');
			$pi = $_REQUEST['pi'];
			$pc = $_REQUEST['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$end;
			$where[] = 'valid=1';
			$sql = "select * from tb_team where (".implode(" and ",$where).")".' '.$limit;
			$teams = $this->team_model->raw_query($sql);
			$data['teams'] = $teams;
			
			$my_team = $this->team_model->query_one(array('employee_id'=>$employee['employee_id']));
			$data['my_team'] = $my_team;
			
			$this->load->model('user/team_employee_model');
			$my_join_team = $this->team_employee_model->query_one(array('employee_id'=>$employee['employee_id']));
			if($my_join_team) {
				$data['my_join_team'] = $this->team_model->query_one(array('team_id'=>$my_join_team['team_id']));
			} else {
				$data['my_join_team'] = null;
			}
			$this->load->model('city/trade_area_model');
			$trade_areas = $this->trade_area_model->query();
			$data['trade_areas'] = $trade_areas;
			
			$this->load->model('user/employee_model');
			$employees = $this->employee_model->query();
			for($i = 0; $i < count($employees); $i++) {
				unset($employees[$i]['password']);
			}
			$data['employees'] = $employees;
			
			$this->load->view('team/team_list_page', $data);
		}
		
		public function sendInviteJoin() {//邀请加入团队
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$employee_id = $_REQUEST['employee_id'];
			$team_id = $_REQUEST['team_id'];
			
			$this->load->model('user/message_model');
			$this->load->model('user/employee_model');
			$e = $this->employee_model->query_one(array('employee_id'=>$team['employee_id']));
			
			if($e['team_creator'] == 1 || $e['joined_team'] != 0) {
				$ret['code'] = -1;
				echo json_encode($ret);
				return;
			}
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $employee_id;
			$msg['type'] = MSG_INVITE_JOIN_TEAM;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			
			$content['team_id'] = $team_id;
			$msg['content'] = json_encode($content);
			
			$this->message_model->insert($msg);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyJoinTeam() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$team_id = $_REQUEST['team_id'];
			
			$this->load->model('user/team_model');
			$t = $this->team_model->query_one(array('team_id'=>$team_id,'employee_id'=>$employee['employee_id']));
			if($t) {
				$ret['code'] = ERROR_MY_TEAM;
				echo json_encode($ret);
				return;
			}
			$team = $this->team_model->query_one(array('team_id'=>$team_id));
			$this->load->model('user/message_model');
			
			$this->load->model('user/employee_model');
			$te = $this->employee_model->query_one(array('employee_id'=>$team['employee_id']));
			
			$ta_id = $te['ta_id'];
			
			$this->load->model('city/trade_area_model');
			$ta = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $ta['employee_id'];//$team['employee_id'];
			$msg['type'] = MSG_APPLY_JOIN_TEAM;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			
			$content['team_id'] = $team_id;
			$msg['content'] = json_encode($content);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowJoinTeam() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			
			$team_id = $_REQUEST['content']['team_id'];
			$employee_id = $_REQUEST['from_employee_id'];
			
			$this->load->model('user/team_employee_model');
			$m['team_id'] = $team_id;
			$m['employee_id'] = $employee_id;
			$m['create_time'] = time();
			$m['update_time'] = time();
			try {
				$a = $this->team_employee_model->query_one(array('team_id'=>$team_id,'employee_id'=>$employee_id));
				if($a) {
					$this->load->model('user/message_model');
					$msg_id = $_REQUEST['msg_id'];
					$msg['valid'] = 0;
					$this->message_model->update(array('msg_id'=>$msg_id), $msg);
					$ret['code'] = ERROR_ALREADY_JOIN;
					echo json_encode($ret);
					return;
				}
				$this->team_employee_model->insert($m);
				$e['joined_team'] = $team_id;
				$this->employee_model->update(array('employee_id'=>$employee_id), $e);
			} catch(mysqli_sql_exception $e) {
			}
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function setAreaEmployee() {
			$area['employee_id'] = $_REQUEST['employee_id'];
			$where['area_id'] = $_REQUEST['area_id'];
			$this->load->model('city/area_model');
			
			$this->area_model->update($where, $area);
			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function setTaEmployee() {
			$area['employee_id'] = $_REQUEST['employee_id'];
			$where['ta_id'] = $_REQUEST['ta_id'];
			$this->load->model('city/trade_area_model');
			
			$this->trade_area_model->update($where, $area);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delTaEmployee() {
			session_start();
			/*
			if($_SESSION['employee']['type'] ) {
				
			}
			*/
			$new_ta['employee_id'] = 0;
			$where['ta_id'] = $_REQUEST['ta_id'];
			$this->load->model('city/trade_area_model');
			$ta = $this->trade_area_model->query_one($where);
			$employee_id = $ta['employee_id'];
			
			$this->load->model('user/employee_model');
			$e['type'] = ADMIN_TYPE_NONE;
			$this->employee_model->update(array('employee_id'=>$employee_id),$e); 
			
			$this->trade_area_model->update($where, $new_ta);

			$ret['code'] = 0;
			echo json_encode($ret);
		}

		public function delAreaEmployee() {
			$area['employee_id'] = 0;
			$where['area_id'] = $_REQUEST['area_id'];
			$this->load->model('city/area_model');
			
			$this->area_model->update($where, $area);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		public function approval_user_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);

			$this->load->model('user/employee_model');
			$employees = $this->employee_model->query(array('valid'=>0));
			for($i = 0; $i < count($employees); $i++) {
				unset($employees[$i]['password']);
			}
			
			$data['employees'] = $employees;
			$this->load->view('team/approval_user_page', $data);
		}
		
		public function team_manager_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('user/team_model');
			$data['teams'] = $this->team_model->query();
			
			$this->load->model('city/area_model');
			$areas = $this->area_model->query();
			$data['areas'] = $areas;
			
			$this->load->view('team/team_manager_page', $data);
		}
		
		
		public function addBEmployee() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['employee_id'] = $_REQUEST['employee_id'];
			$this->load->model('user/employee_model');
			$employee['batch_add_house'] = 1;
			$this->employee_model->update($where, $employee);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delBEmployee() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['employee_id'] = $_REQUEST['employee_id'];
			$this->load->model('user/employee_model');
			$employee['batch_add_house'] = 0;
			$this->employee_model->update($where, $employee);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function batch_typing_manager_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('user/employee_model');
			$where['batch_add_house'] = 1;
			$data['b_employees'] = $this->employee_model->query($where);
			
			$data['employees'] = $this->employee_model->query();
			
			$this->load->view('team/batch_typing_manager_page', $data);
		}
		
		public function employee_list_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			if(!isset($_REQUEST['pi'])) {
				$_REQUEST['pi'] = 1;
			}
			
			if(!isset($_REQUEST['pc'])) {
				$_REQUEST['pc'] = 12;
			}
			
			$this->load->model('user/team_model');
			$pi = $_REQUEST['pi'];
			$pc = $_REQUEST['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$end;
			$sql = 'select * from tb_employee where valid=1 '.$limit;
			
			$this->load->model('user/employee_model');
			$this->load->model('city/trade_area_model');
			$this->load->model('city/area_model');
			$this->load->model('user/team_model');
			
			$this->load->model('houseinfo/house_info_model');
			$sq = "select count(*) from tb_employee where valid=1";
			$res = $this->employee_model->raw_query($sq);
			$total_count = $res[0]['count(*)'];
			
			$employees = $this->employee_model->raw_query($sql);
			for($i = 0; $i < count($employees); $i++) {
				unset($employees[$i]['password']);
				if($employees[$i]['ta_id'] != 0) {
					$ta = $this->trade_area_model->query_one(array('ta_id'=>$employees[$i]['ta_id']));
					$employees[$i]['ta'] = $ta;
					$area_id = $ta['area_id'];
					$area = $this->area_model->query_one(array('area_id'=>$area_id));
					$employees[$i]['area'] = $area;
				}
				
				if($employees[$i]['team_id'] != 0) {
					$team = $this->team_model->query_one(array('team_id'=>$employees[$i]['team_id']));
					$employees[$i]['team'] = $team;
				}
			}
			
			$data['page_count'] = ceil(($total_count)/$pc);
			$data['total_count'] = $total_count;
			$data['pi'] = $pi;
			$data['pc'] = $pc;
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			$data['employees'] = $employees;
			$this->load->view('team/employee_list_page', $data);
		}
		
		public function approvalUser() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$employee_id = $_REQUEST['employee_id'];
			$this->load->model('user/employee_model');
			$this->employee_model->update(array('employee_id'=>$employee_id),array('valid'=>1));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addMaintainArea() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			if($employee['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$employee_id = $_REQUEST['employee_id'];
			$community_id = $_REQUEST['community_id'];
			$this->load->model('user/employee_model');
			
			$employee = $this->employee_model->query_one(array('employee_id'=>$employee_id));
			if($employee['maintain_community_id1'] == 0) {
				$employee['maintain_community_id1'] = $community_id;
			} else if($employee['maintain_community_id2'] == 0) {
				$employee['maintain_community_id2'] = $community_id;
			} else if($employee['maintain_community_id3'] == 0) {
				$employee['maintain_community_id3'] = $community_id;
			}
			
			$this->employee_model->update(array('employee_id'=>$employee_id),$employee);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
	}
?>
