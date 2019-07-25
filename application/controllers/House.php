<?php
	require_once('ControllerBase.php');
	class House extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function house_add_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			$data['employee'] = $_SESSION['employee'];
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query(array());

			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->view('house/house_add_page.php', $data);
		}
		
		
		public function delFloor() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$floor = $_REQUEST['floor'];
			$bb_id = $_REQUEST['bb_id'];
			
			$this->load->model('house/house_model');
			//删除所有属于该栋的该楼层的房子
			$where['floor'] = $floor;
			$where['bb_id'] = $bb_id;
			$this->house_model->remove($where);
			//修改楼栋的最大最小层
			$this->load->model('house/building_block_model');
			$bb = $this->building_block_model->query_one(array('bb_id'=>$bb_id));
			
			if($floor == $bb['max_floor']) {
				$bb['max_floor']--;
			}
			
			if($floor == $bb['min_floor']) {
				$bb['min_floor']++;
			}
			
			$this->building_block_model->update(array('bb_id'=>$bb_id), $bb);
			$ret['code'] = 0;
			$ret['bb'] = $bb;
			echo json_encode($ret);
		}
		
		
		public function house_list_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			if(!isset($_REQUEST['area_id'])) {
				$_REQUEST['area_id'] = 0;
			}
			$area_id = $_REQUEST['area_id'];
			
			if($area_id != 0) {
				$where = 'where area_id='.$area_id;
			} else {
				$where = '';
			}
			
			if(!isset($_REQUEST['pi'])) {
				$_REQUEST['pi'] = 1;
			}
			
			if(!isset($_REQUEST['pc'])) {
				$_REQUEST['pc'] = 12;
			}
			
			$pi = $_REQUEST['pi'];
			$pc = $_REQUEST['pc'];
			
			$data['pi'] = $pi;
			$data['pc'] = $pc;
			
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = ' limit '.$start.','.$pc;
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->model("house/community_model");
			
			$sql = "select count(*) from tb_community ".$where;

			$res = $this->community_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];
			
			$data['area_id'] = $area_id;
			$data['total_count'] = $total_count;
			$data['page_count'] = ceil(($total_count)/$pc);
			
			$data['communities'] = $this->community_model->raw_query('select * from tb_community '.$where.$limit);
			
			$this->load->view('house/house_list_page.php', $data);
		}
		
		public function community_info_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$community_id = $_REQUEST['community_id'];
			
			$this->load->model('house/building_block_model');
			$building_blocks = $this->building_block_model->query(array('community_id'=>$community_id));
			
			$building_block_ids = [];
			$wheres = [];
			for($i = 0; $i < count($building_blocks); $i++) {
				if(!in_array($building_blocks[$i]['bb_id'],$building_block_ids)) {
					$wheres[] = array('bb_id'=>$building_blocks[$i]['bb_id']);
					$building_block_ids[] = $building_blocks[$i]['bb_id'];
				}
			}
			$this->load->model('house/building_unit_model');
			$building_units = $this->building_unit_model->or_query($wheres);
			
			$building_unit_ids = [];
			$wheres = [];
			for($i = 0; $i < count($building_units); $i++) {
				if(!in_array($building_units[$i]['bu_id'],$building_unit_ids)) {
					$wheres[] = array('bu_id'=>$building_units[$i]['bu_id']);
					$building_unit_ids[] = $building_units[$i]['bu_id'];
				}
			}
			$this->load->model('house/house_model');
			$houses = $this->house_model->or_query($wheres);
			
			$this->load->model('house/community_maintainer_model');
			$data['maintainers'] = $this->community_maintainer_model->query(array('community_id'=>$community_id));
			$data['houses'] = $houses;
			$data['building_blocks'] = $building_blocks;
			$data['building_units'] = $building_units;
			
			$this->load->model('house/community_model');
			$c = $this->community_model->query_one(array('community_id'=>$community_id));
			$this->load->model('city/area_model');
			$data['community'] = $c;
			$data['area'] = $this->area_model->query_one(array('area_id'=>$c['area_id']));
			$this->load->model('user/employee_model');
			$data['employees'] = $this->employee_model->query();
			$data['community_id'] = $community_id;
			
			$this->load->view('house/community_info_page',$data);
		}
		
		public function addMaintainer() {
			
			$community_id = $_REQUEST['community_id'];
			$employee_id = $_REQUEST['employee_id'];
			$this->load->model('house/community_maintainer_model');
			$maintain['community_id'] = $community_id;
			$maintain['employee_id'] = $employee_id;
			$maintain['update_time'] = time();
			$maintain['maintainer_name'] = $_REQUEST['maintainer_name'];
			
			$maintain['id'] = $this->community_maintainer_model->insert($maintain);
			$ret['code'] = 0;
			$ret['maintain'] = $maintain;
			echo json_encode($ret);
		}
		
		public function delMaintainer() {
			$where['id'] = $_REQUEST['id'];
			$this->load->model('house/community_maintainer_model');
			$this->community_maintainer_model->remove($where);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryCityInfo() {
			$where['city_id'] = $_REQUEST['city_id'];
			
			$this->load->model('city/area_model');
			$areas = $this->area_model->query($where);
			
			$area_ids = [];
			for($i = 0; $i < count($areas); $i++) {
				if(!in_array($areas[$i]['area_id'], $area_ids)) {
					$wheres[] = array('area_id'=>$areas[$i]['area_id']);
					$area_ids[] = $areas[$i]['area_id'];
				}
			}
			$this->load->model('city/trade_area_model');
			$trade_areas = $this->trade_area_model->or_query($wheres);
			
			$wheres = [];
			$trade_area_ids = [];
			for($i = 0; $i < count($trade_areas); $i++) {
				if(!in_array($trade_areas[$i]['area_id'], $trade_area_ids)) {
					$wheres[] = array('ta_id'=>$trade_areas[$i]['ta_id']);
					$trade_area_ids[] = $trade_areas[$i]['ta_id'];
				}
			}
			$this->load->model('house/community_model');
			$communities = $this->community_model->or_query($wheres);
			
			$ret['areas'] = $areas;
			$ret['trade_areas'] = $trade_areas;
			$ret['communities'] = $communities;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function lockBB() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$bb_id = $_REQUEST['bb_id'];
			$this->load->model('house/building_block_model');
			
			$this->building_block_model->update(array('bb_id'=>$bb_id), array('locked'=>1));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function unlockBB() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$bb_id = $_REQUEST['bb_id'];
			$this->load->model('house/building_block_model');
			
			$this->building_block_model->update(array('bb_id'=>$bb_id), array('locked'=>0));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryBuildingBlocks() {
			$community_id = $_REQUEST['community_id'];
			if($community_id <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			//获取所有小区
			$this->load->model('house/building_block_model');
			$building_blocks = $this->building_block_model->query(array('community_id'=>$community_id));
			$ret['code'] = 0;
			$ret['building_blocks'] = $building_blocks;
			echo json_encode($ret);
		}
		
		public function queryBuildingUnits() {
			$bb_id = $_REQUEST['bb_id'];
			if($bb_id <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			//获取所有小区
			$this->load->model('house/building_unit_model');
			$building_units = $this->building_unit_model->query(array('bb_id'=>$bb_id));
			$ret['code'] = 0;
			$ret['building_units'] = $building_units;
			echo json_encode($ret);
		}
		
		public function queryTradeAreaCommunities() {
			$ta_id = $_REQUEST['ta_id'];
			if($ta_id <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			//获取所有小区
			$this->load->model('house/community_model');
			$communities = $this->community_model->query(array('ta_id'=>$ta_id));
			$ret['code'] = 0;
			$ret['communities'] = $communities;
			echo json_encode($ret);
		}
		
		public function queryAreaCommunities() {
			$area_id = $_REQUEST['area_id'];
			if($area_id <= 0) {
				$ret['code'] = ERROR_PARAM;
				echo json_encode($ret);
				return;
			}
			//获取所有小区
			$this->load->model('city/trade_area_model');
			$trade_areas = $this->trade_area_model->query(array('area_id'=>$area_id));
			$wheres = [];
			$trade_area_ids = [];
			for($i = 0; $i < count($trade_areas); $i++) {
				if(!in_array($trade_areas[$i]['area_id'], $trade_area_ids)) {
					$wheres[] = array('ta_id'=>$trade_areas[$i]['ta_id']);
					$trade_area_ids[] = $trade_areas[$i]['ta_id'];
				}
			}
			$this->load->model('house/community_model');
			$communities = $this->community_model->or_query($wheres);
			$ret['code'] = 0;
			$ret['communities'] = $communities;
			echo json_encode($ret);
		}
		
		public function queryCommunityMainters() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$community_id = $_REQUEST['community_id'];
			
			$this->load->model('house/community_maintainer_model');
			$mainters = $this->community_maintainer_model->query(array('community_id'=>$community_id));
			
			$ids = [];
			for($i = 0; $i < count($mainters); $i++) {
				$ids[] = $mainters[$i]['employee_id'];
			}
			
			if(count($ids) <= 0) {
				$ret['code'] = 0;
				$ret['employees'] = [];
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('user/employee_model');
			$employees = $this->employee_model->raw_query('select * from tb_employee where employee_id in('.implode(',',$ids).')');
			
			for($i = 0; $i < count($employees); $i++) {
				unset($employees[$i]['password']);
			}
			$ret['code'] = 0;
			$ret['employees'] = $employees;
			echo json_encode($ret);
		}
		
		public function queryHouses() {
			$bu_id = $_REQUEST['bu_id'];
			$this->load->model('house/house_model');
			$houses = $this->house_model->query(array('bu_id'=>$bu_id));
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		public function queryCommunityInfo() {
			$where['community_id'] = $_REQUEST['community_id'];
			$this->load->model('house/community_model');
			
			$this->load->model('house/building_block_model');
			$building_blocks = $this->building_block_model->query($where);
			
			$this->load->model('house/building_unit_model');
			$wheres = [];
			$building_block_ids = [];
			for($i = 0; $i < count($building_blocks); $i++) {
				if(!in_array($building_blocks[$i]['bb_id'],$building_block_ids)) {
					$building_block_ids[] = $building_blocks[$i]['bb_id'];
					$wheres[] = array('bb_id'=>$building_blocks[$i]['bb_id']);
				}
			}
			$building_units = $this->building_unit_model->or_query($wheres);//单元
			
			$wheres = [];
			$building_unit_ids = [];
			for($i = 0; $i < count($building_units); $i++) {
				if(!in_array($building_units[$i]['bu_id'],$building_unit_ids)) {
					$building_unit_ids[] = $building_units[$i]['bu_id'];
					$wheres[] = array('bu_id'=>$building_units[$i]['bu_id']);
				}
			}
			$houses = $this->building_unit_model->or_query($wheres);
			$ret['building_blocks'] = $building_blocks;
			$ret['building_units'] = $building_units;
			$ret['houses'] = $houses;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addCommmunity() {
			$community['area_id'] = $_REQUEST['area_id'];
			$community['ta_id'] = $_REQUEST['ta_id'];
			$community['name'] = $_REQUEST['name'];
			$community['lat'] = $_REQUEST['lat'];
			$community['lng'] = $_REQUEST['lng'];
			$community['update_time'] = time();
			$community['retriving_info'] = implode("",$_REQUEST['retriving_info']);
			
			//log_message('error', json_encode($_REQUEST));
			$this->load->model('house/community_model');
			$community['community_id'] = $this->community_model->insert($community);
			$ret['code'] = 0;
			$ret['community'] = $community;
			//生成js文件
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$community['ta_id']));
			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			
			
			$city_id = $area['city_id'];
			$areas = $this->area_model->query(array('city_id'=>$city_id));
			$area_ids = [];
			$wheres = [];
			for($i = 0; $i < count($areas);$i++) {
				$wheres[] = array('area_id'=>$areas[$i]['area_id']);
			}
			$sql = "select tb_community.* from tb_community,tb_trade_area,tb_area where tb_community.ta_id=tb_trade_area.ta_id and tb_trade_area.area_id=tb_area.area_id and tb_area.city_id=".$city_id.";";
			$ret['sql'] = $sql;
			$communities = $this->community_model->raw_query($sql);
			$ret['communities'] = $communities;
			$ret['city_id'] = $city_id;
			$this->load->helper('qiniusdk');
			$config['cdn_ak'] = QINIU_AK;
			$config['cdn_sk'] = QINIU_SK;
			$config['cdn_bucket'] = QINIU_BUCKET;
			$config['cdn_domain'] = QINIU_DOMAIN;
			$js = 'var g_communities_'.$city_id."=".json_encode($communities).";";
			$localPath = $_SERVER['DOCUMENT_ROOT']."/com_js/city_".$city_id.".js";
			$remotePath = "/com_js/city_".$city_id.".js";
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/com_js/city_".$city_id.".js",$js);
			$qiniusdk = new Qiniusdk($config);
			$qiniufile_url = $qiniusdk->uploadFile($localPath, $remotePath, 3600*24*365*200,array("scope"=>QINIU_BUCKET.":".$remotePath,"insertOnly"=> 0)); 
			$this->load->model('city/city_model');
			$this->city_model->update(array('city_id'=>$area['city_id']),array('update_time'=>time()));
			$ret['qiniu_file'] = $qiniufile_url;
			echo json_encode($ret);
		}
		
		public function addBuildingBlock() {
			$building_block['name'] = $_REQUEST['name'];
			$building_block['area_id'] = $_REQUEST['area_id'];
			$building_block['ta_id'] = $_REQUEST['ta_id'];
			$building_block['community_id'] = $_REQUEST['community_id'];
			$building_block['max_floor'] = $_REQUEST['max_floor'];
			$building_block['min_floor'] = $_REQUEST['min_floor'];
			$building_block['update_time'] = time();
			$building_block['locked'] = 0;
			
			$this->load->model('house/building_block_model');
			$building_block['bb_id'] = $this->building_block_model->insert($building_block);
			$ret['code'] = 0;
			$ret['building_block'] = $building_block;
			echo json_encode($ret);
		}
		
		public function addBuildingUnit() {
			//$names = explode("|",$_REQUEST['names']);
			$this->load->model('house/building_unit_model');
			/*
			$build_units = [];
			for($i = 0; $i < count($names); $i++) {
				$building_unit = [];
				$building_unit['area_id'] = $_REQUEST['area_id'];
				$building_unit['ta_id'] = $_REQUEST['ta_id'];
				$building_unit['community_id'] = $_REQUEST['community_id'];
				$building_unit['bb_id'] = $_REQUEST['bb_id'];
				
				$building_unit['lift'] = $_REQUEST['bu']['lift'];
				$building_unit['name'] = $names[$i];
				$building_unit['update_time'] = time();
				$building_unit['bu_id'] = $this->building_unit_model->insert($building_unit);
				$build_units[] = $building_unit;
			}
			*/
			$building_unit = $_REQUEST;
			$building_unit['bu_id'] = $this->building_unit_model->insert($building_unit);
			$ret['code'] = 0;
			$ret['building_unit'] = $building_unit;
			//$ret['building_units'] = $build_units;
			echo json_encode($ret);
		}
		
		public function addFloorToHouse() {//所有门牌添加楼层号
			$bu_id = $_REQUEST['bu_id'];
			$this->load->model('house/house_model');
			$houses = $this->house_model->query(array('bu_id'=>$bu_id));
			foreach($houses as $house) {
				$house['name'] = $house['floor'].$house['name'];
				$this->house_model->update(array('house_id'=>$house['house_id']),$house);
			}
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		public function pasteBB() {
			$src_bb = $_REQUEST['src_bb'];
			$dst_bb = $_REQUEST['dst_bb'];
			
			$this->load->model('house/house_model');
			$this->load->model('house/building_block_model');
			$this->load->model('house/building_unit_model');
			
			$this->building_unit_model->remove(array('bb_id'=>$dst_bb['bb_id']));
			$this->house_model->remove(array('bb_id'=>$dst_bb['bb_id']));
			
			$bus = $this->building_unit_model->query(array('bb_id'=>$src_bb['bb_id']));
			$all_houses = [];
			for($i = 0; $i < count($bus); $i++) {
				$bu_id = $bus[$i]['bu_id'];
				$houses = $this->house_model->query(array('bu_id'=>$bu_id));
				unset($bus[$i]['bu_id']);
				$bus[$i]['bb_id'] = $dst_bb['bb_id'];
				$bus[$i]['bu_id'] = $this->building_unit_model->insert($bus[$i]);
				
				for($j = 0; $j < count($houses); $j++) {
					unset($houses[$j]['house_id']);
					$houses[$j]['bb_id'] = $dst_bb['bb_id'];
					$houses[$j]['bu_id'] = $bus[$i]['bu_id'];
					$houses[$j]['house_id'] = $this->house_model->insert($houses[$j]);
					$all_houses[] = $houses[$j];
				}
			}
			
			$dst_bb['update_time'] = time();
			$dst_bb['min_floor'] = $src_bb['min_floor'];
			$dst_bb['max_floor'] = $src_bb['max_floor'];
			$this->building_block_model->update(array('bb_id'=>$dst_bb['bb_id']),$dst_bb);
			
			$ret['building_units'] = $bus;
			$ret['houses'] = $all_houses;
			$ret['building_block'] = $dst_bb;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delBB() {
			$bb_id = $_REQUEST['bb_id'];
			$this->load->model('house/house_model');
			$this->load->model('house/building_block_model');
			$this->load->model('house/building_unit_model');
			
			$this->building_unit_model->remove(array('bb_id'=>$bb_id));
			$this->house_model->remove(array('bb_id'=>$bb_id));
			$this->building_block_model->remove(array('bb_id'=>$bb_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addUpFloor() {
			$bb_id = $_REQUEST['bb_id'];
			$where['bb_id'] = $bb_id;
			$this->load->model('house/building_block_model');
			$bb['max_floor'] = $_REQUEST['max_floor'] + 1;
			$this->building_block_model->update($where, $bb);
			$ret['bb'] = $bb;
			$ret['where'] = $bb_id;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addDownFloor() {
			$bb_id = $_REQUEST['bb_id'];
			$where['bb_id'] = $bb_id;
			$this->load->model('house/building_block_model');
			$bb['min_floor'] = $_REQUEST['min_floor'] - 1;
			$this->building_block_model->update($where, $bb);
			$ret['bb'] = $bb;
			$ret['where'] = $bb_id;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function pasteBuildUnit() {
			$src_bu = $_REQUEST['src_bu'];
			$dst_bu = $_REQUEST['dst_bu'];
			
			$this->load->model('house/house_model');
			$this->house_model->remove(array('bu_id'=>$dst_bu['bu_id']));
			
			$dst_bu['update_time'] = time();
			$dst_bu['lift'] = $src_bu['lift'];
			
			$this->load->model('house/building_unit_model');
			$this->building_unit_model->update(array('bu_id'=>$dst_bu['bu_id']),$dst_bu);
			
			$houses = $this->house_model->query(array('bu_id'=>$src_bu['bu_id']));
			
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['bu_id'] = $dst_bu['bu_id'];
				unset($houses[$i]['house_id']);
				$houses[$i]['house_id'] = $this->house_model->insert($houses[$i]);
			}
			$ret['houses'] = $houses;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function delBuildUnit() {
			$bu_id = $_REQUEST['bu_id'];
			$this->load->model('house/house_model');
			$this->house_model->remove(array('bu_id'=>$bu_id));
			
			$this->load->model('house/building_unit_model');
			$this->building_unit_model->remove(array('bu_id'=>$bu_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addHouses() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$names = explode("|",$_REQUEST['house_add']['names']);
			$this->load->model('house/house_model');
			$houses = [];
			for($i = 0; $i < count($names); $i++) {
				$house = [];
				$house['area_id'] = $_REQUEST['area_id'];
				$house['ta_id'] = $_REQUEST['ta_id'];
				$house['community_id'] = $_REQUEST['community_id'];
				$house['bb_id'] = $_REQUEST['bb_id'];
				$house['bu_id'] = $_REQUEST['bu_id'];
				$house['floor'] = $_REQUEST['house_add']['floor'];
				$house['name'] = $names[$i];
				$house['update_time'] = time();
				$house['house_id'] = $this->house_model->insert($house);
				$houses[] = $house;
			}
			
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		public function delHouse() {
			$where['house_id'] = $_REQUEST['house_id'];
			$this->load->model('house/house_model');
			$code = $this->house_model->remove($where);
			if($code) {
				$ret['code'] = 0;
			} else {
				$ret['code'] = ERROR_UNKNOWN;
			}
			echo json_encode($ret);
		}
	}
?>
