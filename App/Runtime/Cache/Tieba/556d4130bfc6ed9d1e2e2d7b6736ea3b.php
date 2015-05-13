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
  <title>Posutoba贴吧</title>
  <link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/theme.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/common.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/index.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/jquery.fancybox.css" /> 
 </head>
 <body class="skin_0">
   <div style="z-index: 10005;" id="com_userbar" class="userbar "> 
   <ul> 
    <?php if (null == getUid()): ?> 
    <li class="u_login"><a href="javascript:void(0)" onclick="login()">登录</a></li> 
    <li class="u_reg"><a href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/')));?>">注册</a></li> 
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
            <p id="TANGRAM__PSP_9__submitWrapper" class="pass-form-item pass-form-item-submit"> <input id="TANGRAM__PSP_9__submit" type="submit" value="登录" class="pass-button pass-button-submit" alog-alias="login" /><br />  <a class="pass-reglink" href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/')));?>" target="_blank">立即注册</a>
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
    <div class="page-container">
     <div class="search-sec">
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
     <div class="main-sec clearfix">
    <div class="top-sec clearfix">
   <div id="rec_left" class="rec_left"> 
    <div class="carousel_wrap tbui_slideshow_container" id="carousel_wrap" style="width: 690px; height: 180px;"> 
     <ul class="img_list tbui_slideshow_list slides" style="width: 690px; height: 180px; left: 0px;"> 
      <!-- 列表1 -->
      <li class="img_list_3pic tbui_slideshow_slide"> 
      <?php if(is_array($slide_list)): $i = 0; $__LIST__ = array_slice($slide_list,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank" class="img_box carousel_pic_wrap"> 
        <div class="carousel_large_pic"> 
         <img height="180" width="225" src="<?php echo ($vo["thread_image"]); ?>" /> 
         <div class="img_bg"></div> 
         <div class="img_txt"> 
          <p class="img_title"><?php echo (mysubstr($vo["thread_title"],0,12)); ?></p> 
         </div> 
        </div> </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </li> 
        <!-- 列表2 -->
      <li class="img_list_3pic tbui_slideshow_slide"> 
      <?php if(is_array($slide_list)): $i = 0; $__LIST__ = array_slice($slide_list,3,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank" class="img_box carousel_pic_wrap"> 
        <div class="carousel_large_pic"> 
         <img height="180" width="225" src="<?php echo ($vo["thread_image"]); ?>" /> 
         <div class="img_bg"></div> 
         <div class="img_txt"> 
          <p class="img_title"><?php echo (mysubstr($vo["thread_title"],0,12)); ?></p> 
         </div> 
        </div> </a><?php endforeach; endif; else: echo "" ;endif; ?>           
        </li> 
      <li class="img_list_1pic tbui_slideshow_slide"> 
      <a class="img690" target="_blank" href="/projects/posutoba"> <img height="180" width="690" src="/projects/posutoba/Public/common/images/xinciyuan0129.jpg" /> </a> </li> 
     </ul> 
    </div> 
    <div class="top_progress_bar"> 
    </div> 
   </div> 

   <div class="rec_right rec_login" id="rec_right">
    <div id="in_forum_num" class="num_list num_list02">
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["a"]); ?>"></i></span>
     <span class="num_break"><i class="num_space"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["b"]); ?>"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["c"]); ?>"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["d"]); ?>"></i></span>
     <span class="num_break"><i class="num_space"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["e"]); ?>"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["f"]); ?>"></i></span>
     <span class="num_span"><i class="num_icon" style="<?php echo ($interest_num["g"]); ?>"></i></span>
    </div>
    <?php if(getUid()==null):?>
    <a href="javascript:void(0)" class="btn_login" onclick="login()"></a>
    <?php endif;?>
   </div>
  </div>
      <div class="content-sec clearfix">
       <div class="left-sec"> 
       <?php if(getUid()!=null):?>
        <div id="my_tieba_mod" class="region_bright my_tieba_mod  balv_mod_index">
         <div class="region_header">
          <div class="region_op j_op"> 
          </div>
          <div class="region_title region_icon j_title">
           我在贴吧
          </div>
         </div>
         <div class="region_cnt"> 
          <div class="user_profile clearfix " id="user_info">
           <div class="profile_left user_head">
            <a style="" href="<?php echo U('Home/main',array('id'=>getUid()));?>" target="_blank"><img class="head_img" src="<?php echo U('Home/getAvatar',array('uid'=>getUid()));?>" /></a>
           </div>
             
           <div class="profile_right user_name"> 
            <a href="<?php echo U('Home/main',array('id'=>getUid()));?>" target="_blank"><?php echo getUsername()?></a>
           </div>
           
          </div> 
         </div>
         <div class="region_footer"></div>
        </div>
        <?php endif;?>
        <div class="left-cont-wraper" id="left-cont-wraper">
         <?php if(getUid()!=null):?>
         <?php if($forum_list!=null):?>
         <div class="u-f-t">
          <div class="title">
           常逛的吧
          </div>
          <div class="edit color2" id="addforum" style="display:none;"></div>
         </div>
         <div class="u-f-w">
          <div class="clearfix" id="likeforumwraper">
          <?php if(is_array($forum_list)): $i = 0; $__LIST__ = array_slice($forum_list,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a target="_blank" href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" class="u-f-item <?php echo ($vo["sign_status"]); ?>"><?php echo ($vo["forum_name"]); ?><span class="forum_level lv<?php echo ($vo["level_level"]); ?>"></span></a><?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
          <div class="more-wraper" id="moreforum" style="display:block">
           <a href="<?php echo U('Home/forumList',array('id'=>getUid()));?>" class="more"><span class="more-txt">查看更多</span><span class="more-triangle"></span></a>
          </div>
         </div>
         <?php endif;?>
         <?php endif;?>
        
         <div class="u-f-t ufw-gap">
          <div class="title">
           贴吧分类
          </div>
          <div class="gap" style="width:125px"></div>
         </div>
         <div class="f-d-w" id="f-d-w">
          
          <?php for($i=0;$i<13;$i++):?>
          <div class="f-d-item <?php if($i==0):?>first-border-top<?php endif;?>" data-pid="<?php echo ($class_list[$i][0]['parent_id']); ?>">
           <div class="f-d-item-content">
            <div class="title">
             <span class="typeicon <?php echo ($class_list[$i][0]['class_icon']); ?>"></span>
             <a title="<?php echo ($class_list[$i][0]['class_name']); ?>" target="_blank" href="<?php echo U('Forum/forumPark',array('pid'=>$class_list[$i][0]['parent_id'],'cid'=>0));?>"><?php echo ($class_list[$i][0]['class_name']); ?></a>
            </div>
            <div class="directory-wraper">
            <?php if(is_array($class_list[$i])): foreach($class_list[$i] as $key=>$vo): if($key>0):?>            
             <a title="<?php echo ($vo["class_name"]); ?>" target="_blank" href="<?php echo U('Forum/forumPark',array('pid'=>$class_list[$i][0]['parent_id'],'cid'=>$vo['class_id']));?>"><?php echo ($vo["class_name"]); ?></a>
             <?php endif; endforeach; endif; ?>
            </div>
           </div>
          </div>
          
          <?php endfor;?>
          
          <div class="all-wraper">
           <a target="_blank" href="<?php echo U('Forum/forumClass');?>" class="all"><span class="more-txt">查看全部</span></a>
          </div>
          
     <div style="position:relative ; z-index: 1000; width: 666px; height: auto; display: none;" class="d-up-frame">
   <div class="pop-up-container">
    <div class="directory-pop-frame">
     <div class="d-title">
      <!-- 这里放标题 -->
     </div>
     <div class="item-wraper">      
     <!-- 这里用来放目录 -->    
     </div>
     <div class="rec-forum">
      <div class="rec-icon">
       推荐吧
      </div>
      <div class="rec-forum-cont">
      <!-- 这里用来放贴吧 -->
      </div>
     </div>
    </div>
   </div>
  </div>
         </div>
        </div>
       </div>
       <div class="right-sec clearfix">
       
        <div class="r-left-sec">   
         
         <div class="sub_nav_wrap clearfix" id="sub_nav_wrap" alog-alias="sub_nav_wrap" alog-group="sub_nav_wrap">
          <ul class="sub_nav_list">
           <li style="margin-left:8px"><a href="javascript:void(0)" id="j_remen_nav" class="nav_li nav_li_all cur">热门动态</a></li>         
          </ul> 
        
         </div>
         
         <div id="like-tag-nav">
          <span></span>
          <a href="#" class=""></a>
         </div>
         <div id="info-section"></div>
         <ul class="new_list" pagesize="10">
          <?php if(is_array($thread_list)): foreach($thread_list as $key=>$vo): ?><li class="clearfix j_feed_li thread_image">
           <div class="n_right">
            <div>
             <div class="title-tag-wraper">
              <div class="tag tag-style<?php echo ($vo["style_id"]); ?>" title="点击查看与<?php echo ($vo["forum_class"]["class_name"]); ?>相关贴子">
               <a href="<?php echo U('Forum/forumPark',array('pid'=>$vo['forum_class']['parent_id'],'cid'=>$vo['forum_class']['class_id']));?>" class="tag-name"><?php echo ($vo["forum_class"]["class_name"]); ?></a>
               <a href="javascript:void(0)" class="triangle"></a>
              </div>
              <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank" class="n_name" title="<?php echo ($vo["forum_name"]); ?>"><?php echo ($vo["forum_name"]); ?>吧</a>
             </div>
             <div class="thread-name-wraper">
              <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank" class="title" title="<?php echo ($vo["thread_title"]); ?>"><?php echo ($vo["thread_title"]); ?></a>
              <span class="list-post-num"><em><?php echo ($vo["reply_count"]); ?></em><span class="list-triangle-border"></span><span class="list-triangle-body"></span></span>
             </div>
            </div>
            <div class="n_txt">
             <?php echo (mysubstr($vo["post_content_convert"],0,80)); ?>
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
             
            <div class="n_reply">
             <a href="<?php echo U('Home/main',array('id'=>$vo['user_id']));?>" title="主题作者" target="_blank" class="post_author"><?php echo ($vo["user_name"]); ?></a>
             <span class="time"><?php echo (convertDate($vo["last_date"],'intel')); ?></span>
            </div>
           </div>
           </li><?php endforeach; endif; ?>
   
         </ul>
        

        </div>
        <div class="r-right-sec">
         <div class="right_wrap" id="right_wrap">
          <div class="item jingxuan">
           <div class="item_hd">
            <span class="title">贴吧精选</span>
           </div>
          </a>
           <?php if(is_array($hot_thread_list)): foreach($hot_thread_list as $key=>$vo): ?><ul class="notice_list"> 
            <li> <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank"><?php echo ($vo["thread_title"]); ?></a> </li> 
           </ul><?php endforeach; endif; ?>        
          </div>
          <div> 
           
          </div> 
          
          <div alog-alias="notice_item" id="notice_item" class="item notice_item"> 
           <div class="item_hd"> 
            <span class="title">公告板</span> 
           </div>           
           <ul class="notice_list"> 
           <?php if(is_array($notice_list)): foreach($notice_list as $key=>$vo): ?><li> <a href="<?php echo U('Post/index',array('id'=>$vo['thread_id']));?>" target="_blank"><?php echo ($vo["thread_title"]); ?></a> </li><?php endforeach; endif; ?>
           </ul> 
          </div> 
          <div class="item platform_item">
          <div class="item_hd">
           <span class="title">贴吧推荐</span>
          </div>
          <ul class="platform_item_list"> 
            <?php if(is_array($hot_forum_list)): foreach($hot_forum_list as $key=>$vo): ?><li class="platform_item_item">
           <a class="pii_img_w" href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" target="_blank"> 
           <img src="<?php echo U('Forum/getAvatar',array('fid'=>$vo['forum_id']));?>" title="" alt="" />
             <!-- <div class="pii_bluev pii_bg"></div> --></a>
            <div class="pii_right">
             <a href="javascript:void(0)" class="pii_fbtn pii_bg <?php echo ($vo["concern_btn_css"]); ?>" data-pid="<?php echo ($vo["forum_id"]); ?>" id="like_forum_btn"></a>
             <a href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" title="<?php echo ($vo["forum_name"]); ?>吧" class="h6" target="_blank"><?php echo ($vo["forum_name"]); ?>吧</a>
             <p><?php echo ($vo["forum_desc"]); ?></p>
            </div></li><?php endforeach; endif; ?>
          </ul>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class="bottom-bg"></div>
    </div>
   </div>
   <div class="footer"> 
     <p>©2015 Posutoba 版权所有。模板借鉴自百度贴吧。</p>
   </div> 
  </div> 
  </div>
 <script>var PUBLIC="/projects/posutoba/Public";var MODULE="/projects/posutoba";</script>
 <script type="text/javascript" src="/projects/posutoba/Public/common/js/libs.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/common.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.form.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.showmore.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.flexslider.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.fancybox.js"></script>
 <script>
 $(function(){
	    $('.tbui_slideshow_container').flexslider({
	    	controlsContainer: '.top_progress_bar',
		    });
	 }); 
  </script>
 <script>
  $(function(){
		var offset = 1500;	
		$(window).scroll(function(){
			if( $(this).scrollTop() > offset ) {
				$('#left-cont-wraper').addClass('left-cont-fixed');
				$('#right_wrap').addClass('right-wrap-fixed');
			}
			else{
				$('#left-cont-wraper').removeClass('left-cont-fixed');
				$('#right_wrap').removeClass('right-wrap-fixed');
			}			
		});	
	});
  </script>
   <script>
   $(function(){
	   $.showMore(".new_list",1);
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
</body>
</html>