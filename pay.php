<?php
include('index/common.func.php');
	
if(isset($global['dir']) && isset($global['file']))
{
	include('payment/'.$global['dir'].'/'.$global['file'].'.php');
}
	
//
?>