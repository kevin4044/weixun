<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
    <title>订单管理</title>
    <link href="css/base.css" rel="stylesheet" type="text/css" />
    <script language="javascript">
        //获得选中项
        function getCheckboxItem()
        {
            var allSel="";
            if(document.form1.aids.value) return document.form1.aids.value;
            for(i=0;i<document.form1.aids.length;i++)
            {
                if(document.form1.aids[i].checked)
                {
                    if(allSel=="")
                        allSel=document.form1.aids[i].value;
                    else
                        allSel=allSel+"`"+document.form1.aids[i].value;
                }
            }
            return allSel;
        }
        function ReSel()
        {
            for(i=0;i<document.form1.aids.length;i++)
            {
                if(document.form1.aids[i].checked) document.form1.aids[i].checked = false;
                else document.form1.aids[i].checked = true;
            }
        }
        function DelSel()
        {
            var nid = getCheckboxItem();
            if(nid==""){
                alert("请选择要删除的业务记录!\r\n");
                return ;
            }
            location.href = "shops_operations.php?dopost=delete&nid="+nid;
        }
        function UpSel()
        {
            var nid = getCheckboxItem();
            if(nid==""){
                alert("请选择要更改的订单记录!\r\n");
                return ;
            }
            location.href = "shops_operations.php?dopost=up&nid="+nid;
        }
        function OkSel()
        {
            var nid = getCheckboxItem();
            if(nid==""){
                alert("请选择要更改的订单记录!\r\n");
                return ;
            }
            location.href = "shops_operations.php?dopost=ok&nid="+nid;
        }
        function PushSel(){
            var nid = getCheckboxItem();
            if(nid==""){
                alert("请选择要更改的订单记录!\r\n");
                return ;
            }
            location.href = "shops_operations.php?dopost=push&nid="+nid;
        }
        function OpenMyWinN(surl,w,h){
            window.open(surl, "popUpMyWinN", "scrollbars=yes,resizable=yes,statebar=no,width="+w+",height="+h+",left=200, top=100");
        }
    </script>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="100%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cbd8ac;margin-bottom:5px">
    <tr>
        <td height="30" align="center" bgcolor="#FAFCEF">
            <form name="form2" method="get" action="shops_operations.php">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>输入订单号：</td>
                        <td>
                            <input name="buyid" type="text" id="buyid"></td>
                        <td width="100" align="center"> <input name="imageField" type="submit" class='buttonGrey' value="搜索">
                        </td>
                    </tr>
                </table>
            </form></td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#BFD8E0;">
    <tr>
        <td height="28" colspan="11" bgcolor="#EDF9D5" background='images/tbg.gif'>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="30%"  style="padding-left:10px;"><strong>订单列表：</strong> </td>
                    <td width="45%" align="right" style="padding-top:4px">
                        <input type="button" name="ss13" value="未付款" style="width:50px;margin-right:6px" onClick="location='shops_operations.php?sta=0';"  class='buttonGrey'/>
                        <input type="button" name="ss14" value="已付款" style="width:50px;margin-right:6px" onClick="location='shops_operations.php?sta=1';"  class='buttonGrey'/>
                        <input type="button" name="ss142" value="已发货" style="width:50px;margin-right:6px" onClick="location='shops_operations.php?sta=2';"  class='buttonGrey'/>
                        <input type="button" name="ss142" value="已完成" style="width:50px;margin-right:6px" onClick="location='shops_operations.php?sta=4';"  class='buttonGrey'/>
                        <input type="button" name="ss16" value="全部" style="width:40px;margin-right:6px" onClick="location='shops_operations.php';"  class='buttonGrey'/>
                    </td>
                    <td width="25%" align="right" style="padding-top:4px">
                        <input type="button" name="ss12" value="订单管理" style="width:90px;margin-right:6px" onClick="location='shops_operations.php';"  class='buttonGrey'/>
                    </td>
                </tr>
            </table></td>
    </tr>
    <tr bgcolor="#F9FCFD">
        <td width="8%" align="center">选择</td>
        <td width="10%" align="center">订单号</td>
        <td align="center">状态</td>
        <td align="center">内训课题</td>
        <td align="center">计划培训天数</td>
        <td align="center">生成日期</td>
        <td align="center">计划培训日期</td>
        <td align="center">计划参加人数</td>
        <td align="center">培训期望</td>
        <td align="center">公司信息：姓名</td>
        <td align="center">职位</td>
        <td align="center">公司名称</td>
        <td align="center">电子邮件</td>
        <td align="center">公司地址</td>
        <td align="center">邮政编码</td>
    </tr>
    <form name="form1">
        <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
        <tr bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#F9FCFD';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
            <td align="center">
                <input type='checkbox' name='aids' value='<?php echo $fields['oid']?>' class='np'></td>
            <td align="center">
                <?php echo $fields['oid'];?>
            </td>
            <td align="center">
                <?php echo GetSta($fields['state']);?>
            </td>
            <td align="center">
                <a href="" ><?php echo $fields['name']?></a>
            </td>
            <td align="center">
                <?php echo $fields['days']?>
            </td>
            <td align="center">
                <?php echo GetDateTimeMk($fields['stime'])?>
                (<font color="#FF0000"><?php echo floorTime(time()-$fields['stime'],$fields['stime']); ?></font>)
            </td>
            <td align="center">
                <?php echo $fields['date']?>
            </td>
            <td align="center">
                <?php echo $fields['people_count']?>
            </td>
            <td align="center">
                <?php echo $fields['expect']?>
            </td>
            <td align="center">
                <?php echo $fields['co_info']?>
            </td>
            <td align="center">
                <?php echo $fields['job']?>
            </td>
            <td align="center">
                <?php echo $fields['co_name']?>
            </td>
            <td align="center">
                <?php echo $fields['email']?>
            </td>
            <td align="center">
                <?php echo $fields['co_addr']?>
            </td>
            <td align="center">
                <?php echo $fields['postcode']?>
            </td>
        </tr>
        <?php
}
}?>
    </form>
    <tr>
        <td height="28" colspan="11" bgcolor="#FCFDF7" style="padding-top:4px;">&nbsp;
            <input type="button" name="b7" value="反选" class='buttonGrey' style="width:40" onClick="ReSel();">
            <input type="button" name="b" value="删除" style="width:40" onClick="DelSel();" class='buttonGrey' />
            <input type="button" name="b5" value="设为已付款状态" class='buttonGrey' style="width:100" onClick="UpSel();">
            <input type="button" name="b9" value="设为已完成状态" class='buttonGrey' style="width:100" onClick="OkSel();">
        </td>
    </tr>
    <tr>
        <td height="36" colspan="11" bgcolor="#F9FCFD" align="center">
            <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listitem'] = 'info,index,end,pre,next,pageno';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

        </td>
    </tr>
</table>
</body>
</html>