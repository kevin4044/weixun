<?php
/**
 * 栏目管理
 *
 * @version        $Id: catalog_main.php 1 14:31 2010年7月12日Z 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(XAKINC."/typeunit.class.admin.php");
$userChannel = $cuserLogin->getUserChannel();
include XAKINClude('templets/catalog_main.htm');