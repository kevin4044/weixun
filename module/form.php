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

$course_type = 0;
$sql_str = '';

if (!isset($arcid)) {
	ShowMsg('订单错误，请联系管理员', '-1');
}

//TODO:this sql command is erro on and
$sql_str =
    "SELECT typeid, price, name, start_date, location
FROM  `#@__course`
WHERE aid =$arcid
UNION SELECT typeid, price, name, start_date, location
FROM  `#@__personal`
WHERE aid =$arcid
UNION SELECT typeid, price, name, start_date, location
FROM  `#@__enterprise`
WHERE aid =$arcid";
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
$course_type = GetTopInfo($row['typeid']);

$dtp = new XakTemplate();
$dtp->SetVar('arcid',$arcid);
$dtp->SetVar('course_type',$course_type);
$dtp->SetVar('price',$row['price']);
$dtp->SetVar('name',$row['name']);
$dtp->SetVar('start_date',$row['start_date']);
$dtp->SetVar('location',$row['location']);
$dtp->LoadTemplate(XAKTEMPLATE."/xak/form.htm");
$dtp->Display();
