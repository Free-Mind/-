<?php
	Class Update extends CI_Model{

		public function __conctruct(){
			parent::__conctruct();
			$this->load->database();
		}

		public function update_where($configs){
			$table = $configs['table'];
			$conditions = $configs['conditions'];
			$targets = $configs['targets'];
			$sql ="update `$table` set ";
			foreach($targets as $key=>$value){
				$sql .= "`$key`='$value',";
			}
			$sql = substr($sql, 0,-1);
			$sql .= " where ";
			foreach($conditions as $key=>$value){
				$sql .= "`$key`='$value' and ";
			}
			$sql = substr($sql, 0,-4);
		//	echo $sql;
			 $ret = $this->db->query($sql);
			 return $ret;
		}
	}
?>