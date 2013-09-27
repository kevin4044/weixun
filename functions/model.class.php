<?php   if(!defined('XAKINC')) exit("Warning...");
/**
 * 模型基类
 *
 * @version        $Id: model.class.php 1 13:46 2010-12-1
 */

class Model
{
    var $dsql;
    var $db;
    
    // 析构函数
    function Model()
    {
        global $dsql;
        if ($GLOBALS['cfg_mysql_type'] == 'mysqli')
        {
            $this->dsql = $this->db = isset($dsql)? $dsql : new XakSqli(FALSE);
        } else {
            $this->dsql = $this->db = isset($dsql)? $dsql : new XakSql(FALSE);
        }
            
    }
    
    // 释放资源
    function __destruct() 
    {
        $this->dsql->Close(TRUE);
    }
}