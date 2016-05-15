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
			$this->load->model('query');
			$this->init_similiar_table();
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
			$result = $this->get_user_like_hotel($user_id);
			$self_like_hotels = $result['hotel_id'];
			$hotels_eval_cat = $result['hotel_eval_cat'];
			//
			//获取某用户曾经消费过得所有酒店
			$self_hotels = $this->getSelfEval($user_id);
			//获取所有酒店的信息；
			$all_hotels = $this->get_all_hotel_ids();
			$other_hotels = array_diff($all_hotels, $self_hotels);
			//记录每个酒店对应的评价指数
			$hotel_recommend_list = array();
			for($i = 0;$i < count($self_like_hotels);$i++){
				foreach($other_hotels as $key=>$value){
					$similarity = $this->get_similarity($self_like_hotels[$i],$value);
					$recommend = $similarity * $hotels_eval_cat[$self_like_hotels[$i]];
						if(isset($hotel_recommend_list["$value"])){
							if($hotel_recommend_list["$value"] < $recommend)
								$hotel_recommend_list["$value"] = $recommend;
						}else{
							$hotel_recommend_list["$value"] = $recommend;
						}
				}
			}
			//通过排序，只取前K个酒店推荐
			arsort($hotel_recommend_list);
		    return array_slice($hotel_recommend_list, 0, K,true);
		}
		//计算两个酒店的相似度
		private function get_similarity($first_hotel,$last_hotel){
			global $similiar_table;
			$total_first_hotel = 0;
			$total_last_hotel = 0;
			foreach($similiar_table["$first_hotel"] as $key=>$value){
				$total_first_hotel += $value;
			}
			foreach($similiar_table["$last_hotel"] as $key=>$value){
				$total_last_hotel += $value;
			}
			$result = round($similiar_table["$first_hotel"]["$last_hotel"]/(sqrt($total_last_hotel*$total_first_hotel)),4);
			return $result;
		}
		//得到自己评价过的酒店
		public function getSelfEval($u_id){
			$sql = "select h_id from h_evaluation where u_id = '$u_id'";
			$query = $this->db->query($sql);
			//转换为结果数组
			$objects = $query->result_array();
			$result = array();
			$i = 0;
			foreach($objects as $item){
				$result[$i] = $item['h_id'];
				$i++;
			}
			return $result;
		}

		//建立酒店之间的相似度矩阵
		private function init_similiar_table(){
			global $similiar_table;
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
				$like_hotels = $this->get_user_like_hotel($id)['hotel_id'];
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
			$hotel_id = array();
			$hotel_eval_cat = array();
			foreach($hotels as $like_hotel){
					$hotel_id[$i] = $like_hotel['h_id'];
					$h_id = $like_hotel['h_id'];
					$hotel_eval_cat[$h_id] = $like_hotel['eval_cat'];
					$i++;
			}
			$result['hotel_id'] = $hotel_id;
			$result['hotel_eval_cat'] = $hotel_eval_cat;
			return $result;		
		}
	}
?>