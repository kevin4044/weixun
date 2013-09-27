<?php
/**
 * 系统权限组
 *
 * @version        $Id: sys_group.php 1 22:28 2010年7月20日Z 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Group');
if(empty($dopost)) $dopost = "";
include XAKINClude('templets/sys_group.htm');