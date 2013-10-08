<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>网站会员管理</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/member.js"></script>
<style type="text/css">
.rb{ border-right:1px solid #666666 }
.tb{ border-top:1px solid #666666 }
</style>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#BFD8E0" style="margin-bottom:6px">
  <tr>
    <td height="30" align="center" bgcolor="#F9FCFD"> 
  <form action="member_main.php" name="form1" method="get">
	  <table border="0" cellspacing="0" cellpadding="3">
      <tr>
          <td>关键字：</td>
          <td><input name="keyword" type="text" id="keyword" size="12" style="width:120px" value="<?php echo $GLOBALS['keyword']; ?>" /></td>
          <td>&nbsp;排序：</td>
          <td>
		        <select name="sortkey" id="sortkey" style="width:120px">
              <?php echo $GLOBALS['sortform']; ?>
				      <option value="mid">mid/注册时间</option>
              <option value="logintime">登录时间</option>
              <option value="rank">会员等级</option>
              <option value="money">会员金币</option>
              <option value="scores">会员积分</option>
            </select>
          </td>
          <td>
		         <select name="sex" id="sex" style="width:60px">
               <?php echo $GLOBALS['sexform']; ?>
               <option value="男">男</option>
               <option value="女">女</option>
               <option value="保密">保密</option>
             </select>
          </td>
          <td>
          	<select name="mtype" id="mtype" style="width:60px">
               <?php echo $GLOBALS['mtypeform']; 
           		foreach($MemberModels as $row)
           		{
           			echo "<option value=".$row['name'].">".$row['name']."</option>\r\n";
           		}
           	   ?>
             </select>
          </td>
          <td>
		      <select name="spacesta" id="spacesta" style="width:150px">
              <option value='-10'>--会员状态--</option>
              <?php
           		foreach($staArr as $k=>$v)
           		{
           			if($spacesta==$k) echo "<option value='$k' selected>$v</option>\r\n";
           			else echo "<option value='$k'>$v</option>\r\n";
           		}
           	  ?>
            </select></td>
         <td>
           <input name="imageField" class="np" type="image" src="images/button_search.gif" border="0" />
          </td>
        </tr>
      </table>
	  </form>
    </td>
  </tr>
</table>
<form name="form2">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#BFD8E0">
  <tr> 
  <td height="28" colspan="10" background="images/tbg.gif">
   <table width="99%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="29%" style="padding-left:10px;"><strong>注册会员列表</strong></td>
       <td width="71%" align="right">
          <a href="member_main.php">所有会员</a> |
          <a href="member_main.php?spacesta=-2">被禁言用户</a>
       </td>
     </tr>
  </table>
 </td>
</tr>
  <tr bgcolor="#FEFCEF" height="30" align="center"> 
    <td width="5%">选择</td>
    <td width="5%">mid</td>
    <td width="10%">登录名</td>
    <td width="12%">Email</td>
    <td width="13%">昵称</td>
    <td width="5%">性别</td>
    <td width="10%">会员等级</td>
    <td width="10%">会员属性</td>
    <td width="15%">最后登录</td>
    <td width="15%">操作</td>
  </tr>
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?> 
<tr height="26" align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#F9FCFD';"
  	 onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
  <td><input name="mid" type="checkbox" id="mid" value="<?php echo $fields['mid']; ?>" class="np" /></td>
  <td><?php echo $fields['mid']; ?></td>
  <td><a href="../user/index.php?uid=<?php echo $fields['userid']; ?>" target='_blank'>
    <?php
	  echo '<u>'.$fields['userid'].'</u>';
	if($fields['spacesta']==-2) echo "<font color='red'>(禁言)</font>";
	if($fields['spacesta']==-1) echo "<font color='red'>(未审核)</font>";
	?>
  </a></td>
	<td>
	  <?php echo $fields['email']; ?>
	</td>
  <td>
	  <?php echo $fields['uname']; ?>
  </td>  
  <td>
  	<?php echo $fields['sex']; ?>
  </td>
  <td>
  	<a href="member_main.php?rank=<?php echo $fields['rank']; ?>"><?php echo GetMemberName($fields['rank'],'限制会员'); ?></a>
  </td>
  <td>
  	<?php echo $fields['mtype']; ?>用户<br/><?php echo GetMAtt($fields['matt']); ?>
  </td>
  <td>
  	<?php echo MyDate('y-m-d H:i',$fields['logintime']); ?>
  	<br />
  	【<?php echo $fields['loginip']; ?>】
  </td>
  <td align="center">
    <a href="member_view.php?id=<?php echo $fields['mid']; ?>">修改</a> | 
    <a href="member_do.php?id=<?php echo $fields['mid']; ?>&dopost=delmember">删除</a> |
    <a href="content_list.php?mid=<?php echo $fields['mid']; ?>" target="_blank">文档</a>
  </td>
</tr>
<?php
}
}?> 
<tr bgcolor="#ffffff"> 
 <td height="36" colspan="10">
	&nbsp;
	<a href="javascript:selAll()" class="coolbg">全选</a>
	<a href="javascript:noSelAll()" class="coolbg">取消</a>
	<a href="javascript:delArc(0)" class="coolbg">&nbsp;删除&nbsp;</a>
 </td>
</tr>
<tr bgcolor="#F9FCFD"> 
 <td height="36" colspan="10" align="center">
	<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

 </td>
</tr>
</table>
</form>
</body>
</html>