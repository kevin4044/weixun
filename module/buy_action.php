<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kevin
 * Date: 13-10-4
 * Time: 下午1:29
 */
require_once (dirname(__FILE__) . "/../functions/common.inc.php");
define('_PLUS_TPL_', XAKROOT.'/templets/module');
require_once XAKINC.'/xaktemplate.class.php';
require_once XAKINC.'/shopcar.class.php';
require_once XAKINC.'/memberlogin.class.php';

//检查验证码
$svali = GetCkVdValue();
if(strtolower($vdcode)!=$svali || $svali=='')
{
    ResetVdValue();
    ShowMsg("验证码错误！","-1");
    exit();
}

$arcid = $_POST['arcid'];
$price = $_POST['price'];
$course_name = $_POST['course_name'];
$client_name = $_POST['client_name'];
$client_count = $_POST['client_count'];
$client_tel = $_POST['client_tel'];
$client_email = $_POST['client_email'];
$company_name = isset($company_name)? $company_name : NULL;
$company_tel = isset($company_tel)? $company_tel : NULL;
$company_fax = isset($company_fax)? $company_fax : NULL;
$company_address = isset($company_address)? $company_address : NULL;
$content = $_POST['content'];

//生成订单号
//存入订单
if(!isset($dopost) || empty($dopost)) {
    //订单号
    $oid = 0;
    $tmp_cart = new MemberShops();
    $oid = $tmp_cart->MakeOrders();

    $rows = $dsql->GetOne("SELECT `oid` FROM #@__shops_orders WHERE oid='$oid' LIMIT 0,1");


    $ip = GetIP();
    $stime = time();
    //加入新订单
    if(empty($rows['oid']))
    {
        $sql = "INSERT INTO `#@__shops_orders` (`oid`,`cartcount`,`price`,`state`,`ip`,`stime`,`pid`,`paytype`,`dprice`,`priceCount`)
            VALUES ('$oid','0','$price','0','$ip','$stime','0','$paytype','0','$price');";

        //更新订单
        if($dsql->ExecuteNoneQuery($sql))
        {
            //写入订单产品
            $val['price'] = str_replace(",","",$val['price']);
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__shops_products` (`aid`,`oid`,`userid`,`title`,`price`,`buynum`)
                    VALUES ('$arcid','$oid','0','$course_name','$price','$client_count');");
            //插入收件人信息
            $sql = "INSERT INTO `#@__shops_userinfo` (`userid`,`oid`,`consignee`,`address`,`zip`,`tel`,`email`,`des`,
                `people_count`,`company_name`, `company_tel`, `company_fax`)
                 VALUES ('0','$oid','$client_name','$company_address','0','$client_tel','$client_email','$content',
                 '$client_count','$company_name', '$company_tel','$company_fax');
                ";
            $dsql->ExecuteNoneQuery($sql);
        }
        else
        {
            ShowMsg("新建订单时产生错误！".$dsql->GetError(),"-1");
            exit();
        }
    }
    //更新订单
    else
    {
        $sql = "UPDATE `#@__shops_orders` SET
			`price`='$price',
			`ip`='$ip',
			`stime`='$stime',
			`paytype='$paytype',
			priceCount='$price'
            WHERE oid='$oid';";
        if($dsql->ExecuteNoneQuery($sql))
        {
            $sql = "UPDATE `#@__shops_userinfo` SET
				`consignee`='$client_name',
				`address`='$company_address',
				`tel`='$client_tel',
				`email`='$client_email',
				`des`='$content',
				`people_count`='$client_count',
				`company_name`='$company_name',
				`company_tel`='$company_tel',
				`company_fax`='$company_fax'
                WHERE oid='$oid';";
            $dsql->ExecuteNoneQuery($sql);
        }
        else
        {
            echo $dsql->GetError();
            exit;
        }
        unset($sql);
    }

    //获取支付方式
    $rs = $dsql->GetOne("SELECT * FROM `#@__payment` WHERE id='$paytype' ");
    require_once XAKINC.'/payment/'.$rs['code'].'.php';
    $pay = new $rs['code'];
    if($rs['code']=="cod" || $rs['code']=="bank")
    {
        $order = $oid;
    }
    //在线支付
    else
    {
        $order = array(
            'out_trade_no' => $oid,
            'price' => $price + $rs['fee'],
            'product_name' => $course_name;
        );
        require_once XAKDATA.'/payment/'.$rs['code'].'.php';
    }
    //获取支付按钮
    $button = $pay->GetCode($order,$payment);
    $dtp = new XakTemplate();
    //TODO:set templetes
}
//获取支付方式.

//更新支付方式



//获取配送费用
/*
	$sz 首重
	$xz 续重
	$heft 总重量
*/
function GetPeiSon($sz,$xz,$heft)
{
    if($heft < 1000)
    {
        $price =  $sz;
    }
    else
    {
        $price = (ceil($heft/1000)-1)*$xz + $sz;
        $price = round($price,2);
    }
    return $price;
}
