<div class="bao">
                <div class="ttt"><a href="[field:arcurl/]">讲师：[field:teacher/] 《[field:name/]》</a></div>
                <div class="kais"></div>
                <div class="kaiz">
                    <div class="mqq">
                        <ul>开课时间：[field:start_date function=MyDate('',@me)/]</ul>
                        <dl>开课地点：[field:location/]</dl>
                        <dt>课程价格：￥[field:price/]元</dt>
                        <br/>
                        <dd>课程目标：[field:target/]</dd>
                        <span>状  态：<b>报名中</b></span>
                    </div>
                    <div class="mingg">
                        <a href="">
                            <img src="/images/common/lijibaoming.jpg" alt=""/>
                        </a>
                    </div>
                </div>
                <div class="kaid"></div>
            </div>
            <script type="text/javascript">
                //TODO:complete this function
                function get_state (start_date_str, end_date_str) {
                    var start_arr = start_date_str.split(' ');
                    var end_arr = end_date_str.split(' ');
                    console.log(start_arr);

                }
                $(document).ready(function{
                    var start_str =  '[field:start_date function=MyDate('',@me)/]';
                    var end_str = '[field:end_date function=MyDate('',@me)/]';
                    $('.mqq span b').innerText = get_state(start_str, end_str);
                });
            </script>