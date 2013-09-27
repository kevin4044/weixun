<?php
/**
 * 载入菜单
 *
 * @version        $Id: index_menu_load.php 1 8:48 2010年7月13日Z 
 */
require_once(dirname(__FILE__).'/config.php');
AjaxHead();
if($openitem != 100)
{
    require(dirname(__FILE__).'/inc/inc_menu.php');
    require(XAKADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'main');
    exit();
}
else
{
    $openitem = 0;
    require(dirname(__FILE__).'/inc/inc_menu_module.php');
    require(XAKADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'module');
    exit();
}