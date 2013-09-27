<?php
require(dirname(__FILE__)."/config.php");
require_once(XAKINC."/oxwindow.class.php");
CheckPurview('plus_Mail');
if(!isset($fmdo)) $fmdo="";
if($fmdo=="del")
{
		$filename = $cfg_basedir.$activepath."/$filename";
		@unlink($filename); 
		$t="文件";
		ShowMsg("成功删除一个".$t."！","mail_file_manage.php");
}else{
	if(!isset($activepath)){
		$activepath=$cfg_cmspath;
	}
	$inpath = "";
	$activepath = str_replace("..","",$activepath);
	$activepath = preg_replace("#^/{1,}#","/",$activepath);
	if($activepath == "/"){
		$activepath = "";
	}
	if($activepath == ""){
		$inpath = $cfg_basedir."/config/mail";
	}else{
		$inpath = $cfg_basedir.$activepath."/config/mail";
	}
	$activeurl = $activepath;
	if(preg_match("#".$cfg_templets_dir."#i", $activepath)){
		$istemplets = true;
	}else{
		$istemplets = false;
	}
	include XAKINClude('templets/mail_file_manage.htm');
}


?>