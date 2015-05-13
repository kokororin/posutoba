<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head>
   <meta charset="utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 <link rel="icon" href="/projects/posutoba/favicon.ico" type="image/x-icon" />
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script type="text/javascript" src="/projects/posutoba/Public/common/js/html5.js"></script>
		<![endif]-->
  <title><?php echo ($forum_info["forum_name"]); ?>吧<?php if ($_GET['type'] == 'good'): ?>的精品帖<?php endif;?>_Posutoba贴吧</title>
 <link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/theme.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/common.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/forum.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/emotion.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/upload.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/jquery.Jcrop.min.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/uploadify.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/jquery.fancybox.css" />
 </head>
  <body spellcheck="false" class="skin_normal">
   <div style="z-index: 10005;" id="com_userbar" class="userbar "> 
   <ul> 
    <?php if (null == getUid()): ?> 
    <li class="u_login"><a href="javascript:void(0)" onclick="login()">登录</a></li> 
    <li class="u_reg"><a href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Forum/index/id/3fmebrw')));?>">注册</a></li> 
    <?php else: ?> 
    <li id="j_u_username" class="u_username"> 
     <div class="u_menu_item u_menu_username"> 
      <a href="<?php echo U('Home/main',array('id'=>getUid()));?>" title="点击到个人中心" class="u_menu_wrap u_username_wrap"> <img class="u_username_avatar" src="<?php echo U('Home/getAvatar',array('uid'=>getUid()));?>" /><span class="u_username_title">
        <?php echo getUsername()?></span></a> 
     </div> 
     <div style="display: none;" class="u_ddl"> 
      <div class="u_ddl_tit"> 
      </div> 
      <div class="u_ddl_con"> 
       <div class="u_ddl_con_top"> 
        <ul> 
         <li class="u_itieba"><a href="<?php echo U('Home/main',array('id'=>getUid()));?>">我的贴吧</a></li> 
         <li class="u_favor"><a href="<?php echo U('Home/storedThread',array('id'=>getUid()));?>">我的收藏</a></li> 
        </ul> 
       </div> 
       <div class="d_ddl_con_bottom"> 
       </div> 
      </div> 
     </div> </li> 
    <li class="u_setting"> 
     <div class="u_menu_item u_menu_setting"> 
      <a class="u_menu_wrap u_setting_wrap" href="#" onclick="return false;"></a> 
     </div> 
     <div style="display: none;" class="u_ddl"> 
      <div class="u_ddl_tit"> 
      </div> 
      <div class="u_ddl_con"> 
       <div class="u_ddl_con_top"> 
        <ul> 
         <li class="u_tb_profile"><a href="<?php echo U('Home/profile',array('id'=>getUid()));?>">贴吧设置</a></li> 
         <li class="u_logout"><a href="javascript:void(0)" onclick="logout()">退出</a></li> 
        </ul> 
       </div> 
       <div class="d_ddl_con_bottom"> 
       </div> 
      </div> 
     </div> </li> 
    <li class="u_news"> 
     <div style="display: none;" class="u_ddl"> 
      <div class="u_ddl_tit"> 
      </div> 
      <div class="u_ddl_con"> 
       <div class="u_ddl_con_top"> 
        <div class="u_notity_bd"> 
         <ul> 
          <li class="category_item category_item_empty"><a class="j_cleardata" href="<?php echo U('Home/replyMe',array('id'=>getUid()));?>" target="_blank" data-type="reply">查看回复 <span class="unread_num clearfix"></span></a></li> 
          <li class="category_item category_item_empty"><a class="j_cleardata" href="<?php echo U('Home/fansList',array('id'=>getUid()));?>" target="_blank" data-type="fans">查看新粉丝 <span class="unread_num clearfix"></span></a></li> 
         </ul> 
         <ul class="sys_notify_last"> 
          <li class="category_item category_item_last j_category_item_last"> <a target="_blank" href="<?php echo U('Home/replyMe',array('id'=>getUid()));?>"> 我的通知 </a><span style="display: none;" class="unread_num clearfix">0</span> 
           <ul class="new_message j_new_message j_category_list"> 
           </ul> </li> 
         </ul> 
        </div> 
       </div> 
       <div class="d_ddl_con_bottom"> 
       </div> 
      </div> 
     </div> 
     <div class="u_menu_item u_menu_news"> 
      <a href="#" class="u_menu_wrap u_news_wrap j_news" onclick="return false;"> <span id="notify-count" style="display: none;"></span></a> 
     </div> </li> 
    <?php endif;?> 
   </ul> 
  </div> 
  <?php if (null == getUid()): ?> 
  <!-- 登录框 --> 
  <div id="passport-login-pop" class="tang-pass-pop-login-img tang-pass-pop-login-merge tang-pass-pop-login-tpl-tb tang-pass-pop-login-color-blue tang-pass-pop-login" style="display: none;left: 409px; top: 100px; z-index: 60001;"> 
   <div class="tang-background" id="TANGRAM__PSP_5__" style="position:absolute; top:0px; left:0px;width:100%;height:100%;z-index:-9; -webkit-user-select:none; -moz-user-select:none;" onselectstart="return false"> 
    <div class="tang-background-inner" style="width:100%;height:100%;" id="TANGRAM__PSP_5__inner"> 
    </div> 
    <div style="filter:progid:DXImageTransform.Microsoft.Alpha(opacity:0);position:absolute;z-index:-1;top:0;left:0;width:100%;height:100%;opacity:0;background-color:#FFFFFF"> 
    </div> 
   </div> 
   <div class="tang-foreground" id="TANGRAM__PSP_3__foreground" style="width: 532px;"> 
    <div class="tang-title tang-title-dragable" id="TANGRAM__PSP_3__title"> 
     <div class="buttons" id="TANGRAM__PSP_3__titleButtons"> 
      <a id="TANGRAM__PSP_3__closeBtn" class="close-btn" href="javascript:void(0)"></a> 
     </div> 
     <span id="TANGRAM__PSP_3__titleText">登录帐号</span> 
    </div> 
    <div class="tang-body" id="TANGRAM__PSP_3__body"> 
     <div class="tang-content" id="TANGRAM__PSP_3__content"> 
      <div id="passport-login-pop-dialog"> 
       <div class="clearfix"> 
        <div class="pass-login-pop-img"> 
         <img src="/projects/posutoba/Public/common/images/logindlg_pic1.png" alt="" title="" /> 
        </div> 
        <div class="pass-login-pop-content" id=""> 
         <div class="pass-login-pop-form"> 
          <div id="passport-login-pop-api" class="tang-pass-login"> 
           <form action="<?php echo U('User/login');?>" id="TANGRAM__PSP_9__form" class="pass-form pass-form-normal" method="POST" autocomplete="off"> 
            <p id="TANGRAM__PSP_9__errorWrapper" class="pass-generalErrorWrapper"> <span id="TANGRAM__PSP_9__error" class="pass-generalError pass-generalError-error"></span> </p> 
            <p id="TANGRAM__PSP_9__userNameWrapper" class="pass-form-item pass-form-item-userName" style="display:"> <label for="TANGRAM__PSP_9__userName" id="TANGRAM__PSP_9__userNameLabel" class="pass-label pass-label-userName">用户名</label><input id="TANGRAM__PSP_9__userName" type="text" name="username" class="pass-text-input pass-text-input-userName open" autocomplete="off" placeholder="用户名" /><span id="TANGRAM__PSP_9__userNameTip" class="pass-item-tip pass-item-tip-userName" style="display:none"><span id="TANGRAM__PSP_9__userNameTipText" class="pass-item-tiptext pass-item-tiptext-userName"></span></span> </p> 
            <span class="pass-item-selectbtn pass-item-selectbtn-userName" style="display: none; visibility: hidden; opacity: 1;"></span> 
            <p> </p> 
            <p id="TANGRAM__PSP_9__passwordWrapper" class="pass-form-item pass-form-item-password" style="display:"> <label for="TANGRAM__PSP_9__password" id="TANGRAM__PSP_9__passwordLabel" class="pass-label pass-label-password">密码</label><input id="TANGRAM__PSP_9__password" type="password" name="password" class="pass-text-input pass-text-input-password" placeholder="密码" /><span id="TANGRAM__PSP_9__passwordTip" class="pass-item-tip pass-item-tip-password" style="display:none"><span id="TANGRAM__PSP_9__passwordTipText" class="pass-item-tiptext pass-item-tiptext-password"></span></span> </p> 
            <p id="TANGRAM__PSP_9__memberPassWrapper" class="pass-form-item pass-form-item-memberPass"></p>
            <p id="TANGRAM__PSP_9__submitWrapper" class="pass-form-item pass-form-item-submit"> <input id="TANGRAM__PSP_9__submit" type="submit" value="登录" class="pass-button pass-button-submit" alog-alias="login" /><br />  <a class="pass-reglink" href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Forum/index/id/3fmebrw')));?>" target="_blank">立即注册</a>
            <a class="pass-fgtpwd" href="<?php echo U('User/forgetPassword');?>" target="_blank">忘记密码？</a> </p> 
           </form> 
          </div> 
          <div id="pass-phoenix-login" class="tang-pass-login-phoenix"> 
           <div class="pass-phoenix-title">
             可以使用以下方式登录 
            <span class="pass-phoenix-note"></span> 
           </div> 
           <div id="pass-phoenix-list-login" class="pass-phoenix-list clearfix pass-phoenix-list-second"> 
            <a href="<?php echo U('User/qqAuth');?>"><img src="/projects/posutoba/Public/common/images/qq_login.gif" /></a>
           </div> 
           <div class="clear"></div> 
          </div> 
         </div> 
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 
    <div class="tang-footer" id="TANGRAM__PSP_3__footer" style="display: none;"> 
     <div id="TANGRAM__PSP_3__footerContainer"> 
     </div> 
    </div> 
   </div> 
  </div> 
  <?php endif;?>
  <div class="wrap1">
   <div class="wrap2">
    <div class="wrap_clear"></div>
    <div class="wrap_bright">
     <div class="head_bright">
      <div id="head" class=" search_bright clearfix" style=""> 

   <div class="search_top clearfix"> 
    <a title="到贴吧首页" href="/projects/posutoba/" class="search_logo" style=""></a>
   </div> 
   <div class="search_main_wrap"> 
    <div style="display: block;" class="search_main search_main_fixed clearfix"> 
     <div class="search_form search_form_fixed"> 
      <a id="search_logo_small" class="search_logo_fixed" title="到贴吧首页" href="/projects/posutoba/"></a>
      <form class="clearfix j_search_form" id="tb_header_search_form"> 
       <input class="search_ipt search_inp_border j_search_input tb_header_search_input" name="kw" value="" autocomplete="off" size="42" tabindex="1" id="wd1" maxlength="100" type="text" />
       <span class="search_btn_wrap search_btn_enter_ba_wrap"><a class="search_btn search_btn_enter_ba j_enter_ba search_btn_fixed search_btn_enter_ba_fixed" href="javascript:void(0)">进入贴吧</a></span>
       <span class="search_btn_wrap"><a class="search_btn j_search_post search_btn_fixed" href="javascript:void(0)">全吧搜索</a></span>
      </form> 
      </div> 
     <!-- suggest -->
     <div class="suggestion" style="width: 538px;display: none;">
   <ul class="suggestion_list">
    <div id="suggest_often_forum"></div>
    <div id="suggest_search_res"></div>
   </ul>
  </div>
    </div> 
   </div> 
  </div>
     </div>
     <div class="top_iframe"></div>
     <div id="container" class="container_bright">
      <div class="content_top"></div>
      <div class="content">
       <div class="forum_header">
        <div class="card_banner">
         <!-- <img src="/projects/posutoba/Public/common/images/forum_default_head.jpg" alt="" />  -->
        </div>
        <div class="card_top_wrap clearfix card_top_theme1">
         <div class="card_top_right">
          <div class="sign_mod_bright" id="sign_mod"> 
           <div class="sign_tip_container"> 
            <div class="j_succ_info sign_succ1" style="display: none;"> 
             <div class="sign_tip_bdwrap clearfix"> 
              <div class="sign_tip_bd_arr"></div> 
              <div class="sign_tip_main"> 
               <div class="sign_succ_calendar"> 
                <div class="sign_succ_calendar_title"> 
                 <div class="calendar_title_month clearfix"> 
                  <div class="calendar_month_next j_calendar_month_next">
                   &nbsp;
                  </div> 
                  <div class="calendar_month_prev j_calendar_month_prev">
                   &nbsp;
                  </div> 
                  <div class="calendar_month_span j_calendar_month">
                   XXXX年XX月
                  </div>
                  <input type="hidden" name="sign_month" id="sign_month" value="" />
                 </div> 
                </div> 
                <table class="sign_succ_table"> 
                 <thead align="center"> 
                  <tr class="sign_succ_canlerdar_head"> 
                   <td>日</td> 
                   <td>一</td> 
                   <td>二</td> 
                   <td>三</td> 
                   <td>四</td> 
                   <td>五</td> 
                   <td>六</td> 
                  </tr> 
                 </thead> 
                 <tbody id="sign-table-tbody" class="sign_succ_canlerdar_days j_canlerdar_days" align="center"> 
                  <tr class="j_1"> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                  <tr class="j_2"> 
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                  <tr class="j_3"> 
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                  <tr class="j_4"> 
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                  <tr class="j_5"> 
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                  <tr class="j_6"> 
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td>
                   <td class="sign-table-tbody-day"></td> 
                  </tr> 
                 </tbody> 
                </table> 
               </div> 
               <div class="sign_tip_boards"> 
                <div class="sign_tip_board sign_tip_board_urank j_sign_ad_mobi"> 
                 <div class="sign_tip_board_ico"></div> 
                 <p> 签到排名：今日本吧第<span class="sign_index_num j_signin_index"><?php echo ($sign_order); ?></span>个签到</p> 
                 <!-- <p> <span class="j_succ_text">离前十名还有些距离，大家来得更勤快些吧~</span> </p>  -->
                </div> 
                <div class="sign_tip_board sign_tip_board_barrank"> 
                 <div class="sign_tip_board_ico"></div> 
                 <p>本吧签到人数：<?php echo ($sign_count); ?></p>
                </div> 
               </div> 
              </div> 

             </div> 
            </div> 
           </div> 
           <?php echo ($sign_html); ?>
          </div> 
         </div>
         <div class="card_top clearfix">
          <div class="card_head">
           <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>"><img class="card_head_img" src="<?php echo U('Forum/getAvatar',array('fid'=>$forum_info['forum_id']));?>" /></a>
          </div>
          <div class="card_title ">
           <a class="card_title_fname" title="" href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>"> <?php echo ($forum_info["forum_name"]); ?>吧</a>
           <a href="javascript:void(0)" data-fid="<?php echo ($forum_info["forum_id"]); ?>" class="<?php echo ($concern_btn_css); ?>" id="like_forum_btn" style="margin-top: 2px;"></a>
           <span class="card_num "><span class="card_numLabel">关注：</span><span class="card_menNum"><?php echo ($member_count); ?></span><span class="card_numLabel">贴子：</span><span class="card_infoNum"><?php echo ($post_count); ?></span></span>
          </div>
          <p class="card_slogan"><?php echo ($forum_info["forum_desc"]); ?></p>
          <div class="card_info">
           <ul class="forum_dir_info bottom_list clearfix">
            <li></li>
            <li><span class="dir_text">目录：</span></li>
            <li><a target="_blank" href="<?php echo U('Forum/forumPark',array('pid'=>$forum_class['parent_id'],'cid'=>$forum_class['class_id']));?>"><?php echo ($forum_class["class_name"]); ?></a> </li>
           </ul>
          </div>
         </div>
        </div>
        <div class="game_frs_in_head">
         <!-- ie空div高度消除 -->
        </div>
        <div class="nav_wrap " id="tb_nav">
         <ul class="nav_list j_nav_list">
          <li class=" focus j_tbnav_tab ">
           <div class="tbnav_tab_inner">
            <p class="space"> <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>" class="nav_icon icon_tie  j_tbnav_tab_a" id="tab_forumname">看贴</a> </p>
           </div> </li>
          <li class="none_right_border j_tbnav_tab ">
           <div class="tbnav_tab_inner">
            <p class="space"> <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id'],'type'=>'good'));?>" class="nav_icon icon_jingpin  j_tbnav_tab_a">精品</a> </p>
           </div> </li>

         </ul>
         <div class="search_internal_wrap j_search_internal">
          <form class="j_search_internal_form">
           <input class="search_internal_input j_search_internal_input" type="text" placeholder="吧内搜索"/>
           <input class="search_internal_btn" type="button" />
          </form>
         </div>
        </div>
       </div>
       <div class="forum_content clearfix">
        <div class="main" id="contet_wrap">
         <div id="content_leftList" class="content_leftList clearfix">
          <ul id="thread_list" class="threadlist_bright">
           <!-- 帖子开始 -->
           <?php if(is_array($thread_list)): foreach($thread_list as $key=>$vo): ?><li class="j_thread_list clearfix thread_image <?php if ($key == 0): ?>thread_1st<?php endif;?>">
            <div class="t_con cleafix">
             <div class="threadlist_li_left j_threadlist_li_left">
              <div class="threadlist_rep_num" title="直达尾页">
               <?php echo ($vo["reply_count"]); ?>
              </div>
             </div>
             <div class="threadlist_li_right j_threadlist_li_right">
              <div class="threadlist_lz clearfix">
               <div class="threadlist_text threadlist_title j_th_tit  ">
                <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" title="<?php echo ($vo["thread_title"]); ?>" target="_blank" class="j_th_tit"><?php echo ($vo["thread_title"]); ?></a>
                <span>
                <?php if (strpos($vo['thread_type'], 'good') !== false): ?>
                <img src="/projects/posutoba/Public/common/images/thread_good.gif" alt="精品" />
                <?php endif;?>
                <?php if (strpos($vo['thread_type'], 'top') !== false): ?>
                <img src="/projects/posutoba/Public/common/images/thread_top.gif" alt="置顶" />
                <?php endif;?>
                </span>
               </div>
               <div class="threadlist_author">
                <span class="tb_icon_author " title="主题作者: <?php echo ($vo["user_name"]); ?>">
                <a class="j_user_card" data-uid="<?php echo ($vo["user_id"]); ?>" href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>" target="_blank"><?php echo ($vo["user_name"]); ?></a>
                 <div class="icon_wrap  icon_wrap_theme1 frs_bright_icons "></div></span>
               </div>
              </div>
              <?php if (strpos($vo['thread_type'], 'top') === false): ?>
              <div class="threadlist_detail clearfix">
               <div class="threadlist_text">
                <div class="threadlist_abs threadlist_abs_onlyline">
                  <?php echo ($vo["post_content_convert"]); ?>
                </div>
               <?php echo ($vo["thread_image"]); ?>
               </div>
               <div class="threadlist_author">
                <span class="tb_icon_author_rely j_replyer" title="最后回复人：<?php echo ($vo["last_username"]); ?>">
                <a class="j_user_card" data-uid="<?php echo ($vo["last_userid"]); ?>" href="<?php echo U('Home/main',array('id'=>$vo['last_userid']));?>" target="_blank"><?php echo ($vo["last_username"]); ?></a></span>
                <span class="threadlist_reply_date j_reply_data" title="最后回复时间"> <?php echo (convertDate($vo["last_date"],'intel')); ?></span>
               </div>
              </div>
              <?php endif;?>
             </div>
             <div class="clear"></div>
            </div>
            <?php if (strpos($vo['thread_type'], 'top') === false): ?>
            <!-- 大图start -->
     <div class="media_box j_remove j_media_box" style="display:none;">
   <div class="media_disp">
    <div class="media_pic_control">
     <a class="tb_icon_retract j_retract" href="javascript:void(0)">收起</a>
     <span class="line">|</span>
     <a target="_blank" class="tb_icon_ypic j_ypic" href="">查看大图</a>
    </div>
    <div class="media_bigpic j_media_bigPic">
     <div class="media_bigpic_wrap">
      <img class="j_retract" src="javascript:void(0)" style="margin-top: 25px; margin-bottom: 25px;" />
     </div>
     <div class="media_bigpic_display_pre j_display_pre" style="display: none;"></div>
     <div class="media_bigpic_display_next j_display_next" style="display:none;"></div>
    </div>
   </div>
   <div class="j_enter_pb_wrapper enter_pb_wrapper">
    <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" class="ui_btn ui_btn_m_special j_enter_pb enter_pb" target="_blank"><span><em>进入贴子</em> </span></a>
   </div>
  </div>
  <!-- 大图end -->
  <?php endif;?>
           </li><?php endforeach; endif; ?>
            <!-- 帖子结束 -->

          </ul>
          <div class="thread_list_bottom clearfix">
           <div id="frs_list_pager" class="pager clearfix">
            <?php echo ($page); ?>
           </div>
          </div>
         </div>

        </div>
        <div id="aside" class="side">
         <?php if (null != getUid()): ?>
         <?php if($is_like_forum ==1):?>
