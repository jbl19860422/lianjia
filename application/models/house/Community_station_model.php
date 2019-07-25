<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class Community_station_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_community_station';
			$this->primaryKey = 'id'; 
		}
	}
?>
