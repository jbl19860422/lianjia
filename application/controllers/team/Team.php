<?php
	require_once(dirname(__file__).'/../ControllerBase.php');
	class Team extends ControllerBase {
		public function __construct() {
			parent::__construct();
		}
		
		public function team_page() {
			$this->load->view('team/team_page.php');
		}
	}
?>
