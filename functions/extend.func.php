<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //返回结果
    return $lit_imglist;
}

//对内容里的图片进行最大宽度处理，防止客户上传图片过大导致图片显示不全
/*
	$value 编辑器内容
	$width 显示区最大宽度
	需配合 config.js 使用
*/
/*调用例子 {xak:field.content function='replace_image(@me,600)'/} */
function replace_image($value,$width='600'){
	if(empty($value))
	{
		$val ='';	
	}
	else 
	{
		$image ='<img onload="auto_image(this,'.$width.')"';
		$val=str_replace('<img', $image, $value);
	}
	return $val;
}

//函数直接替换，用于中英文网站的当前位置替换，替换后需自行加上首页链接
/*调用例子 <a href="/cn">首页</a> &gt; {xak:field.positoin function='position_preg(@me)'/} */
function position_preg($position)
{
	$k = preg_replace("/(<a href=.*>简体中文<\/a> >)(.*)/i","\\2",$position);
	$k = preg_replace("/(<a href=.*>English<\/a> >)(.*)/i","\\2",$k);
	$position =$k;
    return $position;
}

//获取当前分类的顶级分类信息
/*
	$id 当前栏目id
	$topid 要返回的顶级栏目id
	$type 返回信息类型 1为栏目id 2为栏目标题
*/
/*调用例子 {xak:field.typeid function='GetTopInfo(@me,0,2)'/} */
function GetTopInfo($id,$topid=0,$type=1)
{
	global $dsql;
	$row = $dsql->GetOne("SELECT * FROM #@__arctype where id='$id'");
	if($row['reid']==$topid || $row['reid']==0)
	{	  
		if($type==1)
		{
			$code = $row['id'];
		}
		else
		{
			$code = $row['typename'];
		}	
	}
	else
	{
		$code = GetTopInfo($row['reid'],$topid,$type);
	}
	return $code;
}

//获取当前分类的上级分类信息
/*
	$id 当前栏目id
	$topid 要返回的顶级栏目id
	$type 返回信息类型 1为栏目id 2为栏目标题
*/
/*调用例子 {xak:field.typeid function='GetReidInfo(@me,0,2)'/} */
function GetReidInfo($id,$topid=0,$type=1)
{
	global $dsql;
	$row = $dsql->GetOne("SELECT * FROM #@__arctype where id='$id'");
	if($row['reid']==$topid || $row['reid']==0)
	{	  
		if($type==1)
		{
			$code = $row['id'];
		}
		else
		{
			$code = $row['typename'];
		}	
	}
	else
	{
		$reid_row = $dsql->GetOne("SELECT * FROM #@__arctype where id=".$row['reid']);
		if($type==1)
		{
			$code = $reid_row['id'];
		}
		else
		{
			$code = $reid_row['typename'];
		}
	}
	return $code;
}


//输出广告信息 是于需要判断广告内容是否为空的情况
/*
	$val 广告内容
	$css 广告位样式	
*/
/*调用例子 {xak:rpad name='list_225' function='IfAdInfo(@me,"<div class=\"box225 mt10\">~code~</div>")'/} */
function IfAdInfo($val,$css='')
{
	$code='';
	if($val!='' && $css!='')
	{
		$code = str_replace('~code~',$val,$css);
	}
	else
	{
		$code = $val;
	}
	
	return $code;
}

//重新输出列表大图(适应于列表全屏大图，高度需要在样式表里固定)
/*调用例子  {xak:rpad name='list_banner' function='RepListBanner(@me)'/} */
function RepListBanner($val)
{
	$code = '';
	$str="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/"; 
	preg_match($str,$val,$img); 
	if(!empty($img[1]))
	{
		
		$code .= '<div class="list_banner" style="background:url('.$img[1].') no-repeat center top"></div>';
	}

	return $code;	
}



//检查seo标题
/*
	$val 内容
	$mark 分隔符
	$pos 分隔符位置
*/
//调用例子 {xak:field.seotitle function="IfSeoTitle(@me,'_','last')"/}
function IfSeoTitle($val,$mark='_',$pos='before')
{
	$code ='';
	if(!empty($val))
	{
		if($pos == 'before')
		{
			$code = $mark.$val;
		}
		else
		{
			$code = $val.$mark;
		}
	}
	return $code;
}

//检查来源或标题是否存在
/*
	$val 字段内容
	$title 字段标题
*/
//调用例子 {xak:field.source function="RepWriterSouce(@me,'来源：')"/}
function RepWriterSouce($val,$title='')
{
	$code ='';
	if($val !='' && $val != 'admin' && $val !='未知')
	{
		$code = $title.$val."&nbsp;&nbsp;";
	}
	return $code;
}

