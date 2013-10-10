<?php
/**
 * Created by XakWeb
 * User: kevin
 * Date: 13-10-10
 * Time: 上午11:25
 * describe:教师合作表单
 */
require_once(dirname(__FILE__)."/../functions/common.inc.php");

$lang_arry = array("teacher_name"=>"姓名",
    "teacher_tel"=>"联系电话",
    "teacher_email"=>"电子邮箱",
    "target"=>"拟培训方向",
    "price"=>"拟培训费用",
    "subject"=>"拟培训课题",
    "course_date"=>"拟开课日期",
    "course_length"=>"拟培训时长",
    "course_intro"=>"课程简介",
    "teacher_intro"=>"自我简介",
    "content"=>"其他说明");


//提示信息及语言
    $error = '您提交的信息不完整,请重新提交!';
    $ok ='您的信息已成功提交,我们会尽快与您取得联系,谢谢!';
    $mailtitle = '您好,接收到来自网站上的留言信息';
    $vdcode_error = '验证码错误！';


//检查验证码
$svali = GetCkVdValue();
if(strtolower($_POST['vdcode'])!=$svali || $svali=='')
{
    ResetVdValue();
    ShowMsg($vdcode_error, '-1');
    exit();
}

//检查信息完整性
if($_POST['teacher_name']=='' || $_POST['teacher_tel']=='' || $_POST['teacher_email']=='')
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

$mailbody = '';
//邮件内容
foreach ($_POST as $key=>$value) {
    if(isset($lang_arry["$key"])) {
        $mailbody .= $lang_arry["$key"]."： ".$value."<br/>";
    }
}

global $teacher_co_email;

if($cfg_sendmail_bysmtp == 'Y' && !empty($cfg_smtp_server))
{
    $mailtype = 'HTML';
    require_once(XAKINC.'/mail.class.php');
    $smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
    $smtp->debug = false;
    $smtp->sendmail($teacher_co_email,$cfg_webname,$cfg_smtp_usermail, $mailtitle, $mailbody, $mailtype);
}
else
{
    $mailtitle= mb_convert_encoding($mailtitle, "gb2312", "utf-8");
    $headers = "Content-type:text/html;charset=utf-8" . "\r\n";
    @mail($teacher_co_email, $mailtitle, $mailbody, $headers);
}

//输出提示信息
echo '<script language="javascript" type="text/javascript">alert("'.$ok.'");window.location.href="'.$return.'";</script>';
exit();
