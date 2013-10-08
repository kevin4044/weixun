<?php
$z[0]=Array("global","",73,98);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",146,175);
$z[1][4]['name']="cfg_description";
$z[2]=Array("global","",215,241);
$z[2][4]['name']="cfg_keywords";
$z[3]=Array("include","",567,601);
$z[3][4]['filename']="head.htm";
$z[4]=Array("field","",671,699);
$z[4][4]['name']="position";
$z[5]=Array("field","",835,881);
$z[5][4]['name']="id";
$z[5][4]['function']="GetTopInfo(@me,0,0)";
$z[6]=Array("channel","\r\n                        <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n                        ",1027,1175);
$z[6][4]['type']="son";
$z[7]=Array("arclist","\r\n                        <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                        ",1550,1717);
$z[7][4]['flag']="c";
$z[7][4]['row']="7";
$z[7][4]['orderby']="pubdate";
$z[8]=Array("arclist","\r\n            <div class=\"bao\">\r\n                <div class=\"ttt\"><a href=\"[field:arcurl/]\">讲师：[field:teacher/] 《[field:name/]》</a></div>\r\n                <div class=\"kais\"></div>\r\n                <div class=\"kaiz\">\r\n                    <div class=\"mqq\">\r\n                        <ul>开课时间：[field:start_date function=MyDate('',@me)/]</ul>\r\n                        <dl>开课地点：[field:location/]</dl>\r\n                        <dt>课程价格：￥[field:price/]元</dt>\r\n                        <br/>\r\n                        <dd>课程目标：[field:target/]</dd>\r\n                        <span >状  态：\r\n                            <b></b>\r\n                        </span>\r\n                        <input type=\"hidden\" name='start_date' value=\"[field:start_date function=MyDate('',@me)/]\"/>\r\n                        <input type=\"hidden\" name='end_date' value=\"[field:end_date function=MyDate('',@me)/]\"/>\r\n                    </div>\r\n                    <div class=\"mingg\">\r\n                        <a href=\"\">\r\n                            <img src=\"/images/common/lijibaoming.jpg\" alt=\"\"/>\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n                <div class=\"kaid\">\r\n                </div>\r\n            </div>\r\n            ",2417,3849);
$z[8][4]['row']="7";
$z[8][4]['orderby']="weight";
$z[8][4]['addfields']="teacher,target,price,name,start_date,end_date,location";
$z[8][4]['channelid']="14";
$z[9]=Array("pagelist","",3926,4005);
$z[9][4]['listitem']="index,end,pre,next,pageno";
$z[9][4]['listsize']="7";
$z[9][4]['sitelang']="cn";
$z[10]=Array("include","",4719,4755);
$z[10][4]['filename']="footer.htm";

?>