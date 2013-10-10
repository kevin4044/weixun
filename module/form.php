<?php
/**
 *
 * 订单填写页面
 *
 * @version        $Id: form.php 2013.10.01 16:09

 */
require_once(dirname(__FILE__)."/../functions/common.inc.php");
require_once(dirname(__FILE__)."/../functions/extend.func.php");

$arcid= $_GET['arcid'];
$typeid = $_GET['typeid'];

$sql_str = '';
$temp_file = '';

if (!isset($arcid)) {
	ShowMsg('订单错误，请联系管理员', '-1');
}

$dtp = new XakTemplate();
$sql_str = "SELECT typeid, price, name, start_date, location
FROM  `#@__course`
WHERE aid =$arcid
UNION SELECT typeid, price, name, start_date, location
FROM  `#@__personal`
WHERE aid =$arcid
UNION SELECT typeid, price, name, start_date, location
FROM  `#@__enterprise`
WHERE aid =$arcid";

$topid = GetTopInfo($typeid);
if ($topid == 1) {
    $temp_file = "/xak/form.htm";
} elseif ($topid == 2) {
    $temp_file = "/xak/form_enterprise.htm";
} elseif ($topid == 3) {
    $temp_file = "/xak/form_personal.htm";
}

//显示支付方式
//获取支付接口列表
$shops_paymentarr = array();
$dsql->SetQuery("SELECT * FROM #@__payment WHERE enabled='1' ORDER BY rank ASC");
$dsql->Execute();
$i = 0 ;
while($row = $dsql->GetArray())
{
    $shops_paymentarr[] = $row;
    $i++;
}
unset($row);
/*
$sql_str = "select typeid, price, name, start_date, location from `#@__course`, `#@__personal`, `#@__enterprise` where aid=$arcid";
*/

$row = $dsql->GetOne($sql_str);

$dtp->SetVar('arcid',$arcid);
$dtp->SetVar('topid',$topid);
$dtp->SetVar('course_type',$typeid);
$dtp->SetVar('data',$row);
$dtp->LoadTemplate(XAKTEMPLATE.$temp_file);
$dtp->Display();
