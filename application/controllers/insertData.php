<?php
class InsertData extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//插入测试数据
	public function insertData(){
		// $telphones = array("18366117613",
		// 					"18366117614",
		// 					"18366117615",
		// 					"18366117616",
		// 					"18366117617");
		// $hotels = array("",
		// 				);
		// for($i = 0;$i<5;$i++){
		// 	$base_hotel = "hotel";
			
		// 	for($j = 0;$j<10;$j++){
		// 		$grades = rand(1,5);
		// 		$random = rand(1,10000);
		// 		$pk_eval = time().$random;
		// 		$hotelNum = $base_hotel.$j;
		// 		$sql = "INSERT INTO `hotel`.`h_evaluation` 
		// 			(`pk_eval_h`, `content`, `h_id`, `eval_cat`, `u_id`) 
		// 			VALUES ('$pk_eval', '', '$hotelNum', '$grades', '$telphones[$i]')";
		// 		$this->db->query($sql);
		// 	}
		// }

				$pk_eval = time().rand(1,10000);
				$sql = "INSERT INTO `hotel`.`h_evaluation` 
					(`pk_eval_h`, `content`, `h_id`, `eval_cat`, `u_id`) 
					VALUES ('$pk_eval', '', '', '', '18366117612')";
				$this->db->query($sql);

	}
	//插入酒店信息
	public function insertHotelData(){
		$base_hotel = "hotel";
		for($i = 0;$i<10;$i++){
			$hotelNum = $base_hotel.$i;
			$hotel_name = "豪客来牛排";
			$hotel_desc = "正宗牛排，毕业季大优惠";
			$hotel_address = "舜华路1500号";
			$hotel_eval_num = rand(1,100);
			$sql = "INSERT INTO `hotel`.`h_info` 
			(`h_id`, `h_name`, `h_address`, `h_desc`, `h_eval_num`, `x`, `y`) 
			VALUES ('$hotelNum', '$hotel_name', '$hotel_address', '$hotel_desc', '$hotel_eval_num', '0', '0')";
			$this->db->query($sql);
		}
	}
	//插入用户信息
	private function insertUserData(){
		$telphones = array("18366117613",
							"18366117614",
							"18366117615",
							"18366117616",
							"18366117617");
		for($i=0;$i<5;$i++){
			$sql = "INSERT INTO `hotel`.`user`
			 (`telphone`, `password`) 
			 VALUES ('$telphones[$i]', '1');";
			 $this->db->query($sql);
		}
	}
	public function update_position(){
		//x=36,y=117
		$base_hotel = 'hotel';
		for($i = 0;$i < 10;$i++){
			$hotel = $base_hotel.$i;
			$x = round(rand(3500,3700)/100,2);
			$y = round(rand(11600,11800)/100,2);
			$sql = "update `hotel`.`h_info` SET `x` = $x,`y` = $y WHERE `h_info`.`h_id` = '$hotel';";
			$this->db->query($sql);
		}
		

	}
}
?>