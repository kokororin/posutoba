/**
 * @name 公用js方法
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */

//div居中显示
function center(pName) {
    var top = ($(window).height() - $(pName).height()) / 2;
    var left = ($(window).width() - $(pName).width()) / 2;
    var scrollTop = $(document).scrollTop();
    var scrollLeft = $(document).scrollLeft();
    $(pName).css({
        'position': 'absolute',
        'top': top + scrollTop,
        'left': left + scrollLeft
    }).show();
}

//返回顶部
function goTop() {
    $('body,html').animate({
        scrollTop: 0
    }, 1000);
    return false;
}

//弹出的提示框
function createAlertbox(title, content) {
    $('.small_dialog.dialogJ').remove();
    var html = '<div class="small_dialog dialogJ dialogJfix dialogJshadow ui-draggable"' +
        'style="display: none;z-index: 50005; width: 410px;">' +
        '<div class="uiDialogWrapper">' +
        '<div class="dialogJtitle" style="cursor: move;">' +
        '<span class="dialogJtxt">' + title + '</span>' +
        '<a title="关闭本窗口" class="dialogJclose" href="javascript:void(0)">&nbsp;</a>' +
        '</div>' +
        '<div class="dialogJcontent">' +
        '<div id="dialogJbody" class="dialogJbody">' +
        '<div class="tb_alert_wrapper">' +
        '<p class="tb_alert_message">' + content + '</p>' +
        '<div class="tb_alert_btn_group">' +
        '<a class="ui_btn ui_btn_m j_btn no_post" href="javascript:void(0)"><span><em>确定</em></span></a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    $('body').append(html);
    center('.small_dialog.dialogJ');
    $('.dialogJ').draggable();
}

function closeAlertbox() {
    $('.dialogJ.small_dialog').hide();
}

//登录框
function login() {
        center('#passport-login-pop');
        $('#passport-login-pop').draggable();
    }
    //退出登录
function logout() {
        $.ajax({
            type: 'get',
            url: MODULE + '/User/logout',
            data: {},
            dataType: 'json',
            success: function(data) {
                location.href = removeHash();
            }
        });
    }
    //获取提醒
function getNotify() {
    $.ajax({
        type: 'get',
        url: MODULE + '/Home/getNotifyCount',
        data: {},
        dataType: 'json',
        success: function(data) {
            if (data.all != 0) {
                $('#notify-count').html(data.all);
                $('#notify-count').show();
                (data.fans != 0) ? getNotify_func('fans', 'show', data.fans): getNotify_func('fans', 'hide', data.fans);
                (data.reply != 0) ? getNotify_func('reply', 'show', data.reply): getNotify_func('reply', 'hide', data.reply);
            } else {
                $('#notify-count').html("");
                $('#notify-count').hide();
            }
        }
    });
}

function getNotify_func(type, action, count) {
    if (action == "show") {
        $('.u_notity_bd>ul>.category_item.category_item_empty>a[data-type="' + type + '"]>.unread_num.clearfix').html(count);
    } else if (action == "hide") {
        $('.u_notity_bd>ul>.category_item.category_item_empty>a[data-type="' + type + '"]>.unread_num.clearfix').html("");
    }
}

function userCard(uid) {
        $.ajax({
            type: 'get',
            url: MODULE + '/Home/getPanel',
            data: {
                uid: uid
            },
            dataType: 'json',
            success: function(data) {

                var avatar_url = MODULE + '/Home/getAvatar/uid/' + data.user_id;
                var home_url = MODULE + '/Home/main/id/' + data.user_id;
                var html = '<div class="ui_card_wrap" id="user_visit_card" style="display:none;z-index: 50005">' +
                    '<div class="j_content ui_card_content">' +
                    '<div class="card_headinfo_wrap" id="card_headinfo_wrap">' +
                    '<img class="card_userinfo_img" src="' + PUBLIC + '/common/images/panel_1001.jpg" />' +
                    '<div class="interaction_wrap interaction_wrap_theme2">' +
                    '<a class="btn_concern" target="_blank" href="#" onclick="return false" style="display:none;"></a>' +
                    '<a class="btn_sendmsg" target="_blank" href="" style="display:none;"></a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="card_userinfo_wrap clearfix">' +
                    '<div class="card_userinfo_left ">' +
                    '<div class="userinfo_head_wrap">' +
                    '<div class="userinfo_head" style=""></div>' +
                    '<a href="' + home_url + '" class="j_avatar" target="_blank"><img src="' + avatar_url + '" /></a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="card_userinfo_middle">' +
                    '<div class="card_userinfo_title clearfix">' +
                    '<a href="' + home_url + '" target="_blank" class="userinfo_username ">' + data.user_name + '</a>' +
                    '<div class="icon_wrap  icon_wrap_theme1"></div>' +
                    '</div>' +
                    '<div class="card_userinfo_num clearfix">' +
                    '<span class="userinfo_sex userinfo_sex_' + data.user_sex + '"></span>' +
                    '<span>吧龄:' + data.user_age + '年</span>' +
                    '<span class="userinfo_split"></span>' +
                    '<span">发贴:' + data.post_count + '</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<!-- <span class="j_ui_white_arrow arrow ui_white_down" style="left: 79px;"></span> -->' +
                    '</div>';
                $('body').append(html);
            }
        });
    }
    //发帖成功提示
function postSuccess() {
    $('.poster_success').show();
    setTimeout(function() {
        location.href = removeHash();
    }, 2000);
}

//回复楼主、楼层等
function replyFloor(pid, fid) {
    if (fid == 1) {
        replyLz();
    } else {
        $.ajax({
            type: 'get',
            url: MODULE + '/Post/getQuote',
            data: {
                pid: pid
            },
            success: function(data) {
                $('#reply-content').html(data);
            }
        });
        $('#replyid').val(pid);
        $('#reply-textarea').val('');
        $('#reply-textarea').focus();
    }
}

function replyLz() {
        $('#reply-content').html('');
        $('#replyid').val('0');
        $('#reply-textarea').focus();
    }
    //贴吧目录
