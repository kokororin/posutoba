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
  <title><?php echo ($thread_title); ?>_<?php echo ($forum_info["forum_name"]); ?>吧_Posutoba贴吧</title>
<link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/theme.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/common.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/post.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/emotion.css" />
 </head>
 <body spellcheck="false" class="skin_normal">
   <div style="z-index: 10005;" id="com_userbar" class="userbar "> 
   <ul> 
    <?php if (null == getUid()): ?> 
    <li class="u_login"><a href="javascript:void(0)" onclick="login()">登录</a></li> 
    <li class="u_reg"><a href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Post/index/id/414dw1v')));?>">注册</a></li> 
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
            <p id="TANGRAM__PSP_9__submitWrapper" class="pass-form-item pass-form-item-submit"> <input id="TANGRAM__PSP_9__submit" type="submit" value="登录" class="pass-button pass-button-submit" alog-alias="login" /><br />  <a class="pass-reglink" href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Post/index/id/414dw1v')));?>" target="_blank">立即注册</a>
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

    <div id="container" class="l_container  ">
     <div class="content clearfix">
      <div class="card_top_wrap clearfix card_top_theme2 ">
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
       </div>
      </div>
      <div class="nav_wrap nav_wrap_add_border" id="tb_nav">
       <ul class="nav_list j_nav_list"> 
        <li class=" j_tbnav_tab "> 
         <div class="tbnav_tab_inner"> 
          <p class="space"> <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>" class="nav_icon icon_tie  j_tbnav_tab_a" id="tab_forumname" stats-data="fr=tb0_forum&amp;amp;st_mod=frs&amp;amp;st_value=tabmain">看贴</a> </p> 
         </div> </li> 
        <li class="none_right_border j_tbnav_tab"> 
         <div class="tbnav_tab_inner"> 
          <p class="space"> <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id'],'type'=>'good'));?>" class="nav_icon icon_jingpin  j_tbnav_tab_a" stats-data="fr=tb0_forum&amp;amp;st_mod=frs&amp;amp;st_value=tabgood">精品</a> </p> 
         </div> </li> 
       </ul>
       <ul style="width:auto;" class="ul_often_forum">
        <li class="li_often_forum first"><a id="often_forum" href="javascript:" data-extend="focus">我爱逛的贴吧<i></i></a></li>
       </ul>
      </div>
      <div class="p_thread thread_theme_5" id="thread_theme_5">
       <div class="l_thread_info">
        <ul class="l_posts_num"> 
         <li class="l_pager pager_theme_4 pb_list_pager">         
         <?php echo ($page); ?>
         </li> 
         <li class="l_reply_num" style="margin-left:8px">
         <span class="red" style="margin-right:3px"><?php echo ($reply_count); ?></span>回复贴，共<span class="red"><?php echo ($total_page); ?></span>页
         </li> 
         <?php if($total_page!=1):?>
         <li class="l_reply_num">，跳到 <input id="jumpPage4" class="jump_input_bright" type="text" /> 页&nbsp;<button id="pager_go4" type="button" value="确定" class="jump_btn_bright">确定</button>&nbsp;</li> 
        <?php endif;?>
        </ul> 
        <div id="tofrs_up" class="tofrs_up">
         <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>" title="<?php echo ($forum_info["forum_name"]); ?>">&lt;返回<?php echo ($forum_info["forum_name"]); ?>吧</a>
        </div>
       </div>
      </div>
      <div class="pb_content clearfix" id="pb_content">
       <div class="left_section">
        <div class="core_title_wrap core_title_wrap_bright" id="j_core_title_wrap">
         <div class="core_title core_title_theme_bright"> 
          <h1 class="core_title_txt  " title="<?php echo ($thread_title); ?>" style="width: 480px"><?php echo ($thread_title); ?></h1>
          <ul class="core_title_btns">
          <?php if($manage_status == 0):?>
          <li><a id="thread_manage_btn" href="javascript:void(0)" class="l_lzonly"><span id="lzonly" class="d_lzonly_bdaside">帖子管理</span></a></li>
           <?php endif;?>
           <?php if($_GET['see_lz']!=1):?>
           <li><a id="lzonly_cntn" href="<?php echo U('Post/index',array('id'=>$thread_id,'see_lz'=>1));?>" class="l_lzonly"><span id="lzonly" class="d_lzonly_bdaside">只看楼主</span></a></li>
           <?php else:?>
           <li><a id="lzonly_cntn" href="<?php echo U('Post/index',array('id'=>$thread_id));?>" class="l_lzonly_cancel"><span id="lzonly" class="d_lzonly_bdaside">取消只看楼主</span></a></li>
           <?php endif;?>
           <li id="j_favthread" class="p_favthread">
            <div class="p_favthr_tip"></div>
            <div class="p_favthr_main" id="store_thread_btn" data-tid="<?php echo ($thread_id); ?>">
             <p><?php echo ($store_status); ?></p>
            </div>
            <div class="p_favthr_listshadow">
             &nbsp;
            </div></li> 
           <li class="quick_reply"><a href="#sub" id="quick_reply" class="j_quick_reply">回复</a></li> 
           
          </ul>
         </div> 
        </div>
        <div class="p_postlist" id="j_p_postlist"> 
        <!-- 帖子开始 -->
        <?php if(is_array($post_list)): foreach($post_list as $key=>$vo): ?><a name="<?php echo ($vo["post_id"]); ?>"></a>
         <div class="l_post l_post_bright noborder"> 
          <div class="user-hide-post-position"></div>
          <div class="d_author">
          <?php if($thread_uid==$vo['user_id']):?>
           <div class="louzhubiaoshi_wrap"> 
            <div class="louzhubiaoshi j_louzhubiaoshi"> 
             <a title="点击即可只看楼主哟～" href="<?php echo U('Post/index',array('id'=>$thread_id,'see_lz'=>1));?>"></a> 
            </div> 
           </div> 
           <?php endif;?>
           <ul class="p_author"> 
            <li class="icon"> 
             <div class="icon_relative j_user_card" data-uid="<?php echo ($vo["user_id"]); ?>"> 
              <a style="" target="_blank" class="p_author_face " href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>">
              <img src="<?php echo U('Home/getAvatar',array('uid'=>$vo['user_id']));?>" /></a> 
              
             </div> </li> 
            <li class="d_nameplate"> </li> 
            <li class="d_name"> <a title="" class="p_author_name j_user_card" href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>" data-uid="<?php echo ($vo["user_id"]); ?>" target="_blank"><?php echo ($vo["user_name"]); ?></a> </li> 
            
            <li class="l_badge" style="display:block;"> 
             <div class="p_badge"> 
              <a href="<?php echo U('Forum/levelDetail',array('id'=>$forum_info['forum_id']));?>" target="_blank" class="user_badge d_badge_bright d_badge_icon<?php echo ($vo["level_css"]); ?>" title="本吧头衔<?php echo ($vo["level_level"]); ?>级，经验值<?php echo ($vo["level_exp"]); ?>，点击进入等级头衔说明页">
               <div class="d_badge_title ">
                <?php echo ($vo["member_title"]); ?>
               </div>
               <div class="d_badge_lv">
                <?php echo ($vo["level_level"]); ?>
               </div></a> 
             </div> </li> 
           </ul>
          </div>
          <div class="d_post_content_main d_post_content_firstfloor"> 
           <div class="p_content p_content_icon_row1 p_content_nameplate">
           <?php echo ($vo["reply_content"]); ?>
            <div class="save_face_bg_hidden save_face_bg_0">
             <a class="save_face_card"></a> 
            </div> 
            <div style="word-wrap:break-word;width:100%;"> 
             <div id="voteFlashPanel"></div> 
            </div> 
            <div id="my_friends_vote_detail" style="display:none;"></div>
            <cc>
             <div id="post_content_<?php echo ($vo["post_id"]); ?>" class="d_post_content j_d_post_content ">                              
               <?php echo ($vo["post_content_convert"]); ?>
             </div>
             <br />
            </cc>
            <br />
            <div class="user-hide-post-down" style="display: none;"></div> 
           </div> 
           <div class="core_reply j_lzl_wrapper">
            <div class="core_reply_tail ">
             <ul class="p_reply">
              <li><a href="javascript:void(0)" onclick="replyFloor('<?php echo ($vo["post_id"]); ?>',<?php echo ($vo["floor_id"]); ?>)" class="p_reply_first">回复</a></li>
             </ul>
             <ul class="p_tail">
              <li><a title="右键复制链接地址，可供访问者直达此楼" href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>#<?php echo ($vo["post_id"]); ?>"><?php echo ($vo["floor_id"]); ?>楼</a></li>
              <li><span><?php echo (convertDate($vo["post_date"],'without_second')); ?></span></li>
             </ul>
             <?php if($manage_status == 0 || $manage_status == 1):?>
             <ul class="p_mtail" data-pid="<?php echo ($vo["post_id"]); ?>" data-fid="<?php echo ($forum_info["forum_id"]); ?>" data-uid="<?php echo ($vo["user_id"]); ?>" data-uname="<?php echo ($vo["user_name"]); ?>">
             <li class="j_jb_ele"><a class="jb_in p_post_del_my post_del_href" href="javascript:void(0)">删除</a>&nbsp;|</li>
             <li><a href="javascript:void(0)" class="p_post_ban">封</a>&nbsp;|</li>
             </ul>
             <?php endif;?>
             <ul class="p_props_tail props_appraise_wrap"></ul>
            </div>
            
           </div> 
          </div>
          <div class="clear"></div>
         </div><?php endforeach; endif; ?>  
         
         <!-- 帖子结束 -->
        </div>
       </div>
       
      <!-- <div class="right_section right_bright"> 
        <?php if(null==getUid()):?>
        
  <div id="login_wrapper" class="login_wrapper login_wrapper_rightmiddle login_wrapper_beforeshow">
   <div class="login_tip_wrapper j_login_tip_wrapper"></div>
   <div id="pass_loginLite_poptip0" class="login_poptip"></div>
   <div class="login_title">
    <span>登录百度帐号</span>
   </div>
   <div class="login_form tang-pass-login" id="TANGRAM__PSP_5__">
    <form id="TANGRAM__PSP_5__form" class="pass-form pass-form-normal" method="POST" autocomplete="off" action="<?php echo U('User/login');?>">
     <p id="TANGRAM__PSP_5__errorWrapper" class="pass-generalErrorWrapper"><span id="TANGRAM__PSP_5__error" class="pass-generalError pass-generalError-error"></span></p>
     <p id="TANGRAM__PSP_5__userNameWrapper" class="pass-form-item pass-form-item-userName" style="display:"><label for="TANGRAM__PSP_5__userName" id="TANGRAM__PSP_5__userNameLabel" class="pass-label pass-label-userName">用户名</label><input id="TANGRAM__PSP_5__userName" type="text" name="username" class="pass-text-input pass-text-input-userName" autocomplete="off" placeholder="手机/邮箱/用户名" /><span id="TANGRAM__PSP_5__userName_clearbtn" class="pass-clearbtn pass-clearbtn-userName" style="display:none;"></span><span id="TANGRAM__PSP_5__userNameTip" class="pass-item-tip pass-item-tip-userName" style="display:none"><span id="TANGRAM__PSP_5__userNameTipText" class="pass-item-tiptext pass-item-tiptext-userName"></span></span></p>
     <p id="TANGRAM__PSP_5__passwordWrapper" class="pass-form-item pass-form-item-password" style="display:"><label for="TANGRAM__PSP_5__password" id="TANGRAM__PSP_5__passwordLabel" class="pass-label pass-label-password">密码</label><input id="TANGRAM__PSP_5__password" type="password" name="password" class="pass-text-input pass-text-input-password" placeholder="密码" /><span id="TANGRAM__PSP_5__password_clearbtn" class="pass-clearbtn pass-clearbtn-password" style="display:none;"></span><span id="TANGRAM__PSP_5__passwordTip" class="pass-item-tip pass-item-tip-password" style="display:none"><span id="TANGRAM__PSP_5__passwordTipText" class="pass-item-tiptext pass-item-tiptext-password"></span></span></p>
     <p id="TANGRAM__PSP_5__memberPassWrapper" class="pass-form-item pass-form-item-memberPass"><input id="TANGRAM__PSP_5__memberPass" type="checkbox" name="memberPass" class="pass-checkbox-input pass-checkbox-memberPass" checked="checked" /><label for="TANGRAM__PSP_5__memberPass" id="TANGRAM__PSP_5__memberPassLabel" class="">下次自动登录</label></p>
     <p id="TANGRAM__PSP_5__submitWrapper" class="pass-form-item pass-form-item-submit"><input id="TANGRAM__PSP_5__submit" type="submit" value="登录" class="pass-button pass-button-submit" /><a class="pass-reglink" href="<?php echo U('User/register?u='.base64_encode('/projects/posutoba/Post/index/id/414dw1v'));?>" target="_blank">立即注册</a><a class="pass-fgtpwd" href="https://passport.baidu.com/?getpassindex&amp;tpl=tb&amp;u=http%3A%2F%2Ftieba.baidu.com%2Fp%2F3500183532" target="_blank">忘记密码？</a></p>
    </form>
   </div>
   <div id="TANGRAM__PSP_5__pass_b2c" style="display:none;"></div>
  </div>

        <?php else:?>
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
        
        
       </div> --> 
      </div>
      <div class="pb_footer">
       <div class="p_thread thread_theme_7" id="thread_theme_7">
       
        <div class="l_thread_info">
         <ul class="l_posts_num"> 
          <li class="l_pager pager_theme_5 pb_list_pager">
          <?php echo ($page); ?>
          </li> 
          <li class="l_reply_num" style="margin-left:8px"><span class="red" style="margin-right:3px"><?php echo ($reply_count); ?></span>回复贴，共<span class="red"><?php echo ($total_page); ?></span>页</li> 
          <?php if($total_page!=1):?>
          <li class="l_reply_num">，跳到 <input id="jumpPage6" class="jump_input_bright" type="text" /> 页&nbsp;<button id="pager_go6" type="button" value="确定" class="jump_btn_bright">确定</button>&nbsp;</li> 
         <?php endif;?>
         </ul> 
        </div>
        <div id="tofrs_up" class="tofrs_up">
         <a href="<?php echo U('Forum/index',array('id'=>$forum_info['forum_id']));?>" title="<?php echo ($forum_info["forum_name"]); ?>">&lt;返回<?php echo ($forum_info["forum_name"]); ?>吧</a>
        </div>
       </div>
       <div style="display: inline;float: right;margin-right: 20px;margin-top: 5px;"></div>
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
     <div class="footer"> 
        <p>©2015 Posutoba 版权所有。模板借鉴自百度贴吧。</p>
       </div>
   </div>
  </div> 
 

  <div class="editor_for_container editor_lzl_container" id="j_editor_for_container"></div> 
  <p class="lzl_panel_error" style="display: none;"></p> 
  <table class="lzl_panel_wrapper"> 
   <tbody> 
    <tr> 
     <td style="width: 75%;"><p style="color:#666;"></p></td>
     <td style="width: 25%; position:relative">
    </td>
    </tr>
   </tbody>
  </table>
