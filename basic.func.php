<?php
function main()
{
	global $global,$smarty;
	set_global();
	if(S_WEAK_STATIC)
	{
		if($global['url'] == '')
		{
			if(S_FLASH != 1)
			{
				$path = '/' . S_URL_SUFFIX;
			}else{
				$path = '/flash.html';
			}
		}else{
			$path = $global['url'];
		}
		$path = 'html' . $path;
		if(substr($path,-1) == '/')
		{
			$path .= S_URL_SUFFIX;
		}
		if(file_exists($path))
		{
			include($path);
			exit();
		}else{
			ob_start();
		}
	}
	
	include_all('index/class/parent');
	include_all('index/class');
	set_more_global();
	$path = 'index/' . $global['channel'] . '.php';
	include($path);
}
function set_more_global()
{
	global $global;
	$global['user_id'] = check_user_login();
	$global['channel'] = get_global('channel','index');
	$global['cat'] = get_global('cat',0);
	$global['page'] = get_global('page',1);
	$global['id'] = get_global('id',0);
}
	
//
?>