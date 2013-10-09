<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>支付接口配置</title>
<link href="css/base.css" rel="stylesheet" type="text/css" />
<script language='javascript'>

</script>
</head>
<style>
.npvar {
	width:90%
}
</style>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<center>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#BFD8E0">
    <tr>
      <td height="28" background="images/tbg.gif" colspan="4">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="padding-left:10px;" align="left"><b>支付接口列表</b></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
    </td>
    </tr>
    <tr align="center" bgcolor="#F9FCFD" height="24">
      <td width="20%">支付方式</td>
      <td width="40%">描述</td>
      <td width="10%">排序</td>
      <td width="20%">管理</td>
    </tr>
   <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" height="26" align="center" onMouseMove="javascript:this.bgColor='#F9FCFD';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td><?php echo $fields['name']; ?></td>
      <td align="left"><?php echo $fields['description']; ?></td>
      <td><?php echo $fields['rank']; ?></td>
      <td>
        <?php
        if($fields['enabled'] == 0) {
        ?>
      	<a href='sys_payment.php?dopost=install&pid=<?php echo $fields['id']; ?>'>[安装]</a>
        <?php
        }
        if($fields['enabled'] == 1) {
        ?>
        <a href='sys_payment.php?dopost=install&pid=<?php echo $fields['id']; ?>&pm=edit'>[更改]</a>
        <a href='sys_payment.php?dopost=uninstall&pid=<?php echo $fields['id']; ?>'>[删除]</a>
        <?php
        }
        ?>
      </td>
    </tr>
   <?php
}
}?>
    <tr align="center" bgcolor="#F9FCFD" height="24">
      <td colspan="4"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
  </td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
</center>
</body>
</html>