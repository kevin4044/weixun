<?php
/**
 * 采集规则测试
 *
 * @version        $Id: co_test_rule.php 1 17:13 2010年7月12日Z 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(XAKINC."/xakcollection.class.php");
$nid = intval($nid);
$co = new XakCollection();
$co->LoadNote($nid);
include XAKINClude('templets/co_test_rule.htm');
exit();