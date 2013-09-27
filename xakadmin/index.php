<?php
/**
 * 管理后台首页
 *
 * @version        $Id: index.php 1 11:06 2010年7月13日Z 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(XAKINC.'/xaktag.class.php');
$defaultIcoFile = XAKDATA.'/admin/quickmenu.txt';
$myIcoFile = XAKDATA.'/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';

if(empty($doout))
{
	if(!file_exists($myIcoFile)) $myIcoFile = $defaultIcoFile;
	include(XAKADMIN.'/templets/index.htm');
	exit();
}
//引入框架
if($doout == 'header')
{
	include(XAKADMIN.'/templets/header.htm');
	exit();	
}
else
{
	include(XAKADMIN.'/templets/frame.htm');
	exit();	
}