function classPanel(pid) {
        $.ajax({
            type: 'get',
            url: MODULE + '/Forum/getForumClassAjaxListByPid',
            data: {
                pid: pid
            },
            dataType: 'json',
            success: function(data) {
                if (data.forum == "") {
                    $('.d-up-frame').find('.rec-icon').hide();
                } else {
                    $('.d-up-frame').find('.rec-icon').show();
                }
                $('.d-up-frame').find('.d-title').html(data.title);
                $('.d-up-frame').find('.item-wraper').html(data.classes);
                $('.d-up-frame').find('.rec-forum-cont').html(data.forum);
            }
        });
    }
    //贴吧名片
function showForumCard() {
        center('.forumcard_dialog.dialogJ');
        //$('.dialogJ').draggable();
    }
    //签到提交
function signForum(id) {
        $.ajax({
            type: 'get',
            url: MODULE + '/Forum/signForum',
            data: {
                fid: id
            },
            success: function(data) {
                if (data == "sign-success") {
                    location.href = removeHash();
                } else if (data == "need-login") {
                    login();
                }
            }
        });
    }
    //签到标记
function signMark(month, fid) {
    $.ajax({
        type: 'get',
        url: MODULE + '/Forum/getSignStatus',
        data: {
            fid: fid,
            month: month
        },
        dataType: 'json',
        success: function(data) {
            if (data == null) {
                return;
            }
            $.each(data, function(key, value) {
                $('.sign-table-tbody-day.day-' + data[key]).addClass('signed_mob_day');
            });
        }
    });
}

//获取cookie
function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1)
                    c_end = document.cookie.length;
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }
    //去除井号后面的内容
function removeHash() {
        var url = window.location.href;
        var hash = location.hash;
        var _url = url.replace(hash, "");
        return _url;
    }
    //获取目录
function loadClass() {
    $.ajax({
        url: MODULE + '/Forum/getForumParentClassAllAjaxList',
        type: 'get',
        data: {},
        dataType: 'json',
        timeout: 5000,
        error: function() {
            createAlertbox('错误', '网络超时');
        },
        success: function(data) {
            $('.select_parent').empty();
            $.each(eval(data), function(i, item) {
                $("<option value='" + item.parent_id + "'>" + item.class_name + "</option>").appendTo($('.select_parent'));
            });
        }
    });
}

function loadSon(pid) {
    $.ajax({
        url: MODULE + '/Forum/getForumClassAllAjaxListByPid',
        type: 'get',
        data: {
            pid: pid
        },
        dataType: 'json',
        timeout: 5000,
        error: function() {
            createAlertbox('错误', '网络超时');
        },
        success: function(data) {
            $('.select_son').empty();
            $.each(eval(data), function(i, item) {
                $("<option value='" + item.class_id + "'>" + item.class_name + "</option>").appendTo($(".select_son"));
            });
        }
    });
}

//搜索初始化
function globalForum() {
    var html = '';
    var text = null;
    var $suggest_often = $('#suggest_often_forum');
    $suggest_often.empty();
    if (getCookie('posutoba') != '') {
        text = '最近常逛的吧：';
    } else {
        text = '您可能喜欢的吧：';
    }
    html_start = '<li class="break_title">' +
        '<span class="break_tip">' + text + '</span></li>';
    $(html_start).appendTo($suggest_often);

    $.ajax({
        url: MODULE + '/Forum/getGlobalForumList',
        type: 'get',
        data: {},
        dataType: 'json',
        success: function(data) {
            $.each(eval(data), function(i, item) {
                html += '<li class="suggestion_li" data-fid="' + item.forum_id + '">' +
                    '<div class="forum_item">' +
                    '<img src="' + MODULE + '/Forum/getAvatar/fid/' + item.forum_id + '" class="forum_image" />' +
                    '<div class="forum_right">' +
                    '<div class="forum_name">' +
                    item.forum_name +
                    '<span class="forum_member" title="会员数">' + item.member_count + '</span>' +
                    '<span class="forum_thread" title="帖子数">' + item.post_count + '</span>' +
                    '</div>' +
                    '<div class="forum_desc">' +
                    '所属目录：' + item.forum_class.parent_name + '&nbsp;' + item.forum_class.class_name +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>';
            });
            $(html).appendTo($suggest_often);
        }
    });
}

//设置后台左侧样式
function setAdminNav() {
    var action_name = $('#page_aside').find('.nav').attr('data-action');
    var $son = $('#' + action_name);
    $son.addClass('sub_active');
    $son.parents('.nav_section').addClass('active');
}

