<?php

function get_varia($var_name)
{
	$obj = new varia();
	return $obj->get_value($var_name);
}

function get_data($table,$id,$field)
{
	$obj = new $table();
	$obj->set_field($field);
	$obj->set_where(substr($table,0,3).'_id = '.$id);
	$one = $obj->get_one();
	if(count($one) > 0)
	{
		return $one[$field];
	}else{
		return '';
	}
}

function get_id($table,$field,$value)
{
	$obj = new $table();
	$obj->set_field(substr($table,0,3).'_id');
	if(is_numeric($value))
	{
		$obj->set_where("$field = $value");
	}else{
		$obj->set_where("$field = '$value'");
	}
	$one = $obj->get_one();
	if(count($one) > 0)
	{
		return $one[substr($table,0,3).'_id'];
	}else{
		return 0;
	}
}

function get_cat_family($table,$id)
{
	$obj = new $table();
	$tab = substr($table,0,3);
	$list = $obj->get_list();
	$arr = array();
	for($i = 0; $i < count($list); $i++)
	{
		$arr[$i][0] = $list[$i][$tab.'_id'];
		$arr[$i][1] = $list[$i][$tab.'_parent_id'];
	}
	$family = array();
	$family[0] = $id;
	$flag = 1;
	while($flag == 1)
	{
		$flag = 0;
		for($i = 0; $i < count($family); $i ++)
		{
			for($j = 0; $j < count($arr); $j ++)
			{
				if($family[$i] == $arr[$j][1])
				{
					$family[count($family)] = $arr[$j][0];
					$arr[$j][1] = -1;
					$flag = 1;
				}
			}
		}
	}
	return $family;
}

function strict($str)
{
	if(S_MAGIC_QUOTES_GPC)
	{
		$str = stripslashes($str);
	}
	$str = str_replace('<','&#60;',$str);
	$str = str_replace('>','&#62;',$str);
	$str = str_replace('?','&#63;',$str);
	$str = str_replace('%','&#37;',$str);
	$str = str_replace(chr(39),'&#39;',$str);
	$str = str_replace(chr(34),'&#34;',$str);
	$str = str_replace(chr(13).chr(10),'<br />',$str);
	return $str;
}

function loose($str)
{
	if(S_MAGIC_QUOTES_GPC)
	{
		$str = stripslashes($str);
	}
	$str = str_replace(chr(39),'&#39;',$str);
	$str = str_replace(chr(60).chr(63),'',$str);
	$str = str_replace(chr(63).chr(62),'',$str);
	$str = str_replace(chr(60).chr(37),'',$str);
	$str = str_replace(chr(37).chr(62),'',$str);
	$str = str_replace(chr(13).chr(10),'',$str);
	return $str;
}

function no_filter($str)
{
	if(S_MAGIC_QUOTES_GPC)
	{
		$str = stripslashes($str);
	}
	return $str;
}

function cut_str($string,$sublen,$start = 0)
{
	$pr = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all($pr,$string,$t_string);
	$arr = $t_string[0];
	$arr_len = count($arr);
	for($i = 0; $i < $arr_len; $i ++)
	{
		if($arr[$i] != 'delete')
		{
			if(strlen($arr[$i]) == 1)
			{
				if($i < $arr_len - 1)
				{
					$arr[$i] .= $arr[$i + 1];
					$arr[$i + 1] = 'delete';
				}
			}
		}
	}
	$arr2 = array();
	foreach($arr as $key => $value)
	{
		if($value != 'delete')
		{
			$arr2[] = $value;
		}
	}
	$return = '';
	for($i = $start; $i < $sublen && $i < count($arr2); $i ++)
	{
		$return .= $arr2[$i];
	}
	if(count($arr2) - $start > $sublen)
	{
		return $return.'...';
	}else{
		return $return;
	}
}

function repair_html(&$html)
{
	$a = strlen(strrchr($html,'<'));
	$b = strlen(strrchr($html,'>'));
	if($a < $b || ($a != 0 && $b == 0))
	{
		$html = substr($html,0,-$a);
	}
	return $html;
}

function num_bound($min,$max,$num)
{
	$num = intval($num);
	if($min < $max)
	{
		if($num < $min) $num = $min;
		else if($num > $max) $num = $max;
	}else{
		$num = $min;
	}
	return $num;
}

function get_file_name($full_path,$str)
{
	if($full_path != '')
	{
		return substr(strrchr($full_path,$str),1);
	}else{
		return '';
	}
}

function set_global($filter = 'loose')
{
	global $global;
	$global = array();
	$global['url'] = $filter($_SERVER['QUERY_STRING']);
	if($global['url'] != '')
	{
		$arr = explode('/',$global['url']);
		$global['channel'] = $arr[1];
		for($i = 0; $i < count($arr); $i ++)
		{
			$strpos = strpos($arr[$i],'-');
			if($strpos)
			{
				$key = substr($arr[$i],0,$strpos);
				$value = substr($arr[$i],$strpos + 1);
				if(!isset($global[$key]))
				{
					$global[$key] = $value;
				}
			}
		}
	}
}

function get_global($key,$val = '')
{
	global $global;
	return isset($global[$key]) ? $global[$key] : $val;
}

