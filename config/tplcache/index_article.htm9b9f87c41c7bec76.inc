<?php
$z[0]=Array("global","",236,263);
$z[0][4]['name']="cfg_soft_lang";
$z[1]=Array("field","",276,294);
$z[1][4]['name']="title";
$z[2]=Array("global","",295,320);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("field","",361,389);
$z[3][4]['name']="keywords";
$z[4]=Array("field","",429,486);
$z[4][4]['name']="description";
$z[4][4]['function']="html2text(@me)";
$z[5]=Array("global","",504,535);
$z[5][4]['name']="cfg_templets_skin";
$z[6]=Array("include","",639,673);
$z[6][4]['filename']="head.htm";
$z[7]=Array("arclist","\r\nlinkarr[[field:global.autoindex/]] = \"[field:arcurl/]\";\r\npicarr[[field:global.autoindex/]]  = \"[field:litpic/]\";\r\ntextarr[[field:global.autoindex/]] = \"[field:title function='html2text(@me)'/]\";\r\n",1005,1247);
$z[7][4]['flag']="f";
$z[7][4]['row']="5";
$z[8]=Array("global","",1833,1864);
$z[8][4]['name']="cfg_templets_skin";
$z[9]=Array("global","",2160,2191);
$z[9][4]['name']="cfg_templets_skin";
$z[10]=Array("arclist","\r\n      <h2><a href=\"[field:arcurl/]\">[field:title/]</a></h2>\r\n      <p>[field:description function='cn_substr(@me,110)'/]...<a href=\"[field:arcurl/]\">[查看全文]</a></p>\r\n      ",2690,2919);
$z[10][4]['flag']="h";
$z[10][4]['limit']="0,1";
$z[11]=Array("arclist","\r\n      <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n      ",2985,3102);
$z[11][4]['flag']="h";
$z[11][4]['limit']="1,6";
$z[12]=Array("arclist","\r\n      <li><a href=\"[field:arcurl/]\">[field:image/]<span class=\"title\">[field:title/]</span></a></li>\r\n      ",3304,3507);
$z[12][4]['row']="5";
$z[12][4]['orderby']="pubdate";
$z[12][4]['type']="image.";
$z[12][4]['imgwidth']="124";
$z[12][4]['imgheight']="94";
$z[13]=Array("channelartlist","\r\n   <dl class=\"tbox\">\r\n    <dt><strong><a href=\"{xak:field name='typeurl'/}\">{xak:field name='typename'/}</a></strong><span class=\"more\"><a href=\"{xak:field name='typeurl'/}\">更多...</a></span></dt>\r\n    <dd>\r\n     <ul class=\"d1 ico3\">\r\n      {xak:arclist titlelen='60' row='8'}\r\n      <li><span class=\"date\">[field:pubdate function=\"MyDate('m-d',@me)\"/]</span><a href=\"[field:arcurl /]\">[field:title /]</a></li>\r\n      {/xak:arclist}\r\n     </ul>\r\n    </dd>\r\n   </dl>\r\n   ",3672,4188);
$z[14]=Array("arclist","\r\n      <li><a href=\"[field:arcurl/]\">[field:title/]</a>\r\n       <p>[field:description function='cn_substr(@me,80)'/]...</p>\r\n      </li>\r\n      ",4431,4630);
$z[14][4]['flag']="c";
$z[14][4]['titlelen']="42";
$z[14][4]['row']="6";
$z[15]=Array("myad","",4744,4774);
$z[15][4]['name']="listRtPicAD";
$z[16]=Array("arclist","\r\n      <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n      ",4950,5067);
$z[16][4]['row']="10";
$z[16][4]['orderby']="click";
$z[17]=Array("myad","",5162,5193);
$z[17][4]['name']="listRtPicAD2";
$z[18]=Array("myad","",5292,5324);
$z[18][4]['name']="innerfooterAD";
$z[19]=Array("include","",5332,5368);
$z[19][4]['filename']="footer.htm";

?>