<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack(array($global['channel']));
initial('message');
$info = get_tpl_info('message');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('message.php');

	
//
?>