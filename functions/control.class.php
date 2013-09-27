<?php   if(!defined('XAKINC')) exit("Warning...");
/**
 * 控制器基类
 *
 * @version        $Id: control.class.php 1 10:33 2010年7月6日
 */
require_once(XAKINC."/xaktemplate.class.php");

class Control
{
    var $tpl;
    var $dsql;
    var $style='default';
    var $_helpers = array();
    
    var $apptpl = '../templates/';
    
    function __construct()
    {
        $this->Control();
    }
    
    // 析构函数
    function Control()
    {
        global $dsql;
        $this->tpl = isset($this->tpl)? $this->tpl : new XakTemplate();
        $sqltype = "XakSql";
        if ($GLOBALS['cfg_mysql_type'] == 'mysqli' && function_exists("mysqli_init")) $sqltype = "XakSql";
        else $sqltype = "XakSqli";
        $this->dsql = isset($dsql)? $dsql : new $sqltype(FALSE);
    }
    
    //设置模板
    //如果想要使用模板中指定的pagesize，必须在调用模板后才调用 SetSource($sql)
    function SetTemplate($tplfile)
    {
        $tplfile = XAKAPPTPL.'/'.$this->style.'/'.$tplfile;
        $this->tpl->LoadTemplate($tplfile);
    }
    function SetTemplet($tplfile)
    {
        $tplfile = XAKAPPTPL.'/'.$this->style.'/'.$tplfile;
        $this->tpl->LoadTemplate($tplfile);
    }
    
    //设置/获取文档相关的各种变量
    function SetVar($k, $v)
    {
        $this->tpl->Assign($k, $v);
    }

    function GetVar($k)
    {
        global $_vars;
        return isset($_vars[$k]) ? $_vars[$k] : '';
    }
    
    function Model($name='')
    {
        $name = preg_replace("#[^\w]#", "", $name);
        $modelfile = XAKMODEL.'/'.$name.'.php';
        if (file_exists($modelfile))
        {
            require_once $modelfile;
        }
        if (!empty($name) && class_exists($name))
        {
            return new $name;
        } 
        return false;
    }
    
    function Libraries($name='',$data = '')
    {
	if(defined('APPNAME')) 
	{
		$classfile = 'MY_'.$name.'.class.php';
		if ( file_exists ( '../'.APPNAME.'/libraries/'.$classfile ) )
		{
			require '../'.APPNAME.'/libraries/'.$classfile;
			return new $name($data);
		}else{
			if (!empty($name) && class_exists($name))
		        {
		            return new $name($data);
		        }
		}
		return FALSE;
	}else{
		if (!empty($name) && class_exists($name))
	        {
	            return new $name($data);
	        }
	        return FALSE;
	 }
    }  
    
    //载入helper
    function helper($helper = "",$path)
    {   
        $help_path = $path.'/config/helper/'.$helper.".helper.php";
        if (file_exists($help_path))
        { 
            include_once($help_path);
        }else{
            exit('Unable to load the requested file: '.$helper.".helper.php");          
        }  
    }
    
    //显示数据
    function Display()
    {
        $this->tpl->SetObject($this);
        $this->tpl->Display();
    }
    
    //保存为HTML
    function SaveTo($filename)
    {
        $this->tpl->SetObject($this);
        $this->tpl->SaveTo($filename);
    }
    
    // 释放资源
    function __destruct() {
        unset($this->tpl);
        $this->dsql->Close(TRUE);
    }
}