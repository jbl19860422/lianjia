<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class Guest_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_guest';
			$this->primaryKey = 'guest_id'; 
		}
	}
?>
