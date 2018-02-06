<?php
include('smarty/Smarty.class.php');
include('index/common.func.php');
	
set_smarty();
load_lang_pack(array($global['channel']));
initial('index');
if(isset($global['key']))
{
	$smarty->assign('page_title',rawurldecode($global['key']));
}
$info = get_tpl_info('search');
run_module(explode('|',$info),'index/module/');
$smarty->assign('global',$global);
$smarty->display('search.php');

	
//
?>