<div id="balv_mod" class="region_bright balv_mod balv_mod_bright" data-region="">
         <div class="region_header">
          <div class="region_op j_op">
           <a class="p_balv_btnmanager" href="javascript:void(0)" target="_blank">[管理]</a> 
          </div>
          <div class="region_title region_icon j_title">
           我在贴吧
          </div>
         </div>
         <div class="region_cnt"> 
         <div class="userliked_ban_content">
         <?php if(strpos($user_status,'block')!==false):?>
              <div class="userlike_prisoned"></div>
         <?php elseif(strpos($user_status,'black')!==false):?>
              <div class="userlike_blacked"></div>
         <?php endif;?>
         </div>
          <div class="user_profile clearfix " id="user_info">
           <div class="profile_left user_head">
            <a href="<?php echo U('Home/main',array('id'=>getUid()));?>" target="_blank"><img class="head_img" src="<?php echo U('Home/getAvatar',array('uid'=>getUid()));?>" /></a>
           </div>
           <div class="profile_right user_name"> 
            <div class="pre_icon_wrap pre_icon_wrap_theme2 ">
            </div>
            <a class="" title="" href="<?php echo U('Home/main',array('id'=>getUid()));?>" target="_blank"><?php echo getUsername()?></a>
           </div>
           <div class="profile_bottom"> 
            <div id="j_profile_pop" class="profile_pop"></div>
           </div>
          </div> 
         </div>
         <div class="region_footer"></div>
        </div>
  <?php endif;?>
  <div class="region_bright balv_mod balv_mod_user_currforum balv_mod_bright">
   <div class="region_header">
    <div class="region_op j_op"> 
    </div>
    <div class="region_title region_icon j_title">
     我在本吧
    </div>
   </div>
   <div class="region_cnt">
    <div class="user_level clearfix">
     <div class="rank"> 
      <a target="_blank" title="点击查看本吧牛人排行榜" href="<?php echo U('Forum/levelRank',array('id'=>$forum_info['forum_id']));?>">排名：</a>
      <span class="rank_index"><?php echo ($rank_order); ?></span> 
     </div>
     <div class="badge badge_lv<?php echo ($level_css); ?>" title="本吧头衔<?php echo ($level); ?>级，经验值<?php echo ($exp); ?>，点击进入本吧头衔说明页">
      <div class="badge_name">
       <?php echo ($member_title); ?>
      </div>
      <div class="badge_index">
       <?php echo ($level); ?>
      </div>
     </div>
     <div class="userlike_info_tip" id="userlike_info_tip"></div>
     <div class="exp">
      <div class="exp_lable">
       经验：
      </div>
      <div class="exp_bar ">
       <div style="width:<?php echo ($ratio); ?>%;" class="exp_bar_current "></div>
       <div class="exp_num">
        <span class="exp_current_num"><?php echo ($exp); ?></span>
        <span>/<?php echo ($max_exp); ?></span>
       </div>
      </div>
     </div>
    </div> 
   </div>
   <div class="region_footer"></div>
  </div>  
         <?php endif;?>
         <div id="forumInfoPanel" class="region_bright forum_info_bright" data-region="">
          <div class="region_header">           
            <div class="region_title region_icon j_title">
           <a id="j_forum_title" href="javascript:void(0)">本吧信息</a>
           </div>
          </div>
          <div class="region_cnt">
           <div class="manager_list">
            <span id="tbManagerApply"> </span>
            <h4> <a href="#" class="manager_btn" onclick="return false;">吧主</a>： </h4>
            <ul class="clearfix">
              <?php if(is_array($manager_list)): foreach($manager_list as $key=>$vo): ?><li class="user_avt_card">
              <div class="manager_pic">
               <a href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>" target="_blank" title="<?php echo ($vo["user_name"]); ?>"><img src="<?php echo U('Home/getAvatar',array('uid'=>$vo['user_id']));?>" alt="" /></a>
              </div>
              <div class="manager_name">
               <a href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>" target="_blank"><?php echo ($vo["user_name"]); ?></a>
              </div> </li><?php endforeach; endif; ?>
             <li id="tbManagerCandidatesNum" style="display: none"> </li>
            </ul>
           </div>
          <h4>小吧：</h4>
          <ul><li>小吧主共<span class="assist_num"><?php echo ($small_manager_count); ?></span>人 
            <span id="tbManagerAssistApply" style="display: none;"></span></li></ul>
           <h4>会员：</h4>
           <ul>
            <li><a id="member_name_link" href="<?php echo U('Forum/memberList',array('id'=>$forum_info['forum_id']));?>" target="_blank"><?php echo ($member_name); ?></a><span class="member_num_o">共<span class="member_num"><?php echo ($member_count); ?></span>人 </span></li>
           </ul>
           <h4 class="forum_dir_info">目录：</h4>
           <ul class="forum_dir_info">
            <li><a href="<?php echo U('Forum/forumPark',array('pid'=>$forum_class['parent_id'],'cid'=>$forum_class['class_id']));?>" target="_blank"><?php echo ($forum_class["class_name"]); ?></a></li>
           </ul>
           <div class="bottom_list">
            <span><a href="<?php echo U('Forum/applyManager',array('id'=>$forum_info['forum_id']));?>" target="_blank">申请吧主</a></span> | <span><a href="" target="_blank">申请小吧主</a></span>
           </div>
          </div>
          <div class="region_footer"></div>
         </div>
           <?php if ($manage_status != -1): ?>
           <div class="region_bright adminModePanel_bright" id="adminModePanel">
   <div class="amPanel_top"></div>
   <div class="amPanel_content clearfix">
    <div id="tbAdminTip" class="admin_tip" style="display: block;"></div>
    <?php if($manage_status == 0):?>
    <a class="tbAdminManage ltbtn" href="javascript:void(0)" onclick="showForumCard()"><span>设置本吧名片</span></a>
    <?php endif;?>
    <a class="titleManageIndex rtbtn" target="_blank" href="<?php echo U('Admin/index',array('id'=>$forum_info['forum_id']));?>"><span>吧务后台</span></a>
   </div>
   <div class="amPanel_bottom"></div>
  </div>
  <?php endif;?>
    <?php if($related_forum_list!=null):?>
         <div id="zyq" class="zyq_bright">
          <div class="mod j_editable" id="zyq_mod_friend" data-mod_type="friend">
           <div class="tl">
            <div class="mod_edit_wrap"></div>
            <span class="zyq_mod_title">友情贴吧</span>
           </div>
           <div class="cnt">
            <ul class="zyq_mod_friend_items clearfix">
             <?php if(is_array($related_forum_list)): foreach($related_forum_list as $key=>$vo): ?><li class="zyq_mod_friend_item">
              <div class="zyq_friend_item_avt">
               <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank" title="<?php echo ($vo["forum_name"]); ?>"><img src="<?php echo U('Forum/getAvatar',array('fid'=>$vo['forum_id']));?>" alt="" /></a>
              </div>
              <div class="zyq_friend_item_name">
               <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank" class="j_mod_item" title="<?php echo ($vo["forum_name"]); ?>"><?php echo ($vo["forum_name"]); ?></a>
              </div></li><?php endforeach; endif; ?>
            </ul>
           </div>
          </div>
         </div>
       <?php endif;?>
        </div>
       </div>
       <div class="forum_foot">
        <div class="th_footer_2 clearfix">
         <div class="th_footer_bright">
          <div class="th_footer_l">
            共有<?php if ($_GET['type'] == 'good'): ?>精品<?php else: ?>主题<?php endif;?>数
           <span class="red"><?php echo ($thread_count); ?></span>个<?php if ($_GET['type'] != 'good'): ?>，贴子数
           <span class="red"><?php echo ($post_count); ?></span>篇，
           <a class="fans_name" href="<?php echo U('Forum/memberList',array('id'=>$forum_info['forum_id']));?>" target="_blank"><?php echo ($member_name); ?></a>数
           <span class="red"><?php echo ($member_count); ?></span>
           <?php endif;?>
          </div>
         </div>
        </div>
        <div style="" id="global_notice_wrap" class="global_notice_wrap"></div>
        <div class="editor_wrap_bright"> 
         <a name="sub"></a>
         <!-- 编辑器 -->
         <div id="tb_rich_poster_container" class="tb_rich_poster_container"> 
          <div id="rich_ueditor_tpl"> 
           <div id="tb_rich_poster" class="tb_rich_poster  "> 
            <div class="j_bubble_container"></div> 
           
            <?php if($poster_type=='addthread'):?>
             <div class="poster_head clearfix"> 
             <div class="poster_head_text"> 
              发表新贴
             </div> 

            </div> 
            <div class="poster_body editor_wrapper">
             <div class="poster_component title_container"> 
              <div class="poster_title">
               标&nbsp;&nbsp;题:
              </div> 
              <div class="j_title_wrap">
               <form id="<?php echo ($poster_type); ?>" method="post">
               <input class="editor_textfield editor_title ui_textfield j_title normal-prefix" name="title" autocomplete="off" placeholder="请填写标题" type="text" /> 
        
               <input type="hidden" id="tocontent" name="content" value=""/>
               <input type="hidden" id="forum_id" name="forum_id" value="<?php echo ($forum_info["forum_id"]); ?>" />
               <input type="hidden" id="forumname" name="forum_name" value="<?php echo ($forum_info["forum_name"]); ?>" />
               </form>
              </div> 
              <div class="poster_error j_error"></div> 
             </div>
             <?php elseif($poster_type=='addpost'):?>
              <div class="poster_head clearfix"> 
             <div class="poster_head_text"> 
              发表回复
             </div> 

            </div> 
            <div class="poster_body editor_wrapper">
              <form id="<?php echo ($poster_type); ?>" method="post">        
               <input type="hidden" id="tocontent" name="content" value=""/>
               <input id="threadid" type="hidden" name="thread_id" value="<?php echo ($thread_id); ?>" />
               <input type="hidden" id="forum_id" name="forum_id" value="<?php echo ($forum_info["forum_id"]); ?>" />
               <input type="hidden" id="replyid" name="replyid" value="0" />
               </form>
             <?php endif;?> 
             <div class="poster_component editor_content_wrapper ueditor_container"> 
              <div class="poster_reply">
               内&nbsp;&nbsp;容:
              </div> 
              <div class="old_style_wrapper"> 
               <div style="width: 690px;" class="edui-container"> 
           <!-- 插入图片移植表单 -->
           <form method="post" enctype="multipart/form-data" target="upframe" id="uploadform">
          <div id="upLoadFile" style="display:none">
          <input type="file" name="img1" id="upimg" accept="image/*" />
          </div>
           </form>
           <iframe id="upframe" name="upframe" style="display:none"></iframe>
           <!-- 插入图片表单结束 -->
                <div class="edui-toolbar"> 
                 <div class="edui-btn-toolbar"> 
                  <div class="edui-btn edui-btn-bold"> 
                  </div> 
                  <div id="up_btn" class="edui-btn edui-btn-image edui-btn-name-list" data-original-title="插入图片"> 
                   <div class="edui-icon-image edui-icon"></div> 
                  </div>     
                  <div id="emo_btn" class="edui-btn edui-btn-emotion edui-btn-name-list edui-last-btn" data-original-title="插入表情"> 
                   <div class="edui-icon-emotion edui-icon"></div> 
                  </div> 
                 </div> 
                  <div class="edui-dialog-container"></div>
                </div> 
                <div class="edui-editor-body"> 
                 <div class="edui-editor-top"></div> 
                 <div class="edui-editor-middle"> 
                  <div id="reply-content"></div>
                  <textarea id="reply-textarea"></textarea>
                  <div class="tb_poster_info poster_success" style="display: none;z-index: 50005;margin:0 auto;width:100px;">
    <div class="poster_success_content ">
        <div class="post_success_tip">发表成功！</div>
        <div class="post_success_exp" style="display: block;">
            <span class="post_success_exp_name">经验</span>
            <b class="post_success_exp_plus">+1</b>
        </div>
    </div>
     </div>
                 </div> 
                 <div class="edui-editor-bottom"></div> 
                 <div class="edui-editor-msg"></div> 
                </div> 
                <div class="edui-attachment-container"></div> 
               </div> 
              </div> 
              <div class="poster_error j_error"></div> 
             </div> 
             <div class="poster_component editor_bottom_panel clearfix"> 
              <div class="j_floating"> 
               <a href="javascript:void(0)" id="poster_btn" class="ui_btn ui_btn_m j_submit poster_submit" title="Ctrl+Enter快捷发表"><span><em>发 表</em></span></a>
               <span class="j_posting_status poster_posting_status"></span>
              </div> 
             </div> 
            </div> 
            <div id="bdInputObjWrapper"></div> 
           </div> 
          </div> 
         </div> 
        </div> 
       </div>
      </div>
     </div>
    </div>
    <div class="footer">
          <p>©2015 Posutoba 版权所有。模板借鉴自百度贴吧。</p>
        </div>
   </div>
  </div>
  <ul class="tbui_aside_float_bar tbui_afb_compact">
   <li class="tbui_aside_fbar_button tbui_fbar_post"><a href="#sub"></a></li>
   <li class="tbui_aside_fbar_button tbui_fbar_refresh"><a href="javascript:void(0)" onclick="window.location.reload()"></a></li>
   <li style="display:none;" class="tbui_aside_fbar_button tbui_fbar_top"><a href="javascript:void(0)" onclick="goTop()"></a></li>
   </ul>
 <script>var PUBLIC="/projects/posutoba/Public";var MODULE="/projects/posutoba";</script>
 <script type="text/javascript" src="/projects/posutoba/Public/common/js/libs.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/common.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.form.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/emotion.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/cale.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.uploadify.min.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.Jcrop.min.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.fancybox.js"></script>
 <!--[if lt IE 10]>
			<script type="text/javascript" src="/projects/posutoba/Public/common/js/placeholder.js"></script>
			<![endif]-->
 <script>
   $(function(){
	   $('.j_ypic').fancybox();
	 });
 </script>
 <?php if($manage_status == 0):?>
 <div class="forumcard_dialog dialogJ visit_card_dlg dialogJshadow ui-draggable" style="z-index: 50003; width: 700px; display:none;">
   <div class="uiDialogWrapper">
    <div class="dialogJtitle" style="cursor: move;">
     <span class="dialogJtxt">设置本吧名片</span>
     <a href="javascript:void(0)" class="dialogJclose" title="关闭本窗口">&nbsp;</a>
    </div>
    <div class="dialogJcontent">
     <div class="dialogJbody" id="dialogJbody">
      <div class="visit_card" id="j_visit_card">
       <div class="rule_intro">
        <span class="tip_title">注意：</span>
        <p>请选择符合本吧讨论内容的图片作为吧头像，具备logo传播价值及易辨认性。</p>
       </div>
       <div class="photo_post">
        <div id="TBNP" style="display: block;">
         <div class="op-pic clearfix">
          <div class="l-pic" id="j_cur_avatar" addr="">
           <h4>当前头像</h4>
           <img style="border:2px solid #ccc" src="<?php echo U('Forum/getAvatar',array('fid'=>$forum_info['forum_id']));?>" />
          </div>
          <div class="r-pic">
           <h4>设置新头像</h4>
            <div class="upload-main">