//右上角
$(function() {
    var timer = null; //定义一个定时器变量
    /*var tmp_a = $('.u_menu_item.u_menu_username').width() - 108;
     var tmp_b = tmp_a + 8;
     var tmp_c = tmp_b + 26;
     var tmp_d = tmp_b + 2;
     var tmp_e = $('.u_menu_item.u_menu_username').width() -34;
     var tmp_f = 109 - tmp_e;
     var tmp_g = 24;
     var tmp_h = 109 - tmp_g;
     var tmp_i = 159 - tmp_g;*/
    //username
    $(".u_menu_username").mouseover(function() {
        clearTimeout(timer);
        $(".u_ddl").hide();
        $(".u_menu_item").removeClass("u_menu_hover");
        $(".u_menu_item.u_menu_username").addClass("u_menu_hover");
        $(".u_username>.u_ddl>.u_ddl_tit").css({
            "width": $('.u_menu_item.u_menu_username').width() - 34 + 'px',
            "left": 143 - $('.u_menu_item.u_menu_username').width() + 'px'
        });
        $(".u_username>.u_ddl").css({
            "left": $('.u_menu_item.u_menu_username').width() - 100 + 'px'
        }).show();
    });
    $(".u_menu_username").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_username>.u_ddl").hide();
            $(".u_menu_item.u_menu_username").removeClass("u_menu_hover");
        }, 300);
    });
    $(".u_username>.u_ddl").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_username>.u_ddl").hide();
            $(".u_menu_item.u_menu_username").removeClass("u_menu_hover");
        }, 300);
    });

    $(".u_username>.u_ddl").mouseover(function() {
        clearTimeout(timer);
        $(".u_username>.u_ddl").show();
    });

    //setting
    $(".u_menu_setting").mouseover(function() {
        clearTimeout(timer);
        $(".u_ddl").hide();
        $(".u_menu_item").removeClass("u_menu_hover");
        $(".u_menu_wrap").removeClass("u_menu_hover");
        $(".u_setting>.u_ddl>.u_ddl_tit").css({
            "width": 24 + 'px',
            "left": 109 - 24 + 'px'
        });
        $(".u_setting>.u_ddl").css({
            "left": $('.u_menu_item.u_menu_username').width() - 74 + 'px'
        }).show();
        $(".u_menu_item.u_menu_setting").addClass("u_menu_hover");
    });
    $(".u_menu_setting").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_setting>.u_ddl").hide();
            $(".u_menu_item.u_menu_setting").removeClass("u_menu_hover");
        }, 300);
    });
    $(".u_setting>.u_ddl").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_setting>.u_ddl").hide();
            $(".u_menu_item.u_menu_setting").removeClass("u_menu_hover");
        }, 300);
    });

    $(".u_setting>.u_ddl").mouseover(function() {
        clearTimeout(timer);
        $(".u_setting>.u_ddl").show();
    });
    //news
    $(".u_menu_news").mouseover(function() {
        clearTimeout(timer);
        $(".u_ddl").hide();
        $(".u_menu_wrap").removeClass("u_menu_hover");
        $(".u_menu_item").removeClass("u_menu_hover");
        $(".u_news>.u_ddl>.u_ddl_tit").css({
            "width": 24 + 'px',
            "left": 159 - 24 + 'px'
        });
        $(".u_news>.u_ddl").css({
            "left": $('.u_menu_item.u_menu_username').width() - 98 + 'px'
        }).show();
        $(".u_menu_item.u_menu_news").addClass("u_menu_hover");
    });
    $(".u_menu_news").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_news>.u_ddl").hide();
            $(".u_menu_item.u_menu_news").removeClass("u_menu_hover");
        }, 300);
    });
    $(".u_news>.u_ddl").mouseout(function() {
        timer = setTimeout(function() {
            $(".u_news>.u_ddl").hide();
            $(".u_menu_item.u_menu_news").removeClass("u_menu_hover");
        }, 300);
    });

    $(".u_news>.u_ddl").mouseover(function() {
        clearTimeout(timer);
        $(".u_news>.u_ddl").show();
    });

    //刷新验证码
    $('#TANGRAM__PSP_4__verifyCodeChange').click(function() {
        var src = $('#TANGRAM__PSP_4__verifyCodeImg').attr('src');
        var time = new Date().getTime();
        $('#TANGRAM__PSP_4__verifyCodeImg').attr('src', src + '/' + time);
    });

    //登录表单关闭
    $('#TANGRAM__PSP_3__closeBtn').click(function() {
        $('#passport-login-pop').hide();
    });

    //登录表单提交
    $('#TANGRAM__PSP_9__form,#TANGRAM__PSP_5__form').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                if (data == "login-success") {
                    location.href = removeHash();
                } else if (data == "password-error") {
                    $('#TANGRAM__PSP_9__error').html("密码错误");
                } else {
                    $('#TANGRAM__PSP_9__error').html("用户不存在");
                }
            }
        });
        return false;
    });

    //注册表单
    $('#TANGRAM__PSP_4__formreg').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                $('#TANGRAM__PSP_4__accountError').empty();
                $('#TANGRAM__PSP_4__passwordError').empty();
                $('#TANGRAM__PSP_4__verifyCodeError').empty();
                if (data == 'register-failure') {
                    createAlertbox('注册失败', '未知错误');
                }
                if (data == 'empty-username') {
                    $('#TANGRAM__PSP_4__accountError').html('还没有填写用户名');
                } else if (data == 'invalid-username') {
                    $('#TANGRAM__PSP_4__accountError').html('用户名不能含有特殊字符');
                } else if (data == 'too-long-username') {
                    $('#TANGRAM__PSP_4__accountError').html('用户名过长');
                } else if (data == 'username-exist') {
                    $('#TANGRAM__PSP_4__accountError').html('用户名已存在');
                }
                if (data == 'invalid-password') {
                    $('#TANGRAM__PSP_4__passwordError').html('密码必须为6-30位');
                }
                if (data == 'error-code') {
                    $('#TANGRAM__PSP_4__verifyCodeError').html('验证码不正确');
                }
                if (data == 'register-success') {
                    location.href = MODULE + '/User/registerSuccess/u/' + $('#return_url').val();
                }
            }
        });
        return false;
    });

    //忘记密码表单提交
    $('#forgotsel').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                if (data == "no-username") {
                    $('#username-error').html('用户不存在')
                } else if (data == "error-code") {
                    $('#code-error').html('验证码错误');
                } else if (data == "send-failure") {
                    createAlertbox('发送失败', '未知错误');
                } else {
                    location.href = MODULE + '/User/forgetPassword/step/2';
                }
            }
        });
        return false;
    });

    //重置密码表单
    $('#form-resetpwd').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                if (data == "invalid-key") {
                    createAlertbox('错误', '该key已被使用过！')
                } else if (data == "empty-password") {
                    $('#password-error').html('密码不能为空');
                } else if (data == "empty-verifypwd") {
                    $('#password-error').html('确认密码不能为空');
                } else if (data == "invalid-password") {
                    $('#password-error').html('密码格式不正确');
                } else if (data == "diff-password") {
                    $('#password-error').html('两次密码不一致');
                } else if (data == "reset-success") {
                    createAlertbox('操作成功', '您的密码已重置');
                } else {
                    location.href = MODULE + '/User/forgetPassword/step/2';
                }
            }
        });
        return false;
    });

    //每隔一段时间ajax加载提醒
    if (getCookie('posutoba') != "") {
        setInterval(function() {
            getNotify();
        }, parseInt(5) * 1000);
    }

    //弹出框的关闭按钮
    $('.dialogJclose').live('click', function() {
        $(this).parents('.dialogJ').hide();
    });

    $('.j_btn.no_post').live('click', function() {
        $(this).parents('.dialogJ').hide();
    });

    //发帖框内容提交
    $('#poster_btn').click(function() {
        var t = $('#reply-textarea').val();
        $('#tocontent').val(t);
        $('#addthread').submit();
        $('#addpost').submit();
        //alert(t);
    });

    //ctrl+enter快捷发表
    $("#reply-textarea").keypress(function(e) {
        if (e.ctrlKey && e.which == 13 || e.which == 10) {
            $("#poster_btn").click();
        }
    });

    //回帖表单
    $('#addpost').submit(function() {
        $(this).ajaxSubmit({
            url: MODULE + '/Post/addPost',
            success: function(data) {
                if (data == 'need-login') {
                    login();
                } else if (data == 'block-status') {
                    createAlertbox('回帖失败', '封禁状态无法回帖！');
                } else if (data == "post-success") {
                    $('.j_posting_status.poster_posting_status').addClass('poster_posting_status_loading');
                    postSuccess();
                } else if (data == 'content-empty') {
                    $('.poster_component.editor_content_wrapper.ueditor_container>.poster_error.j_error').html('内容不能为空');
                } else {
                    createAlertbox("回帖失败", "未知错误");
                }

            }
        });
        return false;
    });

    //创建贴吧表单
    $('#create_forum_form').submit(function() {
        $(this).ajaxSubmit({
            dataType: 'json',
            success: function(data) {
                if (data.msg == 'need-login') {
                    login();
                } else if (data.msg == "create-success") {
                    location.href = MODULE + '/Forum/index/id/' + data.fid;
                } else if (data.msg == 'forum-name-empty') {
                    createAlertbox("创建失败", "贴吧名称不能为空");
                } else if (data.msg == 'forum-desc-empty') {
                    createAlertbox("创建失败", "贴吧描述不能为空");
                } else if (data.msg == 'forum-exist') {
                    createAlertbox("创建失败", "贴吧已存在");
                } else {
                    createAlertbox("创建失败", "未知错误");
                }

            }
        });
        return false;
    });

    //发帖表单
    $('#addthread').submit(function() {
        $(this).ajaxSubmit({
            url: MODULE + '/Forum/addThread',
            success: function(data) {
                if (data == 'need-login') {
                    login();
                } else if (data == 'block-status') {
                    createAlertbox('发帖失败', '封禁状态无法发帖！');
                } else if (data == 'thread-success') {
                    postSuccess();
                } else if (data == 'title-empty') {
                    $('.poster_component.title_container>.poster_error.j_error').html('标题不能为空');
                } else if (data == 'content-empty') {
                    $('.poster_component.editor_content_wrapper.ueditor_container>.poster_error.j_error').html('内容不能为空');
                } else {
                    createAlertbox("发帖失败", "未知错误");
                }

            }
        });
        return false;
    });

    //上传图片
    $('#up_btn').click(function() {
        $('#upimg').click();
    });
    $("#upimg").change(function() {
        $('#uploadform').submit();
        createAlertbox('图片上传中', '请等待...');
    });
    $('#uploadform').submit(function() {
        $(this).ajaxSubmit({
            url: MODULE + '/Forum/uploadImg',
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    var imgurl = "[img]" + data.content + "[/img]";
                    $('#reply-textarea').setCaret();
                    $('#reply-textarea').insertAtCaret(imgurl);
                    closeAlertbox();
                } else if (data.status == 'failure') {
                    closeAlertbox();
                    createAlertbox("上传失败", data.content);
                }

            }
        });
        return false;
    });
    //关注贴吧按钮
    $('#like_forum_btn').click(function() {
        var fid = $(this).attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Forum/doLikeForum',
            data: {
                fid: fid
            },
            success: function(data) {
                if (data == "do-success") {
                    location.href = removeHash();
                } else if (data == "need-login") {
                    login();
                }
            }
        });
    });
    //关注用户按钮
    $('#like_user_btn').click(function() {
        var uid = $(this).attr('data-uid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Home/doLikeUser',
            data: {
                id: uid
            },
            success: function(data) {
                if (data == "do-success") {
                    location.href = removeHash();
                } else if (data == "need-login") {
                    login();
                }
            }
        });
    });

    //收藏帖子按钮
    $('#store_thread_btn').click(function() {
        var tid = $(this).attr('data-tid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Post/storeThread',
            data: {
                tid: tid
            },
            success: function(data) {
                if (data == "do-success") {
                    location.href = removeHash();
                } else if (data == "need-login") {
                    login();
                }
            }
        });
    });

    //用户名片
    $(document).delegate('.j_user_card', 'mouseenter', function(event) {
        var uid = $(this).attr('data-uid');
        var ele = $(this);
        var offset = ele.offset();
        userCard(uid);
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        timer = setTimeout(function() {
            $('#user_visit_card').css({
                "left": offset.left - 50,
                "top": offset.top - 215
            }).show();
        }, 300);
        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    }).delegate('.j_user_card,#user_visit_card', 'mouseleave', function(event) {
        //延迟执行鼠标移除事件
        timer = setTimeout("$('#user_visit_card').remove();", 30);
        event.stopPropagation();
    });
    $(document).delegate('#user_visit_card', 'mouseenter', function(event) {
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        $('#user_visit_card').show();
        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    });

    //显示回到顶部
    $(window).scroll(function() {
        var offset = 100;
        if ($(this).scrollTop() > offset) {
            $('.tbui_aside_fbar_button.tbui_fbar_top').show();
        } else {
            $('.tbui_aside_fbar_button.tbui_fbar_top').hide();
        }
    });

    //跳转分页
    $('#pager_go4').click(function() {
        var p = $('#jumpPage4').val();
        var url = $('.l_pager.pager_theme_4.pb_list_pager>a[data-pn="' + p + '"]').attr('href');
        if (typeof(url) == 'undefined') {
            createAlertbox('跳转失败', '请输入正确的页码！');
        } else {
            location.href = url;
        }
    });
    $('#pager_go6').click(function() {
        var p = $('#jumpPage6').val();
        var href = $('.l_pager.pager_theme_5.pb_list_pager>a[data-pn="' + p + '"]').attr('href');
        if (typeof(url) == 'undefined') {
            createAlertbox('跳转失败', '请输入正确的页码！');
        } else {
            location.href = url;
        }
    });

    //查看所有吧
    $('.j_show_more_forum').click(function() {
        var uid = $(this).attr('data-uid');
        location.href = MODULE + '/Home/forumList/id/' + uid;
    });

    $('#j_forum_title').click(function() {
        center('.managergroup_dialog.dialogJ');
        $('.dialogJ').draggable();
    });

    //签到按钮
    $(document).delegate('.j_signbtn.signstar_signed,.j_succ_info', 'mouseenter', function(event) {
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        $('.j_succ_info').show();
        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    }).delegate('.j_signbtn.signstar_signed,.j_succ_info', 'mouseleave', function(event) {
        //延迟执行鼠标移除事件
        timer = setTimeout("$('.j_succ_info').hide();", 30);
        event.stopPropagation();
    });

    //贴吧页图片缩放
    $('.threadlist_pic_li').click(function() {
        var img_src = new Array();
        img_src = [];
        $(this).parents('.thread_image').find('.threadlist_pic_li').find('img').each(function() {
            img_src.push($(this).attr('src'));
        });
        var img_order = $(this).find('img').attr('data-order');
        var imgsrc = img_src[img_order];
        var img_count = img_src.length;
        $(this).parents('.j_small_wrap,.n_media').hide();
        $(this).parents('.thread_image').find('.media_box').find('img').attr('src', imgsrc);
        $(this).parents('.thread_image').find('.media_box').find('.j_ypic').attr('href', imgsrc);
        $(this).parents('.thread_image').find('.media_box').find('img').attr('data-order', img_order);
        $(this).parents('.thread_image').find('.media_box').show();
        $(this).parents('.thread_image').find('.media_box').find('.j_display_next,.j_display_pre').hide();
        if (img_count == 2 && img_order == 0) {
            $(this).parents('.thread_image').find('.media_box').find('.j_display_next').show();
        } else if (img_count == 2 && img_order == 1) {
            $(this).parents('.thread_image').find('.media_box').find('.j_display_pre').show();
        } else if (img_count == 3 && img_order == 0) {
            $(this).parents('.thread_image').find('.media_box').find('.j_display_next').show();
        } else if (img_count == 3 && img_order == 1) {
            $(this).parents('.thread_image').find('.media_box').find('.j_display_next,.j_display_pre').show();
        } else if (img_count == 3 && img_order == 2) {
            $(this).parents('.thread_image').find('.media_box').find('.j_display_pre').show();
        }
    });

    $('.j_display_pre').click(function() {
        var img_order = parseInt($(this).parents('.media_box').find('img').attr('data-order'));
        var new_order = img_order - 1;
        $(this).parents('.media_box').find('img').attr('data-order', new_order);
        $(this).parents('.thread_image').find('ul').find('img[data-order="' + new_order + '"]').parents('li').click();
    });

    $('.j_display_next').click(function() {
        var img_order = parseInt($(this).parents('.media_box').find('img').attr('data-order'));
        var new_order = img_order + 1;
        $(this).parents('.media_box').find('img').attr('data-order', new_order);
        $(this).parents('.thread_image').find('ul').find('img[data-order="' + new_order + '"]').parents('li').click();
    });

    $('.j_retract,.j_large_pic,.p_putup').click(function() {
        $(this).parents('.media_box').hide();
        $(this).parents('.thread_image').find('.j_small_wrap,.n_media').show();
    });

    //首页左侧贴吧目录弹出菜单
    $(document).delegate('.f-d-item', 'mouseenter', function(event) {
        $('.d-up-frame').hide(); //208 -1200
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        var pid = $(this).attr('data-pid');
        classPanel(pid);
        $(this).addClass('f-d-item-hover');
        $(this).next().addClass('no-border-bottom');
        var pos = $(this).position();

        if ($(window).scrollTop() <= 1500) {
            timer = setTimeout(function() {
                $('.d-up-frame').css({
                    "left": pos.left + 208,
                    "top": pos.top - 1200
                }).show();
            }, 300);
        }

        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    }).delegate('.f-d-item,.d-up-frame', 'mouseleave', function(event) {
        //延迟执行鼠标移除事件
        $(this).removeClass('f-d-item-hover');
        $(this).next().removeClass('no-border-bottom');
        timer = setTimeout("$('.d-up-frame').hide();", 30);
        event.stopPropagation();
    });
    $(document).delegate('.d-up-frame', 'mouseenter', function(event) {
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        $(this).show();
        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    });
    $(document).delegate('.f_class_li', 'mouseenter', function(event) {
        $('.d-up-frame').hide();
        //延迟执行鼠标移除事件
        clearTimeout(timer);
        var pid = $(this).attr('data-pid');
        classPanel(pid);
        $(this).addClass('f-d-item-hover');
        $(this).prev().addClass('no-border-bottom');
        var offset = $(this).offset();
        timer = setTimeout(function() {
            $('.d-up-frame').css({
                "left": offset.left + 209,
                "top": offset.top
            }).show();
        }, 300);
        //该方法将停止事件的传播，阻止它被分派到其他 Document 节点
        event.stopPropagation();
    }).delegate('.f_class_li,.d-up-frame', 'mouseleave', function(event) {
        //延迟执行鼠标移除事件
        $(this).removeClass('f-d-item-hover');
        $(this).prev().removeClass('no-border-bottom');
        timer = setTimeout("$('.d-up-frame').hide();", 30);
        event.stopPropagation();
    });

    //ajax搜索
    $(document).delegate('#tb_header_search_form>.j_search_input', 'keyup', function(event) {
        var $suggest_ul = $('#head').find('.suggestion');
        var $suggest_res = $('#suggest_search_res');
        var $suggest_often = $('#suggest_often_forum');
        $suggest_res.empty();
        $suggest_often.hide();
        var word = $(this).val();
        var space_test = /^\s*$/;
        if (word == '' || space_test.test(word)) {
            $suggest_res.empty();
            //ajax
            globalForum();
            //ajax
            $suggest_often.show();
        }
        var html = null;
        var deli = new Array();
        var forum_name_hl = null;
        var html_end = '<li class="break_title special_title">' +
            '<span class="break_tip">在贴吧中搜索更多与“<em class="highlight">' + word + '</em>”相关的内容</span></li>' +
            '<li class="reserve_query"></li>';
        $.ajax({
            url: MODULE + '/Forum/getForumAjaxList',
            type: 'get',
            data: {
                word: word
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'no-data') {
                    html = '';
                } else {
                    $.each(eval(data), function(i, item) {
                        //forum_name_hl=item.forum_name.replace('/'+word+'/','<em class="highlight">'+word+'</em>');

                        html += '<li class="suggestion_li" data-fid="' + item.forum_id + '">' +
                            '<div class="forum_item">' +
                            '<img src="' + MODULE + '/Forum/getAvatar/fid/' + item.forum_id + '" class="forum_image" />' +
                            '<div class="forum_right">' +
                            '<div class="forum_name">' +
                            item.forum_name_hl +
                            '<span class="forum_member" title="会员数">' + item.member_count + '</span>' +
                            '<span class="forum_thread" title="帖子数">' + item.post_count + '</span>' +
                            '</div>' +
                            '<div class="forum_desc">' +
                            '所属目录：' + item.forum_class.parent_name + '&nbsp;' + item.forum_class.class_name +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</li>';
                    });
                }
                $(html + html_end).appendTo($suggest_res);

            }
        });
        clearTimeout(timer);
        timer = setTimeout(function() {
            $('#head').find('.suggestion').show();
        }, 200);
    });
    $(document).delegate('#tb_header_search_form>.j_search_input', 'click', function(event) {
        clearTimeout(timer);
        timer = setTimeout(function() {
            globalForum();
            $('#suggest_often_forum').show();
            var offset = $('#tb_header_search_form>.j_search_input').offset();
            $('#head').find('.suggestion').css({
                "left": offset.left,
                "top": offset.top + 30
            }).show();
        }, 200);
    });
    $(document).click(function() {
        $('#head').find('.suggestion').hide();
    });
    $('#head').find('.suggestion').find('.break_tip').live('click', function() {
        var word = $(this).find('.highlight').text();
        location.href = MODULE + '/Forum/search/word/' + word;
    });
    $('#head').find('.suggestion_li').live('mouseover', function() {
        $(this).addClass('on');
    }).live('mouseout', function() {
        $(this).removeClass('on');
    }).live('click', function() {
        var fid = $(this).attr('data-fid');
        location.href = MODULE + '/Forum/index/id/' + fid;
    });


    //吧内搜索
    $('.search_internal_btn').click(function() {
        $(this).blur();
        var word = $('.j_search_internal_form>.j_search_internal_input').val();
        var fid = $('#forum_id').val();
        $('.j_search_internal_form>.j_search_internal_input').val('');
        if (word != '') {
            location.href = MODULE + '/Forum/search/fid/' + fid + '/word/' + word;
        }
    });
    $('.j_search_internal_form').on('keydown', function(e) {
        e.keyCode == 13 && $('.search_internal_btn').click();
    });
    $('.j_search_internal_form').submit(function() {
        return false;
    });

    //清除搜索记录
    $('.s_h_clear').click(function() {
        var $history_con = $('#history_con');
        $.ajax({
            type: 'get',
            url: MODULE + '/Forum/clearSearchHistory',
            data: {},
            dataType: 'json',
            success: function(data) {
                if (data == 'clear-success') {
                    $history_con.find('.s_h_content').fadeOut();
                    $history_con.find('.s_h_clear').fadeOut();
                    $history_con.find('.s_h_content').remove();
                    $history_con.find('.s_h_clear').remove()
                    $history_con.find('.s_h_part').append('<div class="s_h_noresult">暂无搜索记录</div>');
                }
            }
        });
    });

    //上方导航栏进入贴吧按钮
    $('.j_enter_ba').click(function() {
        var fname = $('#tb_header_search_form>.j_search_input').val();
        location.href = MODULE + '/Forum/forumRedirect/fname/' + fname;
    });

    $('#tb_header_search_form').on('keydown', function(e) {
        e.keyCode == 13 && $('.j_enter_ba').click();
    });

    $('#tb_header_search_form').submit(function() {
        return false;
    });

    //全吧搜索按钮
    $('.j_search_post').click(function() {
        var word = $('#tb_header_search_form>.j_search_input').val();
        location.href = MODULE + '/Forum/search/word/' + word;
    });

    //贴吧等级页
    $('#lv_nav_which').click(function() {
        $('#lv_nav_intro').removeClass('lv_nav_intro_focus').addClass('lv_nav_intro');
        $('#lv_nav_who').removeClass('lv_nav_who_focus').addClass('lv_nav_who');
        $(this).removeClass('lv_nav_which').addClass('lv_nav_which_focus');
        $('#lv_nav_who_content').hide();
        $('#lv_nav_intro_content').hide();
        $('#lv_nav_which_content').show();
    });
    $('#lv_nav_intro').click(function() {
        $('#lv_nav_who').removeClass('lv_nav_who_focus').addClass('lv_nav_who');
        $('#lv_nav_which').removeClass('lv_nav_which_focus').addClass('lv_nav_which');
        $(this).removeClass('lv_nav_intro').addClass('lv_nav_intro_focus');
        $('#lv_nav_who_content').hide();
        $('#lv_nav_which_content').hide();
        $('#lv_nav_intro_content').show();
    });
    $('#lv_nav_who').click(function() {
        $('#lv_nav_which').removeClass('lv_nav_which_focus').addClass('lv_nav_which');
        $('#lv_nav_intro').removeClass('lv_nav_intro_focus').addClass('lv_nav_intro');
        $(this).removeClass('lv_nav_who').addClass('lv_nav_who_focus');
        $('#lv_nav_intro_content').hide();
        $('#lv_nav_which_content').hide();
        $('#lv_nav_who_content').show();
    });

    //高清头像
    $('#j_userhead').click(function() {
        $('#hd_avatar').show();
    });
    $('#hd_avatar').find('.j_hd_avatar_close').click(function() {
        $('#hd_avatar').hide();
    });

    //申请吧主三步
    $('#agreeBtn').click(function() {
        $('#agreementForm').hide();
        $('.apply_form').show();
        $('.first_step').removeClass('agreement_step');
        $('.fill_step').addClass('agreement_step');
    });

    $('#j_save_btn').click(function() {
        $('#apply_form').submit();
    });

    $('#apply_form').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                if (data == "empty-field") {
                    createAlertbox('错误', '请填写所有的空格！');
                } else if (data == "not-agree") {
                    createAlertbox('错误', '请勾选同意协议！');
                } else {
                    $('.apply_form').hide();
                    $('.fill_step').removeClass('agreement_step');
                    $('.last_step').addClass('agreement_step');
                    $('#apply_success1_dialog').show();
                }
            }
        });
        return false;
    });



    //帖子页管理按钮
    $('#thread_manage_btn').click(function() {
        center('.manage_dialog.dialogJ');
        $('.dialogJ').draggable();
    });

    //帖子管理提交
    $('#manage_submit').click(function() {
        var type = $('.manage_dialog').find('select>option:selected').attr('data-action');
        var tid = $('.manage_dialog').find('select').attr('data-tid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/setThreadType',
            data: {
                type: type,
                tid: tid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'do-success') {
                    createAlertbox('管理帖子', '操作成功!');
                } else if (data == 'do-failure') {
                    createAlertbox('管理帖子', '操作失败!');
                } else if (data == 'already-do') {
                    createAlertbox('管理帖子', '已经被加精或置顶!');
                } else if (data == 'top-limit') {
                    createAlertbox('管理帖子', '置顶最大个数为2,请先删除不需要的置顶帖!');
                } else {
                    createAlertbox('管理帖子', '其它错误！错误码为' + data);
                }
                $('.manage_dialog.dialogJ').hide();
            }
        });
    });

    //删贴按钮
    $('.post_del_href').click(function() {
        var pid = $(this).parents('.p_mtail').attr('data-pid');
        $('#submit_del_post').attr('data-pid', pid);
        center('.delete_dialog.dialogJ');
        $('.dialogJ').draggable();
    });

    //确认删贴
    $('#submit_del_post').click(function() {
        var pid = $(this).attr('data-pid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/delPost',
            data: {
                pid: pid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'delete-success') {
                    createAlertbox('管理帖子', '删除成功！');
                } else if (data == 'already-delete') {
                    createAlertbox('管理帖子', '已经删除过!');
                } else if (data == 'need-normal') {
                    createAlertbox('管理帖子', '置顶或精品不能删除！');
                }
                $('.delete_dialog.dialogJ').hide();
                location.href = removeHash();
            }
        });
    });

    //封按钮
    $('.p_post_ban').click(function() {
        var pid = $(this).parents('.p_mtail').attr('data-pid');
        var fid = $(this).parents('.p_mtail').attr('data-fid');
        var uid = $(this).parents('.p_mtail').attr('data-uid');
        var uname = $(this).parents('.p_mtail').attr('data-uname');
        $('.block_dialog.dialogJ').find('.b_username').html(uname);
        $('#submit_block_user').attr('data-uid', uid);
        $('#submit_block_user').attr('data-fid', fid);
        center('.block_dialog.dialogJ');
        $('.dialogJ').draggable();
    })

    //确认封禁
    $('#submit_block_user').click(function() {
        var fid = $(this).attr('data-fid');
        var uid = $(this).attr('data-uid');
        var day = $('.block_dialog').find('select>option:selected').attr('data-day');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/blockUser',
            data: {
                fid: fid,
                id: uid,
                day: day
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'block-success') {
                    createAlertbox('用户管理', '封禁成功！');
                } else if (data == 'block-failure') {
                    createAlertbox('用户管理', '未知错误');
                } else if (data == 'invalid-day') {
                    createAlertbox('用户管理', '未知的请求');
                }
                $('.block_dialog.dialogJ').hide();
            }
        });
    });

    //后台左侧菜单
    $('.nav_section').click(function() {
        $(this).siblings().removeClass('active');
        var action = $(this).parents('.nav').attr('data-action');
        if ($(this).hasClass('active'))
            $(this).removeClass('active');
        else
            $(this).addClass('active');
    });

    //后台切换管理的贴吧
    $('.j_forum_swich').click(function() {
        $('.j_forum_list_drag').toggle();
    });

    //后台帖子管理日志 全部操作菜单
    $('#operation_menu>.j_select').click(function() {
        var $operate = $('#operation_menu');
        if ($('#operation_menu').hasClass('table_menu_open')) {
            $operate.removeClass('table_menu_open');
            $operate.find('.menu_options_list').hide();
        } else {
            $operate.addClass('table_menu_open');
            $operate.find('.menu_options_list').show();
        }
    });
    //帖子管理日志操作类型选择
    $('#manage_action_select>li').click(function() {
        var action = $(this).find('a').attr('data-action');
        var fid = $('#operation_menu').attr('data-fid');
        if (typeof(page_username) == 'undefined' && typeof(page_startTime) == 'undefined')
            location.href = location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/action/' + action;
        else if (typeof(page_username) != 'undefined' && typeof(page_startTime) == 'undefined')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/action/' + action + '/username/' + page_username + '/utype/' + page_utype;
        else if (typeof(page_username) != 'undefined' && typeof(page_startTime) != 'undefined') location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/action/' + action + '/username/' + page_username + '/utype/' + page_utype + '/startTime/' + page_startTime + '/page_endTime/' + endTime;
        else if (typeof(page_username) == 'undefined' && typeof(page_startTime) != 'undefined')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/action/' + action + '/startTime/' + page_startTime + '/endTime/' + page_endTime;
    });

    //管理日志跳转分页
    $('#manage_jump_btn').click(function() {
        var p = $('#manage_jump_input').val();
        var url = $('.tbui_pagination>ul>li>a[data-pn="' + p + '"]').attr('href');
        if (typeof(url) == 'undefined') {
            createAlertbox('跳转失败', '请输入正确的页码！');
        } else {
            location.href = url;
        }
    });

    //管理日志搜索按钮
    $('#manage_search_btn').click(function() {
        var $form = $('#searchForm');
        var utype = $form.find("input[name='utype']:checked").val();
        var username = $form.find("input[name='username']").val();
        var startTime = $form.find("input[name='startTime']").val();
        var endTime = $form.find("input[name='endTime']").val();
        var fid = $form.find("input[name='fid']").val();
        if ((startTime == '' && endTime != '') || (startTime != '' && endTime == ''))
            createAlertbox('错误', '请务必填写操作时间');
        if (username == '' && startTime != '' && endTime !== '')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/startTime/' + startTime + '/endTime/' + endTime;
        if (username != '' && startTime != '' && endTime != '')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/username/' + username + '/utype/' + utype + '/startTime/' + startTime + '/endTime/' + endTime;
        if (username !== '' && startTime == '' && endTime == '')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/username/' + username + '/utype/' + utype;
    });

    //用户列表搜索按钮
    $('#member_search_btn').click(function() {
        var $form = $('#searchForm');
        var username = $form.find("input[name='username']").val();
        var fid = $form.find("input[name='fid']").val();
        if (username != '')
            location.href = MODULE + '/Admin/' + page_name + '/id/' + fid + '/username/' + username;
    });

    //后台封禁
    $('.j_user_ban_btn').click(function() {
        var uid = $(this).parent().attr('data-uid');
        var fid = $(this).parent().attr('data-fid');
        var uname = $(this).parent().attr('data-uname');
        $('.block_dialog.dialogJ').find('.b_username').html(uname);
        $('#submit_block_user').attr('data-uid', uid);
        $('#submit_block_user').attr('data-fid', fid);
        center('.block_dialog.dialogJ');
        $('.dialogJ').draggable();
    });

    //后台拉黑
    $('.j_user_black_btn').click(function() {
        var uid = $(this).parent().attr('data-uid');
        var fid = $(this).parent().attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/blackUser',
            data: {
                fid: fid,
                id: uid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'black-success') {
                    createAlertbox('用户管理', '拉黑成功！');
                } else if (data == 'black-failure') {
                    createAlertbox('用户管理', '未知错误');
                } else if (data == 'already-black') {
                    createAlertbox('用户管理', '已经拉黑过');
                }
                $('.block_dialog.dialogJ').hide();
            }
        });
    });

    //全选
    $('#selectAll').click(function() {
        $("input[name='s1']").attr('checked', this.checked);
    });

    //恢复帖子
    $('.j_restore_post').click(function() {
        var pid = $(this).attr('data-pid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/restorePost',
            data: {
                pid: pid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'restore-success') {
                    createAlertbox('管理帖子', '恢复成功!');
                } else if (data == 'already-restore') {
                    createAlertbox('管理帖子', '已经恢复过');
                }
            }
        });
    });

    //取消封禁
    $('.j_restore_block').click(function() {
        var uid = $(this).attr('data-uid');
        var fid = $(this).attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/restoreBlock',
            data: {
                uid: uid,
                fid: fid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'restore-success') {
                    createAlertbox('管理用户', '取消封禁成功!');
                } else {
                    createAlertbox('管理用户', '未知错误');
                }
            }
        });
    });

    //取消黑名单
    $('.j_restore_black').click(function() {
        var uid = $(this).attr('data-uid');
        var fid = $(this).attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/restoreBlack',
            data: {
                uid: uid,
                fid: fid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'restore-success') {
                    createAlertbox('管理用户', '取消黑名单成功!');
                } else {
                    createAlertbox('管理用户', '未知错误');
                }
            }
        });
    });

    //吧头衔
    $('#memberTitleApp').click(function() {
        center('.membertitle_dialog.dialogJ');
        $('.dialogJ').draggable();
    });

    $('#member_set').click(function() {
        $('#member_set_form').submit();
    });
    $('#member_set_form').submit(function() {
        $(this).ajaxSubmit({
            success: function(data) {
                if (data == 'set-success') {
                    createAlertbox('设置吧头衔', '操作成功！');
                } else if (data == 'no-data-update') {
                    createAlertbox('设置吧头衔', '没有数据更新！');
                } else if (data == 'invalid-name') {
                    createAlertbox('设置吧头衔', '不能含有特殊字符！');
                } else if (data == 'invalid-length') {
                    createAlertbox('设置吧头衔', '长度过长！');
                }

            }
        });
        return false;
    });

    //添加友情吧
    $('#relatedForumApp').click(function() {
        center('.relatedforum_dialog.dialogJ');
        $('.dialogJ').draggable();
    });
    $('#add_related_forum_btn').click(function() {
        var fname = $('#add_related_forum_name').val();
        var fid = $('#add_related_forum_name').attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/addRelatedForum',
            data: {
                fid: fid,
                fname: fname
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'add-success') {
                    createAlertbox('添加友情贴吧', '添加成功!');
                } else if (data == 'only-five') {
                    createAlertbox('添加友情贴吧', '最大数量为5!');
                } else if (data == 'invalid-forum') {
                    createAlertbox('添加友情贴吧', '目标贴吧不存在！');
                } else if (data == 'already-add') {
                    createAlertbox('添加友情贴吧', '目标贴吧已添加过！');
                } else {
                    createAlertbox('添加友情贴吧', '添加失败!');
                }
            }
        });
    });
    $('#related-forum-list').find('.friend-forum-delete').click(function() {
        var obj_id = $(this).attr('data-fid');
        var fid = $('#add_related_forum_name').attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/deleteRelatedForum',
            data: {
                fid: fid,
                obj_id: obj_id
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'del-success') {
                    createAlertbox('删除友情贴吧', '删除成功!');
                } else {
                    createAlertbox('删除友情贴吧', '未知错误');
                }
            }
        });
    });

    //修改目录
    $('#forumClassApp').click(function() {
        center('.forumclass_dialog.dialogJ');
        $('.dialogJ').draggable();
    });
    $('#manage_forum_class_btn').click(function() {
        var pid = $('#_class_pid').val();
        var cid = $('#_class_cid').val();
        var fid = $(this).attr('data-fid');
        $.ajax({
            type: 'get',
            url: MODULE + '/Admin/modifyForumClass',
            data: {
                fid: fid,
                pid: pid,
                cid: cid
            },
            dataType: 'json',
            success: function(data) {
                if (data == 'set-success') {
                    createAlertbox('修改目录', '修改成功!');
                } else {
                    createAlertbox('修改目录', '未知错误');
                }
            }
        });
    });

    //贴吧名片表单
    $('#forum_card_form').submit(function() {
        $(this).ajaxSubmit({
            dataType: 'json',
            success: function(data) {
                if (data == 'set-success') {
                    createAlertbox("设置吧名片", "操作成功");
                } else {
                    createAlertbox("设置吧名片", "未知错误");
                }
                $('.forumcard_dialog.dialogJ').hide();
            }
        });
        return false;
    });

    //profile表单
    $('#profile_form').submit(function() {
        $(this).ajaxSubmit({
            dataType: 'json',
            success: function(data) {
                if (data == 'set-success') {
                    createAlertbox("修改信息", "操作成功");
                } else if (data == 'empty-sex') {
                    createAlertbox("修改信息", "请选择性别");
                } else {
                    createAlertbox("修改信息", "位置错误");
                }
            }
        });
        return false;
    });

});