<?php
/**
 * 非幻灯广告数据调用
 *
 * @version $Id: ad.lib.php 2012年11月25日Z
 */
 

 
function lib_ad(&$ctag,&$refObj)
{
    global $dsql;

    $attlist = "name|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = $ctag->GetInnerText();
    
    $likeType = '';
    //读取固定的缓存块
    $cacheid = trim($cacheid);
    if($cacheid !='')
	{
        $likeType = GetCacheBlock($cacheid);
        if($likeType != '') 
		return $likeType;
    }

    //And id<>'$typeid'
    $needRel = false;
    $dtp2 = new XakTagParse();
    $dtp2->SetNameSpace('field','[',']');
    $dtp2->LoadSource($innertext);
	
	$typesql = '';
	if( !empty($refObj->Fields['typeid']) ) $typeid = $refObj->Fields['typeid'];
	if($typeid > 0) 
	{
		$typesql = " And typeid in(0,".GetTopids($typeid).") ";
	}
	else
	{
		$typesql = " AND typeid= 0";
	}

	$sql = "SELECT * FROM `#@__rpad` WHERE tagname like '$name' AND adtype != 'slide' $typesql order by typeid desc";
    $bannerInfo = $dsql->GetOne($sql);
    $normparams[0] = unserialize($bannerInfo['normparams']);
	
	
    foreach($normparams as $value)
	{
        if(is_array($dtp2->CTags))
        {
            foreach($dtp2->CTags as $tagid=>$ctag)
            {
				if($ctag->GetName()=='array')
				{
					//传递整个数组，在runphp模式中有特殊作用
					$dtp2->Assign($tagid, $value);
				} 
				else 
				{
					if(isset($value[$ctag->GetName()])){
						$dtp2->Assign($tagid,$value[$ctag->GetName()]);
					}
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