function set_session($name,$value,$filter = 'strict')
{
	if(S_SESSION)
	{
		$_SESSION[$name] = $filter($value);
	}else{
		setcookie($name,$filter($value));
	}
}

function get_session($name,$filter = 'strict')
{
	if(S_SESSION)
	{
		return $filter(isset($_SESSION[$name])?$_SESSION[$name]:'');
	}else{
		return $filter(isset($_COOKIE[$name])?$_COOKIE[$name]:'');
	}
}

function unset_session($name)
{
	if(S_SESSION)
	{
		unset($_SESSION[$name]);
	}else{
		setcookie($name,'',0);
	}
}

function set_cookie($name,$value,$filter = 'strict',$expire = 0)
{
	if($expire == 0)
	{
		setcookie($name,$filter($value));
	}else{
		setcookie($name,$filter($value),$expire);
	}
}

function get_cookie($name,$filter = 'strict')
{
	return $filter(isset($_COOKIE[$name])?$_COOKIE[$name]:'');
}

function unset_cookie($name)
{
	setcookie($name,'',0);
}

function post($val,$filter = 'strict')
{
	return $filter(isset($_POST[$val])?$_POST[$val]:'');
}

function get($val,$filter = 'strict')
{
	return $filter(isset($_GET[$val])?$_GET[$val]:'');
}

function get_ip()
{
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown'))
	{
		$ip = getenv('HTTP_CLIENT_IP');
	}elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
		$ip = getenv('REMOTE_ADDR');
	}elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
		$ip = $_SERVER['REMOTE_ADDR'];
	}else{
		$ip = '0.0.0.0';
	}
	if(!is_numeric(str_replace('.','',$ip)))
	{
		$ip = '0.0.0.0';
	}
	return $ip; 
}

function get_domain()
{
	return $_SERVER['SERVER_PORT'] == '80'?$_SERVER['SERVER_NAME']:$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']; 
}

function check_user_login()
{
	global $user_id;
	$username = get_cookie('user_username');
	$password = get_cookie('user_password');
	if($username != '' && $password != '')
	{
		$obj = new users();
		$obj->set_field('use_id');
		$obj->set_where("use_username = '$username'");
		$obj->set_where("use_password = '$password'");
		$one = $obj->get_one();
		if(count($one) !== 0)
		{
			$user_id = $one['use_id'];
			return intval($user_id);
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

function check_admin_login()
{
	global $admin_id;
	$username = get_session('admin_username');
	$password = get_session('admin_password');
	if($username != '' && $password != '')
	{
		$obj = new admin();
		$obj->set_field('adm_id');
		$obj->set_where("adm_username = '$username'");
		$obj->set_where("adm_password = '$password'");
		$one = $obj->get_one();
		if(count($one) !== 0)
		{
			$admin_id = $one['adm_id'];
			return intval($admin_id);
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
//
function get_attribute($att_str,$att_id)
{
	$return = '';
	$arr = json_decode(rawurldecode($att_str),true);
	if(isset($arr[$att_id]))
	{
		$return = $arr[$att_id];
	}
	return $return;
}
//
function get_att_list($arr,$str,$code = '')
{
	$arr2 = array();
	for($i = 0;$i < count($arr);$i ++)
	{
		if($code == '' || $code == $arr[$i]['att_code'])
		{
			$key = $arr[$i]['att_code'];
			$arr2[$key]['id'] = $arr[$i]['att_id'];
			$arr2[$key]['code'] = $arr[$i]['att_code'];
			$arr2[$key]['name'] = $arr[$i]['att_name'];
			$arr2[$key]['value'] = get_attribute($str,$arr[$i]['att_id']);
			if($code != ''){break;}
		}
	}
	return $arr2;
}



function include_all($dir)
{
	$scandir = scandir($dir);
	foreach($scandir as $file)
	{
		if(is_file($dir . '/' . $file))
		{
			include($dir . '/' . $file);
		}
	}
}

function copy_dir($src,$dst)
{
	$dir = opendir($src);
	if(!file_exists($dst))
	{
		mkdir($dst,0777,true);
	}
	while(false !== ($file = readdir($dir)))
	{
		if(($file != '.') && ($file != '..'))
		{
			if(is_dir($src.'/'.$file))
			{
				copy_dir($src.'/'.$file,$dst.'/'.$file);
			}else{
				copy($src.'/'.$file,$dst.'/'.$file);
			}
		}
	}
	closedir($dir);
}

function del_dir($src)
{
	$dir = opendir($src);
	while(false !== ($file = readdir($dir)))
	{
		if(($file != '.') && ($file != '..'))
		{
			if(is_dir($src.'/'.$file))
			{
				del_dir($src.'/'.$file);
			}else{
				unlink($src.'/'.$file);
			}
		}
	}
	closedir($dir);
}

function get_random($val = '',$len = 3)
{
	if($val == '')
	{
		return time() . str_pad(mt_rand(1,pow(10,$len) - 1),$len,'0',STR_PAD_LEFT);
	}else{
		return $val . str_pad(mt_rand(1,pow(10,$len) - 1),$len,'0',STR_PAD_LEFT);
	}
}

function rhs_error()
{
	echo 'RHS Error:' . $_SERVER['REQUEST_URI'];
	exit();
}

function load_lang_pack($name = array(),$project = 'index')
{
		
}
//
?>
