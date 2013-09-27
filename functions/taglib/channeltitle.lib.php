<?php
if(!defined('XAKINC'))
{
 exit("Warning...");
}
/**
 * 栏目名称调用标签
 * 标签编写：寂寞天涯
 * 时间：2008年12月13日
 * 标签使用说明：
 * {xak:channeltitle order='forward|backward' character='-'/}
 * order:栏目显示顺序 
 *       order='forward'   从左到右顺序为“顶级栏目-一级栏目-二级栏目”
 *       order='backward'  从左到右顺序为“二级栏目-一级栏目-顶级栏目”
 * character：间隔使用符号
 */
function lib_channeltitle(&$ctag,&$refObj)
{
 global $dsql,$envs;
 
 //属性处理
 $attlist="order|forward,character|-";
 FillAttsDefault($ctag->CAttribute->Items,$attlist);
 extract($ctag->CAttribute->Items, EXTR_SKIP);
 $revalue = '';
 $curID = $envs['typeid'];
 $TypeLink = new TypeLink($curID);
 
 //开始处理
 $Temprevalue = ereg_replace("[<>-]",$character,$TypeLink->GetPositionLink(false));
 if($order =="forward")
 {
 	$revalue = $Temprevalue;
 }
 else
 {
  $revaluearrays = explode($character,$Temprevalue);
  foreach($revaluearrays as $key => $revaluearray)
  {
  	($key == 0)? $Tempre = trim($revaluearray):$Tempre = trim($revaluearray).$character.$Tempre;
  }
  $revalue = $Tempre;
  //替换掉语言项
  $lang=array('中文','English','简体中文','日本语','En');
  foreach($lang as $key => $val)
  {
	 $revalue =str_replace($character.$val,'',$revalue);
  }
 }
 return $revalue;
}
?>