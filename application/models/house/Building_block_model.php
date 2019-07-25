<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class Building_block_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_building_block';
			$this->primaryKey = 'bb_id'; 
		}
	}
?>
