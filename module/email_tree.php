<?php
/**
 * Created by XakWeb
 * User: kevin
 * Date: 13-10-10
 * Time: 上午11:25
 * describe:许愿树留言
 */
equire_once(dirname(__FILE__)."/../functions/common.inc.php");


//初始化信息
$name = $_POST['name'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$target = $_POST['target'];
$course = $_POST['course'];
$location = $_POST['location'];
$date_str = $_POST['date'];
$content = $_POST['content'];
$lang = $_POST['lang'];


//提示信息及语言
//if(!isset($lang) || $lang =='cn')
//{
    $error = '您提交的信息不完整,请重新提交!';
    $ok ='您的信息已成功提交,我们会尽快与您取得联系,谢谢!';
    $mailtitle = '您好,接收到来自网站上的留言信息';
    $vdcode_error = '验证码错误！';

    //标题项
    $lang_name = "姓名";
    $lang_telephone = "联系电话";
    $lang_email = "电子邮件";
    $lang_subject = "培训课题";
    $lang_target = "培训方向";
    $lang_course = "培训课程";
    $lang_location = "期望开课地点";
    $lang_date_str = "期望开课日期";
    $lang_content = "其他说明";

//}
/*
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
*/


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
$mailbody.= $lang_telephone.$telephone."<br/>";
$mailbody.= $lang_email.$email."<br/>";
$mailbody.= $lang_subject.$subject."<br/>";
$mailbody.= $lang_target.$target."<br/>";
$mailbody.= $lang_date_str.$date_str."<br/>";
$mailbody.= $lang_content.$content;

//mail addr set on the system
global $tree_mail;
if($cfg_sendmail_bysmtp == 'Y' && !empty($cfg_smtp_server))
{
    $mailtype = 'HTML';
    require_once(XAKINC.'/mail.class.php');
    $smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
    $smtp->debug = false;
    $smtp->sendmail($tree_mail,$cfg_webname,$cfg_smtp_usermail, $mailtitle, $mailbody, $mailtype);
}
else
{
    $mailtitle= mb_convert_encoding($mailtitle, "gb2312", "utf-8");
    $headers = "Content-type:text/html;charset=utf-8" . "\r\n";
    @mail($tree_mail, $mailtitle, $mailbody, $headers);
}

//输出提示信息
echo '<script language="javascript" type="text/javascript">alert("'.$ok.'");window.location.href="'.$return.'";</script>';
exit();