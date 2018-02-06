<?php
function set_smarty()
{
	global $smarty;
	$smarty = new Smarty;
	$smarty->template_dir = S_TPL_PATH.'index/';
	$smarty->compile_dir = 'index/compile/';
	$smarty->cache_dir = 'index/cache/';
}
function initial($table)
{
	global $global,$smarty,$lang;
	$tab = substr($table,0,3);
	if($global['id'] && ($table == 'article' || $table == 'goods'))
	{
		$global['cat'] = get_data($table,$global['id'],$tab.'_cat_id');
		if(!($page_title = get_data($table,$global['id'],$tab.'_title')))
		{
			$page_title = get_data($table,$global['id'],$tab.'_name');
		}
		$cat_name = get_data('cat_'.$tab,$global['cat'],'cat_name');
		$keywords = get_data($table,$global['id'],$tab.'_keywords');
		$describe = get_data($table,$global['id'],$tab.'_description');
	}else{
		$page_title = '';
		$cat_name = '';
		$keywords = get_varia('site_keywords');
		$describe = get_varia('site_description');
	}
	if($global['cat']){$cat_name = get_data('cat_'.$tab,$global['cat'],'cat_name');}
	
	$global['entrance'] = get_lang_info(S_LANG,2);
	$global['entrance'] = $global['entrance'] == 'index.php' ? '' : $global['entrance'];
	
	//$smarty->assign('global',$global);
	$smarty->assign('lang',$lang);
	$smarty->assign('version',get_varia('version'));
	$smarty->assign('site_title',get_varia('site_title'));
	$smarty->assign('channel_title',get_channel_title());
	$smarty->assign('page_title',$page_title);
	$smarty->assign('cat_name',$cat_name);
	$smarty->assign('keywords',$keywords);
	$smarty->assign('describe',$describe);
		
	$smarty->assign('S_ROOT',S_ROOT);
	$smarty->assign('S_TPL_PATH',S_ROOT . S_TPL_PATH);
	$smarty->assign('S_LANG',S_LANG);
	$smarty->assign('S_MULTILINGUAL',S_MULTILINGUAL);
	
	$smarty->registerPlugin('function','url','url');
}

function get_channel_title()
{
	global $global;
	$return = '';
	$priority = 0;
	$obj = new varia();
	$obj->set_where("var_name = 'title'");
	$list = $obj->get_list();
	for($i = 0; $i < count($list); $i ++)
	{
		$arr = explode('{v}',$list[$i]['var_value']);
		if(substr($global['url'],1,strlen($arr[0])) == $arr[0] && intval($arr[2]) >= $priority)
		{
			$return = $arr[1];
			$priority = intval($arr[2]);
		}
	}
	return $return;
}
function get_tpl_info($file_name)
{
	$xml = new domdocument();
	$xml->load(S_TPL_PATH.'index/xml/'.$file_name.'.xml');
	$tag = $xml->getelementsbytagname('module');
	$nodes_num = $tag->length;
	$return = '';
	for($i = 0; $i < $nodes_num; $i ++)
	{
		$text = $tag->item($i)->nodeValue;
		if(substr($text,0,1) != '*')
		{
			$return = $return . $text . '|';
		}
	}
	unset($tag);
	unset($xml);
	return substr($return,0,strlen($return)-1);
}
function run_module($arr,$path = '')
{
	for($i = 0; $i < count($arr); $i ++)
	{
		if($arr[$i] != '')
		{
			if(($module = strrchr($arr[$i],'/')) == '')
			{
				$module = $arr[$i];
			}else{
				$module = substr($module,1);
			}
			include($path.$arr[$i].'.php');
			$func = 'module_'.$module;
			$func();
		}
	}
}
function url($arr)
{
	extract($arr);
	$str = S_ROOT;
	if(isset($entrance))
	{
		$str .= $entrance . '?/';
		unset($arr['entrance']);
	}else{
		$str .= S_URL_PREFIX;
	}
	if(isset($channel) || isset($prefix))
	{
		$str .= (isset($channel)?$channel:$prefix) . '/';
		unset($arr['channel']);
		unset($arr['prefix']);
		foreach($arr as $key => $value)
		{
			$str .= $key . '-' . $value . '/';
		}
	}
	$str .= S_URL_SUFFIX;
	return $str;
}
function set_link($page_sum)
{
	global $global,$smarty;
	$global['page'] = num_bound(1,$page_sum,$global['page']);
	$smarty->assign('page_sum',$page_sum);
}
function get_lang_info($name,$num)
{
	$len = strlen($name);
	$obj = new varia();
	$obj->set_where("var_name = 'languages'");
	$obj->set_where("left(var_value,$len) = '$name'");
	$one = $obj->get_one();
	if(count($one) > 0)
	{
		$arr = explode('{v}',$one['var_value']);
		return $arr[$num - 1];
	}else{
		return '';
	}
}
/////////////////////////////////////
function get_cart_json()
{
	return rawurldecode(get_cookie('cart_json','loose'));
}
function set_cart_json($value)
{
	set_cookie('cart_json',$value,'loose');
}
//
?>