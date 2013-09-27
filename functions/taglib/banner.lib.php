<?php
/**
 * 幻灯调用
 *
 * @version $Id: banner.lib.php 1 2012年10月14日Z
 */ 

 
function lib_banner(&$ctag,&$refObj)
{
    global $dsql;

    $attlist = "name|'',row|7";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = $ctag->GetInnerText();
    
    $likeType = '';
    //读取固定的缓存块
    $cacheid = trim($cacheid);
    if($cacheid !='') {
        $likeType = GetCacheBlock($cacheid);
        if($likeType != '') return $likeType;
    }

    //And id<>'$typeid'
    $needRel = false;
    $dtp2 = new XakTagParse();
    $dtp2->SetNameSpace('field','[',']');
    $dtp2->LoadSource($innertext);

	if(trim($typeid)=='') $typeid=0;
	if( !empty($refObj->Fields['typeid']) && $typeid==0) $typeid = $refObj->Fields['typeid'];

	$typesql = $bannerInfo = '';
	if($typeid > 0) $typesql = " And typeid in(0,".GetTopids($typeid).") ";
	else $typesql = " AND typeid=0 ";
	$bannerInfo = $dsql->GetOne(" Select * From `#@__rpad` where tagname like '$name' $typesql order by typeid desc ");
    
    $normparams = unserialize($bannerInfo['normparams']);

    for($i = 0;$i < $row;$i++)
	{
		if(!empty($normparams['pic'][$i]))
		{
			if(empty($normparams['link'][$i]) || $normparams['link'][$i] =='#' )
			{
            	$normparams['link'][$i] = 'javascript:void(0);';
				$bannerList[$i]['target'] = '';
			}
			else
			{
				if(preg_match("/http:\/\//",$normparams['link'][$i]))
				{
					$bannerList[$i]['target'] = ' target="_blank"';	
				}
			}			
			$bannerList[$i]['pic']  = $normparams['pic'][$i];
			$bannerList[$i]['link'] = $normparams['link'][$i];
			$bannerList[$i]['text'] = $normparams['text'][$i];
			$bannerList[$i]['id'] = $i + 1; 
		}
        
    }    

    foreach($bannerList as $value){
        if(is_array($dtp2->CTags))
        {
            foreach($dtp2->CTags as $tagid=>$ctag)
            {
                if(isset($value[$ctag->GetName()])){
                    $dtp2->Assign($tagid,$value[$ctag->GetName()]);
                }
            }
        }
        $likeType .= $dtp2->GetResult();
    }
	
    //Loop for $i
    $dsql->FreeResult();
    if($cacheid !='') {
        WriteCacheBlock($cacheid, $likeType);
    }

    return $likeType;
}