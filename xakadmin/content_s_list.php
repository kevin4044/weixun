<?php
/**
 * 专题列表
 *
 * @version        $Id: content_s_list.php 1 14:31 2010年7月12日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('spec_List');
$s_tmplets = "templets/content_s_list.htm";
$channelid = -1;
include(dirname(__FILE__)."/content_list.php");