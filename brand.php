<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack(array($global['channel']));
initial('brand');
$info = get_tpl_info('brand');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('brand.php');

	
//
?>