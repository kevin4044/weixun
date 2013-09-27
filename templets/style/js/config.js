/*
  JQ选项卡
* By digua 
* id 切换id
* type 切换类型 click,hover
* sel_first 是否选中第一项 true,flase
*/
function LoadTab(id,type,sel_first)
{
	var nid="#"+id+"_sel li";
	var nbox="#"+id+"_box ."+id+"_item";
	if(type=='click')
	{
		$(nid).click(
		function()
		{
			if(!$(this).hasClass("cur"))
			{
				var ncur =$(this).index();
				$(nid).removeClass("cur");
				$(this).addClass("cur");				
				$(nbox).css("display","none");
				$(nbox).eq(ncur).css("display","block");				
				var npic = "#"+id+"_pic li";
				if($(npic).length > 0)
				{
				   $(npic).hide();
				   $(npic).eq(ncur).show();
				}
			}
		});
	}
	else
	{
		$(nid).hover(
		function()
		{
			if(!$(this).hasClass("cur"))
			{
				var ncur =$(this).index();
				$(nid).removeClass("cur");
				$(this).addClass("cur");
				$(nbox).css("display","none");
				$(nbox).eq(ncur).css("display","block");
				var npic = "#"+id+"_pic li";
				if($(npic).length > 0)
				{
				   $(npic).hide();
				   $(npic).eq(ncur).show();
				}
			}
		},function(){});
	}
	if(sel_first)
	{
		//初始第一项
		$(nid).eq(0).addClass("cur");
		$(nbox).eq(0).css("display","block");
	}
}
/*图片自动缩小*/
function auto_image($img,$maxwidth)
{
	var image = new Image();
	image.src=$img.src;
	var imgwidth=image.width;
	var imgheight=image.height;
	var imgnowwidth = $img.width;
	var imgnowheight = $img.height;
	if($maxwidth==null)
	{
		$maxwidth ='600';//没有定义默认600
	}
        //图片宽度大于最大宽度并且没有指定宽度
	if(imgwidth > $maxwidth && imgnowwidth==null)
	{
		$img.width=$maxwidth;		
		$img.height=(imgheight*$maxwidth)/imgwidth;
	}
        //图片指定宽度并且大于最大宽度
	if(imgnowwidth>$maxwidth)
	{
		$img.style.width='';
		$img.style.height='';
		$img.width=$maxwidth;
		$img.height=(imgheight*$maxwidth)/imgwidth;
	}
}