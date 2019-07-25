<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class House_info_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_house_info';
			$this->primaryKey = 'house_info_id'; 
		}
	}
?>
