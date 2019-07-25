<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class House_follow_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_follow_house';
			$this->primaryKey = 'follow_id'; 
		}
	}
?>
