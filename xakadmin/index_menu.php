<?php
/**
 * 菜单项
 *
 * @version        $Id: index_menu.php 1 11:06 2010年7月13日Z 
 */
require(dirname(__FILE__).'/config.php');
require(XAKADMIN.'/inc/inc_menu.php');
require(XAKADMIN.'/inc/inc_menu_func.php');
$openitem = (empty($openitem) ? 1 : $openitem);
include XAKINClude('templets/index_menu2.htm');
