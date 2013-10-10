<?php
$z[0]=Array("field","",69,87);
$z[0][4]['name']="title";
$z[1]=Array("global","",88,113);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("global","",160,189);
$z[2][4]['name']="cfg_description";
$z[3]=Array("global","",229,255);
$z[3][4]['name']="cfg_keywords";
$z[4]=Array("include","",504,538);
$z[4][4]['filename']="head.htm";
$z[5]=Array("field","",606,634);
$z[5][4]['name']="position";
$z[6]=Array("arclist","\n                        <li><a href=\"[field:arcurl/]\">《[field:title/]》</a></li>\n                        ",908,1104);
$z[6][4]['getall']="1";
$z[6][4]['typeid']="1,2,3";
$z[6][4]['flag']="c";
$z[6][4]['row']="7";
$z[6][4]['orderby']="weight";
$z[7]=Array("arclist","\n           <div class=\"si\">\n             <div class=\"picc\"><img src=\"[field:litpic/]\" alt=\"[field:name/]\" /></div>\n              <div class=\"lao\">[field:name/]</div>\n             <div class=\"jie\">\n            [field:breif function='cn_substrR(html2text(@me),40)'/]… \n          </div>\n           </div>\n           ",1357,1772);
$z[7][4]['flag']="c";
$z[7][4]['row']="3";
$z[7][4]['orderby']="weight";
$z[7][4]['addfields']="name,breif";
$z[7][4]['channelid']="15";
$z[8]=Array("arclist","\n          <div class=\"huo\">\n            <div class=\"du\">\n             <dl>[field:name/]</dl>\n             <dt>擅长领域：[field:fields/]</dt>\n             <dd><a href=\"[field:arcurl/]\">详细介绍>></a></dd>\n            </div>\n           <div class=\"laoshi\">\n           	[field:breif function='cn_substrR(html2text(@me),460)'/]\n	       </div> \n          </div>\n          ",2617,3091);
$z[8][4]['row']="7";
$z[8][4]['orderby']="weight";
$z[8][4]['addfields']="name,fields,breif";
$z[8][4]['channelid']="15";
$z[9]=Array("include","",3181,3217);
$z[9][4]['filename']="footer.htm";

?>