<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack(array($global['channel']));
initial('user');
$info = get_tpl_info('user');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('user.php');

	
//
?>