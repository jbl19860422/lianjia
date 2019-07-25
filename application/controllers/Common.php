<?php
	require_once('ControllerBase.php');
	class Common extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function Common() {
			$view = $_REQUEST['v'];
			$this->load->view('common/'.$view);
		}
		
		public function get_qiniu_upload_token() {
			session_start();
			$qiniu_config['ak'] = QINIU_AK;
			$qiniu_config['sk'] = QINIU_SK;
			
			$this->load->library('qiniuauth', $qiniu_config);
			$randkey = null;
			$expires = 3600*24*960;
			$upload_token = $this->qiniuauth->uploadToken(QINIU_BUCKET, $randkey, $expires);
			$ret['uptoken'] = $upload_token;
			echo json_encode($ret);
		}
	}
?>
