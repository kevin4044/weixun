<?php   if(!defined('XAKINC')) exit('Warning...');
/**
 * 连载图书最新内容调用
 *
 * @version        $Id: bookcontentlist.lib.php 1 9:29 2010年7月6日Z
 */
 

 
require_once(XAKINC.'/taglib/booklist.lib.php');

function lib_bookcontentlist(&$ctag, &$refObj)
{
    global $dsql, $envs, $cfg_dbprefix, $cfg_cmsurl;

    $attlist="row|12,booktype|-1,titlelen|30,orderby|lastpost,author|,keyword|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    if( !$dsql->IsTable("{$cfg_dbprefix}story_books") ) return '没安装连载模块';
    
    return lib_booklist($ctag, $refObj, 1);
    
}