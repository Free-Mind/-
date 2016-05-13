<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	}

	//载入首页
	public function index()
	{
		global $data;
		//载入首页需要准备的数据
		$hotel_data = $this->prepare_index_data();
		$data['hotel_data'] = $hotel_data;
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
	
	public function handle_login(){
		$conditions['telphone'] = htmlspecialchars($_POST['telphone']);
		$conditions['password'] = htmlspecialchars($_POST['password']);
		$configs['table'] = "user";
		$configs['conditions'] = $conditions;
		$datas = $this->query->select_single_where($configs);
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
		$order_data = $this->get_order_data();
		$data['order_data'] = $order_data;
		$this->load->view("account",$data);
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
	private function prepare_index_data(){
		/**
		酒店信息：
			酒店图片url，
			酒店名称
			酒店位置
			酒店介绍
			酒店距离
			按照评价数量由高到低排序
		*/
		$configs['table'] = 'h_info';
		$configs['sequence'] = 'h_eval_num desc';
		$hotel_data = $this->query->select_single_where($configs);
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
}
