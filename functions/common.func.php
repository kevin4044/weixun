<?php
/**
 * 系统核心函数存放文件
 * @version        $Id: common.func.php 4 16:39 2010年7月6日
 */
if(!defined('XAKINC')) exit('Error');

/**
 *  载入小助手,系统默认载入小助手
 *
 * @access    public
 * @param     mix   $helpers  小助手名称,可以是数组,可以是单个字符串
 * @return    void
 */
$_helpers = array();
function helper($helpers)
{
    //如果是数组,则进行递归操作
    if (is_array($helpers))
    {
        foreach($helpers as $Xak)
        {
            helper($Xak);
        }
        return;
    }

    if (isset($_helpers[$helpers]))
    {
        continue;
    }
    if (file_exists(XAKINC.'/helpers/'.$helpers.'.helper.php'))
    { 
        include_once(XAKINC.'/helpers/'.$helpers.'.helper.php');
        $_helpers[$helpers] = TRUE;
    }
    // 无法载入小助手
    if ( ! isset($_helpers[$helpers]))
    {
        exit('Unable to load the requested file: helpers/'.$helpers.'.helper.php');                
    }
}

/**
 *  控制器调用函数
 *
 * @access    public
 * @param     string  $ct    控制器
 * @param     string  $ac    操作事件
 * @param     string  $path  指定控制器所在目录
 * @return    string
 */
function RunApp($ct, $ac = '',$directory = '')
{
    
    $ct = preg_replace("/[^0-9a-z_]/i", '', $ct);
    $ac = preg_replace("/[^0-9a-z_]/i", '', $ac);
        
    $ac = empty ( $ac ) ? $ac = 'index' : $ac;
	if(!empty($directory)) $path = XAKCONTROL.'/'.$directory. '/' . $ct . '.php';
	else $path = XAKCONTROL . '/' . $ct . '.php';
        
	if (file_exists ( $path ))
	{
		require $path;
	} else {
		 if (DEBUG_LEVEL === TRUE)
        {
            trigger_error("Load Controller false!");
        }
        //生产环境中，找不到控制器的情况不需要记录日志
        else
        {
            header ( "location:/404.html" );
            die ();
        }
	}
	$action = 'ac_'.$ac;
    $loaderr = FALSE;
    $instance = new $ct ( );
    if (method_exists ( $instance, $action ) === TRUE)
    {
        $instance->$action();
        unset($instance);
    } else $loaderr = TRUE;
        
    if ($loaderr)
    {
        if (DEBUG_LEVEL === TRUE)
        {
            trigger_error("Load Method false!");
        }
        //生产环境中，找不到控制器的情况不需要记录日志
        else
        {
            header ( "location:/404.html" );
            die ();
        }
    }
}

/**
 *  载入小助手,这里用户可能载入用helps载入多个小助手
 *
 * @access    public
 * @param     string
 * @return    string
 */
function helpers($helpers)
{
    helper($helpers);
}

//兼容php4的file_put_contents
if(!function_exists('file_put_contents'))
{
    function file_put_contents($n, $d)
    {
        $f=@fopen($n, "w");
        if (!$f)
        {
            return FALSE;
        }
        else
        {
            fwrite($f, $d);
            fclose($f);
            return TRUE;
        }
    }
}

/**
 *  显示更新信息
 *
 * @return    void
 */
function UpdateStat()
{
    include_once(XAKINC."/inc/inc_stat.php");
    return SpUpdateStat();
}


/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function ShowMsg($msg, $gourl, $onlymsg=0, $limittime=0)
{
    if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

    $htmlhead  = "<html>\r\n<head>\r\n<title>系统提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<center>\r\n<script>\r\n";
    $htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    $litime = ($limittime==0 ? 1000 : $limittime);
    $func = '';

    if($gourl=='-1')
    {
        if($limittime==0) $litime = 5000;
        $gourl = "javascript:history.go(-1);";
    }

    if($gourl=='' || $onlymsg==1)
    {
        $msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
    }
    else
    {
        //当网址为:close::objname 时, 关闭父框架的id=objname元素
        if(preg_match('/close::/',$gourl))
        {
            $tgobj = trim(preg_replace('/close::/', '', $gourl));
            $gourl = 'javascript:;';
            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
        }
        
        $func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
        $rmsg = $func;
        $rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>系统提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";
        
        if($onlymsg==0)
        {
            if( $gourl != 'javascript:;' && $gourl != '')
            {
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
                $rmsg .= "<br/></div></div>\");\r\n";
                $rmsg .= "setTimeout('JumpUrl()',$litime);";
            }
            else
            {
                $rmsg .= "<br/></div></div>\");\r\n";
            }
        }
        else
        {
            $rmsg .= "<br/><br/></div></div>\");\r\n";
        }
        $msg  = $htmlhead.$rmsg.$htmlfoot;
    }
    echo $msg;
}

/**
 *  获取验证码的session值
 *
 * @return    string
 */
function GetCkVdValue()
{
	@session_id($_COOKIE['PHPSESSID']);
    @session_start();
    return isset($_SESSION['securimage_code_value']) ? $_SESSION['securimage_code_value'] : '';
}

/**
 *  PHP某些版本有Bug，不能在同一作用域中同时读session并改注销它，因此调用后需执行本函数
 *
 * @return    void
 */
function ResetVdValue()
{
    @session_start();
    $_SESSION['securimage_code_value'] = '';
}


// 自定义函数接口
if( file_exists(XAKINC.'/extend.func.php') )
{
    require_once(XAKINC.'/extend.func.php');
}

//密码加密
function PassJoin($pass)
{
	$pass = substr(md5($pass),7,21);
	$pass = strtoupper($pass);
	$pass = md5($pass);
	return $pass;
}