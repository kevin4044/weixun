    <?php
        $add_channel_menu = array();
        //如果为游客访问，不启用左侧菜单
        if(!empty($cfg_ml->M_ID))
        {
            $channelInfos = array();
            $dsql->Execute('addmod',"SELECT id,nid,typename,useraddcon,usermancon,issend,issystem,usertype,isshow FROM `#@__channeltype` ");	
            while($menurow = $dsql->GetArray('addmod'))
            {
                $channelInfos[$menurow['nid']] = $menurow;
                //禁用的模型
                if($menurow['isshow']==0)
                {
                    continue;
                }
                //其它情况
                if($menurow['issend']!=1 || $menurow['issystem']==1 
                || ( !preg_match("#".$cfg_ml->M_MbType."#", $menurow['usertype']) && trim($menurow['usertype'])!='' ) )
                {
                    continue;
                }
                $menurow['ddcon'] = empty($menurow['useraddcon']) ? 'archives_add.php' : $menurow['useraddcon'];
                $menurow['list'] = empty($menurow['usermancon']) ? 'content_list.php' : $menurow['usermancon'];
                $add_channel_menu[] = $menurow;
            }
            unset($menurow);
		?>
    <div id="mcpsub">
      <div class="topGr"></div>
      <div id="menuBody">
      	<!-- 内容中心菜单-->
      	<?php
      	if($menutype == 'content')
      	{
      	?>
        <h2 class="menuTitle" onclick="menuShow('menuFirst')" id="menuFirst_t"><b></b>系统模型内容</h2>
        <ul id="menuFirst">
        <?php
        //是否启用文章投稿
        if($channelInfos['article']['issend']==1 && $channelInfos['article']['isshow']==1)
        {
        ?>
          <li class="articles"><a href="../user/content_list.php?channelid=1" title="已发布的文章"><b></b>文章</a><a href="../user/article_add.php" class="act" title="发表新文章">发表</a></li>
        <?php
      	}
        //是否启用图集投稿
        if($channelInfos['image']['issend']==1 && $cfg_mb_album=='Y'  && $channelInfos['image']['isshow']==1 
        && ($channelInfos['image']['usertype']=='' || preg_match("#".$cfg_ml->fields['mtype']."#", $channelInfos['image']['usertype'])) )
        {
        ?>
          
          
          <li class="photo"><a href="../user/content_list.php?channelid=2" title="管理图集"><b></b>图集</a><a href="../user/album_add.php" class="act" title="新建图集">新建</a></li>
	        <?php
	      	}
	      	//是否启用软件投稿
	        if($channelInfos['soft']['issend']==1 && $channelInfos['soft']['isshow']==1
	        && ($channelInfos['image']['usertype']=='' || preg_match("#".$cfg_ml->fields['mtype']."#", $channelInfos['image']['usertype']))
	        )
	        {
	        ?>
          <li class="soft"><a href="../user/content_list.php?channelid=3" title="已发布的软件"><b></b>软件</a><a href="../user/soft_add.php" title="上传软件"class="act">上传</a></li>
          <?php
           }
           ?>
        </ul>
				<?php
				//是否允许对自定义模型投稿
				if($cfg_mb_sendall=='Y')
				{
				?>
        <h2 class="menuTitle" onclick="menuShow('menuSec')" id="menuSec_t"><b></b>自定义内容</h2>
        <ul id="menuSec">
					<?php
					foreach($add_channel_menu as $nnarr) {
					?>
					<li class="<?php echo $nnarr['nid'];?>"><a href="../user/<?php echo $nnarr['list'];?>?channelid=<?php echo $nnarr['id'];?>" title="已发布的<?php echo $nnarr['typename'];?>"><b></b><?php echo $nnarr['typename'];?></a><a href='archives_do.php?dopost=addArc&channelid=<?php echo $nnarr['id'];?>' class="act" title="发表新文章">发表</a></li>
					<?php
					} 
					}
					?>  
        </ul>
        <h2 class="menuTitle" onclick="menuShow('menuThird')" id="menuThird_t"><b></b>其他管理</h2>
        <ul id="menuThird">
        	<li class="icon attachment"><a href="../user/uploads.php"><b></b>附件管理</a></li>
        </ul>
        
        <?php
      }
      ?>
      	<!-- 我的菜单-->
      	<?php
      	if($menutype == 'xakmenu')
      	{
      	?>
        <h2 class="menuTitle" onclick="menuShow('menuFirst')" id="menuFirst_t"><b></b>会员互动</h2>
        <ul id="menuFirst">
        	<li class="icon mystow"><a href="../user/mystow.php"><b></b>我的收藏夹</a></li>
        <?php
        if($cfg_feedback_forbid=='N')
        {
          //<li class="icon feedback"><a href='../user/myfeedback.php'>我的评论</a></li>
        }
        $dsql->Execute('nn','Select indexname,indexurl From `#@__sys_module` where ismember=1 ');
        while($nnarr = $dsql->GetArray('nn'))
        {
        	@preg_match("/\/(.+?)\//is", $nnarr['indexurl'],$matches);
        	$nnarr['class'] = isset($matches[1]) ? $matches[1] : 'channel';
        	$nnarr['indexurl'] = str_replace("**","=",$nnarr['indexurl']);
        ?>
        <li class="<?php echo $nnarr['class'];?>"><a href="<?php echo $nnarr['indexurl']; ?>"><b></b><?php echo $nnarr['indexname']; ?>模块</a></li>
        <?php
        }
        ?>
        </ul>
        <?php
      }
      ?>
      	<!-- 系统设置菜单-->
      	<?php
      	if($menutype == 'config')
      	{
      	?>
        <h2 class="menuTitle" onclick="menuShow('menuFirst')" id="menuFirst_t"><b></b><?php echo $cfg_ml->M_MbType; ?>资料</a></h2>
        <ul id="menuFirst">
        	<li class="icon baseinfo"><a href="../user/edit_baseinfo.php"><b></b>基本资料</a></li>
	        <li class="icon myinfo"><a href="../user/edit_fullinfo.php"><b></b><?php echo $cfg_ml->M_MbType; ?>资料</a></li>
	        <li class="icon face"><a href="../user/edit_face.php"><b></b>头像设置</a></li>
        </ul>
        <h2 class="menuTitle" onclick="menuShow('menuSec')" id="menuSec_t"><b></b>空间管理</h2>
        <ul id="menuSec">
        	<li class="icon mtypes"><a href="../user/mtypes.php"><b></b>分类管理</a></li>
        	<li class="icon flink"><a href="../user/flink_main.php"><b></b>书签管理</a></li>
        	<li class="icon info"><a href="../user/edit_space_info.php"><b></b>空间设置</a></li>
        	<li class="icon spaceskin"><a href="../user/spaceskin.php"><b></b>风格选择</a></li>
        </ul>
        
        <?php
      }
      ?>
        <!--<h2 class="menuTitle"><b class="showMenu"></b>操作主菜单项</h2> -->
      </div>
      <div class="buttomGr"></div>
    </div>
    <?php
    }
    ?>
    <!--左侧操作菜单项 -->