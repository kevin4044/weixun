<?php   if(!defined('XAKINC')) exit('Warning...');

 
function lib_bshare(&$ctag,&$refObj)
{
    global $dsql,$envs;

    $attlist='type|0';
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $bscodeFile = XAKDATA.'/cache/bshare.code.inc';
    if (!file_exists($bscodeFile))  return '';
    
    $reval = stripslashes(file_get_contents($bscodeFile));
    return $reval;
}