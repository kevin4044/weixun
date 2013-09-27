<?php
/**
 * 退出
 *
 * @version        $Id: exit.php 1 19:09 2010年7月12日Z 
 */
require_once(dirname(__FILE__).'/../functions/common.inc.php');
require_once(XAKINC.'/userlogin.class.php');
$cuserLogin = new userLogin();
$cuserLogin->exitUser();
if(empty($needclose))
{
	$msg = "<script language='javascript'>window.top.location.href='login.php';</script>";
	echo $msg;
	exit;
    //header('location:index.php');
}
else
{
    $msg = "<script language='javascript'>
    if(document.all) window.opener=true;
    window.close();
    </script>";
    echo $msg;
	exit;
}