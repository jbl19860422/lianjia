<?php
	require_once('ControllerBase.php');
	class Houseinfo extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function house_info_add_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query(array());

			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			
			$this->load->model('user/employee_model');
			$data['employees'] = $this->employee_model->query();
			
			$this->load->view('houseinfo/house_info_add_page.php', $data);
		}
		
		
		public function houseinfo_batch_add_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query(array());

			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query();
			
			$this->load->model('house/community_model');
			$data['communities'] = $this->community_model->query();
			
			$this->load->model('user/employee_model');
			$data['employees'] = $this->employee_model->query();
			
			$this->load->view('houseinfo/houseinfo_batch_add_page.php', $data);
		}
		
		public function house_info_list_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				echo "not login";
				return;
				header("location: user/login_page");
				return;
			}
			$data['employee'] = $_SESSION['employee'];
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query(array('area_id'=>$employee['area_id']));
			
			$this->load->model('city/subway_model');
			$subways = $this->subway_model->query();
			$data['subways'] = $subways;
			
			$search_cond = [];
			$search = $_REQUEST['search'];
			if($search['community_name'] != '') {
				$this->load->model('house/community_model');
				$communities = $this->community_model->like_query(null, array('key'=>'name','value'=>$search['community_name'],'invalid'=>0));
			}
			
			$this->load->model("houseinfo/house_info_model");
			$this->load->view('houseinfo/house_info_list_page.php', $data);
		}
		
		
		public function house_info_rent_list_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$employee = $_SESSION['employee'];
			$data['employee'] = $_SESSION['employee'];
			
			$this->load->model('city/area_model');
			$data['areas'] = $this->area_model->query();
			
			$this->load->model('city/trade_area_model');
			$data['trade_areas'] = $this->trade_area_model->query(array('area_id'=>$employee['area_id']));
			
			$this->load->model('city/subway_model');
			$subways = $this->subway_model->query();
			$data['subways'] = $subways;
			
			$search_cond = [];
			$search = $_REQUEST['search'];
			if($search['community_name'] != '') {
				$this->load->model('house/community_model');
				$communities = $this->community_model->like_query(null, array('key'=>'name','value'=>$search['community_name'],'invalid'=>0));
			}
			
			$this->load->model("houseinfo/house_info_model");
			$this->load->view('houseinfo/house_info_rent_list_page.php', $data);
		}
		
		public function house_comment_edit_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);

			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_comment_model');
			$comment = $this->house_comment_model->query_one(array('house_info_id'=>$house_info_id));
			$data['comment'] = $comment;
			
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$data['house_info'] = $house_info;
			
			$this->load->view('houseinfo/house_comment_edit_page',$data);
		}
		
		public function house_followup_edit_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$house_info_id = $_REQUEST['house_info_id'];

			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$data['house_info'] = $house_info;
			
			$data['employee'] = $_SESSION['employee'];
			$this->load->view('houseinfo/house_followup_edit_page',$data);
		}
		
		public function house_info_edit_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$data['house_info'] = $house_info;
			
			$this->load->model('house/house_model');
			$house= $this->house_model->query_one(array('house_id'=>$house_info['house_id']));
			$data['house'] = $house;
			
			$house_infoes = $this->house_info_model->query(array('house_id'=>$house_info['house_id']));
			$data['house_infoes'] = $house_infoes;
			
			$this->load->model('house/building_unit_model');
			$bu = $this->building_unit_model->query_one(array('bu_id'=>$house['bu_id']));
			$data['bu'] = $bu;
			
			$this->load->model('house/building_block_model');
			$bb = $this->building_block_model->query_one(array('bb_id'=>$bu['bb_id']));
			$data['bb'] = $bb;
			
			$this->load->model('house/community_model');
			$community = $this->community_model->query_one(array('community_id'=>$bb['community_id']));
			$data['community'] = $community;
			
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$community['ta_id']));
			$data['trade_area'] = $trade_area;
			
			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			$data['area'] = $area;
			//echo json_encode($data);
			//return;
			$data['now'] = time();
			$this->load->view('houseinfo/house_info_edit_page.php',$data);
		}
		
		public function house_info_detail_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			
			$data['employee'] = $_SESSION['employee'];
			
			$employee = $_SESSION['employee'];
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$house_info_id = $_REQUEST['house_info_id'];
			
			$this->load->model('user/house_follow_model');
			$follow = $this->house_follow_model->query_one(array('employee_id'=>$employee['employee_id'], 'house_info_id'=>$house_info_id));
			$data['follow'] = $follow;
			
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			//查询房源录入人信息
			$this->load->model('user/employee_model');
			$house_add_employee = $this->employee_model->query_one(array('employee_id'=>$house_info['add_employee_id']));
			unset($house_add_employee['password']);
			
			$data['house_add_employee'] = $house_add_employee;
			
			//查询房源维护人信息
			if($house_info['last_maintain_time'] <= (time()-15*3600)) {
				if($house_info['maintain_employee_id'] != 0) {//超过维护时限
					$this->house_info_model->update(array('house_info_id'=>$house_info_id), array('maintain_employee_id'=>0));
					$house_info['maintain_employee_id'] = 0;
				}
			}
			
			$this->load->model('user/employee_model');
			$house_maintain_employee = $this->employee_model->query_one(array('employee_id'=>$house_info['maintain_employee_id']));
			unset($house_maintain_employee['password']);
			$data['house_maintain_employee'] = $house_maintain_employee;
			
			//查询房源实勘人信息
			$this->load->model('user/employee_model');
			$house_prospect_employee = $this->employee_model->query_one(array('employee_id'=>$house_info['prospect_employee_id']));
			unset($house_prospect_employee['password']);
			$data['house_prospect_employee'] = $house_prospect_employee;
			//查询房源图片人信息
			$house_pic_employee = $this->employee_model->query_one(array('employee_id'=>$house_info['pic_employee_id']));
			unset($house_pic_employee['password']);
			$data['house_pic_employee'] = $house_pic_employee;
			
			$data['takesees'] = [];
			$takesee_ids = explode("|",$house_info['takesee_ids']);
			if(count($takesee_ids) > 0) {
				$c = implode(",",$takesee_ids);
				if($c != '') {
					$sql = "select * from tb_take_see where see_id in (".implode(",",$takesee_ids).")";
					$data['takesees'] = $this->house_info_model->raw_query($sql);
				}
			}
			
			$employee_ids = [];
			for($i = 0; $i < count($data['takesees']); $i++) {
				if(!in_array($data['takesees'][$i]['employee_id'], $employee_ids)) {
					$employee_ids[] = $data['takesees'][$i]['employee_id'];
				}
			}
			$data['employees'] = [];
			if(count($employee_ids) > 0) {
				$c = implode(",",$employee_ids);
				if($c != '') {
					$sql = "select employee_id,mobile,work_no,team_name,name,headimg from tb_employee where employee_id in (".implode(",",$employee_ids).")";
					$data['employees'] = $this->house_info_model->raw_query($sql);
				}
			}
			
			if($employee['role'] == 0) {//游客
				unset($house_info['owner']);
			}
			$data['house_info'] = $house_info;
			
			if($house_info['has_cert']) {
				$this->load->model('user/employee_model');
				$house_cert = json_decode($house_info['house_cert'], true);
				$upload_cert_employee = $this->employee_model->query_one(array('employee_id'=>$house_cert['employee_id']));
				
				$data['upload_cert_employee'] = $upload_cert_employee;
			}
			
			if($house_info['has_agent_cert']) {
				$this->load->model('user/employee_model');
				$agent_cert = json_decode($house_info['agent_cert'], true);
				$upload_agent_cert_employee = $this->employee_model->query_one(array('employee_id'=>$agent_cert['employee_id']));
				
				$data['upload_agent_cert_employee'] = $upload_agent_cert_employee;
			}
			
			if($house_info['idpaper']) {
				$this->load->model('user/employee_model');
				$idpaper = json_decode($house_info['idpaper'], true);
				$upload_idpaper_employee = $this->employee_model->query_one(array('employee_id'=>$idpaper['employee_id']));
				
				$data['upload_idpaper_employee'] = $upload_idpaper_employee;
			}
			
			if($house_info['deed_tax_ticket']) {
				$this->load->model('user/employee_model');
				$deed_tax_ticket = json_decode($house_info['deed_tax_ticket'], true);
				$upload_taxticket_employee = $this->employee_model->query_one(array('employee_id'=>$deed_tax_ticket['employee_id']));
				
				$data['upload_taxticket_employee'] = $upload_taxticket_employee;
			}
			
			if($house_info['key_employee_id']) {
				$this->load->model('user/employee_model');
				$key_employee_id = json_decode($house_info['key_employee_id'], true);
				$house_key_employee = $this->employee_model->query_one(array('employee_id'=>$key_employee_id));
				
				$data['house_key_employee'] = $house_key_employee;
			}
			
			if($house_info['veri_report']) {
				$this->load->model('user/employee_model');
				$veri_report = json_decode($house_info['veri_report'], true);
				$upload_veri_report_employee = $this->employee_model->query_one(array('employee_id'=>$idpaper['employee_id']));
				
				$data['upload_verireport_employee'] = $upload_veri_report_employee;
			}
			
			if($house_info['house_number']) {
				$this->load->model('user/employee_model');
				$house_number = json_decode($house_info['house_number'], true);
				$upload_house_number_employee = $this->employee_model->query_one(array('employee_id'=>$house_number['employee_id']));
				
				$data['upload_housenumber_employee'] = $upload_house_number_employee;
			}

			$this->load->model('house/house_model');
			$house= $this->house_model->query_one(array('house_id'=>$house_info['house_id']));
			$data['house'] = $house;
			
			$house_infoes = $this->house_info_model->query(array('house_id'=>$house_info['house_id']));
			$data['house_infoes'] = $house_infoes;
			
			$this->load->model('house/building_unit_model');
			$bu = $this->building_unit_model->query_one(array('bu_id'=>$house['bu_id']));
			$data['bu'] = $bu;
				
			$this->load->model('house/building_block_model');
			$bb = $this->building_block_model->query_one(array('bb_id'=>$bu['bb_id']));
			$data['bb'] = $bb;
				
			$this->load->model('house/community_model');
			$community = $this->community_model->query_one(array('community_id'=>$bb['community_id']));
			$data['community'] = $community;
			
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$community['ta_id']));
			$data['trade_area'] = $trade_area;
			
			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			$data['area'] = $area;
			
			$data['now'] = time();

			if($house_info['entrust_type'] == 1) {
				$this->load->view('houseinfo/house_info_detail_page.php',$data);
			} else {
				$this->load->view('houseinfo/house_info_rent_detail_page.php',$data);
			}
		}
		
		public function house_op_log_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);
			
			$this->load->view('houseinfo/house_op_log_page.php');
		}
		
		public function applyMaintainer() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			
			//如果是职业经纪人，该房源在自己维护范围内，则不需要审批，管理员不能点
			if($employee['role'] == ROLE_IND_AGENT) {
				$this->load->model('house/community_maintainer_model');
				$w['community_id'] = $house_info['community_id'];
				$w['employee_id'] = $employee['employee_id'];
				$h = $this->community_maintainer_model->query_one($w);
				if($h) {//在维护范围内，直接成功
					$ret['code'] = 1;
					$new_h['maintain_employee_id'] = $employee['employee_id'];
					$new_h['maintain_employee_name'] = $employee['name'];
					$new_h['last_maintain_time'] = time();
					$this->house_info_model->update(array('house_info_id'=>$house_info_id), $new_h);
					echo json_encode($ret);
					return;
				}
			}
			
			$where['community_id'] = $house_info['community_id'];
			$where['employee_id'] = $employee['employee_id'];
			$this->load->model('house/community_maintainer_model');
			$c = $this->community_maintainer_model->query_one($where);
			if(!$c) {
				$ret['code'] = -1;
				echo json_encode($ret);
				return;
			}
			
			$house_info_new['maintain_employee_id'] = $employee['employee_id'];
			$house_info_new['maintain_employee_name'] = $employee['name'];
			$house_info_new['last_maintain_time'] = time();
			$this->house_info_model->update(array('house_info_id'=>$house_info_id), $house_info_new);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function editHousePrice() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$where['house_info_id'] = $_REQUEST['house_info_id'];
			
			$this->load->model('houseinfo/house_info_model');
			
			$house_info = $this->house_info_model->query_one($where);
			if($house_info['price'] < $_REQUEST['price_new']) {
				$house_info['price_state'] = 1;//上涨
			} else if($house_info['price'] > $_REQUEST['price_new']) {
				$house_info['price_state'] = 2;//下降
			}
			$house_info['price'] = $_REQUEST['price_new'];
			$this->house_info_model->update($where,$house_info);
			
			
			$house_info = $this->house_info_model->query_one($where);
			$house_info['owner'] = json_decode($house_info['owner'], true);
			if($house_info['owner']['name'] != '' && $house_info['owner']['mobile'] != '' && $house_info['area'] != '' && $house_info['area'] != 0
				&& $house_info['price'] != '' && $house_info['price'] != 0 && $house_info['orientation'] != '') {
				$house_info['info_complete'] = 1;
			} else {
				$house_info['info_complete'] = 0;
			}
			$house_info['owner'] = json_encode($house_info['owner']);
			$this->house_info_model->update($where,$house_info);
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addFollowInfo() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['house_info_id'];
			$followup_infoes = $_REQUEST['followup_infoes'];
			for($i = 0; $i < count($followup_infoes); $i++) {
				if(!isset($followup_infoes[$i]['time'])) {
					$followup_infoes[$i]['time'] = time();
				}
			}
			$house['followup_infoes'] = json_encode($followup_infoes);
			
			$this->house_info_model->update($where,$house);
			$ret['followup_infoes'] = $followup_infoes;
			$ret['time'] = time();
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryHouseInfoes() {
			
		}
		
		public function editHouseComment() {
			$where['house_info_id'] = $_REQUEST['house_info_id'];
			
			$this->load->model('houseinfo/house_info_model');
			$house['comment_title'] = $_REQUEST['comment_title'];
			$house['comments'] = json_encode($_REQUEST['comments']);
			$this->house_info_model->update($where, $house);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function houseDealing() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$house_id = $_REQUEST['house_id'];
			$this->load->model('houseinfo/house_info_model');
			
			$house = $this->house_info_model->query_one(array('house_id'=>$house_id));
			if($house) {
				$ret['house_info'] = $house;
				$ret['code'] = 0;
			} else {
				$ret['code'] = -1;
			}
			
			echo json_encode($ret);
		}
		public function queryAllHouses() {//查询房源
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			$where[] = "(entrust_type=1)";
			
			if($search_cond['community_name'] != '') {
				$where[] = "(community_name like '%".$search_cond['community_name']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['range'] != '') {
				if($search_cond['range'] == 0) {//范围盘房源
					$where[] = "(area_id=".$employee['area_id'].")";
				} else if($search_cond['range'] == 1) {//维护盘房源
					$where[] = "(ta_id=".$employee['ta_id'].")";
				} else if($search_cond['range'] == 2) {//责任盘房源
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['range'] == 3) {//角色房源
					$eid = $employee['employee_id'];
					$where[] = "(maintain_employee_id=".$eid." or add_employee_id=".$eid." or key_employee_id=".$eid." or prospect_employee_id=".$eid." or authorize_employee_id=".$eid." or document_employee_id=".$eid.")";
				} else if($search_cond['range'] == 4) {//共享池房源
					$t = time()-15*3600;//15天没维护
					$where[] = "(maintain_employee_id=0 or last_maintain_time <".$t.")";
				} else if($search_cond['range'] == 5) {//关注房源
					$this->load->model('user/house_follow_model');
					$follows = $this->house_follow_model->raw_query('select house_info_id from tb_follow_house where employee_id='.$employee['employee_id']);
					$ids = [];
					foreach($follows as $f) {
						$ids[] = $f['house_info_id'];
					}
					
					if(count($ids) > 0) {
						$where[] = "(house_info_id in (".implode(",",$ids)."))";
					} else {
						$where[] = "(0=1)";
					}
				}
			}

			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}

			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}

			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info";
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = 'order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			if(count($where) > 0) {
				$sql = "select * from tb_house_info where (".implode(" and ",$where).") ".$order_info.' '.$limit;
			} else {
				$sql = "select * from tb_house_info ".$order_info.' '.$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);
			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['limit'] = $limit;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		
		public function queryFocusHouses() {//查询聚焦房源
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			$where[] = "(focus=1 and entrust_type=1)";
			
			if($search_cond['community_name'] != '') {
				$where[] = "(community_name like '%".$search_cond['community_name']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['range'] != '') {
				if($search_cond['range'] == 0) {//范围盘房源
					$where[] = "(area_id=".$employee['area_id'].")";
				} else if($search_cond['range'] == 1) {//维护盘房源
					$where[] = "(ta_id=".$employee['ta_id'].")";
				} else if($search_cond['range'] == 3) {//角色房源
					$eid = $employee['employee_id'];
					$where[] = "(maintain_employee_id=".$eid." or add_employee_id=".$eid." or key_employee_id=".$eid." or prospect_employee_id=".$eid." or authorize_employee_id=".$eid." or document_employee_id=".$eid.")";
				} else if($search_cond['range'] == 4) {
					$t = time()-15*3600;//15天没维护
					$where[] = "(maintain_employee_id=0 or last_maintain_time <".$t.")";
				} else if($search_cond['range'] == 2) {//责任盘房源
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['range'] == 5) {//关注房源
					$this->load->model('user/house_follow_model');
					$follows = $this->house_follow_model->raw_query('select house_info_id from tb_follow_house where employee_id='.$employee['employee_id']);
					$ids = [];
					foreach($follows as $f) {
						$ids[] = $f['house_info_id'];
					}
					
					if(count($ids) > 0) {
						$where[] = "(house_info_id in (".implode(",",$ids)."))";
					} else {
						$where[] = "(0=1)";
					}
				}
			}

			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}

			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}

			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info";
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_house_info where (".implode(" and ",$where).")".' '.$limit;
			} else {
				$sql = "select * from tb_house_info ".$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);
			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		public function queryAllRentHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			//$where[] = "(invalid=0)";
			$where[] = "(entrust_type=2)";
			if($search_cond['community_name'] != '') {
				$where[] = "(community_name like '%".$search_cond['community_name']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['range'] != '') {
				if($search_cond['range'] == 0) {//范围盘房源
					$where[] = "(area_id=".$employee['area_id'].")";
				} else if($search_cond['range'] == 1) {//维护盘房源
					$where[] = "(ta_id=".$employee['ta_id'].")";
				} else if($search_cond['range'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['range'] == 3) {//角色房源
					$eid = $employee['employee_id'];
					$where[] = "(maintain_employee_id=".$eid." or add_employee_id=".$eid." or key_employee_id=".$eid." or prospect_employee_id=".$eid." or authorize_employee_id=".$eid." or document_employee_id=".$eid.")";
				} else if($search_cond['range'] == 4) {
					$t = time()-15*3600;//15天没维护
					$where[] = "(maintain_employee_id=0 or last_maintain_time <".$t.")";
				} else if($search_cond['range'] == 5) {//关注房源
					$this->load->model('user/house_follow_model');
					$follows = $this->house_follow_model->raw_query('select house_info_id from tb_follow_house where employee_id='.$employee['employee_id']);
					$ids = [];
					foreach($follows as $f) {
						$ids[] = $f['house_info_id'];
					}
					if(count($ids) > 0) {
						$where[] = "(house_info_id in (".implode(",",$ids)."))";
					} else {
						$where[] = "(0=1)";
					}
				}
			}

			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}

			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}

			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = ' order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info";
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_house_info where (".implode(" and ",$where).")".$order_info.' '.$limit;
			} else {
				$sql = "select * from tb_house_info ".$order_info.' '.$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);
			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		
		public function queryFocusRentHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			$where[] = "(invalid=0 and focus=1)";
			$where[] = "(entrust_type=2)";
			if($search_cond['community_name'] != '') {
				$where[] = "(community_name like '%".$search_cond['community_name']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['build_block'] != '') {
				$where[] = "(build_block like '%".$search_cond['build_block']."%')";
			}

			if($search_cond['range'] != '') {
				if($search_cond['range'] == 0) {//范围盘房源
					$where[] = "(area_id=".$employee['area_id'].")";
				} else if($search_cond['range'] == 1) {//维护盘房源
					$where[] = "(ta_id=".$employee['ta_id'].")";
				} else if($search_cond['range'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['range'] == 3) {//角色房源
					$eid = $employee['employee_id'];
					$where[] = "(maintain_employee_id=".$eid." or add_employee_id=".$eid." or key_employee_id=".$eid." or prospect_employee_id=".$eid." or authorize_employee_id=".$eid." or document_employee_id=".$eid.")";
				} else if($search_cond['range'] == 4) {
					$t = time()-15*3600;//15天没维护
					$where[] = "(maintain_employee_id=0 or last_maintain_time <".$t.")";
				}  else if($search_cond['range'] == 5) {//关注房源
					$this->load->model('user/house_follow_model');
					$follows = $this->house_follow_model->raw_query('select house_info_id from tb_follow_house where employee_id='.$employee['employee_id']);
					$ids = [];
					foreach($follows as $f) {
						$ids[] = $f['house_info_id'];
					}
					if(count($ids) > 0) {
						$where[] = "(house_info_id in (".implode(",",$ids)."))";
					} else {
						$where[] = "(0=1)";
					}
				}
			}

			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}

			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}

			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = ' order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info";
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_house_info where (".implode(" and ",$where).")".$order_info.' '.$limit;
			} else {
				$sql = "select * from tb_house_info ".$order_info.' '.$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);
			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
		
		public function applyHouseAgentCert() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_HOUSE_AGENT_CERT;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function recommendHouse() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$to_employee_id = $_REQUEST['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = 15;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyInvalidHouse() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}

			$this->load->model('houseinfo/house_info_model');
			$house_info_id = $_REQUEST['house_info_id'];
			$employee = $_SESSION['employee'];
			if($employee['type'] == ADMIN_TYPE_A) {
				$this->load->model('houseinfo/house_info_model');
				$where['house_info_id'] = $house_info_id;
				$house_info['invalid'] = 1;
				$this->house_info_model->update($where, $house_info);
				$ret['house_info_id'] = $house_info_id;
				$ret['code'] = 0;
				echo json_encode($ret);
				return;
			}
			
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			if(!$house_info) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['msg'] = "no house";
				echo json_encode($ret);
				return;
			}
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			if(!$trade_area) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['msg'] = "no trade_area";
				echo json_encode($ret);
				return;
			}

			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			if(!$area) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['msg'] = "no area";
				echo json_encode($ret);
				return;
			}
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_APPLY_INVALID_HOUSE;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			//$msg['content'] = json_encode($_REQUEST);
			
			$this->load->model('house/building_unit_model');
			$bu = $this->building_unit_model->query_one(array('bu_id'=>$house_info['bu_id']));
			if(!$bu) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['msg'] = "no bu";
				echo json_encode($ret);
				return;
			}
			$this->load->model('house/house_model');
			$house = $this->house_model->query_one(array('house_id'=>$house_info['house_id']));
			if(!$house) {
				$ret['code'] = ERROR_UNKNOWN;
				$ret['msg'] = "no house";
				echo json_encode($ret);
				return;
			}
			$content['address'] = $area['name'].$trade_area['name'].$house_info['community_name'].$house_info['build_block'].$bu['name'].$house_info['floor'].$house['name'];
			$content['house_info_id'] = $house_info_id;
			$msg['content'] = json_encode($content);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyHouseNumber() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_HOUSE_NUMBER;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function receiveHouse() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$house_info_id = $_REQUEST['content']['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info['maintain_employee_id'] = $_SESSION['employee']['employee_id'];
			$house_info['maintain_employee_name'] = $_SESSION['employee']['name'];
			$this->house_info_model->update(array('house_info_id'=>$house_info_id), $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['house_info_id'] = $house_info_id;
			$ret['request'] = $_REQUEST;
			$ret['msg_id'] = $msg_id;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryHouseAddress() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$ret['house_info_id'] = $_REQUEST['house_info_id'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			
			$ret['house_info'] = $house_info;
			$this->load->model('house/house_model');
			$house= $this->house_model->query_one(array('house_id'=>$house_info['house_id']));
			$ret['house'] = $house;
			
			$this->load->model('house/building_unit_model');
			$bu = $this->building_unit_model->query_one(array('bu_id'=>$house['bu_id']));
			$ret['bu'] = $bu;
			
			$this->load->model('house/building_block_model');
			$bb = $this->building_block_model->query_one(array('bb_id'=>$bu['bb_id']));
			$ret['bb'] = $bb;
			
			$this->load->model('house/community_model');
			$community = $this->community_model->query_one(array('community_id'=>$bb['community_id']));
			$ret['community'] = $community;
			
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$community['ta_id']));
			$ret['trade_area'] = $trade_area;
			
			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			$ret['area'] = $area;
			
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function queryHouseAddress2() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$house_id = $_REQUEST['house_id'];
	
			$this->load->model('house/house_model');
			$house= $this->house_model->query_one(array('house_id'=>$house_id));
			$ret['house'] = $house;
			
			$this->load->model('house/building_unit_model');
			$bu = $this->building_unit_model->query_one(array('bu_id'=>$house['bu_id']));
			$ret['bu'] = $bu;
			
			$this->load->model('house/building_block_model');
			$bb = $this->building_block_model->query_one(array('bb_id'=>$bu['bb_id']));
			$ret['bb'] = $bb;
			
			$this->load->model('house/community_model');
			$community = $this->community_model->query_one(array('community_id'=>$bb['community_id']));
			$ret['community'] = $community;
			
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$community['ta_id']));
			$ret['trade_area'] = $trade_area;
			
			$this->load->model('city/area_model');
			$area = $this->area_model->query_one(array('area_id'=>$trade_area['area_id']));
			$ret['area'] = $area;
			
			$this->load->model('houseinfo/house_info_model');
			$h = $this->house_info_model->query_one(array('house_id'=>$house_id));
			if($h) {
				$ret['exists'] = true;
			} else {
				$ret['exists'] = false;
			}
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		
		public function applyHouseFocus() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_APPLY_HOUSE_FOCUS;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($house_info);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyVeriReport() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_VERIREPORT;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyTaxTicket() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_TAXTICKET;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyHouseFollowImg() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$maintain_employee_id = $house_info['maintain_employee_id'];
			$to_employee_id = $maintain_employee_id;
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_APPLY_FOLLOW_IMG;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['content'] = json_encode($_REQUEST);
			
			$msg['msg_id'] = $this->message_model->insert($msg);
			$ret['code'] = 0;
			$ret['msg'] = $msg;
			echo json_encode($ret);
		}
		
		public function allowFollowImg() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['follow_imgs'] = json_encode($_REQUEST['content']['follow_imgs']);
			$house_info['prospect_employee_id'] = $_REQUEST['from_employee_id'];
			$house_info["pic_employee_id"]  = $_REQUEST['from_employee_id'];
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		
		public function allowInvalidHouse() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['invalid'] = 1;
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowFocusHouse() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['focus'] = 1;
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowHouseNumber() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['house_number'] = json_encode($_REQUEST['content']);
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowVeriReport() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['veri_report'] = json_encode($_REQUEST['content']);
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowTaxTicket() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['deed_tax_ticket'] = json_encode($_REQUEST['content']);
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		
		public function allowHouseAgentCert() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['agent_cert'] = json_encode($_REQUEST['content']);
			$house_info['has_agent_cert'] = 1;
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyHouseContract() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			if(!$to_employee_id) {
				$ret['code'] = ERROR_NO_TRADE_EMPLOYEE;
				echo json_encode($ret);
				return;
			}
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_HOUSE_CONTRACT;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyIdPaper() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_IDPAPER;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowIdPaper() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['idpaper'] = json_encode($_REQUEST['content']);
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowHouseContract() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['contract'] = json_encode($_REQUEST['content']);
			$house_info['has_contract'] = 1;
			
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$house_info['authorize_employee_id'] = $msg['from_employee_id'];
			$this->house_info_model->update($where, $house_info);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function applyHouseCert() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$house_info_id = $_REQUEST['house_info_id'];
			$this->load->model('houseinfo/house_info_model');
			$house_info = $this->house_info_model->query_one(array('house_info_id'=>$house_info_id));
			$ta_id = $house_info['ta_id'];
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$ta_id));
			$to_employee_id = $trade_area['employee_id'];
			$this->load->model('user/message_model');
			
			$msg['from_employee_id'] = $employee['employee_id'];
			$msg['to_employee_id'] = $to_employee_id;
			$msg['type'] = MSG_UPLOAD_HOUSE_CERT;
			$msg['create_time'] = time();
			$msg['from_employee_headimg'] = $employee['headimg'];
			$msg['from_employee_name'] = $employee['name'];
			$msg['from_employee_id'] = $employee['employee_id'];
			$_REQUEST['employee_id'] = $employee['employee_id'];
			$_REQUEST['time'] = time();
			$msg['content'] = json_encode($_REQUEST);
			
			$this->message_model->insert($msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function allowHouseCert() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['content']['house_info_id'];
			$house_info['house_cert'] = json_encode($_REQUEST['content']);
			$house_info['has_cert'] = 1;
			$this->house_info_model->update($where, $house_info);
			
			$this->load->model('user/message_model');
			$msg_id = $_REQUEST['msg_id'];
			$msg['valid'] = 0;
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			
			$ret['where'] = $where;
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function uploadHouseKey() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			$employee = $_SESSION['employee'];
			$h['key_number'] = $_REQUEST['key_number'];
			$h['key_mark'] = $_REQUEST['key_mark'];
			$h['key_employee_id'] = $employee['employee_id'];
			$this->load->model('houseinfo/house_info_model');
			$where['house_info_id'] = $_REQUEST['house_info_id'];
			
			$this->house_info_model->update($where, $h);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function querySubwayHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			$where[] = "(entrust_type=1)";
			
			if($search_cond['subway_id'] != '') {
				$this->load->model('house/community_station_model');
				if($search_cond['distance'] == '') {
					$a = $this->community_station_model->query(array('subway_id'=>$search_cond['subway_id']));
				} else {
					$s = 'select * from tb_community_station where subway_id='.$search_cond['subway_id'].' and distance<'.$search_cond['distance'];
					$a = $this->community_station_model->raw_query($s);
				}
				
				$community_ids = [];
				for($i = 0; $i < count($a); $i++) {
					if(!in_array($a[$i]['community_id'], $community_ids)) {
						$community_ids[] = $a[$i]['community_id'];
					}
				}
				
				if(count($community_ids) > 0) {
					$c = implode(",",$community_ids);
					$where[] = '( community_id in ('.$c.'))';
				} else {
					$where[] = '(0=1)';
				}
			}
			
			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}
			
			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = 'order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info";
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_house_info where (".implode(" and ",$where).")".$order_info.' '.$limit;
			} else {
				$sql = "select * from tb_house_info ".$order_info.' '.$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);

			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}

		public function querySchoolHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			if($search_cond['school_name'] != '') {
				$where[] = "(name like '%".$search_cond['school_name']."%')";
			}
			
			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}
			
			if($search_cond['nature'] != '') {
				$where[] = '(nature='.$search_cond['nature'].')';
			}
			
			if($search_cond['upgrade_method'] != '') {
				$where[] = '(upgrade_method='.$search_cond['upgrade_method'].')';
			}
			
			if($search_cond['num_limit'] != '') {
				$where[] = '(num_limit='.$search_cond['num_limit'].')';
			}

			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('city/school_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_school where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_school";
			}

			$res = $this->school_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_school where (".implode(" and ",$where).")".' '.$limit;
			} else {
				$sql = "select * from tb_school ".$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$schools = $this->school_model->raw_query($sql);
			//查询房源距离地铁站信息
			$school_ids = [];
			for($i = 0; $i < count($schools); $i++) {
				if(!in_array($schools[$i]['sc_id'], $school_ids)) {
					$school_ids[] = $schools[$i]['sc_id'];
				}
			}
			
			if(count($school_ids) <= 0) {
				$ret['sch_coms'] = [];
				$ret['houses'] = [];
				$ret['code'] = 0;
				$ret['schools'] = $schools;
				echo json_encode($ret);
				return;
			}
			
			$this->load->model('house/community_school_model');
			$sql = "select * from tb_community_school where sc_id in(".implode(",",$school_ids).")";
			$com_schs = $this->community_school_model->raw_query($sql);
			
			$community_ids = [];
			for($i = 0; $i < count($com_schs); $i++) {
				if(!in_array($com_schs[$i]['community_id'], $community_ids)) {
					$community_ids[] = $com_schs[$i]['community_id'];
				}
			}
			
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = 'order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			
			$this->load->model('houseinfo/house_info_model');
			if(count($community_ids) > 0) {
				$sql = "select * from tb_house_info where community_id in(".implode(",",$community_ids).") and entrust_type=1 ".$order_info;
				$houses = $this->house_info_model->raw_query($sql);
			} else {
				$houses = [];
			}
			
			//查询地铁站
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}

			$ret['sch_coms'] = $com_schs;
			$ret['houses'] = $houses;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['schools'] = $schools;
			echo json_encode($ret);
		}
		
		public function querySchoolRentHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			if($search_cond['school_name'] != '') {
				$where[] = "(name like '%".$search_cond['school_name']."%')";
			}
			
			if($search_cond['area_id'] != '') {
				$where[] = '(area_id='.$search_cond['area_id'].')';
			}
			
			if($search_cond['nature'] != '') {
				$where[] = '(nature='.$search_cond['nature'].')';
			}
			
			if($search_cond['upgrade_method'] != '') {
				$where[] = '(upgrade_method='.$search_cond['upgrade_method'].')';
			}
			
			if($search_cond['num_limit'] != '') {
				$where[] = '(num_limit='.$search_cond['num_limit'].')';
			}

			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$this->load->model('city/school_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_school where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_school";
			}

			$res = $this->school_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_school where (".implode(" and ",$where).")".' '.$limit;
			} else {
				$sql = "select * from tb_school ".$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$schools = $this->school_model->raw_query($sql);
			//查询房源距离地铁站信息
			$school_ids = [];
			for($i = 0; $i < count($schools); $i++) {
				if(!in_array($schools[$i]['sc_id'], $school_ids)) {
					$school_ids[] = $schools[$i]['sc_id'];
				}
			}
			
			$this->load->model('house/community_school_model');
			$sql = "select * from tb_community_school where sc_id in(".implode(",",$school_ids).")";
			$com_schs = $this->community_school_model->raw_query($sql);
			
			$community_ids = [];
			for($i = 0; $i < count($com_schs); $i++) {
				if(!in_array($com_schs[$i]['community_id'], $community_ids)) {
					$community_ids[] = $com_schs[$i]['community_id'];
				}
			}
			
			$this->load->model('houseinfo/house_info_model');
			if(count($community_ids) > 0) {
				$sql = "select * from tb_house_info where community_id in(".implode(",",$community_ids).") and entrust_type=2";
				$houses = $this->house_info_model->raw_query($sql);
			} else {
				$houses = [];
			}
			
			//查询地铁站
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}

			$ret['sch_coms'] = $com_schs;
			$ret['houses'] = $houses;
			$ret['code'] = 0;
			$ret['sql1'] = $sql;
			$ret['schools'] = $schools;
			echo json_encode($ret);
		}
		
		public function querySubwayRentHouses() {//查询购买客户
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$search_cond = $_REQUEST;
			$employee = $_SESSION['employee'];

			$where = [];
			//$where[] = "(invalid=0)";
			
			
			if($search_cond['subway_id'] != '') {
				$this->load->model('house/community_station_model');
				if($search_cond['distance'] == '') {
					$a = $this->community_station_model->query(array('subway_id'=>$search_cond['subway_id']));
				} else {
					$s = 'select * from tb_community_station where subway_id='.$search_cond['subway_id'].' and distance<'.$search_cond['distance'];
					$a = $this->community_station_model->raw_query($s);
				}
				
				$community_ids = [];
				for($i = 0; $i < count($a); $i++) {
					if(!in_array($a[$i]['community_id'], $community_ids)) {
						$community_ids[] = $a[$i]['community_id'];
					}
				}
				
				if(count($community_ids) > 0) {
					$c = implode(",",$community_ids);
					$where[] = '( community_id in ('.$c.'))';
				} else {
					$where[] = '(0=1)';
				}
			}
			
			$where[] = '(entrust_type=2)';
			if($search_cond['min_price'] != '') {
				$where[] = '(price>='.$search_cond['min_price'].')';	
			}
			
			if($search_cond['max_price'] != '') {
				$where[] = '(price<='.$search_cond['max_price'].')';
			}

			if($search_cond['area_min'] != '') {
				$where[] = '(area>='.$search_cond['area_min'].')';
			}
			
			if($search_cond['area_max'] != '') {
				$where[] = '(area<='.$search_cond['area_max'].')';
			}

			if($search_cond['room_min'] != '') {
				$where[] = '(room_count>='.$search_cond['room_min'].')';
			}
			
			if($search_cond['room_max'] != '') {
				$where[] = '(room_count<='.$search_cond['room_max'].')';
			}

			if($search_cond['room_count'] != '') {
				$where[] = '(room_count='.$search_cond['room_count'].')';
			}

			if(count($search_cond['orientation'])>0) {
				$or_like = [];
				for($i = 0; $i < count($search_cond['orientation']); $i++) {
					$or_like[] = "orientation like '%".$search_cond['orientation'][$i]."%'";
				}
				$where[] = "(".implode(" or ", $or_like).")";
			}

			if($search_cond['floor_type'] != '') {
				if($search_cond['floor_type'] == 0) {
					$where[] = '(floor<0)';
				} else if($search_cond['floor_type'] == 1) {
					$where[] = '(floor=1)';
				} else if($search_cond['floor_type'] == 2) {
					$where[] = '(top_floor=1)';
				}
			}

			if($search_cond['floor_min'] != '') {
				$where[] = '(floor>='.$search_cond['floor_min'].')';
			}
			
			if($search_cond['floor_max'] != '') {
				$where[] = '(floor<='.$search_cond['floor_max'].')';
			}

			if($search_cond['level'] != '') {
				$where[] = "(level='".$search_cond['level']."')";
			}

			if($search_cond['real_check'] != '') {
				$where[] = "(real_check=".$search_cond['real_check'].")";
			}

			if($search_cond['delegate_type'] != '') {
				$where[] = "(delegate_type=".$search_cond['delegate_type'].")";
			}

			if($search_cond['has_key'] != '') {
				$where[] = "(has_key=".$search_cond['has_key'].")";
			}

			if($search_cond['my_role'] != '') {
				if($search_cond['my_role'] == 1) {
					$where[] = "(add_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 2) {
					$where[] = "(maintain_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 3) {
					$where[] = "(key_employee_id=".$employee['employee_id'].")";
				} else if($search_cond['my_role'] == 4) {
					$where[] = "(prospect_employee_id=".$employee['employee_id'].")";
				}
			}

			if($search_cond['house_state'] != '') {
				$where[] = "(house_state=".$search_cond['house_state'].")";
			}
			
			if($search_cond['building_type'] != '') {
				$where[] = "(building_type=".$search_cond['building_type'].")";
			}
			
			if($search_cond['houseage_type'] != '') {
				$now = time();
				$t = $now - 3600*24*365*$search_cond['houseage_type'];
				$where[] = "(build_time>".$t.")";
			}
			
			if($search_cond['cert_full'] != '') {
				$where[] = "(cert_full=".$search_cond['cert_full'].")";
			}
			
			if($search_cond['info_complete'] != '') {
				$where[] = "(info_complete=".$search_cond['info_complete'].")";
			}
			
			if(!isset($search_cond['pi'])) {
				$search_cond['pi'] = 1;
			}
			
			if(!isset($search_cond['pc'])) {
				$search_cond['pc'] = 12;
			}
			
			if($search_cond['invalid'] != '') {
				if($employee['type'] == ADMIN_TYPE_C && $search_cond['invalid']==1) {//房源有【有效/无效】自己那个商圈所有的房源包括无效房源，其他大区房源不能查看无效房源
					$where[] = "(invalid=".$search_cond['invalid']." and area_id=".$employee['area_id'].")";
				} else  if($employee['type'] == ADMIN_TYPE_NONE && $employee['role'] == ROLE_DEP_AGENT){//独立经纪人
					$where[] = "(invalid=".$search_cond['invalid']." and maintain_employee_id!=0)";
				} else {
					$where[] = "(invalid=".$search_cond['invalid'].")";
				}
			}
			
			$pi = $search_cond['pi'];
			$pc = $search_cond['pc'];
			$start = ($pi-1)*$pc;
			$end = $pi*$pc;
			$limit = 'limit '.$start.','.$pc;
			$order_info = '';
			if($_REQUEST['order_name'] != '') {
				$order_info = ' order by '.$_REQUEST['order_name'].' '.$_REQUEST['order_type'];
			} 
			$this->load->model('houseinfo/house_info_model');
			if(count($where) > 0) {
				$sql = "select count(*) from tb_house_info where (".implode(" and ",$where).")";
			} else {
				$sql = "select count(*) from tb_house_info".$order_info;
			}

			$res = $this->house_info_model->raw_query($sql);
			$total_count = $res[0]['count(*)'];

			if(count($where) > 0) {
				$sql = "select * from tb_house_info where entrust_type=2 and (".implode(" and ",$where).")".$order_info.' '.$limit;
			} else {
				$sql = "select * from tb_house_info entrust_type=2 ".$order_info.' '.$limit;
			}
			
			$ret['total_count'] = $total_count;
			$ret['page_count'] = ceil(($total_count)/$pc);
			$ret['page_index'] = $pi;
			$ret['sql'] = $sql;
			$houses = $this->house_info_model->raw_query($sql);

			//查询房源距离地铁站信息
			$community_ids = [];
			for($i = 0; $i < count($houses); $i++) {
				$houses[$i]['stations'] = [];
				if(!in_array($houses[$i]['community_id'], $community_ids)) {
					$community_ids[] = $houses[$i]['community_id'];
				}
			}
			
			if(count($community_ids) > 0) {
				$this->load->model('house/community_station_model');
				$sql = "select * from tb_community_station where community_id in (".implode(",",$community_ids).")";
				$com_stats = $this->community_station_model->raw_query($sql);
				for($i = 0; $i < count($houses); $i++) {
					
					for($j = 0; $j < count($com_stats); $j++) {
						if($com_stats[$j]['community_id'] == $houses[$i]['community_id']) {
							$houses[$i]['stations'][] = $com_stats[$j];
						}
					}
				}
			}
			$ret['com_stats'] = $com_stats;
			
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}

		public function editHouseInfo() {
			$where['house_info_id'] = $_REQUEST['house_info_id'];
			
			$houseinfo = $_REQUEST;
			
			foreach($houseinfo as $key => $value) {
				if(gettype($houseinfo[$key]) == "object" || gettype($houseinfo[$key]) == "array") {
					$houseinfo[$key] = json_encode($value);
				}
			}
			$houseinfo['update_time'] = time();
			$this->load->model('houseinfo/house_info_model');
			
			$owner = $_REQUEST['owner'];
			if($owner['name'] != '' && $owner['mobile'] != '' && $houseinfo['area'] != '' && $houseinfo['area'] != 0
				&& $houseinfo['price'] != '' && $houseinfo['price'] != 0 && $houseinfo['orientation'] != '') {
				$houseinfo['info_complete'] = 1;
			} else {
				$houseinfo['info_complete'] = 0;
			}
			
			$houseinfo['house_info_id'] = $this->house_info_model->update($where,$houseinfo);
			$ret['code'] = 0;
			$ret['house_info'] = $houseinfo;
			echo json_encode($ret);
		}
		
		public function addHouseInfoes() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];
			$this->load->model('house/community_station_model');
			for($i = 0; $i < count($_REQUEST['house_infoes']); $i++) {
				$houseinfo = [];
				$hi = $_REQUEST['house_infoes'][$i];
				$houseinfo['add_employee_id'] = $employee['employee_id'];
				$houseinfo['house_id'] = $hi['house_id'];
				$houseinfo['entrust_type'] = $hi['entrust_type'];
				$houseinfo['update_time'] = time();
				$houseinfo['room_count'] = $hi['room_count'];
				$houseinfo['hall_count'] = $hi['hall_count'];
				$houseinfo['kitchen_count'] = $hi['kitchen_count'];
				$houseinfo['toilet_count'] = $hi['toilet_count'];
				$houseinfo['community_id'] = $hi['community_id'];
				
				$this->load->model('house/community_model');
				$where['community_id'] = $houseinfo['community_id'];
				$community = $this->community_model->query_one($where);
				$houseinfo['community_name'] = $community['name'];
				$houseinfo['ta_id'] = $community['ta_id'];
				$houseinfo['build_time'] = $community['build_time'];
				$houseinfo['has_school'] = $community['has_school'];
				
				$this->load->model('city/trade_area_model');
				$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$houseinfo['ta_id']));
				$houseinfo['ta_name'] = $trade_area['name'];
				
				$houseinfo['area_id'] = $hi['area_id'];
				$houseinfo['bb_id'] = $hi['bb_id'];
				$houseinfo['build_block'] = $hi['build_block'];
				$houseinfo['bu_id'] = $hi['bu_id'];
				$houseinfo['floor'] = $hi['floor'];
				$houseinfo['top_floor'] = $hi['top_floor'];
				$houseinfo['max_floor'] = $hi['max_floor'];
				$houseinfo['create_time'] = time();
				
				$this->load->model('user/employee_model');
				if($employee['employee_id'] == $hi['maintain_employee_id']) {//如果不是自己作为维护人，则要对方接收
					$houseinfo['maintain_employee_id'] = $hi['maintain_employee_id'];
					$maintain_employee = $this->employee_model->query_one(array('employee_id'=>$houseinfo['maintain_employee_id']));
					if($maintain_employee) {
						$houseinfo['maintain_employee_name'] = $maintain_employee['name'];
					}
				}

				$houseinfo['area'] = $hi['area'];
				$houseinfo['price'] = $hi['price'];
				$houseinfo['orientation'] = $hi['orientation'];
				$houseinfo['openhome_time'] = $hi['openhome_time'];
				$houseinfo['entrust_src1'] = $hi['entrust_src1'];
				$houseinfo['entrust_src2'] = $hi['entrust_src2'];
				$houseinfo['owner'] = json_encode($hi['owner']);
				$houseinfo['contacts'] = json_encode($hi['contacts']);
				
				$this->load->model('houseinfo/house_info_model');
				
				
				if($hi['owner']['name'] != '' && $hi['owner']['mobile'] != '' && $hi['area'] != '' && $hi['area'] != 0
					&& $hi['price'] != '' && $hi['price'] != 0 && $hi['orientation'] != '') {
					$houseinfo['info_complete'] = 1;
				}
				
				$houseinfo['house_info_id'] = $this->house_info_model->insert($houseinfo);
				
				//不是自己作为维护人，则需要发消息给对方
				$houseinfo['maintain_employee_id'] = 0;
				$houseinfo['maintain_employee_name'] = '';
				//获取地铁距离
				$this->load->model('house/community_school_model');
				$cs = $this->community_school_model->query_one(array('community_id'=>$houseinfo['community_id']));
				if($cs) {
					$houseinfo['ss_distance'] = $cs['distance'];
				}
				
				if($employee['employee_id'] != $hi['maintain_employee_id']) {
					$house_info_id = $houseinfo['house_info_id'];
					$to_employee_id = $hi['maintain_employee_id'];
					$this->load->model('user/message_model');
					
					$msg['from_employee_id'] = $employee['employee_id'];
					$msg['to_employee_id'] = $to_employee_id;
					$msg['type'] = 15;
					$msg['create_time'] = time();
					$msg['from_employee_headimg'] = $employee['headimg'];
					$msg['from_employee_name'] = $employee['name'];
					$msg['from_employee_id'] = $employee['employee_id'];
					$content['house_info_id'] = $houseinfo['house_info_id'];
					$content['time'] = time();
					$content['emloyee_id'] = $employee['employee_id'];
					$msg['content'] = json_encode($content);
					
					$this->message_model->insert($msg);
				}
			}
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function addHouseInfo() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				$ret['code'] = ERROR_NOT_LOGIN;
				echo json_encode($ret);
				return;
			}
			
			$employee = $_SESSION['employee'];

			$houseinfo['add_employee_id'] = $employee['employee_id'];
			$houseinfo['house_id'] = $_REQUEST['house_id'];
			$houseinfo['entrust_type'] = $_REQUEST['entrust_type'];
			$houseinfo['update_time'] = time();
			$houseinfo['room_count'] = $_REQUEST['room_count'];
			$houseinfo['hall_count'] = $_REQUEST['hall_count'];
			$houseinfo['kitchen_count'] = $_REQUEST['kitchen_count'];
			$houseinfo['toilet_count'] = $_REQUEST['toilet_count'];
			$houseinfo['community_id'] = $_REQUEST['community_id'];
			
			$this->load->model('house/community_model');
			$where['community_id'] = $houseinfo['community_id'];
			$community = $this->community_model->query_one($where);
			$houseinfo['community_name'] = $community['name'];
			$houseinfo['ta_id'] = $community['ta_id'];
			$houseinfo['build_time'] = $community['build_time'];
			$houseinfo['has_school'] = $community['has_school'];
			
			$this->load->model('city/trade_area_model');
			$trade_area = $this->trade_area_model->query_one(array('ta_id'=>$houseinfo['ta_id']));
			$houseinfo['ta_name'] = $trade_area['name'];
			
			$houseinfo['area_id'] = $_REQUEST['area_id'];
			$houseinfo['bb_id'] = $_REQUEST['bb_id'];
			$houseinfo['build_block'] = $_REQUEST['build_block'];
			$houseinfo['bu_id'] = $_REQUEST['bu_id'];
			$houseinfo['floor'] = $_REQUEST['floor'];
			$houseinfo['top_floor'] = $_REQUEST['top_floor'];
			$houseinfo['max_floor'] = $_REQUEST['max_floor'];
			$houseinfo['create_time'] = time();
			
			$this->load->model('user/employee_model');
			if($employee['employee_id'] == $_REQUEST['maintain_employee_id']) {//如果不是自己作为维护人，则要对方接收
				$houseinfo['maintain_employee_id'] = $_REQUEST['maintain_employee_id'];
				$maintain_employee = $this->employee_model->query_one(array('employee_id'=>$houseinfo['maintain_employee_id']));
				if($maintain_employee) {
					$houseinfo['maintain_employee_name'] = $maintain_employee['name'];
				}
			}

			$houseinfo['area'] = $_REQUEST['area'];
			$houseinfo['price'] = $_REQUEST['price'];
			$houseinfo['orientation'] = $_REQUEST['orientation'];
			$houseinfo['openhome_time'] = $_REQUEST['openhome_time'];
			$houseinfo['entrust_src1'] = $_REQUEST['entrust_src1'];
			$houseinfo['entrust_src2'] = $_REQUEST['entrust_src2'];
			$houseinfo['owner'] = json_encode($_REQUEST['owner']);
			$houseinfo['contacts'] = json_encode($_REQUEST['contacts']);
			
			
			$this->load->model('house/community_station_model');
			$cs = $this->community_station_model->query_one(array('community_id'=>$houseinfo['community_id']));
			if($cs) {
				$houseinfo['ss_distance'] = $cs['distance'];
			}
			
			$this->load->model('houseinfo/house_info_model');

			if($_REQUEST['owner']['name'] != '' && $_REQUEST['owner']['mobile'] != '' && $_REQUEST['area'] != '' && $_REQUEST['area'] != 0
				&& $_REQUEST['price'] != '' && $_REQUEST['price'] != 0 && $_REQUEST['orientation'] != '') {
				$houseinfo['info_complete'] = 1;
			}
			
			$houseinfo['house_info_id'] = $this->house_info_model->insert($houseinfo);
			
			//不是自己作为维护人，则需要发消息给对方
			$houseinfo['maintain_employee_id'] = 0;
			$houseinfo['maintain_employee_name'] = '';
			if($employee['employee_id'] != $_REQUEST['maintain_employee_id']) {
				$house_info_id = $houseinfo['house_info_id'];
				$to_employee_id = $_REQUEST['maintain_employee_id'];
				$this->load->model('user/message_model');
				
				$msg['from_employee_id'] = $employee['employee_id'];
				$msg['to_employee_id'] = $to_employee_id;
				$msg['type'] = 15;
				$msg['create_time'] = time();
				$msg['from_employee_headimg'] = $employee['headimg'];
				$msg['from_employee_name'] = $employee['name'];
				$msg['from_employee_id'] = $employee['employee_id'];
				$content['house_info_id'] = $houseinfo['house_info_id'];
				$content['time'] = time();
				$content['emloyee_id'] = $employee['employee_id'];
				$msg['content'] = json_encode($content);
				
				$this->message_model->insert($msg);
			}
			
			$ret['code'] = 0;
			$ret['house_info'] = $houseinfo;
			echo json_encode($ret);
		}

		public function queryTakeSeeHouses() {//P:price,A:area,C:count
			$this->load->model('houseinfo/house_info_model');
			$entrust_type = $_REQUEST['entrust_type'];
			$cond = [];
			$name = $_REQUEST['name'];
			$cond[] = 'entrust_type='.$entrust_type;
			if(isset($_REQUEST['min_price']) && $_REQUEST['min_price'] != '') {
				$cond[] = 'price >='.$_REQUEST['min_price'];
			}
			
			if(isset($_REQUEST['max_price']) && $_REQUEST['max_price'] != '') {
				$cond[] = 'price <='.$_REQUEST['max_price'];
			}
			
			if(isset($_REQUEST['min_area']) && $_REQUEST['min_area'] != '') {
				$cond[] = 'area >='.$_REQUEST['min_area'];
			}
			
			if(isset($_REQUEST['max_area']) && $_REQUEST['max_area'] != '') {
				$cond[] = 'area <='.$_REQUEST['max_area'];
			}
			
			if(isset($_REQUEST['min_room']) && $_REQUEST['min_room'] != '') {
				$cond[] = 'room_count >='.$_REQUEST['min_room'];
			}
			
			if(isset($_REQUEST['max_room']) && $_REQUEST['max_room'] != '') {
				$cond[] = 'room_count <='.$_REQUEST['max_room'];
			}
			
			if(isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
				$name = $_REQUEST['name'];
				$cond[] = "(house_info_id like '%".$name."%' or community_name like '%".$name."%')";
			}
			
			$sql = "select * from tb_house_info where (".implode(" and ",$cond).")";
			$houses = $this->house_info_model->raw_query($sql);
			
			$employee_ids = [];
			$this->load->model('user/employee_model');
			$wheres = [];
			for($i = 0; $i < count($houses); $i++) {
				$wheres[] = array('employee_id'=>$houses['maintain_employee_id']);
			}
			$ret['code'] = 0;
			$ret['houses'] = $houses;
			echo json_encode($ret);
		}
	}
?>
