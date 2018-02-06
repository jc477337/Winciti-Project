<?php
include('index/common.func.php');
	
deal();
	
function deal()
{
	$cmd = post('cmd');
	$cmd();
	exit();
}
	
function add_to_cart()
{
	$id = post('id');
	$buy_num = intval(post('buy_num'));
	$obj = new goods();
	$obj->set_where("goo_id = $id");
	$obj->set_where("goo_number >= $buy_num");
	if($obj->get_count() > 0)
	{
		$json = get_cart_json();
		if($json != '' && $json != 'null')
		{
			if($arr = json_decode($json,true))
			{
				if(!isset($arr[$id]))
				{
					$arr[$id] = $buy_num;
				}else{
					$arr[$id] = intval($arr[$id]) + intval($buy_num);
				}
			}
		}else{
			$arr = array();
			$arr[$id] = $buy_num;
		}
		set_cart_json(json_encode($arr));
		echo 1;
	}else{
		echo 2;
	}
}
function cart_del_goods()
{
	$id = post('id');
	$json = get_cart_json();
	if($json != '' && $json != 'null')
	{
		if($arr = json_decode($json,true))
		{
			if(isset($arr[$id]))
			{
				unset($arr[$id]);
			}
		}
	}else{
		$arr = array();
	}
	if(count($arr))
	{
		set_cart_json(json_encode($arr));
	}else{
		set_cart_json('');
	}
	echo 1;
}
function cart_clear()
{
	set_cart_json('');
	echo 1;
}
function check_username()
{
	$use_username = post('val');
	$obj = new users();
	$obj->set_where("use_username = '$use_username'");
	if($obj->get_count() > 0)
	{
		echo 1;
	}else{
		echo 0;
	}
}
function get_region()
{
	$val = post('val');
	$obj = new region();
	$obj->set_field('reg_id,reg_name');
	$obj->set_where("reg_parent_id = $val");
	$list = $obj->get_list();
	$str = '';
	for($i = 0; $i < count($list); $i ++)
	{
		$reg_id = $list[$i]['reg_id'];
		$reg_name = $list[$i]['reg_name'];
		$str .= '<option value="'.$reg_id.'">'.$reg_name.'</option>';
	}
	echo $str;
}
function add_to_collection()
{
	global $global;
	$goods_id = post('id');
	if($global['user_id'] !== 0)
	{
		$obj = new collection();
		$obj->set_where('col_user_id = '.$global['user_id']);
		$obj->set_where("col_goods_id = $goods_id");
		if($obj->get_count() == 0)
		{
			$obj->set_value('col_user_id',$global['user_id']);
			$obj->set_value('col_goods_id',$goods_id);
			$obj->set_value('col_add_time',time());
			$obj->set_value('col_lang',S_LANG);
			$obj->add();
			echo 1;
		}else{
			echo 2;
		}
	}else{
		echo 0;
	}
}
function do_system_pay()
{
	global $global;
	$order_id = post('id');
	$obj = new orders();
	$obj->set_where("ord_id = $order_id");
	$one = $obj->get_one();
	if($global['user_id'] !== 0)
	{
		$money = sprintf('%.2f',get_data('users',$global['user_id'],'use_money'));
		if($money >= $one['ord_price_total'])
		{
			$obj->set_value('ord_status',1);
			$obj->edit();
			
			$obj = new account();
			$obj->set_value('acc_user_id',$global['user_id']);
			$obj->set_value('acc_sn',$one['ord_sn']);
			$obj->set_value('acc_increase',0);
			$obj->set_value('acc_amount',$one['ord_price_total']);
			$obj->set_value('acc_add_time',time());
			$obj->set_value('acc_edit_time',time());
			$obj->set_value('acc_status',2);
			$obj->add();
			
			$obj = new users();
			$obj->set_value('use_money',$money - $one['ord_price_total']);
			$obj->set_where('use_id = '.$global['user_id']);
			$obj->edit();
			echo 1;
		}else{
			echo 0;
		}
	}
}
//
?>
