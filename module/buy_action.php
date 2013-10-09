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
$price = $_POST['course_price'];
$course_name = $_POST['course_name'];
$client_name = $_POST['client_name'];
$client_count = $_POST['client_count'];
$client_tel = $_POST['client_tel'];
$client_email = $_POST['client_email'];
$co_name = isset($_POST['client_company'])? $_POST['client_company'] : NULL;
$co_tel = isset($_POST['client_company_tel'])? $_POST['client_company_tel'] : NULL;
$co_fax = isset($_POST['client_company_fax'])? $_POST['client_company_fax'] : NULL;
$co_address = isset($_POST['client_company_address'])? $_POST['client_company_address'] : NULL;
$content = $_POST['content'];

//生成订单号
//存入订单
if(!isset($dopost) || empty($dopost)) {
    //订单号
    $oid = 0;
    $tmp_cart = new MemberShops();
    //gen the oid
    $oid = $tmp_cart->MakeOrders();

    $rows = $dsql->GetOne("SELECT `oid` FROM #@__shops_orders WHERE oid='$oid' LIMIT 0,1");


    $ip = GetIP();
    $stime = time();
    //加入新订单
    if(empty($rows['oid']))
    {
        //TODO:extra fee is not counted in
        $sql = "INSERT INTO `#@__shops_orders`
        (`oid`,`name`,`price`,`state`,`ip`,`stime`,`pid`,`paytype`,`dprice`,`priceCount`,`people_count`)
            VALUES ('$oid','$course_name','$price','0','$ip','$stime','0','$paytype','0','$price','$client_count')";
        echo $sql;
        $val =array();
        //更新订单
        if($dsql->ExecuteNoneQuery($sql))
        {
            //写入订单产品
            $val['price'] = str_replace(",","",$val['price']);
            $dsql->ExecuteNoneQuery("INSERT INTO `#@__shop_public` (`oid`,`client_name`,`client_tel`,`client_mobile`,
                    `client_email`,`co_name`,`co_tel`,`co_fax`,`co_addr`,`content`)
                    VALUES ('$oid','$client_name','$client_tel','$client_mobile','$client_email','$co_name','$co_tel',
                    '$co_fax','$co_addr','$content')");
            echo $sql;
            //插入收件人信息
        }
        else
        {
            ShowMsg("新建订单时产生错误！".$dsql->GetError(),"-1");
            exit();
        }
    }
    //更新订单
    /*
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
    */

    $button = get_pay_button($oid, $paytype, $price,$course_name);

    echo $button;

}
//TODO:what does it mean
//支付返回
else if ($dopost == 'return')
{
    $write_list = array('alipay', 'bank', 'cod', 'yeepay');
    if (in_array($code, $write_list))
    {
        require_once XAKINC.'/payment/'.$code.'.php';
        $pay = new $code;
        $msg=$pay->respond();
        ShowMsg($msg, "javascript:;", 0, 3000);
        exit();  
    } 
	else 
	{
        exit('Error:File Type Can\'t Recognized!');
    }
}




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
/*
 *@description  get_pay button by pay type
 *@param        $oid order id
 *@param        $paytype typeid 
 *@param        $price product price
 *@return       pay button code
 */
function get_pay_button($oid,$paytype,$price,$course_name)
{
    global $dsql;
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
            'product_name' => $course_name
        );
        require_once XAKDATA.'/payment/'.$rs['code'].'.php';
    }
    $payment = 'none';
    //获取支付按钮
    $button = $pay->GetCode($order,$payment);
    return $button;
}
