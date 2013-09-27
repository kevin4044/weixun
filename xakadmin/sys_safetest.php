<?php
/**
 * 安全检测
 *
 * @version        $Id: sys_safetest.php 2 9:25 2010-11-12 
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('sys_Edit');
if(empty($action)) $action = '';
if(empty($message)) $message = '尚未进行检测……';
if(empty($filetype)) $filetype = 'php|inc';
if(empty($info)) $info = 'eval|cmd|_GET|_POST';

$safefile = "data/common.inc.php
index.php
xakadmin/config.php
xakadmin/index_body.php
xakadmin/member_do.php
xakadmin/sys_info_pay.php
xakadmin/mychannel_main.php
group/postform.php
group/reply.php
include/common.inc.php
include/mail.class.php
include/Lurd.class.php
include/payment/alipay.php
include/payment/bank.php
include/payment/cod.php
include/payment/yeepay.php
include/helpers/debug.helper.php
include/request.class.php
include/xakcollection.class.php
include/xaktag.class.php
include/dialog/config.php
include/taglib/php.lib.php
include/FCKeditor/fckeditor.php
include/smtp.class.php
include/zip.class.php
install/common.inc.php
include/json.class.php
include/sphinxclient.class.php
module/bshare.php
install/index.php";

$adminDir = preg_replace("#(.*)[\/\\\\]#", "", dirname(__FILE__));
$safefile = trim(str_replace('xakadmin/',$adminDir.'/',$safefile));
$safefiles = preg_split("#[\r\n]{1,}#", $safefile);

function TestOneFile($f)
{
    global $message, $info;
    $str = '';

    //排除safefile和data/tplcache目录
    if(NotCheckFile($f) || preg_match("#data/tplcache|.svn#", $f)) return -1;
    
    $fp = fopen($f, 'r');
    while(!feof($fp)) { $str .= fgets($fp,1024); }
    fclose($fp);
    if(preg_match("#(".$info.")[ \r\n\t]{0,}([\[\(])#i", $str))
    {
        $trfile = preg_replace("#^".XAKROOT."#", '', $f);
        $message .= "<div style='clear:both;border-bottom:1px dotted #B8E6A2;line-height:24px'>
        <div style='width:350px;float:left'>可疑文件：{$trfile}</div>
        <div style='float:left'>[<a href='file_manage_view.php?fmdo=del&filename=$trfile&activepath=' target='_blank'><u>删除</u></a>]
        [<a href='file_manage_view.php?fmdo=edit&filename=$trfile&activepath=' target='_blank'><u>查看源码</u></a>]
        </div></div>\r\n";
        return 1;
    }
    return 0;
}

function NotCheckFile($f)
{
    global $safefiles, $safefile;
    if($safefile != '')
    {
        foreach($safefiles as $v)
        {
            //if(empty($v)) continue;
            if( preg_match("#".$v."#i", $f) ) return TRUE;
        }
    }
    return false;
}

function TestSafe($tdir)
{
    global $filetype;
    $dh = dir($tdir);
    while($fname=$dh->read())
    {
        $fnamef = $tdir.'/'.$fname;
        if(@is_dir($fnamef) && $fname != '.' && $fname != '..')
        {
            TestSafe($fnamef);
        }
        if(preg_match("#\.(" . $filetype . ")#i", $fnamef))
        {
            TestOneFile($fnamef);
        }
    }
}

//检测
if($action=='test')
{
     $message = '';
     AjaxHead();
     TestSafe(XAKROOT);
     if($message=='') $message = "<font color='green' style='font-size:14px'>没发现可疑文件！</font>";
     echo $message;
     exit();
}

//清空模板缓存
else if($action=='clear')
{
    global $cfg_tplcache_dir;
    $message = '';
    $d = XAKROOT.$cfg_tplcache_dir;
    AjaxHead();
    sleep(1);
    if(preg_match("#data\/#", $cfg_tplcache_dir) && file_exists($d) && is_dir($d))
    {
        $dh = dir($d);
        while($filename = $dh->read())
        {
            if($filename=='.'||$filename=='..'||$filename=='index.html') continue;
            @unlink($d.'/'.$filename);
        }
    }
    $message = "<font color='green' style='font-size:14px'>成功清空模板缓存！</font>";
    echo $message;
    exit();
}

include(dirname(__FILE__).'/templets/sys_safetest.htm');