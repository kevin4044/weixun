<?php
/**
 * @version        $Id: edit_fullinfo.php 1 8:38 2010年7月9日Z
 */
require_once(dirname(__FILE__).'/config.php');
require_once XAKINC.'/membermodel.cls.php';
require_once(XAKINC."/userlogin.class.php");
CheckRank(0,0);
require_once(XAKINC.'/enums.func.php');
$menutype = 'config';
if(!isset($dopost)) $dopost = '';

if($dopost=='')
{
    $xak_fields = empty($xak_fields) ? '' : trim($xak_fields);
    if(!empty($xak_fields))
    {
        if($xak_fieldshash != md5($xak_fields.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
    }
    
    $xak_fieldshash = empty($xak_fieldshash) ? '' : trim($xak_fieldshash);
    $membermodel = new membermodel($cfg_ml->M_MbType);
    $modelform = $dsql->GetOne("SELECT * FROM `#@__member_model` WHERE id='$membermodel->modid' ");
    if(!is_array($modelform))
    {
        showmsg('模型表单不存在', '-1');
        exit();
    }
    $row = $dsql->GetOne("SELECT * FROM ".$modelform['table']." WHERE mid=$cfg_ml->M_ID");
    if(!is_array($row))
    {
        showmsg("你访问的记录不存在或未经审核", '-1');
        exit();
    }
    $postform = $membermodel->getForm('edit', $row, 'membermodel');
    include(XAKMEMBER."/templets/edit_fullinfo.htm");
    exit();
}
/*------------------------
function __Save()
------------------------*/
if($dopost=='save'){
    
        $membermodel = new membermodel($cfg_ml->M_MbType);
        $postform = $membermodel->getForm(true);

      //这里完成详细内容填写
        $xak_fields = empty($xak_fields) ? '' : trim($xak_fields);
        $xak_fieldshash = empty($xak_fieldshash) ? '' : trim($xak_fieldshash);
        $modid = empty($modid)? 0 : intval(preg_replace("/[^\d]/",'', $modid));
        
        if(!empty($xak_fields))
        {
            if($xak_fieldshash != md5($xak_fields.$cfg_cookie_encode))
            {
                showMsg('数据校验不对，程序返回', '-1');
                exit();
            }
        }
        $modelform = $dsql->GetOne("SELECT * FROM `#@__member_model` WHERE id='$modid' ");
        if(!is_array($modelform))
        {
            showmsg('模型表单不存在', '-1');
            exit();
        }
        
        $inadd_f = '';
        if(!empty($xak_fields))
        {
            $fieldarr = explode(';', $xak_fields);
            if(is_array($fieldarr))
            {
                foreach($fieldarr as $field)
                {
                    if($field == '') continue;
                    $fieldinfo = explode(',', $field);
                    if($fieldinfo[1] == 'textdata')
                    {
                        ${$fieldinfo[0]} = FilterSearch(stripslashes(${$fieldinfo[0]}));
                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});
                    } else if ($fieldinfo[1] == 'img')
                    {
                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});
                    }
                    else
                    {
                        if(empty(${$fieldinfo[0]})) ${$fieldinfo[0]} = '';
                        ${$fieldinfo[0]} = GetFieldValue(${$fieldinfo[0]}, $fieldinfo[1],0,'add','','diy', $fieldinfo[0]);
                    }
                    if($fieldinfo[0]=="birthday") ${$fieldinfo[0]}=GetDateMk(${$fieldinfo[0]});
                    $inadd_f .= ','.$fieldinfo[0]." ='".${$fieldinfo[0]}."'";
                }
            }

        }
        $inadd_f=preg_replace('/,/','',$inadd_f,1);
        $query = "UPDATE `{$membermodel->table}`set {$inadd_f} WHERE mid='{$cfg_ml->M_ID}'";
        // 清除缓存
        $cfg_ml->DelCache($cfg_ml->M_ID);
        
        if(!$dsql->ExecuteNoneQuery($query))
        {
            ShowMsg("更新附加表 `{$membermodel->table}`  时出错，请联系管理员！","javascript:;");
            exit();
        }else{
            ShowMsg('成功更新你的详细资料！','edit_fullinfo.php',0,5000);
            exit();
        }
}