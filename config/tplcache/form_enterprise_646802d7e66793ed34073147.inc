<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>订单填写_<?php echo $GLOBALS['cfg_webname']; ?></title>
    <meta name="description" content="<?php echo $GLOBALS['cfg_description']; ?>"/>
    <meta name="keywords" content="<?php echo $GLOBALS['cfg_keywords']; ?>"/>
    <meta name="author" content="http://www.xak.cn"/>
    <link href="/templets/style/style.css" rel="stylesheet" media="screen" type="text/css"/>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script type="text/javascript" src="/templets/style/js/common.js"></script>
</head>
<body>
<?php
   pasterTempletDiy("xak/head.htm");
?>
<div class="main">
<div class="weizhi">您现在所在位置：订单填写</div>
<?php
   pasterTempletDiy("xak/sidebar.htm");
?>
<div class="rightt">


<div class="nn">
<div class="nntt">
    <div class="baoo">提交报名</div>
</div>
<div class="nnz">

<script language="JavaScript">
    /*
     @describe form ajax callback
     @param
     */
    function ajax_call_back(data) {
        $('input').attr('disabled', 'disabled');
        $('.submit').hide();
        $('.submitt').hide();
        $('#vdcode').hide();
        //$('td#pay_button').html(data);
        alert(data);
    }
    $(document).ready(function () {

        $('#enterprise_form').bind('submit', function () {
            ajaxSubmit(this, ajax_call_back);
            return false;
        });
    });
</script>

<form id="enterprise_form" name="myform" method="post" action="/module/buy_action.php">
<input name="arcid" type="hidden" size="25"
       value=<?php echo $GLOBALS['_vars']['course_type']; ?>>
    <input name="topid" type="hidden" size="25"
           value=<?php echo $GLOBALS['_vars']['topid']; ?>>
<table width="100%" border="0" align="center" cellPadding="5" cellSpacing="1">
<tr>
    <td height="40" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr>
    <td height="25" align="right">需求信息:内训课题：&nbsp;</td>
    <td width="30%" height="25" align="left">
        <input class="input" name="course_name" readonly="readonly" type="text" size="25"
               value=<?php echo $GLOBALS['_vars']['data']['name']; ?>>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr>
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>
<tr class="f_personal">
    <td height="25" align="right">培训计划天数：&nbsp;</td>
    <td height="25">
        <input class="input" name="days" type="text" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>

<tr class="f_personal">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr class="f_personal">
    <td height="25" align="right">培训计划日期：&nbsp;</td>
    <td height="25">
        <input class="input" name="date" type="date" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_personal">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr class="f_personal">
    <td height="25" align="right">计划参加人数：&nbsp;</td>
    <td height="25">
        <input class="input" name="people_count" type="text" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_personal">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>


<tr class="f_personal">
    <td height="25" align="right">培训期望：&nbsp;</td>
    <td height="25">
        <input class="input" name="expect" type="text" size="25"/>
        &nbsp;
    </td>
</tr>
<tr class="f_personal">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr class="f_personal">
    <td height="25" align="right">公司信息：姓名：&nbsp;</td>
    <td height="25">
        <input class="input" name="co_info" type="text" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_personal">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>


<tr class="f_enterprise">
    <td height="25" align="right">职位：&nbsp;</td>
    <td height="25">
        <input class="input" name="job" type="text" size="25"/>
        &nbsp;
    </td>
</tr>
<tr class="f_enterprise">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr class="f_enterprise">
    <td height="25" align="right">公司名称：&nbsp;</td>
    <td height="25">
        <input class="input" name="co_name" type="text" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_enterprise">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr class="f_enterprise">
    <td height="25" align="right">公司电话：&nbsp;</td>
    <td height="25">
        <input class="input" name="co_tel" type="text" size="25"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_enterprise">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>
<tr class="f_enterprise">
    <td width="15%" height="25" align="right">电子邮件：&nbsp;</td>
    <td height="25" align="left"><input class="input" name="email" type="text" size="60"/></td>
    </tr>
    <tr class="f_enterprise">
        <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
    </tr>
<tr class="f_enterprise">
    <td width="15%" height="25" align="right">公司地址：&nbsp;</td>
    <td height="25" align="left">
        <input class="input" name="co_addr" type="text" size="60"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_enterprise">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>
<tr class="f_enterprise">
    <td width="15%" height="25" align="right">邮政编码：&nbsp;</td>
    <td height="25" align="left">
        <input class="input" name="postcode" type="text" size="60"/>
        &nbsp;<font color="red">*</font>
    </td>
</tr>
<tr class="f_enterprise">
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>

<tr>
    <td width="15%" height="25" align="right">验证码：&nbsp;</td>
    <td height="25" align="left">
        <input id="vdcode" class="input" name="vdcode" type="text" size="10"/>
        <img align="absmiddle" onclick="this.src=this.src+'?'" style="cursor: pointer;" alt="看不清？"
             src="/functions/vdimgck.php"/>
        <font color="red">*</font>
    </td>
</tr>
<tr>
    <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
</tr>
<tr>
    <td width="15%">&nbsp;</td>
    <td>
        <input class="submit" type="submit" name="submitsure">
        <input class="submitt" type="reset" name="Reset">
    </td>
</tr>
<tr>
    <td width="15%">&nbsp;</td>
    <td id="pay_button">

    </td>
</tr>
</table>
</form>


</div>
<div class="nnd"></div>
</div>


</div>
</div>
<?php
   pasterTempletDiy("xak/footer.htm");
?>
</body>
</html>