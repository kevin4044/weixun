<?php
require_once(dirname(__FILE__)."/../../functions/common.inc.php");
require_once(XAKROOT.'/module/rpad/rpad_func.php');

if(isset($arcID)) $aid = $arcID;
$arcID = $aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
if($aid==0) die(' Warning... ');

$cacheFile = XAKDATA.'/cache/rpad-'.$aid.'.htm';
if( isset($nocache) || !file_exists($cacheFile) || time() - filemtime($cacheFile) > $cfg_puccache_time )
{
	$row = $dsql->GetOne("Select * From `#@__rpad` where aid='$aid' ");
	$adbody = '';
	if($row['timeset']==0)
	{
		$adbody = rpadParser($row['adtype'],$row['normparams']);
	}
	else
	{
		$ntime = time();
		if($ntime>$row['endtime'] || $ntime < $row['starttime']) {
			$adbody = $row['expbody'];
		}
		else {
			$adbody = rpadParser($row['adtype'],$row['normparams']);
		}
	}
	$adbody = str_replace('"', '\"',$adbody);
	$adbody = str_replace("\r", "\\r",$adbody);
	$adbody = str_replace("\n", "\\n",$adbody);
	$adbody = "<!--\r\ndocument.write(\"{$adbody}\");\r\n-->\r\n";
	$fp = fopen($cacheFile, 'w');
	fwrite($fp, $adbody);
	fclose($fp);
}
include $cacheFile;
?>