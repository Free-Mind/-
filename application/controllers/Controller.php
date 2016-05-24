<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//基数K：只选取与某酒店相似的前K个酒店
define('K',2);
class Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	private $data = array();
	//二维数组，用来储存用户对酒店的评价
	private $user_eval = array();
	//酒店相似度矩阵:横轴和纵轴分别是酒店ID
	private $similiar_table = array();
	//每位用户喜爱的酒店列表；
	private $user_hotels = array();

	public function __construct(){

		global $data;
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('query');
		$this->load->model('insert');
		$this->load->model('update');
		$base_url = base_url();
		$path['js'] = $base_url.$this->config->item('js_path'); 
		$path['css'] = $base_url.$this->config->item('css_path');
		$path['image'] = $base_url.$this->config->item('image_path');
		$data['path'] = $path;
		$data['base_url'] = $base_url;
		$this->init_similiar_table();
	}

	//载入首页(默认酒店的排序顺序为按照好评率由高到低排序)
	public function index($sort_cat = 1)
	{
		global $data;
		//载入首页需要准备的数据
		$hotel_data = $this->prepare_index_data($sort_cat);
		// if(isset($_SESSION['x']) && isset($_SESSION['y'])){
		// 	$i = 0;
		// 	foreach($hotel_data as $hotel_item){
		// 		$x = $hotel_item['x'];
		// 		$y = $hotel_item['y'];
		// 		$distance = sqrt(pow($x-$_SESSION['x'],2)+pow($y-$_SESSION['y'],2));
		// 		$hotel_item['distance'] = $distance * 111;
		// 		$hotel_data[$i] = $hotel_item;
		// 		$i++;
		// 	}
		// }
		$data['hotel_data'] = $hotel_data;
		if(isset($_SESSION['id'])){
			$recommend_hotel = $this->recommend($_SESSION['id']);
			$data['recommend_hotel'] = $recommend_hotel;
			if(isset($_SESSION['x']) && isset($_SESSION['y'])){
			$i = 0;
			foreach($recommend_hotel as $hotel_item){
				$x = $hotel_item['x'];
				$y = $hotel_item['y'];
				$distance = sqrt(pow($x-$_SESSION['x'],2)+pow($y-$_SESSION['y'],2));
				$hotel_item['distance'] = $distance * 111;
				$hotel_data[$i] = $hotel_item;
				$i++;
			}
		}
		}
	//	var_dump($hotel_data);
		$this->load->view('index',$data);
	}

	//载入酒店详情页面
	public function detail($hotel_id){
		global $data;
		//载入详情页面准备数据
		$detail_data = $this->get_detail_data($hotel_id);
		$data['detail_data'] = $detail_data;
 		$this->load->view('detail',$data);
	}

	//跳转登录界面
	public function login()
	{
		global $data;
		$this->load->view('login',$data);
	}
	
	public function handle_position(){
		if(isset($_POST['x']) && isset($_POST['y'])){
			$_SESSION['x'] = $_POST['x'];
			$_SESSION['y'] = $_POST['y'];
			echo "success";
		}else{
			echo "false";
		}
	}
	public function handle_login(){
		$conditions['telphone'] = htmlspecialchars($_POST['telphone']);
		$conditions['password'] = htmlspecialchars($_POST['password']);
		$configs['table'] = "user";
		$configs['conditions'] = $conditions;
		$datas = $this->query->select_single_where($configs);
		if(isset($_POST['x']) && isset($_POST['y'])){
			$_SESSION['x'] = htmlspecialchars($_POST['x']);
			$_SESSION['y'] = htmlspecialchars($_POST['y']);
		}
		if(!empty($datas)){
			foreach($datas as $data){
				$_SESSION['id'] = $data['telphone'];
				echo "Success";
			}
		}else{
			echo "Fail";
		}
	}
	
	//处理订单
	public function handle_order(){
		if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
			$foods_id = '';
			$total_price = 0;
			$time = '';
			$hotel_id = '';
			$room_id = '';
			$o_id = '';
			if(isset($_POST['foods_id']))
				$foods_id = htmlspecialchars($_POST['foods_id']);
			if(isset($_POST['total_price']))
				$total_price = htmlspecialchars($_POST['total_price']);
			if(isset($_POST['time']))
				$time = htmlspecialchars($_POST['time']);
			if(isset($_POST['hotel_id']))
				$hotel_id = htmlspecialchars($_POST['hotel_id']);
			if(isset($_POST['room_id']))
				$room_id = htmlspecialchars($_POST['room_id']);
			
			if(isset($_POST['order_id']) && !empty($_POST['order_id'])){
				$o_id = htmlspecialchars($_POST['order_id']);
				//本次请求为修改订单
				$update_targets = array();
				$update_order_conditions['o_id'] = $o_id;
				$update_order_configs['conditions'] = $update_order_conditions;
				$update_order_configs['table'] = 'order';
				if(!empty($foods_id)){
					$update_targets['f_id'] = $foods_id;
				}else if(!empty($room_id)){
					$update_targets['r_id'] = $room_id;
				}
				$update_order_configs['targets'] = $update_targets;
				$this->update->update_where($update_order_configs);
			}else{
				//本次请求为新增订单
				$user_id = $_SESSION['id'];
				$o_id = 'order'.time().rand(1,100);
				$status = 1;
				$configs['table'] = "order";
				$cols = ['o_id','u_id','h_id','f_id','r_id','time','status'];
				$configs['cols'] = $cols;
				$datas = [$o_id,$user_id,$hotel_id,$foods_id,$room_id,$time,$status];
				$configs['datas'] = $datas;
				$this->insert->insert($configs);
			}
			//修改该房间的状态
			if(!empty($room_id)){
				$update_conditions['r_id'] = $room_id;
				$update_conditions['r_hotel'] = $hotel_id;
				$update_configs['conditions'] = $update_conditions; 
				$update_configs['table'] = "r_info";
				$targets['r_status'] = 0;
				$update_configs['targets'] = $targets;
				$this->update->update_where($update_configs);
			}
			echo "success";
		}else{
			echo "fail";
		}
	}

	//载入修改订单页面
	public function modify_order($o_id){
		global $data;
		//为载入修改页准备数据
		$hotel_id = '';
		$order_configs['table'] = 'order';
		$order_conditions['o_id'] = $o_id;
		$order_configs['conditions'] = $order_conditions;
		$orders = $this->query->select_single_where($order_configs);
		foreach($orders as $order){
			if(!empty($order['f_id']))
				$data['food_ordered'] = 1;
			if(!empty($order['r_id']))
				$data['room_ordered'] = 1;
			$hotel_id = $order['h_id'];
		}

		//获取酒店信息
		$hotel_configs['table'] = 'h_info';
		$hotel_conditions['h_id'] = $hotel_id;
		$hotel_configs['conditions'] = $hotel_conditions;
		$hotel_detail = $this->get_detail_data($hotel_id);

		$data['detail_data'] = $hotel_detail;
		$data['order_id'] = $o_id;
		$this->load->view('detail',$data);

	}
	//载入个人中心页面
	public function account(){
		global $data;
		//为载入个人中心页面准备数据
		if(isset($_SESSION['id'])){
			$order_data = $this->get_order_data();
			$data['order_data'] = $order_data;
			$this->load->view("account",$data);
		}else{
			redirect("./controller/login");
		}
		
	}

	//载入订单详情页面
	public function order_detail($order_id){
		global $data;
		//为载入订单详情页面准备数据
		$order_detail = $this->get_order_detail($order_id);
		$data['order_detail'] = $order_detail;
	//	print_r($order_detail);
		$this->load->view("order",$data);	
	}
	private function prepare_index_data($sort_cat){
		/**
		酒店信息：
			酒店图片url，
			酒店名称
			酒店位置
			酒店介绍
			酒店距离
			按照好评率由高到低排序
		*/
		$hotel_data = array();
		switch($sort_cat){
			case 1:
				$hotel_data = $this->query->select_hotel_order_goodeval($_SESSION['x'],$_SESSION['y']);
				break;
			case 2:
				$hotel_data = $this->query->select_hotel_order_distance($_SESSION['x'],$_SESSION['y']);
				break;
			case 3:
				$hotel_data = $this->query->select_hotel_order_salenum($_SESSION['x'],$_SESSION['y']);
				break;
		}
		return $hotel_data;
	}
	private function get_detail_data($hotel_id){
		//查询酒店基本信息
		$configs['table'] = 'h_info';
		$conditions['h_id'] = $hotel_id;
		$configs['conditions'] = $conditions;
		$hotel_details = $this->query->select_single_where($configs);
		foreach($hotel_details as $item)
			$hotel_detail = $item;
		
		//查询酒店照片
		$pic_configs['table'] = 'h_pic';
		$pic_conditions['h_id'] = $hotel_id; 
		$pic_configs['conditions'] = $pic_conditions;
		$pic_rets[0] = 'p_url';
		$pic_configs['rets'] = $pic_rets;
		$hotel_pics = $this->query->select_single_where($pic_configs);

		//查询酒店房间信息
		$room_configs['table'] = 'r_info';
		$room_conditions['r_hotel'] = $hotel_id;
		$room_configs['conditions'] = $room_conditions;
		$hotel_rooms = $this->query->select_single_where($room_configs);

		//查询酒店菜品信息
		$food_configs['table'] = 'f_info';
		$food_conditions['f_hotel'] = $hotel_id;
		$food_configs['conditions'] = $food_conditions;
		$hotel_foods = $this->query->select_single_where($food_configs);

		//查询酒店评价详情
		$eval_configs['table'] = 'h_evaluation';
		$eval_conditions['h_id'] = $hotel_id;
		$eval_configs['conditions'] = $eval_conditions;
		$hotel_eval = $this->query->select_single_where($eval_configs);

		$hotel['hotel_detail'] = $hotel_detail;
		$hotel['hotel_pics'] = $hotel_pics;
		$hotel['hotel_rooms'] = $hotel_rooms;
		$hotel['hotel_foods'] = $hotel_foods;

		return $hotel;
	}

	//获取用户当前的所有订单以及对应酒店的信息
	private function get_order_data(){
		$conditions['u_id'] = $_SESSION['id'];
		$result = $this->query->select_mult_where($conditions);
		return $result;
	}
	//获取用户某个订单的详情
	private function get_order_detail($o_id){
		$order_detail_data = $this->query->get_order_detail($o_id);
		return $order_detail_data;
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
	    $hotels_id = array_slice($hotel_recommend_list, 0, K,true);
	    $top_K_recommend = array();
	    $j = 0;
	    foreach($hotels_id as $key=>$value){
	    	$top_K_recommend[$j] = $this->get_hotel_info_by_id($key);
	    	$j++;
	    }
	    return $top_K_recommend;
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
	private function get_hotel_info_by_id($h_id){
		$configs['table'] = 'h_info';
		$conditions['h_id'] = $h_id;
		$configs['conditions'] = $conditions;
		$hotels = $this->query->select_single_where($configs);
		foreach($hotels as $item){
			return $item;
		}
	}
}
