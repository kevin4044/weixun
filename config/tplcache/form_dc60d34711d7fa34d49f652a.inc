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
<div class="leftt">
    <div class="gongkaike">
        <div class="shang">
            <div class="kecheng">公开课程</div>
        </div>
        <div class="zhong">
            <div class="kee">
                <ul>
                    <?php
$atts = array();
$atts['tagname'] = 'channel';
$atts['typid'] = '1';
$atts['type'] = 'son';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{
?>
                    <li><a href="[field:typeurl/]">[field:typename/]</a></li>
                    <?php
}
}
?>
                </ul>
            </div>
        </div>
        <div class="di"></div>
    </div>
    <div class="jian">
        <div class="ts">
            <div class="kecheng">课程推荐</div>
        </div>
        <div class="tz">
            <div class="mdd">
                <ul>
                    <?php
$atts = array();
$atts['tagname'] = 'arclist';
$atts['typeid'] = '1,2,3';
$atts['flag'] = 'c';
$atts['row'] = '7';
$atts['orderby'] = 'pubdate';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{
?>
                    <li><a href="[field:arcurl/]">[field:title/]</a></li>
                    <?php
}
}
?>
                </ul>
            </div>
        </div>
        <div class="td"></div>
    </div>
</div>
<div class="rightt">


<div class="nn">
<div class="nntt">
    <div class="baoo">提交报名</div>
</div>
<div class="nnz">

<script language="JavaScript">
    var course_type = <?php echo $GLOBALS['_vars']['course_type']; ?>;
    $(document).ready(function(){
        display_and_hide('tr.f_personal', 'tr.f_enterprise', course_type);
    });

    function CheckForm() {
        if (document.myform.name.value == "") {
            alert("请输入您的姓名!");
            document.myform.name.focus();
            return false;
        }
        if (document.myform.telephone.value == "") {
            alert("请输入您的电话!");
            document.myform.telephone.focus();
            return false;
        }
        if (document.myform.email.value == "") {
            alert("请输入您的邮箱地址!");
            document.myform.email.focus();
            return false;
        }
        if (document.myform.content.value == "") {
            alert("请输入反馈内容!");
            document.myform.content.focus();
            return false;
        }
        if (document.myform.vdcode.value == "") {
            alert("请输入验证码!");
            document.myform.vdcode.focus();
            return false;
        }
    }
</script>

<form name="myform" method="post" action="/module/buy_action.php" onsubmit="return CheckForm();">
    <input name="arcid" type="hidden" size="25"
           value=<?php echo $GLOBALS['_vars']['arcid']; ?>>
    <table width="100%" border="0" align="center" cellPadding="5" cellSpacing="1">
        <tr>
            <td height="40" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr>
            <td height="25" align="right">课程名：&nbsp;</td>
            <td width="30%" height="25" align="left">
                <input class="input" name="course_name" disabled="disabled" type="text" size="25"
                    value=<?php echo $GLOBALS['_vars']['name']; ?>>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>


        <tr>
            <td width="15%" height="25" align="right">开课时间：&nbsp;</td>
            <td height="25" align="left">
                <input class="input" name="course_start_time" disabled="disabled" type="text" size="25"
                   value=<?php echo MyDate('',$GLOBALS['_vars']['start_date']); ?>/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr>
            <td width="15%" height=23 align="right">开课地点：&nbsp;</td>
            <td height=23 align="left">
                <input class="input" name="course_location" disabled="disabled" type="text" size="25"
                       value=<?php echo $GLOBALS['_vars']['location']; ?>>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr>
            <td height="25" align="right">费用：&nbsp;</td>
            <td height="25"><input class="input" name="course_price" disabled="disabled" type="text" size="25"
                   value=<?php echo $GLOBALS['_vars']['price']; ?>>
                &nbsp;<font color="red">*</font></td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_personal">
            <td height="25" align="right">负责人姓名：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_name" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>

        <tr class="f_personal">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_personal">
            <td height="25" align="right">报名人数：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_count" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_personal">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_personal">
            <td height="25" align="right">负责人电话：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_tel" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_personal">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>


        <tr class="f_personal">
            <td height="25" align="right">负责人手机：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_mobile" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_personal">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_personal">
            <td height="25" align="right">负责人-Email：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_email" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_personal">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>


        <tr class="f_enterprise">
            <td height="25" align="right">公司名称：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_company" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_enterprise">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_enterprise">
            <td height="25" align="right">公司电话：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_company_tel" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_enterprise">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr class="f_enterprise">
            <td height="25" align="right">公司传真：&nbsp;</td>
            <td height="25">
                <input class="input" name="client_company_fax" type="text" size="25"/>
                &nbsp;<font color="red">*</font>
            </td>
        </tr>
        <tr class="f_enterprise">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>
        <tr class="f_enterprise">
            <td width="15%" height="25" align="right">公司地址：&nbsp;</td>
            <td height="25" align="left"><input class="input" name="client_company_address" type="text" size="60"/></td>
        </tr>
        <tr class="f_enterprise">
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>


        <tr>
            <td width="15%" height="25" align="right">其他说明：&nbsp;</td>
            <td height="25" align="left">
                <textarea class="input" name="content" rows="8" cols="48"></textarea>
                <font color="red">*</font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>
        <tr>
            <td width="15%" height="25" align="right">支付方式：&nbsp;</td>
            <td height="25" align="left">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="my_table">
                    <tr onMouseMove="javascript:this.bgColor='#F8F8F8';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
                        <td width="10%" align="right" style="vertical-align:middle;"></td>
                        <td width="20%" valign="middle" style="vertical-align:middle;"> 方式 </td>
                        <td width="60%"> 描述 </td>
                        <td width="10%" align="center"> 手续费</td>
                        <font color="red">*</font>
                    </tr>
                <?php  foreach($GLOBALS['shops_paymentarr'] as $key=>$value){ ?>
                    <tr onMouseMove="javascript:this.bgColor='#F8F8F8';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
                        <td width="10%" align="right" style="vertical-align:middle;"><input name="paytype" type="radio" value="<?php echo $value['id']; ?>" /></td>
                        <td width="20%" valign="middle" style="vertical-align:middle;"> <?php echo $value['name']; ?> </td>
                        <td width="60%"> <?php echo $value['description']; ?> </td>
                        <td width="10%" align="center"> <span class="red"><?php echo $value['fee']; ?></span>元</td>
                        <font color="red">*</font>
                    </tr>
                <?php  }    ?>

                </table>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="2" style="line-height:10px;">&nbsp;</td>
        </tr>

        <tr>
            <td width="15%" height="25" align="right">验证码：&nbsp;</td>
            <td height="25" align="left">
                <input class="input" name="vdcode" type="text" size="10"/>
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
                <input class="submit" type="submit"  name="submitsure">
                <input class="submitt" type="reset"  name="Reset">
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