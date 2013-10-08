<?php


/*报错开关*/
error_reporting(E_ALL);
//error_reporting(E_ALL || ~E_NOTICE);

define('XAKINC', str_replace("\\", '/', dirname(__FILE__) ) );
define('XAKROOT', str_replace("\\", '/', substr(XAKINC,0,-10) ) );
define('XAKDATA', XAKROOT.'/config');
define('XAKMEMBER', XAKROOT.'/user');
define('XAKTEMPLATE', XAKROOT.'/templets');

//关闭前后台动态页面操作
/*header("Content-type: text/html; charset=utf-8"); 
exit("网站功能更新中，请稍侯....");*/

// ------------------------------------------------------------------------
define('XAKMODEL', './model');
define('XAKCONTROL', './control');
define('XAKAPPTPL', './templates');

define('DEBUG_LEVEL', FALSE);

if (version_compare(PHP_VERSION, '5.3.0', '<')) 
{
    set_magic_quotes_runtime(0);
}

if(version_compare(PHP_VERSION, '5.3.0', '>'))
{
    if(strtoupper(ini_get('request_order')) == 'GP') 
    {
    	header("Content-type: text/html; charset=utf-8"); 
	exit("请将php.ini 里的 request_order 设为 CGP!");
    }    
}

if (version_compare(PHP_VERSION, '5.4.0', '>=')) 
{
    if (!function_exists('session_register'))
    {
        function session_register()
        { 
            $args = func_get_args(); 
            foreach ($args as $key){ 
                $_SESSION[$key]=$GLOBALS[$key]; 
            } 
        } 
        function session_is_registered($key)
        {
            return isset($_SESSION[$key]); 
        }
        function session_unregister($key){ 
            unset($_SESSION[$key]); 
        }
    }
}

//是否启用mb_substr替换cn_substr来提高效率
$cfg_is_mb = $cfg_is_iconv = FALSE;
if(function_exists('mb_substr')) $cfg_is_mb = TRUE;
if(function_exists('iconv_substr')) $cfg_is_iconv = TRUE;

function _RunMagicQuotes(&$svar)
{
    if(!get_magic_quotes_gpc())
    {
        if( is_array($svar) )
        {
            foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
        }
        else
        {
            if( strlen($svar)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE)#',$svar) )
            {
              exit('Request var not allow!');
            }
            $svar = addslashes($svar);
        }
    }
    return $svar;
}

if (!defined('XAKREQUEST')) 
{
    //检查和注册外部提交的变量
    function CheckRequest(&$val) {
        if (is_array($val)) {
            foreach ($val as $_k=>$_v) {
                if($_k == 'nvarname') continue;
                CheckRequest($_k); 
                CheckRequest($val[$_k]);
            }
        } else
        {
            if( strlen($val)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE)#',$val)  )
            {
                exit('Request var not allow!');
            }
        }
    }
    
    //var_dump($_REQUEST);exit;
    CheckRequest($_REQUEST);

    foreach(Array('_GET','_POST','_COOKIE') as $_request)
    {
        foreach($$_request as $_k => $_v) 
		{
			if($_k == 'nvarname') ${$_k} = $_v;
			else ${$_k} = _RunMagicQuotes($_v);
		}
    }
}

//系统相关变量检测
if(!isset($needFilter))
{
    $needFilter = false;
}
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isSafeMode = @ini_get("safe_mode");
if( preg_match('/windows/i', @getenv('OS')) )
{
    $isSafeMode = false;
}

//Session保存路径
$sessSavePath = XAKDATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
    session_save_path($sessSavePath);
}

//系统配置参数
require_once(XAKDATA."/config.cache.inc.php");

//转换上传的文件相关的变量及安全处理、并引用前台通用的上传函数
if($_FILES)
{
    require_once(XAKINC.'/uploadsafe.inc.php');
}

//数据库配置文件
require_once(XAKDATA.'/xakdb.php');

//载入系统验证安全配置
if(file_exists(XAKDATA.'/safe/inc_safe_config.php'))
{
    require_once(XAKDATA.'/safe/inc_safe_config.php');
    if(!empty($safe_faqs)) $safefaqs = unserialize($safe_faqs);
}

//Session跨域设置
if(!empty($cfg_domain_cookie))
{
    @session_set_cookie_params(0,'/',$cfg_domain_cookie);
}

//php5.1版本以上时区设置
//由于这个函数对于是php5.1以下版本并无意义，因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
    $time51 = $cfg_cli_time * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}
$cfg_isUrlOpen = @ini_get("allow_url_fopen");

//用户访问的网站host
$cfg_clihost = 'http://'.$_SERVER['HTTP_HOST'];

//站点根目录
$cfg_basedir = preg_replace('#'.$cfg_cmspath.'\/functions$#i', '', XAKINC);
if($cfg_multi_site == 'Y')
{
    $cfg_mainsite = $cfg_basehost;
}
else
{
    $cfg_mainsite = '';
}

//模板的存放目录
$cfg_templets_dir = $cfg_cmspath.'/templets';
$cfg_templeturl = $cfg_mainsite.$cfg_templets_dir;
$cfg_templets_skin = empty($cfg_df_style)? $cfg_mainsite.$cfg_templets_dir."/default" : $cfg_mainsite.$cfg_templets_dir."/$cfg_df_style";

//cms安装目录的网址
$cfg_cmsurl = $cfg_mainsite.$cfg_cmspath;

