<?php   if(!defined('XAKINC')) exit('Warning...');
/**
 * 广告调用
 *
 * @version        $Id: myad.lib.php 1 9:29 2010年7月6日Z
 */
 

 
require_once(XAKINC.'/taglib/mytag.lib.php');

function lib_myad(&$ctag, &$refObj)
{
    $attlist = "typeid|0,name|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $body = lib_GetMyTagT($refObj, $typeid, $name, '#@__myad');
    
    return $body;
}