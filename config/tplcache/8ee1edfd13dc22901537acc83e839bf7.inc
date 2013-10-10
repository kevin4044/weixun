<div class="bao">
                <div class="ttt"><a href="[field:arcurl/]">讲师：[field:teacher/] 《[field:name/]》</a></div>
                <div class="kais"></div>
                <div class="kaiz">
                    <!--todo:this is abusolutly a rubbish-->
                    <div class="mqq">
                        <table class="t-course">
                            <tr>
                                <td>开课时间：[field:start_date function=MyDate('',@me)/]</td>
                                <td>开课地点：[field:location/]</td>
                                <td>课程目标：[field:target/]</td>
                            </tr>
                            <tr>
                                <td>课程目标：[field:target/]</td>
                                <td>
                                    <span >状  态：
                                        <b></b>
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