<?php
$z[0]=Array("global","",73,98);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",146,175);
$z[1][4]['name']="cfg_description";
$z[2]=Array("global","",216,242);
$z[2][4]['name']="cfg_keywords";
$z[3]=Array("include","",497,531);
$z[3][4]['filename']="head.htm";
$z[4]=Array("type","\r\n        <div class=\"kecheng\">[field:typename/]</div>\r\n        ",631,727);
$z[4][4]['typeid']="1";
$z[5]=Array("channel","\r\n                <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n                ",827,969);
$z[5][4]['type']="son";
$z[5][4]['typeid']="1";
$z[6]=Array("arclist","\r\n                <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                ",1683,1819);
$z[6][4]['typeid']="24";
$z[6][4]['row']="9";
$z[7]=Array("arclist","\r\n            <tr >\r\n                <td class=\"name\"><a href=\"[field:arcurl/]\">《[field:name/]》</a></td>\r\n                <td class=\"time\">[field:start_date function=MyDate('y-m-d',@me)/]</td>\r\n                <td class=\"location\">[field:location /]</td>\r\n                <td class=\"price\">￥[field:price/]</td>\r\n            </tr>\r\n            ",2627,3117);
$z[7][4]['typeid']="1,2,3";
$z[7][4]['flag']="c";
$z[7][4]['row']="7";
$z[7][4]['orderby']="pubdate";
$z[7][4]['addfields']="price,name,start_date,location";
$z[7][4]['channelid']="14,16,17";
$z[8]=Array("arclist","\r\n                <tr >\r\n                    <td class=\"name\"><a href=\"[field:arcurl/]\">《[field:name/]》</a></td>\r\n                    <td class=\"time\">[field:start_date function=MyDate('y-m-d',@me)/]</td>\r\n                    <td class=\"location\">[field:location /]</td>\r\n                    <td class=\"price\">￥[field:price/]</td>\r\n                </tr>\r\n                ",3814,4312);
$z[8][4]['typeid']="1";
$z[8][4]['row']="7";
$z[8][4]['orderby']="weight";
$z[8][4]['addfields']="price,name,start_date,location";
$z[8][4]['channelid']="14";
$z[9]=Array("arclist","\r\n                <tr >\r\n                    <td class=\"name\"><a href=\"[field:arcurl/]\">《[field:name/]》</a></td>\r\n                    <td class=\"time\">[field:start_date function=MyDate('y-m-d',@me)/]</td>\r\n                    <td class=\"location\">[field:location/]</td>\r\n                    <td class=\"price\">￥[field:price/]</td>\r\n                </tr>\r\n                ",5015,5512);
$z[9][4]['typeid']="3";
$z[9][4]['row']="7";
$z[9][4]['orderby']="weight";
$z[9][4]['addfields']="price,name,start_date,location";
$z[9][4]['channelid']="14";
$z[10]=Array("arclist","\r\n        <div class=\"tz\">\r\n            <div class=\"si\">\r\n                <a href=\"[field:arcurl/]\">\r\n                    <div class=\"picc\"><img src=\"[field:litpic/]\" alt=\"[field:name/]\" ></div>\r\n                    <div class=\"lao\">[field:name/]</div>\r\n                    <div class=\"jie\">[field:breif function='cn_substrR(html2text(@me),40)'/]...</div>\r\n                    <div class=\"zi\"><a href=\"tencent://message/?uin=[field:conntact/]&Site=Customer service 1&Menu=yes\">[点击在线咨询]</a></div>\r\n                </a>\r\n            </div>\r\n        </div>\r\n        ",5774,6459);
$z[10][4]['typeid']="4";
$z[10][4]['orderby']="weight";
$z[10][4]['row']="4";
$z[10][4]['addfields']="name,breif,conntact";
$z[10][4]['channelid']="15";
$z[11]=Array("arclist","\r\n            <div class=\"zz\">\r\n                <a href=\"[field:arcurl/]\">\r\n                    <img src=\"[field:litpic/]\" alt=\"[field:title/]\" />\r\n                </a>\r\n            </div>\r\n            ",6753,7002);
$z[11][4]['typeid']="23";
$z[11][4]['row']="4";
$z[12]=Array("flink","",7372,7393);
$z[12][4]['row']="24";
$z[13]=Array("include","",7489,7525);
$z[13][4]['filename']="footer.htm";

?>