<!-- 修改头像 -->
<form action="<?php echo U('Forum/setForumCard');?>" method="post" id="forum_card_form" class="update-pic cf">
	<div class="upload-area">
		<input type="file" id="user-pic">
		<div class="file-tips">支持JPG,PNG,GIF，图片小于1MB，尺寸不小于100*100,真实高清头像更受欢迎！</div>
		<div class="preview hidden" id="preview-hidden"></div>
	</div>
	<div class="preview-area">
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />
		<input type="hidden" id='img_src' name='src'/>
		<input type="hidden" id='picName' name='picName'/>
		<input type="hidden" name="forum_id" value="<?php echo ($forum_info["forum_id"]); ?>" />
		<input type="hidden" name="desc" id="desc" />
		
		<a class="uppic-btn reupload-img" href="javascript:void(0)">重新上传</a>
	</div>
</form>
<!-- /修改头像 -->
</div>
          </div>
         </div>
         
        </div>
       
       </div>
       <div class="text_post clearfix">
        <h2>填写吧描述:</h2>
        <div class="clearfix">
         <div id="containerforeditor">
          <div class="lzl_simple_wrapper" style="width: 290px;">
           <div class="tb-editor-editarea-wrapper">
            <div class="ui_textfield j_ba_description tb-editor-editarea" style="height: auto; min-height: 140px; max-height: 150px; display: block;" contenteditable="true"><?php echo ($forum_info["forum_desc"]); ?></div>
           </div>
          </div>
         </div>
         <h3>详细描述</h3>
         <ol>
          <li><span class="ui_text_summary">介绍本吧讨论主题、特色内容、常用信息等;</span></li>
          <li><span class="ui_text_summary"><span class="ui_text_emphasize">不能</span>出现敏感词、不允许使用口号、格言等抽象类描述;</span></li>
          <li><span class="ui_text_summary"><span class="ui_text_emphasize">字数控制在10字以内</span>。</span></li>
         </ol>
         <a href="javascript:void(0)" class="ui_btn ui_btn_m j_post_btn"><span><em>确认提交</em></span></a>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
  <script>
	$(function(){
		//上传头像(uploadify插件)
		$("#user-pic").uploadify({
			'fileObjName':'forum_avatar',
			'queueSizeLimit' : 1,
			'removeTimeout' : 0.5,
			'preventCaching' : true,
			'multi'    : false,
			'swf' 			: '/projects/posutoba/Public/common/images/uploadify.swf',
			'uploader' 		: '<?php echo U("Forum/uploadAvatar");?>',
			'buttonText' 	: '<i class="userup-icon"></i>上传头像',
			'width' 		: '200',
			'height' 		: '200',
			'fileTypeExts'	: '*.jpg; *.png; *.gif;',
			'onUploadSuccess' : function(file, data, response){
				var data = $.parseJSON(data);
				if(data['status'] == 0){
					alertbox('发生错误',data['info']);
					return;
				}

				var preview = $('.upload-area').children('#preview-hidden');
				preview.show().removeClass('hidden');
				//两个预览窗口赋值
				$('.crop').children('img').attr('src',data['url']+'?random='+Math.random());
				//隐藏表单赋值
				$('#img_src').val(data['url']);
				$('#picName').val(data['picName']);			
				//绑定需要裁剪的图片
				var img = $('<img />');
				preview.append(img);
				preview.children('img').attr('src',data['url']+'?random='+Math.random());
				var crop_img = preview.children('img');
				crop_img.attr('id',"cropbox").show();
				var img = new Image();
				img.src = data['url']+'?random='+Math.random();
				//根据图片大小在画布里居中
				img.onload = function(){
					var img_height = 0;
					var img_width = 0;
					var real_height = img.height;
					var real_width = img.width;
					if(real_height > real_width && real_height > 200){
						var persent = real_height / 200;
						real_height = 200;
						real_width = real_width / persent;
					}else if(real_width > real_height && real_width > 200){
						var persent = real_width / 200;
						real_width = 200;
						real_height = real_height / persent;
					}
					if(real_height < 200){
						img_height = (200 - real_height)/2;	
					}
					if(real_width < 200){
						img_width = (200 - real_width)/2;
					}
					preview.css({width:(200-img_width)+'px',height:(200-img_height)+'px'});
					preview.css({paddingTop:img_height+'px',paddingLeft:img_width+'px'});			
				}
				//裁剪插件
				$('#cropbox').Jcrop({
		            bgColor:'#333',   //选区背景色
		            bgFade:true,      //选区背景渐显
		            fadeTime:1000,    //背景渐显时间
		            allowSelect:false, //是否可以选区，
		            allowResize:true, //是否可以调整选区大小
		            aspectRatio: 1,     //约束比例
		            minSize : [100,100],//可选最小大小
		            boxWidth : 200,		//画布宽度
		            boxHeight : 200,	//画布高度
		            onChange: showPreview,//改变时重置预览图
		            onSelect: showPreview,//选择时重置预览图
		            setSelect:[ 0, 0, 100, 100],//初始化时位置
		            onSelect: function (c){	//选择时动态赋值，该值是最终传给程序的参数！
			            $('#x').val(c.x);//需裁剪的左上角X轴坐标
			            $('#y').val(c.y);//需裁剪的左上角Y轴坐标
			            $('#w').val(c.w);//需裁剪的宽度
			            $('#h').val(c.h);//需裁剪的高度
		          }
		        });
				
				//重新上传,清空裁剪参数
				var i = 0;
				$('.reupload-img').click(function(){
					$('#preview-hidden').find('*').remove();
					$('#preview-hidden').hide().addClass('hidden').css({'padding-top':0,'padding-left':0});
				});
		     }
		});
		//提交表单
		$('.j_post_btn').click(function(){
			
				//由于GD库裁剪gif图片很慢，所以长时间显示弹出框
				//createAlertbox('操作成功','图片处理中，请稍候……');
				$('#desc').val($('.j_ba_description').html());
				$('#forum_card_form').submit();
			
		});
		//预览图
		function showPreview(coords){
			var img_width = $('#cropbox').width();
			var img_height = $('#cropbox').height();
			  //根据包裹的容器宽高,设置被除数
			  var rx = 100 / coords.w;
			  var ry = 100 / coords.h; 
			  $('#crop-preview-100').css({
			    width: Math.round(rx * img_width) + 'px',
			    height: Math.round(ry * img_height) + 'px',
			    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			    marginTop: '-' + Math.round(ry * coords.y) + 'px'
			  });
			  rx = 60 / coords.w;
			  ry = 60 / coords.h;
			  $('#crop-preview-60').css({
			    width: Math.round(rx * img_width) + 'px',
			    height: Math.round(ry * img_height) + 'px',
			    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			    marginTop: '-' + Math.round(ry * coords.y) + 'px'
			  });
		}
	})
	
