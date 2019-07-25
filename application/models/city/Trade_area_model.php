<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class Trade_area_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_trade_area';
			$this->primaryKey = 'ta_id'; 
		}
	}
?>
