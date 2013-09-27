<?php
/**
 * 验证图片
 *
 * @version        $Id: vdimgck.php 1 15:21 2010年7月5日
 */
require_once (dirname(__FILE__).'/common.inc.php');
require_once (XAKDATA.'/safe/inc_safe_config.php');
require_once (XAKDATA.'/config.cache.inc.php');

$config = array(
    'font_size'   => 14,
    'img_height'  => $safe_wheight,
    'word_type'  => (int)$safe_codetype,   // 0:数字  1:英文  2:混合
    'img_width'   => $safe_wwidth,
    'font_file'   => dirname(__FILE__).'/data/fonts/elephant.ttf',
    'wordlist_file'   => dirname(__FILE__).'/data/words/words.txt');


//是否自定义宽度
if(isset($ewidth) && $ewidth > 0)
{
	$config['img_width'] = $ewidth;
}

//是否自定义高度
if(isset($eheight) && $eheight > 0)
{
	$config['img_height'] = $eheight;
}

//重新定义字号
if(isset($efontsize) && $efontsize > 0)
{
	$config['font_size'] = $efontsize;
}


$sessSavePath = XAKDATA."/sessions/";

// Session保存路径
if(is_writeable($sessSavePath) && is_readable($sessSavePath)){ session_save_path($sessSavePath); }
if(!empty($cfg_domain_cookie)) session_set_cookie_params(0,'/',$cfg_domain_cookie);

if (!echo_validate_image($config))
{
    // 如果不成功则初始化一个默认验证码
    @session_start();
    $_SESSION['securimage_code_value'] = strtolower('abcd');
    $im = @imagecreatefromjpeg(dirname(__FILE__).'/data/vdcode.jpg');
    header("Pragma:no-cache\r\n");
    header("Cache-Control:no-cache\r\n");
    header("Expires:0\r\n");
    imagejpeg($im);
    imagedestroy($im);
}

function echo_validate_image( $config = array() )
{
    @session_start();
    
    //主要参数
    $font_size   = isset($config['font_size']) ? $config['font_size'] : 14;
    $img_height  = isset($config['img_height']) ? $config['img_height'] : 30;
    $img_width   = isset($config['img_width']) ? $config['img_width'] : 80;
    $font_file   = isset($config['font_file']) ? $config['font_file'] : PATH_DATA.'/data/fonts/elephant.ttf';
	$word_type   = isset($config['word_type']) ? $config['word_type'] : 3; 
	
	//定义生成字符
	$charset = array(
		'1' => '23456789',
		'2' => 'ABCDEFGHKLMNPRSTUVWYZ',
		'3' => 'ABCDEFGHKLMNPRSTUVWYZ23456789');

    //创建图片
    $im = @imagecreatetruecolor($img_width,$img_height);
    
	//获取随机字符
    $rndstring  = '';
	$charset_len = strlen($charset[$word_type])-1;
	for($i=0; $i<4; $i++)
	{
		$rndstring .= $charset[$word_type][rand(1,$charset_len)];
	}
   
    $_SESSION['securimage_code_value'] = strtolower($rndstring);
    $rndcodelen = strlen($rndstring);
	
	
	//设置背景色
	$background = '#EDF7FF';
	$background = imagecolorallocate($im,hexdec(substr($background, 1,2)),hexdec(substr($background, 3,2)),hexdec(substr($background, 5,2)));
	//画一个柜形，设置背景颜色。
	imagefilledrectangle($im,0,$img_height,$img_width,0,$background);
	
	//输出文字
	$font_color = imagecolorallocate($im, rand(0,156), rand(0,156), rand(0,156));
	$x = $img_width/4;
	for ($i=0; $i<4; $i++) 
	{
		$rndstring[$i] = strtoupper($rndstring[$i]);
		@imagettftext($im, $font_size, rand(-20,20), $x*$i+rand(0,2), $img_height/1.4, $font_color, $font_file, $rndstring[$i]);
	}
	
	//画线
	@imagesetthickness($im, 3);
	$xpos   = ($font_size * 2) + rand(-5, 5);
	$width  = $img_width / 2.66 + rand(3, 10);
	$height = $font_size * 2.14;

	if ( rand(0,100) % 2 == 0 ) 
	{
	  $start = rand(0,66);
	  $ypos  = $img_height / 2 - rand(10, 30);
	  $xpos += rand(5, 15);
	} else {
	  $start = rand(180, 246);
	  $ypos  = $img_height / 2 + rand(10, 30);
	}

	$end = $start + rand(75, 110);

	imagearc($im, $xpos, $ypos, $width, $height, $start, $end, $font_color);
	
	if ( rand(1,75) % 2 == 0 ) {
	  $start = rand(45, 111);
	  $ypos  = $img_height / 2 - rand(10, 30);
	  $xpos += rand(5, 15);
	} else {
	  $start = rand(200, 250);
	  $ypos  = $img_height / 2 + rand(10, 30);
	}

	$end = $start + rand(75, 100);

	imagearc($im, $img_width * .75, $ypos, $width, $height, $start, $end, $font_color);
	
    header("Pragma:no-cache\r\n");
    header("Cache-Control:no-cache\r\n");
    header("Expires:0\r\n");

    //输出特定类型的图片格式，优先级为 gif -> jpg ->png
    if(function_exists("imagejpeg"))
    {
        header("content-type:image/jpeg\r\n");
        imagejpeg($im);
    }
    else
    {
        header("content-type:image/png\r\n");
        imagepng($im);
    }
    imagedestroy($im);
    exit();
}
