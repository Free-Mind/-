<?php
	class Insert extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
		//插入数据
		public function insert($configs){
			//表名
			$table = $configs['table'];
			//列名
			$cols = $configs['cols'];
			//数据
			$datas = $configs['datas'];
			$sql = "insert into `".$table."` ( ";
			foreach($cols as $col){
				$sql .= "`$col`,";
			}
			$sql = substr($sql,0,-1);
			$sql .= " ) values (";
			foreach($datas as $data){
				$sql .= "'$data',";
			}
			$sql = substr($sql,0,-1);
			$sql .= ")";
		//	echo $sql;
			$ret = $this->db->query($sql);
			return $ret;
		}
	}

?>