<ul class="tbui_aside_float_bar tbui_afb_compact"> 
   <li class="tbui_aside_fbar_button tbui_fbar_post"><a href="#sub"></a></li> 
   <li class="tbui_aside_fbar_button tbui_fbar_refresh"><a href="javascript:void(0)" onclick="window.location.reload()"></a></li> 
   <li style="display:none;" class="tbui_aside_fbar_button tbui_fbar_top"><a href="javascript:void(0)" onclick="goTop()"></a></li> 
   </ul>
   <script>var PUBLIC="/projects/posutoba/Public";var MODULE="/projects/posutoba";</script>
   <script type="text/javascript" src="/projects/posutoba/Public/common/js/libs.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/common.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.form.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/emotion.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/cale.js"></script>
   <!--[if lt IE 10]>
			<script type="text/javascript" src="/projects/posutoba/Public/common/js/placeholder.js"></script>
			<![endif]-->
   <?php if($manage_status == 0 || $manage_status == 1):?>
     <div class="delete_dialog dialogJ dialogJfix dialogJshadow" style="z-index: 50003; width: 300px; left: 520px; top: 126.5px;display:none;"> 
   <div class="uiDialogWrapper">
    <div class="dialogJcontent">
     <div id="dialogJbody" class="dialogJbody">
      <div style="margin:15px auto 0;text-align:center;">
       确认删除?
       <div></div>
      </div>
     </div>
    </div>
    <div class="dialogJanswers">
     <input type="button" value="确定" class="dialogJbtn" id="submit_del_post" /> 
     <input type="button" value="取消" class="dialogJbtn j_btn no_post" />
    </div>
   </div>
  </div>
   <?php if($manage_status == 0):?>
     <div class="block_dialog dialogJ dialogJfix dialogJshadow ui-draggable" style="z-index: 50001; width: 556px; display:none;">
   <div class="uiDialogWrapper">
    <div class="dialogJtitle" style="cursor: move;">
     <span class="dialogJtxt">封禁操作</span>
     <a title="关闭本窗口" class="dialogJclose" href="javascript:void(0)">&nbsp;</a>
    </div>
    <div class="dialogJcontent">
     <div id="dialogJbody" class="dialogJbody">
      <div class="block_user_wrapper"> 
       <ul class="b_u_items"> 
        <li class="b_u_items_outer"> <label>用户名</label>
         <div class="b_username">
          XX
         </div> </li> 
        <li class="b_u_items_outer"> <label>封禁时长:</label> 
         <div class="b_block_time"> 
          <select class="b_select_time" style="display: block;"> 
          <option data-day="1">1天</option> 
          <option data-day="3">3天</option>
          <option data-day="10">10天</option> 
          </select> 
         </div> </li>         
       </ul> 
       <div class="block_btns"> 
        <div class="b_id_btn" id="submit_block_user">
         封禁ID
        </div> 
       </div> 
      </div>
     </div>
    </div>
   </div>
  </div>

     <div class="manage_dialog dialogJ dialogJfix dialogJshadow ui-draggable" style="z-index: 50001; width: 556px; display:none;">
   <div class="uiDialogWrapper">
    <div class="dialogJtitle" style="cursor: move;">
     <span class="dialogJtxt">帖子管理</span>
     <a title="关闭本窗口" class="dialogJclose" href="javascript:void(0)">&nbsp;</a>
    </div>
    <div class="dialogJcontent">
     <div id="dialogJbody" class="dialogJbody">
      <div class="block_user_wrapper"> 
       <ul class="b_u_items"> 
        <li class="b_u_items_outer"> <label>帖子标题</label>
         <div class="b_username">
          <?php echo ($thread_title); ?>
         </div> </li> 
        <li class="b_u_items_outer"> <label>操作内容:</label> 
         <div class="b_block_time"> 
          <select class="b_select_time" style="display: block;" data-tid="<?php echo ($vo["thread_id"]); ?>"> 
          <option data-action="set-good">设为精华贴</option> 
          <option data-action="cancel-good">取消精华贴</option>
          <option data-action="set-top">置顶主题</option> 
          <option data-action="cancel-top">取消置顶</option>           
          </select> 
         </div> </li> 
       </ul> 
       <div class="block_btns"> 
        <div class="b_id_btn" id="manage_submit">
         确认
        </div> 
       </div> 
      </div>
     </div>
    </div>
   </div>
  </div>

   <?php endif;?>
   <?php endif;?>

 </body>
</html>