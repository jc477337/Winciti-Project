<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack();
initial('index');
$info = get_tpl_info('index');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('index.php');

	
//
?>