<?php   if(!defined('XAKINC')) exit('Warning...');
/**
 * 管理员后台基本函数
 *
 * @version        $Id:inc_fun_funAdmin.php 1 13:58 2010年7月5日
 */

/**
 *  获取拼音信息
 *
 * @access    public
 * @param     string  $str  字符串
 * @param     int  $ishead  是否为首字母
 * @param     int  $isclose  解析后是否释放资源
 * @return    string
 */
function SpGetPinyin($str, $ishead=0, $isclose=1)
{
    global $pinyins;
    $restr = '';
    $str = trim($str);
    $slen = strlen($str);
    if($slen < 2)
    {
        return $str;
    }
    if(count($pinyins) == 0)
    {
        $fp = fopen(XAKINC.'/data/pinyin.dat', 'r');
        while(!feof($fp))
        {
            $line = trim(fgets($fp));
            $pinyins[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
        }
        fclose($fp);
    }
    for($i=0; $i<$slen; $i++)
    {
        if(ord($str[$i])>0x80)
        {
            $c = $str[$i].$str[$i+1];
            $i++;
            if(isset($pinyins[$c]))
            {
                if($ishead==0)
                {
                    $restr .= $pinyins[$c];
                }
                else
                {
                    $restr .= $pinyins[$c][0];
                }
            }else
            {
                $restr .= "_";
            }
        }else if( preg_match("/[a-z0-9]/i", $str[$i]) )
        {
            $restr .= $str[$i];
        }
        else
        {
            $restr .= "_";
        }
    }
    if($isclose==0)
    {
        unset($pinyins);
    }
    return $restr;
}


/**
 *  创建目录
 *
 * @access    public
 * @param     string  $spath 目录名称
 * @return    string
 */
function SpCreateDir($spath)
{
    global $cfg_dir_purview,$cfg_basedir,$cfg_ftp_mkdir,$isSafeMode;
    if($spath=='')
    {
        return true;
    }
    $flink = false;
    $truepath = $cfg_basedir;
    $truepath = str_replace("\\","/",$truepath);
    $spaths = explode("/",$spath);
    $spath = "";
    foreach($spaths as $spath)
    {
        if($spath=="")
        {
            continue;
        }
        $spath = trim($spath);
        $truepath .= "/".$spath;
        if(!is_dir($truepath) || !is_writeable($truepath))
        {
            if(!is_dir($truepath))
            {
                $isok = MkdirAll($truepath,$cfg_dir_purview);
            }
            else
            {
                $isok = ChmodAll($truepath,$cfg_dir_purview);
            }
            if(!$isok)
            {
                echo "创建或修改目录：".$truepath." 失败！<br>";
                CloseFtp();
                return false;
            }
        }
    }
    CloseFtp();
    return true;
}

function jsScript($js)
{
	$out = "<script type=\"text/javascript\">";
	$out .= "//<![CDATA[\n";
	$out .= $js;
	$out .= "\n//]]>";
	$out .= "</script>\n";

	return $out;
}

/**
 *  获取编辑器
 *
 * @access    public
 * @param     string  $fname 表单名称
 * @param     string  $fvalue 表单值
 * @param     string  $nheight 内容高度
 * @param     string  $etype 编辑器类型
 * @param     string  $gtype 获取值类型
 * @param     string  $isfullpage 是否全屏
 * @return    string
 */
function SpGetEditor($fname,$fvalue,$nheight="350",$etype="Basic",$gtype="print",$isfullpage="false",$bbcode=false)
{
    global $cfg_ckeditor_initialized;
    if(!isset($GLOBALS['cfg_html_editor']))
    {
        $GLOBALS['cfg_html_editor']='fck';
    }
    if($gtype=="")
    {
        $gtype = "print";
    }
    if($GLOBALS['cfg_html_editor']=='fck')
    {
        require_once(XAKINC.'/FCKeditor/fckeditor.php');
        $fck = new FCKeditor($fname);
        $fck->BasePath        = $GLOBALS['cfg_cmspath'].'/functions/FCKeditor/' ;
        $fck->Width        = '100%' ;
        $fck->Height        = $nheight ;
        $fck->ToolbarSet    = $etype ;
        $fck->Config['FullPage'] = $isfullpage;
        if($GLOBALS['cfg_fck_xhtml']=='Y')
        {
            $fck->Config['EnableXHTML'] = 'true';
            $fck->Config['EnableSourceXHTML'] = 'true';
        }
        $fck->Value = $fvalue ;
        if($gtype=="print")
        {
            $fck->Create();
        }
        else
        {
            return $fck->CreateHtml();
        }
    }
    else if($GLOBALS['cfg_html_editor']=='ckeditor')
    {
        require_once(XAKINC.'/ckeditor/ckeditor.php');
        $CKEditor = new CKEditor();
        $CKEditor->basePath = $GLOBALS['cfg_cmspath'].'/functions/ckeditor/' ;
        $config = $events = array();
        $config['extraPlugins'] = 'xakpage,multipic,addon';
		if($bbcode)
		{
			$CKEditor->initialized = true;
			$config['extraPlugins'] .= ',bbcode';
			$config['fontSize_sizes'] = '30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%';
			$config['disableObjectResizing'] = 'true';
			$config['smiley_path'] = $GLOBALS['cfg_cmspath'].'/images/smiley/';
			// 获取表情信息
			require_once(XAKDATA.'/smiley.data.php');
			$jsscript = array();
			foreach($GLOBALS['cfg_smileys'] as $key=>$val)
			{
				$config['smiley_images'][] = $val[0];
				$config['smiley_descriptions'][] = $val[3];
				$jsscript[] = '"'.$val[3].'":"'.$key.'"';
			}
			$jsscript = implode(',', $jsscript);
			echo jsScript('CKEDITOR.config.ubb_smiley = {'.$jsscript.'}');
		}

        $GLOBALS['tools'] = empty($toolbar[$etype])? $GLOBALS['tools'] : $toolbar[$etype] ;
        $config['toolbar'] = $GLOBALS['tools'];
        $config['height'] = $nheight;
        $config['skin'] = 'kama';
        $CKEditor->returnOutput = TRUE;
        $code = $CKEditor->editor($fname, $fvalue, $config, $events);
        if($gtype=="print")
        {
            echo $code;
        }
        else
        {
            return $code;
        }
    }
	else if($GLOBALS['cfg_html_editor']=='kindeditor')
	{
		if(empty($etype))
		{
			$etype='Basic';
		}
		if($etype=='Basic')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image','flash','insertfile', 'table', 'hr', 'emoticons', 'map', 'link', 'unlink', 'pagebreak']";
		}
		else if($etype=='Default')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image','flash','insertfile', 'table', 'hr', 'emoticons', 'map', 'link', 'unlink']";
		}
		else if($etype=='Small')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image','table', 'hr', 'emoticons', 'map', 'link', 'unlink']";
		}
		else if($etype=='Member')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'map', 'link', 'unlink']";
		}
		else if($etype=='MemberLit')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'map', 'link', 'unlink']";
		}
		else if($etype=='Diy')
		{
			$items="['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'map', 'link', 'unlink']";
		}
		else if($etype=='Feedback')
		{
			$items="['source', '|', 'undo', 'redo', '|','bold','italic', 'underline', 'fontsize', 'forecolor', 'link', 'unlink']";
		}
	

		$edpath=$GLOBALS['cfg_cmspath'].'/include/kindeditor';
		$code='<script charset="utf-8" src="'.$edpath.'/kindeditor-min.js"></script>
			  <script charset="utf-8" src="'.$edpath.'/lang/zh_CN.js"></script>
			  <script charset="utf-8" src="'.$edpath.'/plugins/code/prettify.js"></script>
			  <script>
			  KindEditor.ready(function(K) {
			  var editor1 = K.create(\'textarea[name="'.$fname.'"]\', {
			  cssPath : \''.$edpath.'/plugins/code/prettify.css\',
			  uploadJson : \''.$edpath.'/upload.php\',
			  items:'.$items.',
			  fileManagerJson : \''.$edpath.'/file_manager.php\',
			  allowFileManager : true
			  });
			  prettyPrint();
			  });
			  </script>
			  <textarea name="'.$fname.'" style="width:100%;height:'.$nheight.'px;visibility:hidden;">'.$fvalue.'</textarea>';
		if($gtype=="print")
        {
            echo $code;
        }
        else
        {
            return $code;
        }
		
	}
    
}

/**
 *  获取更新信息
 *
 * @return    void
 */
function SpGetNewInfo()
{
    global $cfg_version,$dsql;
    $nurl = $_SERVER['HTTP_HOST'];
    if( preg_match("#[a-z\-]{1,}\.[a-z]{2,}#i",$nurl) ) {
        $nurl = urlencode($nurl);
    }
    else {
        $nurl = "test";
    }
    $phpv = phpversion();
    $sp_os = PHP_OS;
    $mysql_ver = $dsql->GetVersion();
    $offUrl = "http://www.de"."decms.com/newinfov57.php?version={$cfg_version}&formurl={$nurl}&phpver={$phpv}&os={$sp_os}&mysqlver={$mysql_ver}";
    return $offUrl;
}

?>