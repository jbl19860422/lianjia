<?php
	require_once('ControllerBase.php');
	class Cityinfo extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function city_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model("city/province_model");
			$data['provinces'] = $this->province_model->query(null);
			
			$this->load->model('city/city_model');
			$data['cities'] = $this->city_model->query();
			
			$this->load->view('cityinfo/city_page.php', $data);
		}

		public function area_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			if($_SESSION['employee']['type'] == ADMIN_TYPE_C) {
				header("location: trade_area_page");
				return;
			}
			
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			
			$this->load->view('cityinfo/area_page.php', $data);
		}
		
		public function school_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/school_model');
			$data['schools'] = $this->school_model->query();
			
			$this->load->view('cityinfo/school_page.php', $data);
		}
		
		public function edit_school_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$where = [];
			$where['sc_id'] = $_REQUEST['sc_id'];
			$this->load->model('city/school_model');
			$data['school'] = $this->school_model->query_one($where);
			
			$this->load->view('cityinfo/edit_school_page.php', $data);
		}
		
		public function subway_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model("city/subway_model");
			$data['subways'] = $this->subway_model->query(null);
			
			$this->load->model('city/subway_station_model');
			$data['subway_stations'] = $this->subway_station_model->query();

			$this->load->view('cityinfo/subway_page.php', $data);
		}
		
		public function trade_area_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('cityinfo/trade_area_page.php', $data);
		}
		
		public function community_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model("house/community_model");
			$data['communities'] = $this->community_model->query(array());
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('cityinfo/community_page.php', $data);
		}
		
		public function add_community_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model("house/community_model");
			$data['communities'] = $this->community_model->query(array());

			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->model("city/subway_model");
			$data['subways'] = $this->subway_model->query(null);
			
			$this->load->model('city/subway_station_model');
			$data['subway_stations'] = $this->subway_station_model->query();
			
			$this->load->model('city/school_model');
			$data['schools'] = $this->school_model->query();
			
			$this->load->view('cityinfo/add_community_page.php', $data);
		}
		
		public function edit_community_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model("house/community_model");
			$where['community_id'] = $_REQUEST['community_id'];
			$data['community'] = $this->community_model->query_one($where);

			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->model("city/subway_model");
			$data['subways'] = $this->subway_model->query(null);
			
			$this->load->model('city/subway_station_model');
			$data['subway_stations'] = $this->subway_station_model->query();
			
			$this->load->model('city/school_model');
			$data['schools'] = $this->school_model->query();
			
			$this->load->model('house/community_station_model');
			$data['stations'] = $this->community_station_model->query($where);
			
			$this->load->model('house/community_school_model');
			$cses = $this->community_school_model->query($where);
			
			$this->load->model('city/school_model');
			$data['community']['school_adds'] = [];
			for($i = 0; $i < count($cses); $i++) {
				$s = $this->school_model->query_one($cses[$i]['ss_id']);
				$data['community']['school_adds'][] = $s;
			}
			
			$this->load->view('cityinfo/edit_community_page.php', $data);
		}

		public function delCommunity() {
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
			
			$community_id = $_REQUEST['community_id'];
			$this->load->model('house/community_model');
			
			$this->community_model->remove(array('community_id'=>$community_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function lockCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$community_id = $_REQUEST['community_id'];
			$this->load->model('house/community_model');
			
			$this->community_model->update(array('community_id'=>$community_id), array('locked'=>1));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function unlockCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$community_id = $_REQUEST['community_id'];
			$this->load->model('house/community_model');
			
			$this->community_model->update(array('community_id'=>$community_id), array('locked'=>0));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addArea() {
			$this->load->model('city/area_model');
			
			$area_names = $_REQUEST['names'];
			$names = explode("|", $area_names);
			$areas = [];
			for($i = 0; $i < count($names); $i++) {
				$area = [];
				$area['name'] = $names[$i];
				$area['update_time'] = time();
				$area['area_id'] = $this->area_model->insert($area);
				$areas[] = $area;
			}
			
			$ret['code'] = 0;
			$ret['areas'] = $areas;
			echo json_encode($ret);
		}
		
		public function delArea() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/area_model');
			$area_id = $_REQUEST['area_id'];
			
			$this->load->model('house/community_model');
			$sql = 'select count(*) from tb_community where area_id='.$area_id;
			$res = $this->community_model->raw_query($sql);
			$community_count = $res[0]['count(*)'];
			if($community_count > 0) {
				$ret['code'] = ERROR_DELAREA_COMMUNITY_EXISTS;
				echo json_encode($ret);
				return;
			}
			
			$this->area_model->remove(array('area_id'=>$area_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addSchool() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/school_model');
			$school['name'] = $_REQUEST['name'];
			$school['img'] = $_REQUEST['img'];
			$school['type'] = $_REQUEST['type'];
			$school['nature'] = $_REQUEST['nature'];
			$school['num_limit'] = $_REQUEST['num_limit'];
			$school['upgrade_method'] = $_REQUEST['upgrade_method'];
			$school['area_id'] = $_REQUEST['area_id'];
			$school['lat'] = $_REQUEST['lat'];
			$school['lng'] = $_REQUEST['lng'];
			$school['area_id'] = $_REQUEST['area_id'];
			$school['position'] = $_REQUEST['position'];
			
			$school['sc_id'] = $this->school_model->insert($school);
			$ret['code'] = 0;
			$ret['school'] = $school;
			echo json_encode($ret);
		}
		
		public function editSchool() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/school_model');
			$school['name'] = $_REQUEST['name'];
			$school['img'] = $_REQUEST['img'];
			$school['type'] = $_REQUEST['type'];
			$school['nature'] = $_REQUEST['nature'];
			$school['num_limit'] = $_REQUEST['num_limit'];
			$school['upgrade_method'] = $_REQUEST['upgrade_method'];
			$school['area_id'] = $_REQUEST['area_id'];
			$school['lat'] = $_REQUEST['lat'];
			$school['lng'] = $_REQUEST['lng'];
			$school['area_id'] = $_REQUEST['area_id'];
			$school['position'] = $_REQUEST['position'];
			$where['sc_id'] = $_REQUEST['sc_id'];
			$this->school_model->update($where, $school);
			$ret['code'] = 0;
			$ret['school'] = $school;
			echo json_encode($ret);
		}
		
		public function delSchool() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/school_model');
			
			$sc_id = $_REQUEST['sc_id'];
			$this->school_model->remove(array('sc_id'=>$sc_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addSubway() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/subway_model');
			
			$names = $_REQUEST['names'];
			$names = explode("|", $names);
			$subways = [];
			for($i = 0; $i < count($names); $i++) {
				$subway = [];
				$subway['name'] = $names[$i];
				$subway['update_time'] = time();
				$subway['subway_id'] = $this->subway_model->insert($subway);
				$subways[] = $subway;
			}
			
			$ret['code'] = 0;
			$ret['subways'] = $subways;
			echo json_encode($ret);
		}
		
		public function delSubway() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/subway_model');
			
			$subway_id = $_REQUEST[subway_id];
			$this->subway_model->remove(array(subway_id=>$subway_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addSubwayStation() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/subway_station_model');
			$subway_station['subway_id'] = $_REQUEST['subway_id'];
			$subway_station['name'] = $_REQUEST['name'];
			
			$subway_station['lat'] = $_REQUEST['lat'];
			$subway_station['lng'] = $_REQUEST['lng'];
			
			$subway_station['sc_id'] = $this->subway_station_model->insert($subway_station);
			$ret['code'] = 0;
			$ret['subway_station'] = $subway_station;
			echo json_encode($ret);
		}
		
		public function delSubwayStation() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/subway_station_model');
			$subway_station['ss_id'] = $_REQUEST['ss_id'];
			$this->subway_station_model->remove($subway_station);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addTradeArea() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['type'] = $_SESSION['employee']['type'];
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/trade_area_model');
			
			$name = $_REQUEST['name'];
			$area_id = $_REQUEST['area_id'];
			$names = explode("|", $names);
			$trade_area['name'] = $name;
			$trade_area['remark'] = $_REQUEST['remark'];
			$trade_area['update_time'] = time();
			$trade_area['area_id'] = $area_id;
			
			$trade_area['ta_id'] = $this->trade_area_model->insert($trade_area);
			
			$ret['code'] = 0;
			$ret['trade_area'] = $trade_area;
			echo json_encode($ret);
		}
		
		public function delTradeArea() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('city/trade_area_model');
			$trade_area['ta_id'] = $_REQUEST['ta_id'];
			$this->trade_area_model->remove($trade_area);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('house/community_model');
			$community_info = $_REQUEST['community'];
			$where['name'] = $community_info['name'];
			$where['area_id'] = $community_info['area_id'];
			$where['ta_id'] = $community_info['ta_id'];
			$sql = 'select count(*) from tb_community where area_id='.$where['area_id'].' and ta_id='.$where['ta_id'].' and name="'.$where['name'].'"';
			$res = $this->community_model->raw_query($sql);
			$community_count = $res[0]['count(*)'];
			if($community_count > 0) {
				$ret['code'] = ERROR_COMMUNITY_EXISTS;
				echo json_encode($ret);
				return;
			}
			
			
			$community['area_id'] = $community_info['area_id'];
			$community['ta_id'] = $community_info['ta_id'];
			$community['name'] = $community_info['name'];
			$community['lat'] = $community_info['lat'];
			$community['lng'] = $community_info['lng'];
			$community['update_time'] = time();
			$community['retriving_info'] = implode("",$community_info['retriving_info']);
			$community['pm_fee'] = $community_info['pm_fee'];
			$community['transaction_ownership'] = $community_info['transaction_ownership'];
			$community['property_year'] = $community_info['property_year'];
			$community['usage'] = $community_info['usage'];
			$community['building_type'] = $community_info['building_type'];
			$community['build_time'] = $community_info['build_time'];
			$community['bad_thing'] = $community_info['bad_thing'];
			$community['lift_user_rate'] = $community_info['lift_user_rate'];
			$community['heat_type'] = $community_info['heat_type'];
			$community['heat_fee'] = $community_info['heat_fee'];
			$community['electro_type'] = $community_info['electro_type'];
			$community['car_rate'] = $community_info['car_rate'];
			$community['car_manager_fee'] = $community_info['car_manager_fee'];
			$community['water_use_type'] = $community_info['water_use_type'];
			$community['ground_car_park_count'] = $community_info['ground_car_park_count'];
			$community['has_lift'] = $community_info['has_lift'];
			$community['has_gas'] = $community_info['has_gas'];
			$community['gas_fee'] = $community_info['gas_fee'];
			$community['underground_car_park_count'] = $community_info['underground_car_park_count'];
			$community['hot_water_fee'] = $community_info['hot_water_fee'];
			$community['school_info'] = $community_info['school_info'];
			$community['has_warm_water'] = $community_info['has_warm_water'];
			$community['has_hot_water'] = $community_info['has_hot_water'];
			$community['warm_water_fee'] = $community_info['warm_water_fee'];
			$community['developer'] = $community_info['developer'];
			$community['prop_company'] = $community_info['prop_company'];
			$community['plot_ratio'] = $community_info['plot_ratio'];
			$community['green_rate'] = $community_info['green_rate'];
			
			$schools = $community_info['school_adds'];
			if(count($schools) > 0) {
				$community['has_school'] = 1;
			} else {
				$community['has_school'] = 0;
			}
			
			$community['community_id'] = $this->community_model->insert($community);
			$ret['code'] = 0;
			$ret['community'] = $community;
			
			$this->load->model('house/community_station_model');
			$stations = $_REQUEST['stations'];
			$this->load->model('city/subway_model');
			for($i = 0; $i < count($stations); $i++) {
				$s['community_id'] = $community['community_id'];
				$s['community_name'] = $community['name'];
				$s['ss_id'] = $stations[$i]['ss_id'];
				$s['station_name'] = $stations[$i]['name'];
				$s['subway_id'] = $stations[$i]['subway_id'];
				$subway = $this->subway_model->query_one(array('subway_id'=>$s['subway_id']));
				$s['subway_name'] = $subway['name'];
				$s['distance'] = $stations[$i]['distance'];
				$s['create_time'] = time();
				$this->community_station_model->insert($s);
			}
			
			$this->load->model('house/community_school_model');
			
			for($i = 0; $i < count($schools); $i++) {
				$s = [];
				$s['community_id'] = $community['community_id'];
				$s['community_name'] = $community['name'];
				$s['sc_id'] = $schools[$i]['sc_id'];
				$s['school_name'] = $schools[$i]['name'];
				$s['create_time'] = time();
				$this->community_school_model->insert($s);
			}

			echo json_encode($ret);
		}
		
		public function editCommunity() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			if($_SESSION['employee']['type'] != ADMIN_TYPE_A) {
				$ret['code'] = ERROR_UNKNOWN;
				echo json_encode($ret);
				return;
			}
			
			$where['community_id'] = $_REQUEST['community']['community_id'];
			$community_info = $_REQUEST['community'];
			$community['area_id'] = $community_info['area_id'];
			$community['ta_id'] = $community_info['ta_id'];
			$community['name'] = $community_info['name'];
			$community['lat'] = $community_info['lat'];
			$community['lng'] = $community_info['lng'];
			$community['update_time'] = time();
			$community['retriving_info'] = implode("",$community_info['retriving_info']);
			$community['pm_fee'] = $community_info['pm_fee'];
			$community['transaction_ownership'] = $community_info['transaction_ownership'];
			$community['property_year'] = $community_info['property_year'];
			$community['usage'] = $community_info['usage'];
			$community['building_type'] = $community_info['building_type'];
			$community['build_time'] = $community_info['build_time'];
			$community['bad_thing'] = $community_info['bad_thing'];
			$community['lift_user_rate'] = $community_info['lift_user_rate'];
			$community['heat_type'] = $community_info['heat_type'];
			$community['heat_fee'] = $community_info['heat_fee'];
			$community['electro_type'] = $community_info['electro_type'];
			$community['car_rate'] = $community_info['car_rate'];
			$community['car_manager_fee'] = $community_info['car_manager_fee'];
			$community['water_use_type'] = $community_info['water_use_type'];
			$community['ground_car_park_count'] = $community_info['ground_car_park_count'];
			$community['has_lift'] = $community_info['has_lift'];
			$community['has_gas'] = $community_info['has_gas'];
			$community['gas_fee'] = $community_info['gas_fee'];
			$community['underground_car_park_count'] = $community_info['underground_car_park_count'];
			$community['hot_water_fee'] = $community_info['hot_water_fee'];
			$community['school_info'] = $community_info['school_info'];
			$community['has_warm_water'] = $community_info['has_warm_water'];
			$community['has_hot_water'] = $community_info['has_hot_water'];
			$community['warm_water_fee'] = $community_info['warm_water_fee'];
			$community['developer'] = $community_info['developer'];
			$community['prop_company'] = $community_info['prop_company'];
			$community['plot_ratio'] = $community_info['plot_ratio'];
			$community['green_rate'] = $community_info['green_rate'];
			
			$schools = $community_info['school_adds'];
			if(count($schools) > 0) {
				$community['has_school'] = 1;
			} else {
				$community['has_school'] = 0;
			}
			
			$this->load->model('house/community_model');
			$this->community_model->update($where, $community);
				
			$this->load->model('house/community_station_model');
			$stations = $_REQUEST['stations'];
			$this->load->model('city/subway_model');
			$this->community_station_model->remove(array('community_id'=>$where['community_id']));
			for($i = 0; $i < count($stations); $i++) {
				$s['community_id'] = $where['community_id'];
				$s['community_name'] = $community['name'];
				$s['ss_id'] = $stations[$i]['ss_id'];
				$s['station_name'] = $stations[$i]['station_name'];
				$s['subway_id'] = $stations[$i]['subway_id'];
				$subway = $this->subway_model->query_one(array('subway_id'=>$s['subway_id']));
				
				$s['subway_name'] = $subway['name'];
				$s['distance'] = $stations[$i]['distance'];
				$s['create_time'] = time();
				$this->community_station_model->insert($s);
			}
			
			$this->load->model('house/community_school_model');
			$this->community_school_model->remove(array('community_id'=>$where['community_id']));
			for($i = 0; $i < count($schools); $i++) {
				$s = [];
				$s['community_id'] = $where['community_id'];
				$s['community_name'] = $community['name'];
				$s['sc_id'] = $schools[$i]['sc_id'];
				$s['school_name'] = $schools[$i]['name'];
				$s['create_time'] = time();
				$this->community_school_model->insert($s);
			}
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
	
		public function queryCommunities() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$ret['code'] = 0;
			$this->load->model('house/community_model');
			$ret['communities'] = $this->community_model->query();
			echo json_encode($ret);
		}
	
	}
?>
