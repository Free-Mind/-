<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	//基数K：只选取与某酒店相似的前K个酒店
	define('K',2);
	class ItemCF extends CI_Controller{
		//二维数组，用来储存用户对酒店的评价
		private $user_eval = array();
		//酒店相似度矩阵:横轴和纵轴分别是酒店ID
		private $similiar_table = array();
		//每位用户喜爱的酒店列表；
		private $user_hotels = array();
		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->model('query');
			$this->init_similiar_table();
		}
		public function test(){

		} 
		/*
			推荐策略：
			根据用户过去的评价情况，挑选出用户喜欢的酒店hotel1
			再根据基于物品的协同过滤算法得出与这些酒店相似的其他酒店hotel2，
			将hotel2推荐给用户
			这里的hotel2默认会有两家酒店，通过基数K可以控制hotel2的数量
		*/
		public function recommend($user_id){
			//根据用户自己喜欢的酒店,推荐与该酒店相似的其他酒店
			//获取某用户喜欢的酒店
			$self_hotels = $this->get_user_like_hotel($user_id);
			//获取所有酒店的信息；
			$all_hotels = $this->get_all_hotel_ids();
			var_dump($self_hotels);
			var_dump($all_hotels);
			return;
			$other_hotels = array_diff_assoc($all_hotels, $self_hotels);
			//记录每个酒店对应的评价指数
			$hotel_recommend = array();
			for($i = 0;$i < count($hotels);$i++){
				foreach($other_hotels as $key=>$value){
					$similarity = $this->get_similarity($hotels[$i],$value);
						if(isset($hotel_recommend["$value"])){
							if($hotel_recommend["$value"] < $similarity)
								$hotel_recommend["$value"] = $similarity;
						}else{
							$hotel_recommend["$value"] = $similarity;
						}
				}
			}
			var_dump($hotel_recommend);

		}
		//计算两个酒店的相似度
		private function get_similarity($first_hotel,$last_hotel){
			$total_first_hotel = 0;
			$total_last_hotel = 0;
			foreach($similiar_table["$first_hotel"] as $key=>$value){
				$total_first_hotel += $value;
			}
			foreach($similiar_table["$total_last_hotel"] as $key=>$value){
				$total_last_hotel += $value;
			}
			$result = round($similiar_table["$total_first_hotel"]["$total_last_hotel"]/(sqrt($total_last_hotel*$total_first_hotel)),4);
			return $result;
		}
		//进行相似度计算
		public function getCF(){
			$self_hotel = $this->getSelfEval();
			$other_hotel = $this->getOtherEval();
			foreach($self_hotel as $self_hotel_key=>$self_hotel_value){
				$target_hotel = array();
				foreach($other_hotel as $other_hotel_key=>$other_hotel_value){
					//得到需要进行相似度计算的酒店
					if($self_hotel_key == $other_hotel_key){
						$target_hotel = $other_hotel_value;
						continue;
					}
					//把该酒店和其他酒店进行相似度计算
					foreach($target_hotel as $target_hotel_key=>$target_hotel_value){
						foreach($other_hotel_value as $other_hotel_value_key=>$other_hotel_value_value){
							if($target_hotel_key == $other_hotel_value_key){

							}
						}
					}
				}
			}
		}

		//得到其他用户对酒店的评价
		public function getOtherEval(){
			global $user_eval;
			for($i = 0;$i < 10;$i++){
				$base_name = "hotle";
				$hotel_name = $base_name.$i;
				$sql = "select u_id,eval_cat from h_evaluation where h_id
					= '$hotel_name' and u_id != '18366117612'";
			//	echo $sql."</br>";
				$query = $this->db->query($sql);
				//返回结果数组
				$objects = $query->result_array();
				$line = array();
				for($j = 0;$j < count($objects);$j++){
					$user = $objects[$j]['u_id'];
					$grades = $objects[$j]['eval_cat'];
					$line[$user] = $grades;
				}
				$user_eval["$hotel_name"] = $line;
			}		
		}
		//得到自己评价过得酒店
		public function getSelfEval(){
		//	$self_id = $_SESSION['id'];
			$self_id = "18366117612";
			$sql = "select h_id,eval_cat from h_evaluation where u_id = '$self_id'";
			$query = $this->db->query($sql);
			//转换为结果数组
			$objects = $query->result();
			$result = array();
			for($i = 0;$i < count($objects);$i++){
				$key = $objects[$i]['h_id'];
				$grades = $objects[$i]['eval_cat'];
				$result["$key"] = $grades;
			}
			return $result;
		}

		//建立酒店之间的相似度矩阵
		private function init_similiar_table(){
			//获取所有酒店的ID
			$i = 0;
			$hotel_ids = $this->get_all_hotel_ids();
			//初始化酒店相似度矩阵，初始值为0
			for($m = 0;$m < count($hotel_ids);$m++){
				for($j = 0;$j < count($hotel_ids);$j++){
					$signle_similiar_table["$hotel_ids[$j]"] = 0;
				}
				$similiar_table["$hotel_ids[$m]"] = $signle_similiar_table;
			}
			/**
			建立酒店-用户反查表:存储每一位用户喜欢的酒店
			二维数组：x:用户ID Y：酒店ID
			*/
			$user_ids = $this->get_all_user_ids();	
			foreach($user_ids as $user_id){
				//获取用户喜欢的酒店ID
				$id = $user_id['telphone'];
				$like_hotels = $this->get_user_like_hotel($id);
				$user_hotels["$id"] = $like_hotels;
				//根据用户喜爱的酒店，更新酒店相似度矩阵
				for($i = 0;$i < count($like_hotels);$i++){
					for($j = $i+1; $j < count($like_hotels);$j++){
						$similiar_table["$like_hotels[$i]"]["$like_hotels[$j]"]++;
						$similiar_table["$like_hotels[$j]"]["$like_hotels[$i]"]++;
					}
				}
			}
			
		}
		private function get_all_hotel_ids(){
			$configs['table'] = 'h_info';
			$rets['h_id'] = 'h_id';
			$configs['rets'] = $rets;
			$hotels = $this->query->select_single_where($configs);
			$i = 0;
			$hotel_ids = array();
			foreach($hotels as $hotel){
				$hotel_ids[$i] = $hotel['h_id'];
				$i++;
			}
			return $hotel_ids;
		}
		private function get_all_user_ids(){
			$configs['table'] = 'user';
			$rets['telphone'] = 'telphone';
			$configs['rets'] = $rets;
			$users = $this->query->select_single_where($configs);
			return $users;
		}
		private function get_user_like_hotel($user_id){
			$hotels = $this->query->get_user_like_hotel($user_id);
			$i = 0;
			$single_user_hotel = array();
			foreach($hotels as $like_hotel){
					$single_user_hotel[$i] = $like_hotel['h_id'];
					$i++;
			}
			//返回一维索引数组
			return $single_user_hotel;		
		}
	}
?>