<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack(array($global['channel']));
initial('goods');
$info = get_tpl_info('goods');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('goods.php');

	
//
?>