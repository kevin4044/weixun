<?php
/**
 * 检索操作
 *
 * @version        $Id: action_search.php 1 8:26 2010年7月12日Z 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/actionsearch_class.php");

//增加权限检查
if(empty($dopost)) $dopost = "";

$keyword=empty($keyword)? "" : $keyword;
$actsearch = new ActionSearch($keyword);
$asresult = $actsearch->Search();
include XAKINClude('templets/action_search.htm');
