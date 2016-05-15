<?php
	class Query extends CI_Model{
		//初始化方法,连接数据库
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
		//单表查询
		public function select_single_where($configs){
			$sql = 'select ';
			//返回的字段
			if(isset($configs['rets'])){
				$rets = $configs['rets'];
				foreach($rets as $ret){
					$sql .= $ret.',';
				}
				$sql = substr($sql, 0,-1);
			}else{
				$sql .= "*";
			}
			$table = $configs['table'];
			$sql .=' from `'.$table.'` ';
			
			if(isset($configs['conditions'])){
				$sql .= ' where ';
				$conditions = $configs['conditions'];
				foreach($conditions as $key=>$value){
					$sql .= $key.' = '."'".$value."'".' and ';
				}
				$sql = substr($sql, 0, -4);
			}

			if(isset($configs['sequence'])){
				$sql .=" order by ".$configs['sequence'];
			}

			$query = $this->db->query($sql);
			//返回结果数组
			return $query->result_array();
		}
		//多表查询
		public function select_mult_where($conditions){
			$sql = "select * from `order` left join `h_info`on `order`.h_id=`h_info`.h_id where ";
			foreach($conditions as $key=>$value){
				$sql .= "`order`.$key = '$value'";
			}
			$result = $this->db->query($sql);
			return $result->result_array();
		}
		//通过订单号查询订单详情：房间信息，菜品信息
		public function get_order_detail($o_id){
			$order_detail_data;
			//获取订单信息
			$order_sql = "select * from `order` where o_id = '$o_id'";
			$order_item = $this->db->query($order_sql)->row_array();
			if(empty($order_item))
				return false;
			$order_detail_data['order_item'] = $order_item;
			
			//获取房间信息
			$r_id = $order_item['r_id'];
			$room_sql = "select * from `r_info` where r_id = '$r_id'";
			$room_item = $this->db->query($room_sql)->row_array();
			$order_detail_data['room_item'] = $room_item;
			
			//获取菜品信息
			$foods_data = array();
			//将字符串序列化成数组
			$food_ids = explode("&",$order_item['f_id']);
			for($i = 0;$i < count($food_ids);$i++){
				$food_sql = "select * from `f_info` where f_id = '$food_ids[$i]'";
				$food_item = $this->db->query($food_sql)->row_array();
				if(!empty($food_item))
					$foods_data[$i] = $food_item; 
			}
			$order_detail_data['foods_data'] = $foods_data;
			return $order_detail_data;
		}
		public function get_user_like_hotel($u_id){
			$sql = "select h_id,eval_cat from `h_evaluation` where u_id = '$u_id' and eval_cat >=3";
			$hotels = $this->db->query($sql);
			return $hotels->result_array();
		}
		//根据好评率由高到低排序
		public function select_hotel_order_goodeval(){
			$sql = "select *,(`h_good_eval_num`/`h_eval_num`) as `result` FROM `h_info` order by `result` desc";
			$hotels = $this->db->query($sql)->result_array();
			return $hotels;
		}
		//根据销售量来由高到低排序
		public function select_hotel_order_salenum(){
			$sql = "select * from `h_info` order by `h_sale_num` desc";
			$hotels = $this->db->query($sql)->result_array();
			return $hotels;
		}
		//根据距离远近进行排序
		public function select_hotel_order_distance($x,$y){
			$sql = "select * from `h_info` where x>$x-1 and x<$x+1 and y<$y+1 and y>$y-1 order by abs(x-$x)+abs(y-$y)";
			$hotels = $this->db->query($sql)->result_array();
			return $hotels;
		}
	}
?>