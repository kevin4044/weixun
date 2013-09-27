<?php
if(!defined('XAKINC'))
{
    exit("Warning...");
}
require_once(XAKINC."/taglib/flink.lib.php");
/**
 * 友情链接
 *
 * @version        $Id: flinktype.lib.php 1 15:57 2011年2月18日Z niap $
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 */
 
 
function lib_flinktype(&$ctag,&$refObj)
{
    global $dsql;
    $attlist="row|24,titlelen|24";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $totalrow = $row;
    $revalue = '';
  
    $equery = "SELECT * FROM #@__flinktype order by id asc limit 0,$totalrow";

    if(trim($ctag->GetInnerText())=='') $innertext = "<li>[field:typename /]</li>";
    else $innertext = $ctag->GetInnerText();
	if(!isset($type)) $type = '';
    $dtp = new XakTagParse();
    $dtp->SetNameSpace("xak","{","}");
    $dtp->LoadString($innertext);
    
    $dsql->SetQuery($equery);
    $dsql->Execute();
    $rs = '';
    $row = array();
    while($dbrow=$dsql->GetObject())
    {
        $row[] = $dbrow;
    }
	
    foreach ($row as $key => $value) {
        if (is_array($dtp->CTags))
        {
            $GLOBALS['envs']['flinkid'] = $value->id;
            foreach($dtp->CTags as $tagid=>$ctag)
            {
                $tagname = $ctag->GetName();
                if($tagname=="flink") $dtp->Assign($tagid, lib_flink($ctag, $refObj));
            }
        }
        $rs = $dtp->GetResult();
    	$rs = preg_replace("/\[field:id([\/\s]{0,})\]/isU", $value->id, $rs);
        $rs = preg_replace("/\[field:typename([\/\s]{0,})\]/isU", $value->typename, $rs);
        $revalue .= $rs;
    }
    
    return $revalue;
}