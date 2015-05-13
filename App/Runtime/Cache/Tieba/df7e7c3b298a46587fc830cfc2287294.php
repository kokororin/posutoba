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
  <title><?php echo ($class_list["0"]["class_name"]); ?>_Posutoba贴吧</title>
  <link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/theme.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/common.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/forum_class.css" /><link rel="stylesheet" type="text/css" href="/projects/posutoba/Public/common/css/forum_park.css" />

  </head>
 <body>  
   <div style="z-index: 10005;" id="com_userbar" class="userbar "> 
   <ul> 
    <?php if (null == getUid()): ?> 
    <li class="u_login"><a href="javascript:void(0)" onclick="login()">登录</a></li> 
    <li class="u_reg"><a href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Forum/forumPark/pid/9/cid/0')));?>">注册</a></li> 
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
            <p id="TANGRAM__PSP_9__submitWrapper" class="pass-form-item pass-form-item-submit"> <input id="TANGRAM__PSP_9__submit" type="submit" value="登录" class="pass-button pass-button-submit" alog-alias="login" /><br />  <a class="pass-reglink" href="<?php echo U('User/register',array('u'=>base64_encode('/projects/posutoba/Forum/forumPark/pid/9/cid/0')));?>" target="_blank">立即注册</a>
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
  <div id="local_flash_cnt"></div>
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
     <div class="container">
      <div class="content clearfix">
       <div class="left-sec" id="left-sec">
        <div class="f_class_title">
         全部贴吧分类
        </div>
        
        <div class="class_info">
         <h3 class="class_title"><a href="<?php echo U('Forum/forumPark',array('pid'=>$class_list[0]['parent_id'],'cid'=>0));?>" title="<?php echo ($class_list["0"]["class_name"]); ?>" class="<?php echo ($class_list["0"]["class_icon"]); ?>"><?php echo ($class_list["0"]["class_name"]); ?></a></h3>
         <ul class="class_list clearfix" data-cid="<?php echo ($_GET['cid']); ?>">
         <?php if(is_array($class_list)): foreach($class_list as $key=>$vo): if($key>0):?>
          <li data-cid="<?php echo ($vo["class_id"]); ?>" class="<?php if($key==(count($class_list)-1)):?>last_tag<?php endif;?>">
          <a class="" href="<?php echo U('Forum/forumPark',array('pid'=>$vo['parent_id'],'cid'=>$vo['class_id']));?>" title="<?php echo ($vo["class_name"]); ?>"><?php echo ($vo["class_name"]); ?></a></li>
          <?php endif; endforeach; endif; ?>
          </ul>
        </div>
       </div>
       <div class="right-sec">
        <div class="ba_class_title">
         <?php echo ($class_list["0"]["class_name"]); ?>
        </div>
        <!-- 
        <div class="bft_rcmd_forum">
         <span class="bft_rcmd_label" title="精选推荐"></span>
         <ul class="bft_forum_list clearfix">
          <li class="bft_forum_item"><a href="/f?kw=uniq" target="_blank" class="bft_forum"><img class="bft_forum_pic" target="_blank" href="/f?kw=uniq" src="http://imgsrc.baidu.com/forum/pic/item/a50f4bfbfbedab643b6ec1dcf436afc379311e89.jpg" alt="吧头像" />
            <div class="bft_forum_meta">
             <p class="bft_forum_name" title="uniq">uniq</p>
             <p class="bft_forum_p_num" title="28008">28008</p>
             <p class="bft_forum_m_num" title="319310">319310</p>
            </div></a></li>
          <li class="bft_forum_item"><a href="/f?kw=lorde" target="_blank" class="bft_forum"><img class="bft_forum_pic" target="_blank" href="/f?kw=lorde" src="http://imgsrc.baidu.com/forum/pic/item/7aec54e736d12f2ef876a4b24dc2d562843568f4.jpg" alt="吧头像" />
            <div class="bft_forum_meta">
             <p class="bft_forum_name" title="lorde">lorde</p>
             <p class="bft_forum_p_num" title="8755">8755</p>
             <p class="bft_forum_m_num" title="87836">87836</p>
            </div></a></li>
          <li class="bft_forum_item"><a href="/f?kw=exo%D1%B1%C2%B9%B0%C9%CD%EA%BD%E1%CE%C4%BF%E2" target="_blank" class="bft_forum"><img class="bft_forum_pic" target="_blank" href="/f?kw=exo%D1%B1%C2%B9%B0%C9%CD%EA%BD%E1%CE%C4%BF%E2" src="http://imgsrc.baidu.com/forum/pic/item/1e30e924b899a9014b187b841c950a7b0208f556.jpg" alt="吧头像" />
            <div class="bft_forum_meta">
             <p class="bft_forum_name" title="exo驯鹿吧完结文库">exo驯鹿...</p>
             <p class="bft_forum_p_num" title="20416">20416</p>
             <p class="bft_forum_m_num" title="69378">69378</p>
            </div></a></li>
          <li class="bft_forum_item"><a href="/f?kw=%B2%DC%B3%D0%D1%DC" target="_blank" class="bft_forum"><img class="bft_forum_pic" target="_blank" href="/f?kw=%B2%DC%B3%D0%D1%DC" src="http://imgsrc.baidu.com/forum/pic/item/aa18972bd40735fa803f020a9d510fb30e2408b1.jpg" alt="吧头像" />
            <div class="bft_forum_meta">
             <p class="bft_forum_name" title="曹承衍">曹承衍</p>
             <p class="bft_forum_p_num" title="4865">4865</p>
             <p class="bft_forum_m_num" title="32231">32231</p>
            </div></a></li> 
         </ul>
        </div>  -->
       <!-- 
        <div class="square_nav clearfix">
         <a class="renqi" href="#" onclick="return false;">人气最热</a>
         <a class="recent" href="/f/index/forumpark?cn=&amp;ci=0&amp;pcn=%D3%E9%C0%D6%C3%F7%D0%C7&amp;pci=0&amp;ct=1&amp;st=popular">最近流行</a>
        </div>
         -->
        <div class="ba_list clearfix" id="ba_list"> 
         <?php if(is_array($forum_list)): foreach($forum_list as $key=>$vo): ?><div class="ba_info <?php if($key%2!=0):?>ba_info2<?php endif;?>">
          <a target="_blank" href="<?php echo U('Forum/index',array('id'=>$vo['forum_id']));?>" class="ba_href clearfix">
          <img width="105" height="105" class="ba_pic" src="<?php echo U('Forum/getAvatar',array('fid'=>$vo['forum_id']));?>" />
           <div class="ba_content">
            <p class="ba_name"><?php echo ($vo["forum_name"]); ?>吧</p>
            <p class="ba_num clearfix"><span class="ba_m_num"><?php echo ($vo["member_count"]); ?></span><span class="ba_p_num"><?php echo ($vo["post_count"]); ?></span></p>
            <p class="ba_desc"></p>
           </div></a>
          <!-- <div class="ba_post ">
           <a href="/p/3572204722" target="_blank">曾经历过周董统治下的华语乐坛的留下你的年龄！</a>
           <a href="/p/3572194053" target="_blank">小学生不应该成为周杰伦粉丝素质差的理由</a>
           <a href="/p/3572192409" target="_blank">不吹不黑 ，王力宏第一歌神</a>
           <a href="/p/3571859977" target="_blank">音乐皇帝--周杰伦--自己都难以超越的冷门歌--2/...</a>
          </div> --> 
          <div id="like_forum_btn" class="ba_like <?php echo ($vo["concern_btn"]["css"]); ?>" data-fid="<?php echo ($vo["forum_id"]); ?>" title="<?php echo ($vo["concern_btn"]["title"]); ?>"></div> 
          <p class="ba_tag"></p>
         </div><?php endforeach; endif; ?>
          
          
        </div>
        <div class="square_pager">
         <div class="pagination">
          <?php echo ($page); ?>
         </div>
        </div>
       </div>
      </div>
      <div class="bottom-bg"></div>
      <div class="page-footer">
       <div class="footer" alog-alias="footer"> 
        <p>©2015 Posutoba 版权所有。模板借鉴自百度贴吧。</p>
       </div>
      </div>
     </div>
    </div> 
   </div>
  </div>
  <script>var PUBLIC="/projects/posutoba/Public";var MODULE="/projects/posutoba";</script>
  <script type="text/javascript" src="/projects/posutoba/Public/common/js/libs.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/common.js"></script><script type="text/javascript" src="/projects/posutoba/Public/common/js/jquery.form.js"></script>
  <script>
  $(function(){
	   var current_cid=$('.class_list').attr('data-cid');
	   if(current_cid != 0)
		   $('.class_list>li[data-cid="' + current_cid + '"]>a').addClass('cur_class');
	 });
  </script>
  <!--[if lt IE 10]>
			<script type="text/javascript" src="/projects/posutoba/Public/common/js/placeholder.js"></script>
			<![endif]-->
 </body>
</html>