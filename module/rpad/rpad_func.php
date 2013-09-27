<?php


function rpadParser($adtype,$normparams)
{
    global $cfg_phpurl;
    $returnValue = '';
    if($adtype == 'code')
    {
        $returnValue = $normparams;
    }
    else if($adtype == 'text')
    {
        $paramsArr = unserialize($normparams);
        $returnValue = "<a href=\"{$paramsArr['link']}\" font-size=\"{$paramsArr['size']}\" color=\"{$paramsArr['color']}\" target=\"_blank\">{$paramsArr['title']}</a>";
    }
    else if($adtype == 'image')
    {
        $paramsArr = unserialize($normparams);
        if(empty($paramsArr['width']))
		{
			$width = "";
		}
		else
		{
			$width = " width=\"{$paramsArr['width']}\"";
		}
		if (empty($paramsArr['height']))
		{
			$height = "";
		}
		else
		{
			$height = "height=\"{$paramsArr['height']}\"";
		}
		
		if (empty($paramsArr['descrip']))
		{
			$title='';
			$alt='';
		}
		else
		{
			$title=' title="'.$paramsArr['descrip'].'"';
			$alt=' alt="'.$paramsArr['descrip'].'"';
		}
		
		
		if(empty($paramsArr['link']) || $paramsArr['link']=="#")
		{
			$returnValue = "<img src=\"{$paramsArr['url']}\"$width $height border=\"0\"$alt $title/>";
		}
		else
		{
			$returnValue = "<a href=\"{$paramsArr['link']}\"$title  target=\"_blank\"><img src=\"{$paramsArr['url']}\"$width $height border=\"0\"$alt /></a>";	
		}
		if($paramsArr['url']=='')
		{
			$returnValue='';
		}
    }
    else if($adtype == 'flash')
    {
        $paramsArr = unserialize($normparams);
        if(empty($paramsArr['width']))
		{
			$width = "";
		}
		else
		{
			$width = ' width="'.$paramsArr['width'].'"';
		}
		if (empty($paramsArr['height']))
		{
			$height = "";
		}
		else
		{
			$height = ' height="'.$paramsArr['height'].'"';
		}
		$returnValue='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=11,0,1,152"'.$width.$height.'><param name="movie" value="'.$paramsArr['link'].'" /><param name="quality" value="high" /><param name="allowFullScreen" value="true" /><param name="wmode" value="transparent" /><embed src="'.$paramsArr['link'].'" quality="high" wmode="transparent" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"'.$width.$height.'></embed></object>';
		
		if($paramsArr['link']=='')
		{
			$returnValue='';
		}
		
    }
    else if($adtype == 'slide')
    {
        $paramsArr = unserialize($normparams);
		
		//宽度
		if($paramsArr['width']=='')
		{
			$width = 240;
		}
		else
		{
			$width = $paramsArr['width'];
		}
		
		//高度
		if($paramsArr['height']=='')
		{
			$height = 180;
		}
		else
		{
			$height = $paramsArr['height'];
		}
	
		//开始循环数据
		$num = 1;
		$configxml='';
	
		foreach($paramsArr['pic'] as $k=>$v)
        {
            if(!empty($v))
            {
                $configxml .= 'linkarr['.$num.']="'.$paramsArr['link'][$k].'";';
				$configxml .= 'picarr['.$num.']="'.$v.'";';
				$configxml .= 'textarr['.$num.']="'.$paramsArr['text'][$k].'";';
				$num++;
            }
        }
		//开始输出数据
		$returnValue  = '<script language="javascript">linkarr = new Array();picarr = new Array();textarr = new Array();var swf_width='.$width.';var swf_height='.$height.';';
		$returnValue .='var configtg="0xffffff|2|0x3FA61F|5|0xffffff|0xFF6600|0x000033|5|3|1|_self";var files = "";var links = "";var texts = "";';
		$returnValue .=$configxml;
		$returnValue .='for(i=1;i<picarr.length;i++){  if(files=="") files = picarr[i];else files += "|"+picarr[i];}for(i=1;i<linkarr.length;i++){if(links=="") links = linkarr[i];else links += "|"+linkarr[i];}for(i=1;i<textarr.length;i++){  if(texts=="") texts = textarr[i];else texts += "|"+textarr[i];}';
		$returnValue .='document.write(\'<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="\'+ swf_width +\'" height="\'+ swf_height +\'">\');document.write(\'<param name="movie" value="/module/rpad/bcastr3.swf"><param name="quality" value="high">\');document.write(\'<param name="menu" value="false"><param name=wmode value="opaque">\');document.write(\'<param name="FlashVars" value="bcastr_file=\'+files+\'&bcastr_link=\'+links+\'&bcastr_title=\'+texts+\'&bcastr_config=\'+configtg+\'">\');document.write(\'<embed src="/module/rpad/bcastr3.swf" wmode="opaque" FlashVars="bcastr_file=\'+files+\'&bcastr_link=\'+links+\'&bcastr_title=\'+texts+\'&bcastr_config=\'+configtg+\'&menu="false" quality="high" width="\'+ swf_width +\'" height="\'+ swf_height +\'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />\'); document.write(\'</object>\');</script>';
    }
    else
    {
        $returnValue = '';
    }

    return $returnValue;
}

?>
