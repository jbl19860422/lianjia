<?php
	class Dbbase_model extends CI_Model {
		protected $tableName = '';
		//protected $db = null;
		protected $primary_key = 'id';
		public function __construct($config = null) {
			parent::__construct();
			if(!$config) {
				$this->db = $this->load->database('default', true);  
			} else {
				/*
				$conf = array(
					'dsn'	=> '',
					'hostname' => 'localhost',
					'username' => 'root',
					'password' => 'jbl35270422',
					'port' 	   => 3306,
					'database' => 'tpzb',
					'dbdriver' => 'mysqli',
					'dbprefix' => '',
					'pconnect' => TRUE,
					'db_debug' => (ENVIRONMENT !== 'production'),
					'cache_on' => FALSE,
					'cachedir' => '',
					'char_set' => 'utf8',
					'dbcollat' => 'utf8_general_ci',
					'swap_pre' => '',
					'encrypt' => FALSE,
					'compress' => FALSE,
					'stricton' => FALSE,
					'failover' => array(),
					'save_queries' => TRUE
				);
				*/
				$this->db = $this->load->database($config, true);
			}
		}
		
		public function create_db($dbname) {
			$sql = "CREATE DATABASE IF NOT EXISTS ".$dbname." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			$ret = $this->db->query($sql);
			return $ret;
		}
		
		public function list_tables($dbname) {
			$sql = "SHOW TABLES FROM ".$dbname;
			$query = $this->db->query($sql);
			
			$tables = $query->result_array();
			
			return $tables;
		}

		public function dump_sql($dbname,$sql_file) {
			$this->db->query("USE ".$dbname);
			log_message('error', 'source='.$this->db->last_query());
			$this->db->query("source ".$sql_file.";");
			log_message('error', 'source='.$this->db->last_query());
		}
		
		public function insert($record,$intid=true) {
			$code = $this->db->insert($this->tableName, $record);
			if($code) {
				if($intid) {
					return $this->db->insert_id();
				} else {
					return true;
				}
			}
			return false;
		}
		
		public function remove($where) {
			$this->db->where($where);
	    return $this->db->delete($this->tableName);
		}
		
		public function update($where, $new) {
			$update_ret = $this->db->update($this->tableName, $new, $where);
			return $update_ret;
		}
		
		public function raw_query($sql) {
			$query = $this->db->query($sql);
			if($this->db->affected_rows() > 0){
				$records = $query->result_array();
				return $records;
			}
			return [];
		}
		
		public function query($where = null, $limit = null, $offset = null, $order = null) {
			if($order) {
				$this->db->order_by($order['field'], $order['mode']);
			}
			$query = $this->db->get_where($this->tableName, $where, $limit, $offset);
			if($this->db->affected_rows() > 0){
				$records = $query->result_array();
				return $records;
			}
			return [];
		}
		
		public function select_sum($where,$field) {
			$query = $this->db->select_sum($field)->get_where($this->tableName, $where);
			$result = $query->row_array();
			return $result;
		}
		
		public function query_one($where) {
			$query = $this->db->get_where($this->tableName, $where);
			if($this->db->affected_rows() > 0) {
				$record = $query->row_array();
				return $record;
			}
			return null;
		}
		
		public function or_query($wheres) {
			$first = true;
			if(count($wheres) <= 0) {
				return [];
			}
			$where_strs = [];
			foreach($wheres as $where) {
				$strs = [];
				foreach($where as $key=>$value) {
					$str = $key.'="'.$value.'"';
					$strs[] = $str;
				}
				
				$tmp = implode(" and ",$strs);
				$where_strs[] = '('.$tmp.')';
			}
			
			$query_str = implode(" or ", $where_strs);
			//echo $query_str;
			//return;
			$this->db->where($query_str);
			$query = $this->db->get($this->tableName);
			$records = [];
			$records = $query->result_array();
			//echo $this->db->last_query();
			return $records;
		}
		
		public function page_query($where, $page_index, $num_per_page,$order = null) {
			if(!$where) {
				$where = [];
			}
			$this->db->where($where);
			if($order) {
				$this->db->order_by($order['field'], $order['mode']);
			}
			$total_count = $this->db->count_all_results($this->tableName);
			$limit = $num_per_page;
			if($page_index < 1) {
				$page_index = 1;
			}
			$offset = ($page_index-1)*$num_per_page;
			$result['total_count'] = $total_count;
			$result['page_count'] = ceil(($total_count)/$num_per_page);
			$result['page_index'] = $page_index;
			if($order) {
				$query= $this->db->where($where)->limit($limit, $offset)->order_by($order['field'], $order['mode'])->get($this->tableName);
			} else {
				$query= $this->db->where($where)->limit($limit, $offset)->get($this->tableName);
			}
			$result['data'] = $query->result_array();
			return $result;
		}
		
		public function in_page_query($where, $in, $page_index, $num_per_page) {
			$this->db->where($where)->where_in($in['key'],$in['values']);
			$total_count = $this->db->count_all_results($this->tableName);
			$limit = $num_per_page;
			if($page_index < 1) {
				$page_index = 1;
			}
			$offset = ($page_index-1)*$num_per_page;
			$result['total_count'] = $total_count;
			$result['page_count'] = ceil(($total_count)/$num_per_page);
			$result['page_index'] = $page_index;
			$query= $this->db->where($where)->where_in($in['key'],$in['values'])->limit($limit, $offset)->get($this->tableName);
			$result['data'] = $query->result_array();
			//echo $this->db->last_query();
			return $result;
		}
		
		public function like_query($where, $like) {
			$query= $this->db->where($where)->like($like['key'],$like['value'],'both')->get($this->tableName);
			return $query->result_array();
		}
		
		public function like_page_query($where, $like, $page_index, $num_per_page) {
			$this->db->where($where)->like($like['key'],$like['value'],'both');
			$total_count = $this->db->count_all_results($this->tableName);
			$limit = $num_per_page;
			if($page_index < 1) {
				$page_index = 1;
			}
			$offset = ($page_index-1)*$num_per_page;
			$result['total_count'] = $total_count;
			$result['page_count'] = ceil(($total_count)/$num_per_page);
			$result['page_index'] = $page_index;
			$query= $this->db->where($where)->like($like['key'],$like['value'],'both')->limit($limit, $offset)->get($this->tableName);
			$result['data'] = $query->result_array();
			//echo json_encode($like);
			//echo $this->db->last_query();
			return $result;
		}

		public function or_like_query($where, $likes, $limit = null, $offset = null) {
			$first = true;
			$this->db->where($where);
			foreach($likes as $like) {
				if($first) {
					$this->db->like($like['key'], $like['value']);
					$first = false;
				} else {
					$this->db->or_like($like['key'], $like['value']);
				}
			}

			if($limit) {
				$this->db->limit($limit);
			}
			
			if($offset) {
				$this->db->offset($offset);
			}
			$query = $this->db->get($this->tableName);
			echo $this->db->last_query();
			$result = $query->result_array();
			return $result;
		}
		
		public function or_like_page_query($like, $page_index, $num_per_page) {
			$first = true;
			foreach($like as $key => $value) {
				if($first) {
					$this->db->like($key, $value);
					$first = false;
				} else {
					$this->db->or_like($key, $value);
				}
			}
			$total_count = $this->db->count_all_results($this->tableName);
			$limit = $num_per_page;
			$this->db->limit($limit);
			$offset = ($page_index-1)*$num_per_page;
			$this->db->offset($offset);
			$result['total_count'] = $total_count;
			$result['page_index'] = $page_index;
			$result['page_count'] = $total_count/$num_per_page + 1;
			$result['data'] = $this->db->get($this->tableName);
			return $result;
		}
	}
?>