</script>
 <?php endif;?>
   <div class="managergroup_dialog dialogJ dialogJfix dialogJshadow ui-draggable" style="z-index: 50001; width: 550px; display">
   <div class="uiDialogWrapper">
    <div class="dialogJtitle" style="cursor: move;">
     <span class="dialogJtxt">吧务团队</span>
     <a href="javascript:void(0)" class="dialogJclose" title="关闭本窗口">&nbsp;</a>
    </div>
    <div class="dialogJcontent">
     <div class="dialogJbody" id="dialogJbody" style="height: 260px;">
      <table style="line-height:20px;" width="100%" border="0" cellspacing="0" cellpadding="0"> 
   <tbody>
    <tr valign="top">
     <td width="70" align="right">本吧吧主：</td>
     <td style="padding-bottom:20px;">&nbsp; 
    <?php if(is_array($manager_list)): foreach($manager_list as $key=>$vo): ?><a target="_blank" href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>"><?php echo ($vo["user_name"]); ?></a>&nbsp;<?php endforeach; endif; ?></td>
    </tr> 
    <tr valign="top">
     <td width="70" align="right">小吧主：</td>
     <td style="padding-bottom:20px;">&nbsp; 
      <?php if(is_array($small_manager_list)): foreach($small_manager_list as $key=>$vo): ?><a target="_blank" href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>"><?php echo ($vo["user_name"]); ?></a>&nbsp;<?php endforeach; endif; ?>
    </td>
    </tr> 
   </tbody>
  </table>
     </div>
     <div style="position: absolute; left: 0px; top: 0px; cursor: move; display: none; width: 560px; height: 327px;"></div>
    </div>
   </div>
  </div>
 </body>
</html>