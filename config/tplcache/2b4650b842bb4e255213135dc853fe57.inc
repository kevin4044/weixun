<div class="bao">
                <div class="ttt"><a href="[field:arcurl/]">讲师：[field:teacher/] 《[field:name/]》</a></div>
                <div class="kais"></div>
                <div class="kaiz">
                    <!--todo:this is abusolutly a rubbish-->
                    <div class="mqq">
                        <table class="t-course">
                            <tr>
                                <td class="t-time">开课时间：[field:start_date function=MyDate('',@me)/]</td>
                                <td class="t-location">开课地点：[field:location/]</td>
                                <td class="t-price">课程价格：￥[field:price/]元</td>
                            </tr>
                            <tr>
                                <td class="t-target">课程目标：[field:target function='cn_substrR(html2text(@me),100)'/]</td>
                                <td class="t-status">
                                    状  态：
                                    <span >
                                        进行中
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name='start_date' value="[field:start_date function=MyDate('',@me)/]"/>
                        <input type="hidden" name='end_date' value="[field:end_date function=MyDate('',@me)/]"/>
                    </div>
                    <div class="mingg">
                        <a href="/module/form.php?arcid=[field:id/]&typeid=[field:typeid/]">
                            <img src="/images/common/lijibaoming.jpg" alt=""/>
                        </a>
                    </div>
                </div>
                <div class="kaid">
                </div>
            </div>