<?php
require(dirname(__FILE__).'/config.php');
require(XAKADMIN.'/inc/xmenu5.php');
require(XAKADMIN.'/inc/inc_menu_func.php');
$openitem = (empty($openitem) ? 1 : $openitem);
include XAKINClude('templets/xmenu5.htm');
?>