//插件目录，这个目录是用于存放计数器、投票、评论等程序的必要动态程序
$cfg_plus_dir = $cfg_cmspath.'/module';
$cfg_phpurl = $cfg_mainsite.$cfg_plus_dir;

$cfg_data_dir = $cfg_cmspath.'/config';
$cfg_dataurl = $cfg_mainsite.$cfg_data_dir;

//会员目录
$cfg_member_dir = $cfg_cmspath.'/user';
$cfg_memberurl = $cfg_mainsite.$cfg_member_dir;

//专题列表的存放路径
$cfg_special = $cfg_cmspath.'/special';
$cfg_specialurl = $cfg_mainsite.$cfg_special;

//附件目录
$cfg_medias_dir = $cfg_cmspath.$cfg_medias_dir;
$cfg_mediasurl = $cfg_mainsite.$cfg_medias_dir;

//上传的普通图片的路径,建议按默认
$cfg_image_dir = $cfg_medias_dir.'/allimg';

//上传的缩略图
$ddcfg_image_dir = $cfg_medias_dir.'/litimg';

//用户投稿图片存放目录
$cfg_user_dir = $cfg_medias_dir.'/userup';

//上传的软件目录
$cfg_soft_dir = $cfg_medias_dir.'/soft';

//上传的多媒体文件目录
$cfg_other_medias = $cfg_medias_dir.'/media';

//软件摘要信息，****请不要删除本项**** 否则系统无法正确接收系统漏洞或升级信息
$cfg_version = 'V5.0';
$cfg_soft_lang = 'utf-8';
$cfg_soft_public = 'base';

$cfg_softname = '卓睿创想网站管理系统';
$cfg_soft_enname = 'xakcms';
$cfg_soft_devteam = 'Xak Team';

//文档的默认命名规则
$art_shortname = $cfg_df_ext = '.html';
$cfg_df_namerule = '{typedir}/{aid}'.$cfg_df_ext;

//新建目录的权限，如果你使用别的属性，本程不保证程序能顺利在Linux或Unix系统运行
if(isset($cfg_ftp_mkdir) && $cfg_ftp_mkdir=='Y')
{
    $cfg_dir_purview = '0755';
}
else
{
    $cfg_dir_purview = 0755;
}

//会员是否使用精简模式（已禁用）
$cfg_mb_lit = 'N';

//特殊全局变量
$_sys_globals['curfile'] = '';
$_sys_globals['typeid'] = 0;
$_sys_globals['typename'] = '';
$_sys_globals['aid'] = 0;

if(empty($cfg_addon_savetype))
{
    $cfg_addon_savetype = 'Ymd';
}
if($cfg_sendmail_bysmtp=='Y' && !empty($cfg_smtp_usermail))
{
    $cfg_adminemail = $cfg_smtp_usermail;
}

//对全局分页传递参数进行过滤
if (isset($GLOBALS['PageNo'])) {
    $GLOBALS['PageNo'] = intval($GLOBALS['PageNo']);
}
if (isset($GLOBALS['TotalResult'])) {
    $GLOBALS['TotalResult'] = intval($GLOBALS['TotalResult']);
}

// ------------------------------------------------------------------------
// 设定缓存配置信息
if ($cfg_memcache_enable == 'Y')
{
    $cache_helper_config = array();
    $cache_helper_config['memcache']['is_mc_enable'] = $GLOBALS["cfg_memcache_enable"];
    $cache_helper_config['memcache']['mc'] = array (
        'default' => $GLOBALS["cfg_memcache_mc_defa"],
        'other' => $GLOBALS["cfg_memcache_mc_oth"]
    );
    $cache_helper_config['memcache']['mc_cache_time'] = $GLOBALS["cfg_puccache_time"];
}


if(!isset($cfg_NotPrintHead)) {
    header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

//自动加载类库处理
function __autoload($classname)
{
    global $cfg_soft_lang;
    $classname = preg_replace("/[^0-9a-z_]/i", '', $classname);
    if( class_exists ( $classname ) )
    {
        return TRUE;
    }
    $classfile = $classname.'.php';
    $libclassfile = $classname.'.class.php';
        if ( is_file ( XAKINC.'/'.$libclassfile ) )
        {
            require XAKINC.'/'.$libclassfile;
        }
        else if( is_file ( XAKMODEL.'/'.$classfile ) ) 
        {
            require XAKMODEL.'/'.$classfile;
        }
        else
        {
            if (DEBUG_LEVEL === TRUE)
            {
                echo '<pre>';
				echo $classname.'类找不到';
				echo '</pre>';
				exit ();
            }
            else
            {
                
            }
        }
}

//引入数据库类
if ($GLOBALS['cfg_mysql_type'] == 'mysqli' && function_exists("mysqli_init"))
{
    require_once(XAKINC.'/xaksqli.class.php');
} else {
    require_once(XAKINC.'/xaksql.class.php');
}


//全局常用函数
require_once(XAKINC.'/common.func.php');

// 模块MVC框架需要的控制器和模型基类
require_once(XAKINC.'/control.class.php');
require_once(XAKINC.'/model.class.php');

//载入小助手配置,并对其进行默认初始化
if(file_exists(XAKDATA.'/helper.inc.php'))
{
    require_once(XAKDATA.'/helper.inc.php');
    // 若没有载入配置,则初始化一个默认小助手配置
    if (!isset($cfg_helper_autoload))
    {
        $cfg_helper_autoload = array('util', 'charset', 'string', 'time', 'cookie');
    }
    // 初始化小助手
    helper($cfg_helper_autoload);
}