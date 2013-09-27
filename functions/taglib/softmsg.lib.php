<?php
if(!defined('XAKINC'))
{
    exit("Warning...");
}
/**
 * 下载说明标签
 *
 * @version        $Id: softmsg.lib.php 1 9:29 2010年7月6日Z
 */
 

 
function lib_softmsg(&$ctag,&$refObj)
{
    global $dsql;
    //$attlist="type|textall,row|24,titlelen|24,linktype|1";
    //FillAttsDefault($ctag->CAttribute->Items,$attlist);
    //extract($ctag->CAttribute->Items, EXTR_SKIP);
    $revalue = '';
    $row = $dsql->GetOne(" SELECT * FROM `#@__softconfig` ");
    if(is_array($row)) $revalue = $row['downmsg'];
    return $revalue;
}