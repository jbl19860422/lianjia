<?php
	require_once('ControllerBase.php');
	class Contract extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function contract_list_page() {
			$this->load->view('contract/contract_list_page');
		}
	}
?>
