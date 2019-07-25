<?php
	require_once('ControllerBase.php');
	class Msg extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function verify_detail_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$data['employee'] = $employee;
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);

			$msg_id = $_REQUEST['msg_id'];
			$this->load->model('user/message_model');
			$data['message'] = $this->message_model->query_one(array('msg_id'=>$msg_id));
			$this->load->view('msg/verify_detail_page', $data);
		}
		
		public function apply_follow_img_page() {
			session_start();
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			$data['employee'] = $employee;
			$data['messages'] = $this->queryMsgs($_SESSION['employee']);

			$msg_id = $_REQUEST['msg_id'];
			$this->load->model('user/message_model');
			$data['message'] = $this->message_model->query_one(array('msg_id'=>$msg_id));
			$this->load->view('msg/apply_follow_img_page', $data);
		}
		
		public function setMsgStatus() {
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			
			$msg_id = $_REQUEST['msg_id'];
			$this->load->model('user/message_model');
			$msg['status'] = $_REQUEST['status'];
			$this->message_model->update(array('msg_id'=>$msg_id), $msg);
			$ret['code'] = 0;
			echo json_encode($ret);
		}
		
		public function deleteMsg() {
			if(!isset($_SESSION['employee'])) {
				header("location: user/login_page");
				return;
			}
			$employee = $_SESSION['employee'];
			
			$msg_id = $_REQUEST['msg_id'];
			$this->load->model('user/message_model');

			$this->message_model->remove(array('msg_id'=>$msg_id));
			$ret['code'] = 0;
			echo json_encode($ret);
		}
	}
?>
