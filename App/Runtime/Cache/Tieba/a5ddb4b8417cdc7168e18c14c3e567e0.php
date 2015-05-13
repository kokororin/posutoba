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
  <title><?php echo ($user_info["user_name"]); ?>的贴吧</title>
   <link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/theme.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/common.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/home_main.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/jquery.fancybox.css" />
 </head>
 <body class="skin_1001">
   <div style="z-index: 10005;" id="com_userbar" class="userbar "> 
   <ul> 
    <?php if (null == getUid()): ?> 
    <li class="u_login"><a href="javascript:void(0)" onclick="login()">登录</a></li> 
    <li class="u_reg"><a href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Home/main/id/16l2bkr')));?>">注册</a></li> 
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
            <p id="TANGRAM__PSP_9__submitWrapper" class="pass-form-item pass-form-item-submit"> <input id="TANGRAM__PSP_9__submit" type="submit" value="登录" class="pass-button pass-button-submit" alog-alias="login" /><br />  <a class="pass-reglink" href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Home/main/id/16l2bkr')));?>" target="_blank">立即注册</a>
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
    <div id="headinfo_wrap" class="headinfo_wrap"> 
    </div>
    <div id="userinfo_wrap" class="userinfo_wrap clearfix">
     <div class="userinfo_left ">
      <div class="userinfo_left_head" id="j_userhead" title="点击查看高清头像">
       <a href="javascript:;" style="" class="userinfo_head"><img src="<?php echo U('Home/getAvatar',array('uid'=>$user_info['user_id']));?>" /></a>
      </div>
     </div>
     <div class="userinfo_middle">
      <div class="userinfo_relation">
       <div class="btn_grounps"> 
        <div class="interaction_wrap interaction_wrap_theme1"> 
         <a id="like_user_btn" class="<?php echo ($concern_btn_css); ?>" href="javascript:void(0)" data-uid="<?php echo ($user_info["user_id"]); ?>"></a> 
         <a class="btn_sendmsg" target="_blank" href="" style="display:none;"></a> 
        </div>
       </div> 
      </div>
      <div class="userinfo_title"> 
       <span class="userinfo_username"><?php echo ($user_info["user_name"]); ?></span>
      </div>
      <div class="userinfo_num">
       <div class="userinfo_userdata">
        <span class="userinfo_sex userinfo_sex_<?php echo ($user_info["user_sex"]); ?>"></span>
        <span>吧龄:<?php echo ($user_info["user_age"]); ?>年</span>
        <span class="userinfo_split"></span>
        <span>发贴:<?php echo ($user_info["post_count"]); ?></span>
       </div>
      </div>
      <div class="userinfo_honor"> 
       <div class="icon_wrap  icon_wrap_theme2  "></div> 
      </div>
     </div>
     <div class="userinfo_right"> 
     </div>
    </div>
    <div id="container" class="container_wrap clearfix ihome_body">
     <div class="left_aside ihome_left_aside">
      <div class="content_wrap"> 
       <div id="ihome_nav_wrap" class="ihome_nav_wrap">
        <ul class="ihome_nav_list"> 
         <li class="focus"> 
          <div class="tbnav_tab_inner"> 
           <p class=""> <a class="nav_icon nav_main" href="<?php echo U('Home/main',array('id'=>$user_info['user_id']));?>"><?php echo ($user_info["user_sex_pron"]); ?>的主页</a></p> 
          </div></li> 
        </ul>
       </div>
       <div class="ihome_forum_group ihome_section clearfix"> 
        <h1 class="ihome_title"><span class="cut_line">|</span>关注的吧</h1>
        <div class="clearfix u-f-wrap" id="forum_group_wrap">
         <?php if(is_array($forum_list)): $i = 0; $__LIST__ = array_slice($forum_list,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a target="_blank" href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" class="u-f-item unsign">
         <span><?php echo ($vo["forum_name"]); ?></span>
         <span class="forum_level lv<?php echo ($vo["level_level"]); ?>"></span></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
       </div> 
       <div class="ihome_section">
        <h1 class="threadList_title"><span class="cut_line">|</span>贴子</h1>
        <ul class="new_list clearfix" pagesize="10"> 
        
        <?php if(is_array($post_list)): foreach($post_list as $key=>$vo): if($vo['floor_id']!=1):?>
         <div class="n_right <?php if($key==0):?>n_right_first<?php endif;?> clearfix">
          <div class="n_post_time">
           <?php echo (convertDate($vo["post_date"],'intel')); ?>
          </div>
          <div class="n_type type_huifu"></div>
          <div class="n_contain">
           <div>
            <div class="thread_name">
             <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>#<?php echo ($vo["post_id"]); ?>" class="reply_content" target="_blank"><?php echo ($vo["post_content_convert"]); ?></a>
            </div>
           </div>
           <div class="n_txt_huifu">
            <div class="n_triangle"></div>
            <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank" class="titletxt" title="回复：<?php echo ($vo["thread_title"]); ?>">回复：<?php echo ($vo["thread_title"]); ?></a>
            <span class="userinfo_split"></span>
            <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank" class="n_name" title="<?php echo ($vo["forum_name"]); ?>"><?php echo ($vo["forum_name"]); ?>吧</a>
           </div>
          </div>
         </div>
         <?php else:?>
         
         <div class="n_right clearfix thread_image">
          <div class="n_post_time">
           <?php echo (convertDate($vo["post_date"],'intel')); ?>
          </div>
          <div class="n_type type_zhuti"></div>
          <div class="n_contain">
           <div>
            <div class="thread_name">
             <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>#<?php echo ($vo["post_id"]); ?>" target="_blank" class="title" title="<?php echo ($vo["thread_title"]); ?>"><?php echo ($vo["thread_title"]); ?></a>
             <span class="userinfo_split"></span>
             <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank" class="n_name" title="<?php echo ($vo["forum_name"]); ?>"><?php echo ($vo["forum_name"]); ?></a>
            </div>
           </div>
           <div class="n_txt">
            <?php echo (mysubstr($vo["thread_content_convert"],0,50)); ?>
           </div>
             <?php echo ($vo["thread_image"]); ?>
         <!-- 大图start -->
         <div class="media_box" style="display:none;">
   <div class="p_tools">
    <a class="p_putup" href="javascript:void(0)" >收起</a>
    <span class="line">|</span>
    <a class="tb_icon_ypic j_ypic" href="#" target="_blank">查看大图</a>
   </div>
   <div class="media_bigpic_wrap">
    <img class="j_large_pic" src="#" style="max-height: 250px;max-width:400px;"/>
   </div>
   <div class="bigpic_display_pre bigpic_turn j_display_pre" style="display: none;"></div>
   <div class="bigpic_display_next bigpic_turn j_display_next" style="display: block;"></div>
  </div>
  <!-- 大图end -->
          </div>
         </div>
         <?php endif; endforeach; endif; ?>
        </ul>
        
       </div>
      </div>
     </div>
     <div class="right_aside">
      <?php if($visitor_list!=null):?>
      <div class="ihome_aside_section ihome_visitor ">
       <h1 class="ihome_aside_title">最近来访</h1>
       <div class="card_wrap">
        <ul id="visitor_card_wrap"> 
        <?php if(is_array($visitor_list)): $i = 0; $__LIST__ = array_slice($visitor_list,0,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="visitor_card">
         <a href="<?php echo U('Home/main',array('id'=>$vo['visitor_id']));?>" target="_blank" class="j_user_card" data-uid="<?php echo ($vo["visitor_id"]); ?>">
         <img src="<?php echo U('Home/getAvatar',array('uid'=>$vo['visitor_id']));?>" alt="头像" /></a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
       </div>
      </div>
      <?php endif;?>
      <?php if(null!=$concern_list):?>
      <div class="ihome_aside_section">
       <h1 class="ihome_aside_title"><?php echo ($user_info["user_sex_pron"]); ?>关注的人<span class="concern_num">(<a href="<?php echo U('Home/concernList',array('id'=>$user_info['user_id']));?>" target="_blank"><?php echo ($user_info["concern_count"]); ?></a>)</span></h1>
       <ul class="concern_wrap"> 
              <?php if(is_array($concern_list)): $i = 0; $__LIST__ = array_slice($concern_list,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="concern_item">
        <a class="j_user_card" data-uid="<?php echo ($vo["user_id"]); ?>" target="_blank" href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>">
        <img src="<?php echo U('Home/getAvatar',array('uid'=>$vo['user_id']));?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
       </ul>
      </div>
      <?php endif;?>
      <?php if(null!=$fans_list):?>
      <div class="ihome_aside_section ">
       <h1 class="ihome_aside_title">关注<?php echo ($user_info["user_sex_pron"]); ?>的人<span class="concern_num">(<a href="<?php echo U('Home/fansList',array('id'=>$user_info['user_id']));?>" target="_blank"><?php echo ($user_info["fans_count"]); ?></a>)</span></h1>
       <ul class="concern_wrap"> 
        <?php if(is_array($fans_list)): $i = 0; $__LIST__ = array_slice($fans_list,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="concern_item">
        <a class="j_user_card" data-uid="<?php echo ($vo["fans_id"]); ?>" target="_blank" href="<?php echo U('Home/main',array('id'=>$vo['fans_id']));?>">
        <img src="<?php echo U('Home/getAvatar',array('uid'=>$vo['fans_id']));?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>        
        </ul>
      </div>
      <?php endif;?>
     </div>
    </div> 
    <div id="footer" class="footer"> 
     <p>©2015 Posutoba 版权所有。模板借鉴自百度贴吧。</p>
    </div> 
   </div>
  </div> 
  <ul class="tbui_aside_float_bar">
   <li style="display:none;" class="tbui_aside_fbar_button tbui_fbar_top">
   <a href="javascript:void(0)" onclick="goTop()"></a></li>
  </ul>
  <script>var PUBLIC="/projects/posutoba/Public";var MODULE="/projects/posutoba";</script>
  <script type="text/javascript" src="/projects/posutoba/Public/common/js/libs.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/common.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.form.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.showmore.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.fancybox.js"></script>
    <script>
    $(function(){
    	$.showMore(".new_list",2);
      });        
    </script>
    <script>
   $(function(){
	   $('.j_ypic').fancybox();
	 });
 </script>
    <!--[if lt IE 10]>
			<script type="text/javascript" src="/projects/posutoba/Public/common/js/placeholder.js"></script>
			<![endif]-->
    <div id="hd_avatar" style="margin-left: -240px; margin-top: -240px; display:none;" class="hd_avatar_480">
   <div class="hd_avatar_in"></div> 
   <img width="480px" height="480px" src="<?php echo U('Home/getAvatar',array('uid'=>$user_info['user_id']));?>" style="margin-left: -240px; margin-top: -240px;" class="hd_avatar_img" id="hd_avatar_img" /> 
   <a class="hd_avatar_close j_hd_avatar_close" href="javascript:void(0)"></a>
  </div>
 </body>
</html>