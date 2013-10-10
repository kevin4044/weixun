<?php
$z[0]=Array("field","",73,91);
$z[0][4]['name']="title";
$z[1]=Array("global","",92,117);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("global","",165,194);
$z[2][4]['name']="cfg_description";
$z[3]=Array("global","",234,260);
$z[3][4]['name']="cfg_keywords";
$z[4]=Array("include","",586,620);
$z[4][4]['filename']="head.htm";
$z[5]=Array("field","",690,718);
$z[5][4]['name']="position";
$z[6]=Array("field","",854,900);
$z[6][4]['name']="id";
$z[6][4]['function']="GetTopInfo(@me,0,0)";
$z[7]=Array("channel","\r\n                        <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n                        ",1046,1194);
$z[7][4]['type']="son";
$z[8]=Array("arclist","\r\n                        <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                        ",1569,1736);
$z[8][4]['flag']="c";
$z[8][4]['row']="7";
$z[8][4]['orderby']="pubdate";
$z[9]=Array("arclist","\r\n            <div class=\"bao\">\r\n                <div class=\"ttt\"><a href=\"[field:arcurl/]\">讲师：[field:teacher/] 《[field:name/]》</a></div>\r\n                <div class=\"kais\"></div>\r\n                <div class=\"kaiz\">\r\n                    <!--todo:this is abusolutly a rubbish-->\r\n                    <div class=\"mqq\">\r\n                        <div class='t-course'>\r\n                            <div class=\"t-time\">开课时间：[field:start_date function=MyDate('',@me)/]</div>\r\n                            <div class=\"t-location\">开课地点：[field:location/]</div>\r\n                            <div class=\"t-price\">课程价格：￥[field:price/]元</div>\r\n                        </div>\r\n                        <div class=\"t-course\">\r\n                            <div class=\"t-target\">课程目标：[field:target function='cn_substrR(html2text(@me),100)'/]</div>\r\n                            <div class=\"t-status\">\r\n                                状  态：\r\n                                <span >\r\n                                </span>\r\n                            </div>\r\n                        </div>\r\n                        <input type=\"hidden\" name='start_date' value=\"[field:start_date function=MyDate('',@me)/]\"/>\r\n                        <input type=\"hidden\" name='end_date' value=\"[field:end_date function=MyDate('',@me)/]\"/>\r\n                    </div>\r\n                    <div class=\"mingg\">\r\n                        <a href=\"/module/form.php?arcid=[field:id/]&typeid=[field:typeid/]\">\r\n                            <img src=\"/images/common/lijibaoming.jpg\" alt=\"\"/>\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n                <div class=\"kaid\">\r\n                </div>\r\n            </div>\r\n            ",2458,4372);
$z[9][4]['row']="7";
$z[9][4]['orderby']="weight";
$z[9][4]['addfields']="teacher,target,price,name,start_date,end_date,location";
$z[9][4]['channelid']="14";
$z[10]=Array("pagelist","",4449,4528);
$z[10][4]['listitem']="index,end,pre,next,pageno";
$z[10][4]['listsize']="7";
$z[10][4]['sitelang']="cn";
$z[11]=Array("include","",5209,5245);
$z[11][4]['filename']="footer.htm";

?>