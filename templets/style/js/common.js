/**
 * Created with JetBrains WebStorm.
 * Author: Kevin Wang
 * Date: 13-9-27
 * Time: 上午11:07
 * Brief: 公共js函数文件
 */

function get_state (start_date_str, end_date_str) {
    var start_time = new Date(start_date_str);
    var end_time = new Date(end_date_str);
    var current_time = new Date();

    if (current_time < start_time) {
        return '报名中';
    } else if (current_time < end_time) {
        return '进行中';
    } else {
        return '已结束';
    }
}

