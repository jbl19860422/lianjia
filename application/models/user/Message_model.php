<?php
	require_once(dirname(__file__)."/../Dbbase_model.php");
	class Message_model extends Dbbase_model {
		public function __construct($config = null) {
			parent::__construct($config);
			$this->tableName = 'tb_message';
			$this->primaryKey = 'msg_id'; 
		}
	}
?>
