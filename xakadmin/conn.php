<?php
if(!defined('XAKADMIN')) exit("Warning...");

//关闭后台操作
/*header("Content-type: text/html; charset=utf-8"); 
exit("网站功能更新中....");*/

/*后台导航菜单开关  1为开启 0为关闭*/
$open_content = 1;  //内容管理
$open_category = 1;  //栏目配置
$open_html = 1;  //Html生成
$open_templets = 0;  //界面模板
$open_collection = 1;  //采集管理
$open_member = 1;  //会员管理
$open_module = 1; //模块配置
$open_config = 1;  //系统设置


$open_comment = 0;  //发布页评论开关
$open_help = 0; //系统帮助


/*后台基本参数菜单开关  1为开启 0为关闭*/
$open_sysconfig = array(
	'站点设置' => '1',
	'核心设置' => '1',
	'附件设置' => '1',
	'会员设置' => '1',
	'互动设置' => '1',
	'性能选项' => '1',
	'其它选项' => '1',
	'模块设置' => '1'
);
?>