<?php
/**
 * 该页仅用于检测用户登录的情况，如要手工更改系统配置，请更改common.inc.php
 *
 * @version        $Id: config.php 1 9:43 2010年7月8日Z
 */
require_once(dirname(__FILE__)."/../common.inc.php");
require_once(dirname(__FILE__)."/../userlogin.class.php");

//获得当前脚本名称，如果你的系统被禁用了$_SERVER变量，请自行更改这个选项
$xakNowurl   =  '';
$s_scriptName = '';
$isUrlOpen = @ini_get('allow_url_fopen');

$xakNowurl = GetCurUrl();
$xakNowurls = explode("?",$xakNowurl);
$s_scriptName = $xakNowurls[0];

//检验用户登录状态
$cuserLogin = new userLogin();

if($cuserLogin->getUserID() <=0 )
{
    if(empty($adminDirHand))
    {
        ShowMsg("<b>提示：需输入后台管理目录才能登录</b><br /><form>请输入后台管理目录名：<input type='hidden' name='gotopage' value='".urlencode($xakNowurl)."' /><input type='text' name='adminDirHand' value='' style='width:120px;' /><input style='width:80px;' type='submit' name='sbt' value='转入登录' /></form>", "javascript:;");
        exit();
    }
    $gurl = "../../{$adminDirHand}/login.php?gotopage=".urlencode($xakNowurl);
    echo "<script language='javascript'>location='$gurl';</script>";
    exit();
}

//启用远程站点则创建FTP类
if($cfg_remote_site=='Y')
{
    require_once(XAKINC.'/ftp.class.php');
    if(file_exists(XAKDATA."/cache/inc_remote_config.php"))
    {
        require_once XAKDATA."/cache/inc_remote_config.php";
    }
    if(empty($remoteuploads)) $remoteuploads = 0;
    if(empty($remoteupUrl)) $remoteupUrl = '';
    //初始化FTP配置
    $ftpconfig = array(
        'hostname'=>$rmhost, 
        'port'=>$rmport,
        'username'=>$rmname,
        'password'=>$rmpwd

    );
    $ftp = new FTP; 
    $ftp->connect($ftpconfig);
}