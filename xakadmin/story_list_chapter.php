<?php
/**
 * @version        $Id: story_list_chapter.php 1 9:02 2010年9月25日
 */

require_once(dirname(__FILE__). "/config.php");
require_once XAKINC. '/datalistcp.class.php';
setcookie("ENV_GOBACK_URL", $xakNowurl, time()+3600,"/");
CheckPurview('story_books');
if(!isset($action)) $action = '';

if(!isset($keyword)) $keyword = "";

if(!isset($bid)) $bid = 0;

if(!empty($bookid)) $bid = $bookid;


$addquery = " id>0 ";
$orderby = " ORDER BY id DESC ";
if($keyword!="") $addquery .= " And (bookname LIKE '%$keyword%' OR chaptername LIKE '%$keyword%') ";

if($bid!=0) $addquery .= " And bookid='$bid' ";


$query = "
   SELECT * FROM #@__story_chapter WHERE $addquery $orderby
";
$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetParameter("keyword", $keyword);
$dlist->SetParameter("bid", $bid);
$dlist->SetTemplate(XAKADMIN. '/templets/story_list_chapter.htm');
$dlist->SetSource($query);
$dlist->Display();
