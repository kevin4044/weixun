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

function make_wish () {
    $('#xys').show(); 
}

/*
    @param personal_div_str
    @param enterprise_div_str
    @param type_id
 */
function display_and_hide ($p, $e, type_id) {
    if (type_id == 3) {
        $($e).hide();
    }

}

function CheckForm() {
    if (document.myform.client_name.value == "") {
        alert("请输入负责人姓名!");
        document.myform.name.focus();
        return false;
    }
    if (document.myform.client_count.value == "") {
        alert("请输入具体的人数!");
        document.myform.client_count.focus();
        return false;
    }
    if (document.myform.client_count.value <= 0) {
        alert("请输入正确的人数!");
        document.myform.client_count.focus();
        return false;
    }
    if (document.myform.client_mobile.value == "") {
        alert("请输入您手机号码!");
        document.myform.client_mobile.focus();
        return false;
    }
    var email;
    if ((email=document.myform.client_email.value) == "") {
        alert("请输入您的email地址!");
        document.myform.client_email.focus();
        return false;
    }
    var emailPat=/^(.+)@(.+)$/;
    if (!email.test(emailPat)) {
        alert("请输入合法的email地址");
    }
    if (document.myform.client_company.value == "") {
        alert("请输入您的公司名称!");
        document.myform.client_company.focus();
        return false;
    }
    if (document.myform.vdcode.value == "") {
        alert("请输入验证码!");
        document.myform.vdcode.focus();
        return false;
    }
}


/* @describe 将form中的值转换为键值对。
    @param frm the form you want to transfer
 */

 function getFormJson(frm) {
    var o = {};
    var a = $(frm).serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });

    return o;
}

/* @describe make form to submit
 */
function ajaxSubmit(frm, fn) {
    var dataPara = getFormJson(frm);
    $.ajax({
        url: frm.action,
        type: frm.method,
        data: dataPara,
        success: fn
    });
}

function kf_toggle() {
    $('div.KfMenu').toggle();
}
