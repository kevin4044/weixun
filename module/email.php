<?php
/**
 *
 * 留言发信
 *
 * @version        $Id: email.php 2012年12月14日 by heibian
*/
require_once(dirname(__FILE__)."/../functions/common.inc.php");


//初始化信息
$name = $_POST['name'];
$company = $_POST['company'];
$telephone = $_POST['telephone'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$address = $_POST['address'];
$content = $_POST['content'];
$lang = $_POST['lang'];


//提示信息及语言
if(!isset($lang) || $lang =='cn')
{
	$error = '您提交的信息不完整,请重新提交!';
	$ok ='您的信息已成功提交,我们会尽快与您取得联系,谢谢!';
	$mailtitle = '您好,接收到来自网站上的留言信息';
	$vdcode_error = '验证码错误！';
	
	//标题项
	$lang_name = '姓名：';
	$lang_company = '公司名称：';
	$lang_tel = '电话：';
	$lang_fax = '传真：';
	$lang_email = '邮箱：';
	$lang_address = '地址：';
	$lang_content = '留言内容：';
	
}
elseif($lang =='en')
{
	$error = 'Information is not complete.';
	$ok ='Your message has been submitted, please wait for the administrator reply, thank you!';
	$mailtitle = 'Hello, you have a new message from  your website';
	$vdcode_error = 'Verification code error!';
	
	//标题项
	$lang_name = 'Name：';
	$lang_company = 'Company：';
	$lang_tel = 'Tel：';
	$lang_fax = 'Fax：';
	$lang_email = 'Email：';
	$lang_address = 'Address：';
	$lang_content = 'Content：';
}
else
{
	$error = 'Information is not complete.';
	$ok ='Your message has been submitted, please wait for the administrator reply, thank you!';
	$mailtitle = 'Hello, you have a new message from  your website';
	$vdcode_error = 'Verification code error!';
	
	//标题项
	$lang_name = 'Name：';
	$lang_company = 'Company：';
	$lang_tel = 'Tel：';
	$lang_fax = 'Fax：';
	$lang_email = 'Email：';
	$lang_address = 'Address：';
	$lang_content = 'Content：';
}


//检查验证码
$svali = GetCkVdValue();
if(strtolower($vdcode)!=$svali || $svali=='')
{
	ResetVdValue();
	ShowMsg($vdcode_error, '-1');
	exit();
}

//检查信息完整性
if($name=='' || $telephone=='' || $email=='' || $content=='')
{
	ShowMsg($error, '-1');
	exit();
}

//初始化返回地址
if(!isset($return) || $return=='')
{
	$return = '/';
}
else
{
	$return = trim($return);
}

//邮件内容
$mailbody = $lang_name.$name."<br/>";
$mailbody.= $lang_company.$company."<br/>";
$mailbody.= $lang_tel.$telephone."<br/>";
$mailbody.= $lang_fax.$fax."<br/>";
$mailbody.= $lang_email.$email."<br/>";
$mailbody.= $lang_address.$address."<br/>";
$mailbody.= $lang_content.$content;


if($cfg_sendmail_bysmtp == 'Y' && !empty($cfg_smtp_server))
{
	$mailtype = 'HTML';
	require_once(XAKINC.'/mail.class.php');
	$smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
	$smtp->debug = false;
	$smtp->sendmail($smtp_email,$cfg_webname,$cfg_smtp_usermail, $mailtitle, $mailbody, $mailtype);
}
else
{
	$mailtitle= mb_convert_encoding($mailtitle, "gb2312", "utf-8");
	$headers = "Content-type:text/html;charset=utf-8" . "\r\n";
	@mail($smtp_email, $mailtitle, $mailbody, $headers);
}

//输出提示信息
echo '<script language="javascript" type="text/javascript">alert("'.$ok.'");window.location.href="'.$return.'";</script>';
exit();	