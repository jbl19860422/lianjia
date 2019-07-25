<?php
	require_once('ControllerBase.php');
	class Guest extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function buy_guest_add_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			$this->load->model('user/label_model');
			$wheres = [];
			$wheres[] = array('employee_id' => $employee['employee_id']);
			$wheres[] = array('sys'=>1);
			$labels = $this->label_model->or_query($wheres);
			$data['labels'] = $labels;
			$this->load->view('guest/buy_guest_add_page', $data);
		}
		
		public function addLabel() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			
			$label['name'] = $_REQUEST['name'];
			$label['create_time'] = time();
			$label['employee_id'] = $employee['employee_id'];
			$label['sys'] = 0;
			$this->load->model('user/label_model');
			$label['id'] = $this->label_model->insert($label);
			$ret['label'] = $label;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function add_buy_require_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/guest_model');
			
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$data['guest'] = $guest;
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('guest/add_buy_require_page',$data);
		}
		
		public function add_rent_require_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/guest_model');
			
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$data['guest'] = $guest;
			$this->load->view('guest/add_rent_require_page',$data);
		}
		
		public function guest_detail_page() {//客源详情页面
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/require_model');
			
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$data['guest'] = $guest;
			$data['guest']['takesees'] = [];
			$city_id = $guest['city_id'];
			$data['city_id'] = $city_id;
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$requires = $this->require_model->query(array('guest_id'=>$guest_id));
			$data['requires'] = $requires;
			
			$this->load->model('user/guest_takesee_model');
			$this->load->model('houseinfo/house_info_model');
			$this->load->model('user/employee_model');
			$this->load->model('user/takesee_model');
			$takesees_arr = $this->takesee_model->query(array('guest_id'=>$guest_id));
			for($i = 0; $i < count($takesees_arr); $i++) {
				$takesee_houses = json_decode($takesees_arr[$i]['takesee_houses'],true);
				$takesees_arr[$i]['takesee_houses'] = [];
				$takesees_arr[$i]['takesee_employee'] = $this->employee_model->query_one(array('employee_id'=>$takesees_arr[$i]['employee_id']));
				unset($takesees_arr[$i]['takesee_employee']['password']);

				$takesees_arr[$i]['accompany_employee'] = $this->employee_model->query_one(array('employee_id'=>$takesees_arr[$i]['accompany_employee_id']));
				unset($takesees_arr[$i]['accompany_employee']['password']);
				
				
				for($j = 0; $j < count($takesee_houses); $j++) {
					$takesees_arr[$i]['takesee_houses'][] = $this->house_info_model->query_one(array('house_info_id'=>$takesee_houses[$j]['house_info_id']));
					$takesees_arr[$i]['takesee_houses'][$j]['customer_attitude'] = $takesee_houses[$j]['customer_attitude'];
					$takesees_arr[$i]['takesee_houses'][$j]['house_type'] = $takesee_houses[$j]['house_type'];
				}
				
				$data['guest']['takesees'][] = $takesees_arr[$i];//$one_see;
			}
			
			
			//输出约看信息
			$this->load->model('user/appsee_model');
			$appsees_arr = $this->appsee_model->query(array('guest_id'=>$guest_id));
			for($i = 0; $i < count($appsees_arr); $i++) {
				$appsee_houses = json_decode($appsees_arr[$i]['appsee_houses'],true);
				$appsees_arr[$i]['appsee_houses'] = [];
				$appsees_arr[$i]['appsee_employee'] = $this->employee_model->query_one(array('employee_id'=>$appsees_arr[$i]['employee_id']));
				unset($appsees_arr[$i]['appsee_employee']['password']);
				/*
				$appsees_arr[$i]['accompany_employee'] = $this->employee_model->query_one(array('employee_id'=>$appsees_arr[$i]['accompany_employee_id']));
				unset($appsees_arr[$i]['accompany_employee']['password']);
				*/
				
				for($j = 0; $j < count($appsee_houses); $j++) {
					$appsees_arr[$i]['appsee_houses'][] = $this->house_info_model->query_one(array('house_info_id'=>$appsee_houses[$j]['house_info_id']));
					$appsees_arr[$i]['appsee_houses'][$j]['house_type'] = $appsee_houses[$j]['house_type'];
					$appsees_arr[$i]['appsee_houses'][$j]['agreed'] = $appsee_houses[$j]['agreed'];
					$appsees_arr[$i]['appsee_houses'][$j]['start_time'] = $appsee_houses[$j]['start_time'];
					$appsees_arr[$i]['appsee_houses'][$j]['end_time'] = $appsee_houses[$j]['end_time'];
				}
				
				$data['guest']['appsees'][] = $appsees_arr[$i];//$one_see;
			}
			
			
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			
			$this->load->model('user/intendcommunity_model');
			$data['intend_communities'] = $this->intendcommunity_model->query(array('guest_id'=>$guest_id));
			
			$this->load->view('guest/guest_detail_page',$data);
		}
		
		public function guest_list_page() {//客源列表页
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			
			$this->load->model('user/label_model');
			$data['labels'] = $this->label_model->query(array('employee_id'=>$employee['employee_id']));
			
			$this->load->view('guest/guest_list_page',$data);
		}
		
		public function rent_guest_list_page() {//客源列表页
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			
			$this->load->model('user/label_model');
			$data['labels'] = $this->label_model->query(array('employee_id'=>$employee['employee_id']));
			
			$this->load->view('guest/rent_guest_list_page',$data);
		}
		
		/*******初始化查询数量*********/
		public function initQueryMyBuyGuest() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee_id = $_SESSION['employee_id'];
			for($i = 0; $i < 4; $i++) {
				$where = [];
				$where[] = 'employee_id='.$employee_id;
				$where[] = 'entrust_type=1';
				$where[] = 'intention='.($i);
				$this->load->model('user/guest_model');
				$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
				$res = $this->guest_model->raw_query($sql);
				$ret['intention'][$i] = $res[0]['count(*)'];
			}
			
			for($i = 0; $i < 4; $i++) {
				$where = [];
				$where[] = 'employee_id='.$employee_id;
				$where[] = 'entrust_type=1';
				$where[] = 'curr_progress='.($i);
				$this->load->model('user/guest_model');
				$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
				$res = $this->guest_model->raw_query($sql);
				$ret['curr_progress'][$i] = $res[0]['count(*)'];
			}
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryMyBuyGuest() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$guest_cond = $search_cond['guest'];
			$employee_id = $_SESSION['employee_id'];
			
			$where = [];
			$where[] = 'employee_id='.$employee_id;
			$where[] = 'entrust_type=1';
			if($guest_cond['intention'] != '') {
				$where[] = 'intention='.$guest_cond['intention'];
			}
			
			if($guest_cond['curr_progress'] != '') {
				$where[] = 'curr_progress='.$guest_cond['curr_progress'];
			}

			if($guest_cond['min_price'] != '') {
				$where[] = 'max_price>='.$guest_cond['min_price'];
			}
			
			if($guest_cond['max_price'] != '') {
				$where[] = 'min_price<='.$guest_cond['max_price'];
			}
			
			if($guest_cond['min_area'] != '') {
				$where[] = 'max_area>='.$guest_cond['min_area'];
			}
			
			if($guest_cond['max_area'] != '') {
				$where[] = 'min_area<='.$guest_cond['max_area'];
			}

			if($guest_cond['min_room'] != '') {
				$where[] = 'min_room>='.$guest_cond['min_room'];
			}
			
			if($guest_cond['max_room'] != '') {
				$where[] = 'max_room<='.$guest_cond['max_room'];
			}
			
			if($guest_cond['label'] != '') {
				$where[] = "(labels like '%".$guest_cond['label']."%')";
			}

			if($guest_cond['like_name'] != '') {
				$where[] = "(name like '%".$guest_cond['like_name']."%' or mobiles like '%".$guest_cond['like_name']."%' or guest_id like '%".$guest_cond['like_name']."%')";
			}
			
			if(!isset($_REQUEST['pi'])) {
				$_REQUEST['pi'] = 1;
			}
			
			if(!isset($_REQUEST['pc'])) {
				$_REQUEST['pc'] = 12;
			}
			
			$pi = $_REQUEST['pi'];
			$pc = $_REQUEST['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('user/guest_model');
			$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
			$res = $this->guest_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];
			$sql = "select * from tb_guest where (".implode(" and ",$where).")".' '.$limit;
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$guests = $this->guest_model->raw_query($sql);
			
			$in_guest_ids = [];
			for($i = 0; $i < count($guests); $i++) {
				if(!in_array($guests[$i]['guest_id'],$in_guest_ids)) {
					$in_guest_ids[] = $guests[$i]['guest_id'];
				}
				$guests[$i]['requires'] = [];
			}
			
			if(count($in_guest_ids) > 0) {
				$s = "select * from tb_require where type=0 and guest_id in(".implode(",",$in_guest_ids).")";
				$this->load->model('user/require_model');
				$reqs = $this->require_model->raw_query($s);
				for($j = 0; $j <  count($guests); $j++) {
					for($i = 0; $i < count($reqs); $i++) {
						if($reqs[$i]['guest_id'] == $guests[$j]['guest_id']) {
							$guests[$j]['requires'][] = $reqs[$i];
						}
					}	
				}
			}
			$ret['in_guest_ids'] = $in_guest_ids;
			$ret['code'] = 0;
			$ret['guests'] = $guests;
			echo json_encode($ret);
		}
		
		public function initQueryMyRentGuest() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee_id = $_SESSION['employee_id'];
			for($i = 0; $i < 4; $i++) {
				$where = [];
				$where[] = 'employee_id='.$employee_id;
				$where[] = 'entrust_type=2';
				$where[] = 'intention='.($i);
				$this->load->model('user/guest_model');
				$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
				$res = $this->guest_model->raw_query($sql);
				$ret['intention'][$i] = $res[0]['count(*)'];
			}
			
			for($i = 0; $i < 4; $i++) {
				$where = [];
				$where[] = 'employee_id='.$employee_id;
				$where[] = 'entrust_type=2';
				$where[] = 'curr_progress='.($i);
				$this->load->model('user/guest_model');
				$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
				$res = $this->guest_model->raw_query($sql);
				$ret['curr_progress'][$i] = $res[0]['count(*)'];
			}
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryMyRentGuest() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$guest_cond = $search_cond['guest'];
			$employee_id = $_SESSION['employee_id'];
			
			$where = [];
			$where[] = 'employee_id='.$employee_id;
			$where[] = 'entrust_type=2';
			if($guest_cond['intention'] != '') {
				$where[] = 'intention='.$guest_cond['intention'];
			}
			
			if($guest_cond['curr_progress'] != '') {
				$where[] = 'curr_progress='.$guest_cond['curr_progress'];
			}

			if($guest_cond['min_price'] != '') {
				$where[] = 'max_price>='.$guest_cond['min_price'];
			}
			
			if($guest_cond['max_price'] != '') {
				$where[] = 'min_price<='.$guest_cond['max_price'];
			}
			
			if($guest_cond['min_area'] != '') {
				$where[] = 'max_area>='.$guest_cond['min_area'];
			}
			
			if($guest_cond['max_area'] != '') {
				$where[] = 'min_area<='.$guest_cond['max_area'];
			}

			if($guest_cond['min_room'] != '') {
				$where[] = 'min_room>='.$guest_cond['min_room'];
			}
			
			if($guest_cond['max_room'] != '') {
				$where[] = 'max_room<='.$guest_cond['max_room'];
			}
			
			if($guest_cond['label'] != '') {
				$where[] = "(labels like '%".$guest_cond['label']."%')";
			}

			if($guest_cond['like_name'] != '') {
				$where[] = "(name like '%".$guest_cond['like_name']."%' or mobiles like '%".$guest_cond['like_name']."%' or guest_id like '%".$guest_cond['like_name']."%')";
			}
			
			if(!isset($_REQUEST['pi'])) {
				$_REQUEST['pi'] = 1;
			}
			
			if(!isset($_REQUEST['pc'])) {
				$_REQUEST['pc'] = 12;
			}
			
			$pi = $_REQUEST['pi'];
			$pc = $_REQUEST['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('user/guest_model');
			$sql = "select count(*) from tb_guest where (".implode(" and ",$where).")";
			$res = $this->guest_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];
			$sql = "select * from tb_guest where (".implode(" and ",$where).")".' '.$limit;
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$guests = $this->guest_model->raw_query($sql);
			
			$in_guest_ids = [];
			for($i = 0; $i < count($guests); $i++) {
				if(!in_array($guests[$i]['guest_id'],$in_guest_ids)) {
					$in_guest_ids[] = $guests[$i]['guest_id'];
				}
				$guests[$i]['requires'] = [];
			}
			
			if(count($in_guest_ids) > 0) {
				$s = "select * from tb_require where type=0 and guest_id in(".implode(",",$in_guest_ids).")";
				$this->load->model('user/require_model');
				$reqs = $this->require_model->raw_query($s);
				for($j = 0; $j <  count($guests); $j++) {
					for($i = 0; $i < count($reqs); $i++) {
						if($reqs[$i]['guest_id'] == $guests[$j]['guest_id']) {
							$guests[$j]['requires'][] = $reqs[$i];
						}
					}	
				}
			}
			$ret['in_guest_ids'] = $in_guest_ids;
			$ret['code'] = 0;
			$ret['guests'] = $guests;
			echo json_encode($ret);
		}
		
		public function delIntendCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['id'] = $_REQUEST['id'];
			$this->load->model('user/intendcommunity_model');
			$this->intendcommunity_model->remove($where);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addIntendCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$guest_id = $_REQUEST['guest_id'];
			$coms_add = $_REQUEST['coms_add'];
			$this->load->model('user/intendcommunity_model');
			$intend_communities = [];
			for($i = 0; $i < count($coms_add); $i++) {
				$c = [];
				$c['guest_id'] = $guest_id;
				$c['community_id'] = $coms_add[$i]['community_id'];
				$c['community_name'] = $coms_add[$i]['name'];
				$c['create_time'] = time();
				$c['id'] = $this->intendcommunity_model->insert($c);
				$intend_communities[] = $c;
			}
			$ret['intend_communities'] = $intend_communities;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function add_take_see_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			
			$data['guest'] = $guest;
			
			$this->load->model('user/employee_model');
			$employees = $this->employee_model->query();
			$data['employees'] = $employees;
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('guest/add_take_see_page', $data);
		}
		
		public function add_app_see_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			
			$data['guest'] = $guest;
			
			$this->load->model('user/employee_model');
			$employees = $this->employee_model->query();
			$data['employees'] = $employees;
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('guest/add_app_see_page', $data);
		}
		
		public function edit_guest_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$guest_id = $_REQUEST['guest_id'];
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			
			$data['guest'] = $guest;
			$this->load->view('guest/edit_guest_page', $data);
		}
		
		public function hire_guest_add_page() {
			
		}
		
		public function addTakeSee() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('user/takesee_model');
			$takesee_houses = $_REQUEST['takesee_houses'];
			if(count($takesee_houses) <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			
			$takesee = $_REQUEST;
			$takesee['takesee_houses'] = [];
			for($i = 0; $i < count($_REQUEST['takesee_houses']); $i++) {
				$house = [];
				$house['house_info_id'] = $_REQUEST['takesee_houses'][$i]['house_info_id'];
				$house['house_type'] = $_REQUEST['takesee_houses'][$i]['house_type'];
				$house['customer_attitude'] = $_REQUEST['takesee_houses'][$i]['customer_attitude'];
				$takesee['takesee_houses'][] = $house;
			}
			$takesee['takesee_houses'] = json_encode($takesee['takesee_houses']);
			$takesee['employee_id'] = $_SESSION['employee']['employee_id'];
			$takesee['create_time'] = time();
			$takesee['see_id'] = $this->takesee_model->insert($takesee);
			$houses = $_REQUEST['takesee_houses'];
			$house_info_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$house_info_ids[] = $houses[$i]['house_info_id'];
			}

			$this->load->model('houseinfo/house_info_model');
			for($i = 0; $i < count($house_info_ids); $i++) {
				$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_ids[$i]));
				if($house_info) {
					if($house_info['takesee_ids']) {
						$takesee_ids = explode("|",$house_info['takesee_ids']);
					} else {
						$takesee_ids = [];
					}
					array_push($takesee_ids,$takesee['see_id']);
					$house_info['takesee_ids'] = implode("|",$takesee_ids);
					$this->house_info_model->update(array('house_info_id'=>$house_info_ids[$i]),$house_info);
				}
			}
			
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$_REQUEST['guest_id']));
			$guest['takesee_count'] = $guest['takesee_count']+1;
			$guest['takesee_time'] = $takesee['start_time'];
			$guest['maintain_time'] = time();
			
			$guest['curr_progress'] = 1;//已带看
			$this->guest_model->update(array('guest_id'=>$_REQUEST['guest_id']),$guest);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		
		public function addAppSee() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('user/appsee_model');
			$appsee_houses = $_REQUEST['appsee_houses'];
			if(count($appsee_houses) <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			
			$appsee = $_REQUEST;
			$appsee['appsee_houses'] = [];
			for($i = 0; $i < count($_REQUEST['appsee_houses']); $i++) {
				$house = [];
				$house['house_info_id'] = $_REQUEST['appsee_houses'][$i]['house_info_id'];
				$house['house_type'] = $_REQUEST['appsee_houses'][$i]['house_type'];
				$house['agreed'] = 0;
				$appsee['appsee_houses'][] = $house;
			}
			$appsee['appsee_houses'] = json_encode($appsee['appsee_houses']);
			$appsee['employee_id'] = $_SESSION['employee']['employee_id'];
			$appsee['create_time'] = time();
			$appsee['employee_name'] = $employee['name'];
			$appsee['see_id'] = $this->appsee_model->insert($appsee);//插入约看信息
			
			//对每个预约房源，发送约看请求消息
			$houses = $_REQUEST['appsee_houses'];
			$this->load->model('houseinfo/house_info_model');
			$this->load->model('user/message_model');
			for($i = 0; $i < count($houses); $i++) {
				$house_info = $this->house_info_model->query_one(array('house_info_id'=>$houses[$i]['house_info_id']));
				if($house_info['maintain_employee_id'] != 0) {
					$msg = [];
					$msg['create_time'] = time();
					$msg['from_employee_id'] = $employee['employee_id'];
					$msg['from_employee_name'] = $employee['name'];
					$msg['from_employee_headimg'] = $employee['headimg'];
					$msg['from_employee_workno'] = $employee['workno'];
					$msg['to_employee_id'] = $house_info['maintain_employee_id'];
					$msg['type'] = MSG_PLAYSEE_HOUSE;
					$msg['valid'] = 1;
					$content = [];
					$content['appsee'] = $appsee;
					$houses[$i]['start_time'] = $appsee['start_time'];
					$houses[$i]['end_time'] = $appsee['end_time'];
					$content['house_info'] = $houses[$i];
					$msg['content'] = json_encode($content);
					$msg['brocast'] = 0;
					$msg['bro_type'] = 0;
					$msg['status'] = 0;
					$this->message_model->insert($msg);
				}
			}
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function agreeSee() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$start_time = $_REQUEST['start_time'];
			$end_time = $_REQUEST['end_time'];
			$see_id = $_REQUEST['see_id'];
			$house_info_id = $_REQUEST['house_info_id'];
			
			$this->load->model('user/appsee_model');
			
			$appsee = $this->appsee_model->query_one(array('see_id'=>$see_id));
			
			$appsee['appsee_houses'] = json_decode($appsee['appsee_houses'], true);
			for($i = 0; $i < count($appsee['appsee_houses']); $i++) {
				if($appsee['appsee_houses'][$i]['house_info_id'] == $house_info_id) {
					$appsee['appsee_houses'][$i]['start_time'] = $start_time;
					$appsee['appsee_houses'][$i]['end_time'] = $end_time;
					$appsee['appsee_houses'][$i]['agreed'] = 1;
					break;
				}
			}
			
			$appsee['appsee_houses'] = json_encode($appsee['appsee_houses']);
			$this->appsee_model->update(array('see_id'=>$see_id), $appsee);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addGuest() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('user/guest_model');
			for($i = 0; $i < count($_REQUEST['mobiles']); $i++) {
				$sql = 'select * from tb_guest where mobiles like "%'.$_REQUEST['mobiles'][$i].'%"';
				$res = $this->guest_model->raw_query($sql);
				
				if(count($res) > 0) {
					$ret['code'] = ERROR_GUEST_EXISTS;
					$ret['guest'] = $res[0];
					echo json_encode($ret);
					return;
				}
			}
			
			
			$employee_id = $_SESSION['employee_id'];
			$guest['employee_id'] = $employee_id;
			$guest['city_id'] = $_REQUEST['city_id'];
			$guest['name'] = $_REQUEST['name'];
			$guest['mobiles'] = implode("|",$_REQUEST['mobiles']);
			$guest['type'] = $_REQUEST['type'];
			$guest['sex'] = $_REQUEST['sex'];
			$guest['entrust_type'] = $_REQUEST['entrust_type'];
			$guest['entrust_src1'] = $_REQUEST['entrust_src1'];
			$guest['entrust_src2'] = $_REQUEST['entrust_src2'];
			$guest['labels'] = implode("|",$_REQUEST['labels']);
			$guest['contacts'] = json_encode($_REQUEST['contacts']);
			
			$guest['has_loan'] = $_REQUEST['has_loan'];
			$guest['has_house'] = $_REQUEST['has_house'];
			$guest['has_sold'] = $_REQUEST['has_sold'];
			$guest['loan_type'] = $_REQUEST['loan_type'];
			
			$guest['intention'] = $_REQUEST['intention'];
			$guest['create_time'] = time();
			
			$this->load->model('user/guest_model');
			$guest['guest_id'] = $this->guest_model->insert($guest);
			$ret['code'] = 0;
			$ret['guest'] = $guest;
			echo json_encode($ret);
		}
		
		public function editGuest() {
			$where['guest_id'] = $_REQUEST['guest_id'];
			
			$guest = $_REQUEST;
			foreach($guest as $key => $value) {
				if(gettype($guest[$key]) == "object" || gettype($guest[$key]) == "array") {
					$guest[$key] = json_encode($value);
				}
			}
			$guest['mobiles'] = implode("|",$_REQUEST['mobiles']);
			$guest['labels'] = implode("|",$_REQUEST['labels']);
			$guest['maintain_time'] = time();
			$this->load->model('user/guest_model');
			$guest['guest_id'] = $this->guest_model->update($where, $guest);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addBuyRequire() {
			$guest_id = $_REQUEST['guest_id'];
			
			$this->load->model('user/require_model');
			
			$require['guest_id'] = $guest_id;
			$require['type'] = 0;
			$require['buy_intention'] = $_REQUEST['buy_intention'];
			$require['buy_usage'] = $_REQUEST['buy_usage'];
			$require['buy_price_min'] = $_REQUEST['buy_price_min'];
			$require['buy_price_max'] = $_REQUEST['buy_price_max'];
			$require['buy_firstpay_min'] = $_REQUEST['buy_firstpay_min'];
			$require['buy_firstpay_max'] = $_REQUEST['buy_firstpay_max'];
			$require['buy_monthpay_min'] = $_REQUEST['buy_firstpay_min'];
			$require['buy_monthpay_max'] = $_REQUEST['buy_firstpay_max'];
			$require['buy_area_min'] = $_REQUEST['buy_area_min'];
			$require['buy_area_max'] = $_REQUEST['buy_area_max'];
			$require['buy_room_min'] = $_REQUEST['buy_room_min'];
			$require['buy_room_max'] = $_REQUEST['buy_room_max'];
			$require['buy_pay_method'] = $_REQUEST['buy_pay_method'];
			$require['buy_area_id'] = $_REQUEST['buy_area_id'];
			$require['buy_trade_areas'] = json_encode($_REQUEST['buy_trade_areas']);
			
			$require['buy_decoration'] = implode("|",$_REQUEST['buy_decoration']);
			$require['buy_orientation'] = implode("|",$_REQUEST['buy_orientation']);
			$require['buy_floor'] = implode("|",$_REQUEST['buy_floor']);
			$require['buy_age'] = implode("|",$_REQUEST['buy_age']);
			$require['update_time'] = time();
			$require['remark'] = $_REQUEST['remark'];
			$require['create_time'] = time();
			$require['require_id'] = $this->require_model->insert($require);
			
			$requires = $this->require_model->query(array('guest_id'=>$guest_id,'type'=>0));
			$min_price = $require['buy_price_min'];
			$max_price = $require['buy_price_max'];
			$min_area = $require['buy_area_min'];
			$max_area = $require['buy_area_max'];
			$min_room = $require['buy_room_min'];
			$max_room = $require['buy_room_max'];
			for($i = 0; $i < count($requires); $i++) {
				if($requires[$i]['buy_price_min'] < $min_price) {
					$min_price = $requires[$i]['buy_price_min'];
				}
				
				if($requires[$i]['buy_price_max'] > $max_price) {
					$max_price = $requires[$i]['buy_price_max'];
				}
				
				if($requires[$i]['buy_area_min'] < $min_area) {
					$min_area = $requires[$i]['buy_area_min'];
				}
				
				if($requires[$i]['buy_area_max'] > $max_area) {
					$max_area = $requires[$i]['buy_area_max'];
				}
				
				if($requires[$i]['buy_room_min'] < $min_room) {
					$min_room = $requires[$i]['buy_min_room'];
				}
				
				if($requires[$i]['buy_room_max'] > $max_room) {
					$max_room = $requires[$i]['buy_room_max'];
				}
			}
			
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$guest['min_price'] = $min_price;
			$guest['max_price'] = $max_price;
			$guest['min_area'] = $min_area;
			$guest['max_area'] = $max_area;
			$guest['min_room'] = $min_room;
			$guest['max_room'] = $max_room;
			$guest['maintain_time'] = time();
			
			$this->guest_model->update(array('guest_id'=>$guest_id), $guest);
			
			$ret['code'] = 0;
			$ret['guest'] = $guest;
			$ret['require'] = $require;
			echo json_encode($ret);
		}
		
		public function updateBuyRequire() {
			$require_id = $_REQUEST['require_id'];
			$this->load->model('user/require_model');
			
			$require['buy_intention'] = $_REQUEST['buy_intention'];
			$require['buy_usage'] = $_REQUEST['buy_usage'];
			$require['buy_price_min'] = $_REQUEST['buy_price_min'];
			$require['buy_price_max'] = $_REQUEST['buy_price_max'];
			$require['buy_firstpay_min'] = $_REQUEST['buy_firstpay_min'];
			$require['buy_firstpay_max'] = $_REQUEST['buy_firstpay_max'];
			$require['buy_monthpay_min'] = $_REQUEST['buy_firstpay_min'];
			$require['buy_monthpay_max'] = $_REQUEST['buy_firstpay_max'];
			$require['buy_area_min'] = $_REQUEST['buy_area_min'];
			$require['buy_area_max'] = $_REQUEST['buy_area_max'];
			$require['buy_room_min'] = $_REQUEST['buy_room_min'];
			$require['buy_room_max'] = $_REQUEST['buy_room_max'];
			$require['buy_pay_method'] = $_REQUEST['buy_pay_method'];
			$require['buy_area_id'] = $_REQUEST['buy_area_id'];
			$require['buy_trade_areas'] = json_encode($_REQUEST['buy_trade_areas']);
			
			$require['buy_decoration'] = implode("|",$_REQUEST['buy_decoration']);
			$require['buy_orientation'] = implode("|",$_REQUEST['buy_orientation']);
			$require['buy_floor'] = implode("|",$_REQUEST['buy_floor']);
			$require['buy_age'] = implode("|",$_REQUEST['buy_age']);
			$require['update_time'] = time();
			$require['remark'] = $_REQUEST['remark'];
			
			$this->require_model->update(array('require_id'=>$require_id),$require);
			
			
			$requires = $this->require_model->query(array('guest_id'=>$guest_id,'type'=>0));
			$min_price = $require['buy_price_min'];
			$max_price = $require['buy_price_max'];
			$min_area = $require['buy_area_min'];
			$max_area = $require['buy_area_max'];
			$min_room = $require['buy_room_min'];
			$max_room = $require['buy_room_max'];
			for($i = 0; $i < count($requires); $i++) {
				if($requires[$i]['buy_price_min'] < $min_price) {
					$min_price = $requires[$i]['buy_price_min'];
				}
				
				if($requires[$i]['buy_price_max'] > $max_price) {
					$max_price = $requires[$i]['buy_price_max'];
				}
				
				if($requires[$i]['buy_area_min'] < $min_area) {
					$min_area = $requires[$i]['buy_area_min'];
				}
				
				if($requires[$i]['buy_area_max'] > $max_area) {
					$max_area = $requires[$i]['buy_area_max'];
				}
				
				if($requires[$i]['buy_room_min'] < $min_room) {
					$min_room = $requires[$i]['buy_min_room'];
				}
				
				if($requires[$i]['buy_room_max'] > $max_room) {
					$max_room = $requires[$i]['buy_room_max'];
				}
			}
			
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$guest['min_price'] = $min_price;
			$guest['max_price'] = $max_price;
			$guest['min_area'] = $min_area;
			$guest['max_area'] = $max_area;
			$guest['min_room'] = $min_room;
			$guest['max_room'] = $max_room;
			$guest['maintain_time'] = time();
			
			$this->guest_model->update(array('guest_id'=>$guest_id), $guest);
			
			$ret['require'] = $require;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delBuyRequire() {
			$require_id = $_REQUEST['require_id'];
			$this->load->model('user/require_model');
			
			$this->require_model->remove(array('require_id'=>$require_id));
			
			$requires = $this->require_model->query(array('guest_id'=>$guest_id,'type'=>0));
			$min_price = $require['buy_price_min'];
			$max_price = $require['buy_price_max'];
			$min_area = $require['buy_area_min'];
			$max_area = $require['buy_area_max'];
			$min_room = $require['buy_room_min'];
			$max_room = $require['buy_room_max'];
			for($i = 0; $i < count($requires); $i++) {
				if($requires[$i]['buy_price_min'] < $min_price) {
					$min_price = $requires[$i]['buy_price_min'];
				}
				
				if($requires[$i]['buy_price_max'] > $max_price) {
					$max_price = $requires[$i]['buy_price_max'];
				}
				
				if($requires[$i]['buy_area_min'] < $min_area) {
					$min_area = $requires[$i]['buy_area_min'];
				}
				
				if($requires[$i]['buy_area_max'] > $max_area) {
					$max_area = $requires[$i]['buy_area_max'];
				}
				
				if($requires[$i]['buy_room_min'] < $min_room) {
					$min_room = $requires[$i]['buy_min_room'];
				}
				
				if($requires[$i]['buy_room_max'] > $max_room) {
					$max_room = $requires[$i]['buy_room_max'];
				}
			}
			
			$this->load->model('user/guest_model');
			$guest = $this->guest_model->query_one(array('guest_id'=>$guest_id));
			$guest['min_price'] = $min_price;
			$guest['max_price'] = $max_price;
			$guest['min_area'] = $min_area;
			$guest['max_area'] = $max_area;
			$guest['min_room'] = $min_room;
			$guest['max_room'] = $max_room;
			$guest['maintain_time'] = time();
			
			$this->guest_model->update(array('guest_id'=>$guest_id), $guest);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addRentRequire() {
			$guest_id = $_REQUEST['guest_id'];
			
			$require['type'] = 1;
			$require['guest_id'] = $guest_id;
			$require['rent_price_min'] = $_REQUEST['rent_price_min'];
			$require['rent_price_max'] = $_REQUEST['rent_price_max'];
			$require['rent_area_min'] = $_REQUEST['rent_area_min'];
			$require['rent_area_max'] = $_REQUEST['rent_area_max'];
			$require['rent_room_count'] = $_REQUEST['rent_room_count'];
			$require['rent_hall_count'] = $_REQUEST['rent_hall_count'];
			$require['rent_pay_method'] = $_REQUEST['rent_pay_method'];
			$require['rent_area_id'] = $_REQUEST['rent_area_id'];
			$require['rent_trade_area_ids'] = implode("|",$_REQUEST['rent_trade_area_ids']);
			
			$require['rent_decoration'] = implode("|",$_REQUEST['rent_decoration']);
			$require['rent_orientation'] = implode("|",$_REQUEST['rent_orientation']);
			$require['rent_floor'] = implode("|",$_REQUEST['rent_floor']);
			$require['rent_age'] = implode("|",$_REQUEST['rent_age']);
			$require['rent_duration'] = $_REQUEST['rent_duration'];
			$require['update_time'] = time();
			$require['remark'] = $_REQUEST['remark'];
			
			$this->load->model('user/require_model');
			$this->require_model->insert($require);
			$ret['code'] = 0;
			$ret['require'] = $require;
			echo json_encode($ret);
		}
		
		
	}
?>