//判断栏目内容是否为空
//调用例子 {xak:field.content function='IsHaveContent(@me)'/}
function IsHaveContent($val)
{
	if(!empty($val) && $val !='&nbsp;')
	{
		//样式根据需要自行定义
		$val = '<div class="about_content">'.replace_image($val,'610').'</div>';
	}
	else
	{
		$val = '';
	}
	return $val;
}

//输出底部关键字（适应于在底部增加内链关键词，需要系统设置添加一个变量）
//调用例子 {xak:global.cfg_key function="RepFooterKey(@me)"/}
function RepFooterKey($val)
{
	global $cfg_basehost;
	$code = '';
	if(!empty($val))
	{
		$val_arr = explode(',',$val);
		foreach($val_arr as $v)
		{
			if(!empty($v))
			{
				$code .= '<a href="'.$cfg_basehost.'" title="'.$v.'">'.$v.'</a>'."\r\n";
			}
		}
	}
	return $code;
}

//输出自定义搜索关键字（适应于在搜索框处定义一些热门搜索词，需要系统设置添加一个变量）
//调用例子 {xak:global.cfg_search_key function="RepSearchKey(@me)"/}
function RepSearchKey($val)
{
	$code = '';
	if(!empty($val))
	{
		$val_arr = explode(',',$val);
		foreach($val_arr as $v)
		{
			if(!empty($v))
			{
				//搜索参数根据需要自行设置
				$code .= '<a href="/module/search.php?kwtype=0&pagesize=25&searchtype=titlekeyword&q='.urlencode($v).'" title="'.$v.'">'.$v.'</a>'."\r\n";
			}
		}
	}
	
	return $code;
}

//获取指定栏目链接（适用于在文档标签需要调用某个固定栏目链接时使用）
//调用例子 [field:id function='GetTypeLink(13)'/]
function GetTypeLink($id)
{
	global $dsql;
	$row = $dsql->GetOne("SELECT id,typename,typedir,seotitle,content,typepic,open_new,description,isdefault,ispart,defaultname,namerule2,moresite,siteurl,sitepath FROM `#@__arctype` WHERE id='$id' ");
	return  GetOneTypeUrlA($row);
}

//输出图集图片
/*
	$aid 文档id
	$type 输出类型 1 输出图集第一张图片的地址 2 输出图集列表（含样式）
*/
//调用例子 {xak:field.id function='get_image_list(@me,2)'/}
function get_image_list($aid=0,$type=2)
{
    global $dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$aid'");
    $addtable = trim($row['addtable']);
    
    //获取imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$aid'");
    
    $dtp = new XakTagParse();
    $dtp->LoadSource($row['imgurls']);	
    $img_list='';
    foreach($dtp->CTags as $ctag)
    {
    	if($ctag->GetName()=="img")
        {
        	if($type=='1')
        	{
        		$img = trim($ctag->GetInnerText());        		        		
        		$ddimg = $ctag->GetAtt('ddimg');
        		
        		if(empty($img) && !empty($ddimg))
        		{
        			$img = $ddimg;
        		}
        		break;        		
        	}
        	else
        	{ 
	        	$ddimg = $ctag->GetAtt('ddimg');
	        	$src = trim($ctag->GetInnerText());
				if(empty($ddimg))
				{
					$ddimg =$src;
				}
				//循环图集列表 样式可根据需要自行定义
	        	$img_list.='<li><a href="javascript:void(0);" rel="{gallery: \'gal1\', smallimage: \''.$src.'\',largeimage: \''.$src.'\'}"><img src="'.$ddimg.'" /></a></li>'."\r\n";
        	}
        }
    }
    if($type==1)
    {
    	if(empty($img))
    	{
    		$row = $dsql->GetOne("SELECT litpic FROM #@__archives  where id='$aid'");
        	if($row['litpic']!='')
        	{
        		$img =$row['litpic']; 
        	}
        	else
        	{
        		$img='/images/defaultpic.gif';
        	}
    	}
    	return $img;
    }
    else 
    {
    	return $img_list;
   	}        
}


//模板引擎（适应于会员中心等直接引入模板文件无法解析的情况）
/*
调用例子
<?php
   pasterTempletDiy("xak/head.htm");
?>
*/
function pasterTempletDiy($path)
{
  require_once(XAKINC."/arc.partview.class.php");
  global $cfg_basedir,$cfg_templets_dir;
  $tmpfile = $cfg_basedir.$cfg_templets_dir."/".$path;//模版文件的路径
  $dtp = new PartView();
  $dtp->SetTemplet($tmpfile);
  $dtp->Display();
}