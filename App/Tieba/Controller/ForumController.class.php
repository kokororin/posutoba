<?php
/**
 *
 *
 * @name 贴吧页控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class ForumController extends BaseController
{
    /**
     * @access public
     * 初始化父类
     * @see \Tieba\Controller\BaseController::_initialize()
     */
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 主页面
     * @access public
     * @param string $id 用户id
     */
    public function index($id, $type = 'all')
    {
        $forum_info = $this->getForumInfo($id);
        if ($forum_info == null) {
            $this->error('贴吧不存在！');
        }
        $thread_list_array = $this->getThreadList($id, $type);
        $thread_list       = $thread_list_array[0];
        $page              = $thread_list_array[1];
        $thread_count      = $thread_list_array[2];
        $this->getPublic($forum_info['forum_id']);
        $forum_class        = $this->getForumClass($id);
        $member_name        = $this->getMemberName($id);
        $related_forum_list = $this->getRelatedForumList($id);
        if ($this->uid != null) {
            $uid         = $this->uid;
            $user_status = $this->getUserStatus($uid, $id);
            $this->assign('user_status', $user_status);
        }
        //区分是主题页还是回复页
        $this->assign('poster_type', 'addthread');
        $this->assign('forum_info', $forum_info);
        $this->assign('thread_list', $thread_list);
        $this->assign('thread_count', $thread_count);
        $this->assign('page', $page);
        $this->assign('forum_class', $forum_class);
        $this->assign('member_name', $member_name);
        $this->assign('related_forum_list', $related_forum_list);
        $this->display();
    }

    /**
     * 获取贴吧信息
     * @access public
     * @param string $fid 贴吧id
     * @return array
     */
    public function getForumInfo($fid)
    {
        $u    = $this->table_name['users'];
        $f    = $this->table_name['forum'];
        $info = M('forum')->field("{$u}.user_name,{$u}.user_id,{$f}.forum_id,{$f}.forum_name,{$f}.forum_desc")->join("{$u} ON {$f}.owner_id = {$u}.user_id")->where(array("{$f}.forum_id" => $fid))->find();
        return $info;
    }

    /**
     * 发帖
     * @access public
     */
    public function addThread()
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if ($this->isPostable($uid, I('post.forum_id')) == false) {
            $this->ajaxReturn('block-status');
        }

        //插入主题表
        $data_1['thread_id']    = getMikuInt();
        $data_1['thread_title'] = I('post.title');
        $data_1['user_id']      = $uid;
        $data_1['forum_id']     = I('post.forum_id');
        $data_1['thread_date']  = getNowDate();
        $data_1['is_exist']     = 1;
        if ($data_1['thread_title'] == '') {
            $this->ajaxReturn('title-empty');
            return;
        } else {
            $re_1 = M('thread')->data($data_1)->add();
        }

        //插入回复表
        $data_2['post_id']       = $data_1['thread_id'];
        $data_2['thread_id']     = $data_1['thread_id'];
        $data_2['user_id']       = $uid;
        $data_2['post_content']  = I('post.content');
        $data_2['post_date']     = getNowDate();
        $data_2['reply_post_id'] = '0';
        $data_2['floor_id']      = 1;
        $data_2['is_exist']      = 1;
        if ($data_2['post_content'] == '') {
            $this->ajaxReturn('content-empty');
            return;
        } else {
            $re_2 = M('post')->data($data_2)->add();
        }
        //插入类型表
        $data_3['thread_id']   = $data_1['thread_id'];
        $data_3['thread_type'] = 'normal';
        $re_3                  = M('thread_type')->data($data_3)->add();

        $re = $re_1 && $re_2 && $re_3;
        if ($re) {
            $this->ajaxReturn('thread-success');
        } else {
            $this->ajaxReturn('thread-failure');
        }

    }

    /**
     * 获取帖子列表
     * @access private
     * @param string $fid 贴吧id
     * @return array
     */
    private function getThreadList($fid, $type)
    {
        $p  = $this->table_name['post'];
        $u  = $this->table_name['users'];
        $t  = $this->table_name['thread'];
        $tt = $this->table_name['thread_type'];
        //公用join
        $join = "{$tt} ON {$t}.thread_id = {$tt}.thread_id";
        //公用where条件
        $condition["{$t}.forum_id"] = $fid;
        $condition["{$t}.is_exist"] = 1;
        if ($type == 'good') {
            $condition["{$tt}.thread_type"] = array('in', array('good', 'good,top'));
        }
        $count = M('thread')->join($join)->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 50, 'cur', false);
        $show  = $Pager->show();

        $info_2 = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$t}.user_id,{$u}.user_name,{$t}.thread_date,{$tt}.thread_type")->join("{$p} ON {$t}.thread_id = {$p}.thread_id")->join("{$u} ON {$t}.user_id = {$u}.user_id")->join($join)->group("{$p}.thread_id")->where($condition)
                             ->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        foreach ($info_2 as $key => $value) {
            $info_2[$key]['last_date']            = $this->getLastDate($info_2[$key]['thread_id']);
            $info_2[$key]['last_username']        = $this->getLastUsername($info_2[$key]['thread_id']);
            $info_2[$key]['last_userid']          = $this->getLastUserid($info_2[$key]['thread_id']);
            $info_2[$key]['reply_count']          = $this->getReplyCount($info_2[$key]['thread_id']);
            $info_2[$key]['post_content_convert'] = $this->getThreadText($this->getThreadContent($info_2[$key]['thread_id']));
            $info_2[$key]['thread_image']         = $this->getThreadImg($info_2[$key]['thread_id']);
        }
        $info_2 = sortArray($info_2, 'last_date', $type = 'desc');

        foreach ($info_2 as $key => $value) {
            if (strpos($info_2[$key]['thread_type'], 'top') !== false) {
                $temp_value = $info_2[$key];
                unset($info_2[$key]);
                array_unshift($info_2, $temp_value);
                //break;
            }

        }

        $array[0] = $info_2;
        $array[1] = $show;
        $array[2] = $count;
        return $array;
    }

    /**
     * 获取楼层数
     * @access public
     * @param string $tid 帖子id
     * @return int
     */
    public function getFloorCount($tid)
    {
        $floor_count = M('post')->field("max(floor_id)")->where(array('thread_id' => $tid))->find();
        return $floor_count['max(floor_id)'];
    }

    /**
     * 获取回复数
     * @access public
     * @param string $tid 帖子id
     * @return int
     */
    public function getReplyCount($tid)
    {
        $reply_count = M('post')->where(array('thread_id' => $tid))->count() - 1;
        return $reply_count;
    }

    /**
     * 获取最后回复时间
     * @access public
     * @param string $tid 帖子id
     * @return string
     */
    public function getLastDate($tid)
    {
        $lastdate = M('post')->field('post_date')->where(array('thread_id' => $tid))->order('post_date desc')->find();
        return $lastdate['post_date'];
    }

    /**
     * 获取最后回复人基类方法
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getLastUser($tid)
    {
        $u        = $this->table_name['users'];
        $p        = $this->table_name['post'];
        $lastuser = M('post')->field("{$u}.user_name,{$p}.user_id")->join("{$u} ON {$p}.user_id = {$u}.user_id")->where(array("{$p}.thread_id" => $tid))->order('post_date desc')->find();
        return $lastuser;
    }

    /**
     * 获取最后回复人
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getLastUsername($tid)
    {
        $info = $this->getLastUser($tid);
        return $info['user_name'];
    }

    /**
     * 获取最后回复人id
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getLastUserid($tid)
    {
        $info = $this->getLastUser($tid);
        return $info['user_id'];
    }

    /**
     * 获取1楼内容
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getThreadContent($tid)
    {
        $info = M('post')->field('post_content')->where(array('thread_id' => $tid, 'floor_id' => 1))->find();
        return $info['post_content'];
    }

    /**
     * 只保留帖子的文字内容、去除图片和表情
     * @access public
     * @param string $cont 原内容
     * @return string
     */
    public function getThreadText($cont, $type = null)
    {
        switch ($type) {
            case null:
                $info = preg_replace('/\[img\](.+?)\[\/img\]/is', '', $cont);
                $info = preg_replace('/\[emo\](.+?)\[\/emo\]/is', '', $info);
                break;
            case 'post':
                $info = preg_replace('/\[img\](.+?)\[\/img\]/is', '[图片]', $cont);
                $info = preg_replace('/\[emo\](.+?)\[\/emo\]/is', '[表情]', $info);
                break;
        }
        return $info;
    }

    /**
     * 获取主题的图片缩略图
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getThreadImg($tid)
    {
        $thread_content = $this->getThreadContent($tid);
        $img_count      = preg_match_all('/\[img\](.+?)\[\/img\]/is', $thread_content, $matches);
        if ($img_count >= 3) {
            $img_count = 3;
        }
        for ($i = 0; $i < $img_count; $i++) {
            $img_name[$i] = $matches[1][$i];
        }
        if ($img_count != 0) {
            //生成拼接的li块数组
            $li_html_start = '<li class="threadlist_pic_li">
       <div class="vpic_wrap">
        <img class="threadlist_pic j_m_pic" src="';
            $li_html_end = '" style="height:90px;"/>
       </div>
       <div class="threadlist_pic_highlight j_m_pic_light"></div>
       </li>';
            //最终的li块
            $li_html_final = '';
            for ($i = 0; $i < $img_count; $i++) {
                $img_src[$i]   = __ROOT__ . '/Public/uploads/forum_images/' . $img_name[$i];
                $li_html[$i]   = $li_html_start . $img_src[$i] . '" data-order="' . $i . $li_html_end;
                $li_html_final = $li_html_final . $li_html[$i];
            }
            $html = ' <div class="small_wrap j_small_wrap">
   <div class="small_list j_small_list">
    <div class="small_list_gallery">
     <ul class="threadlist_media j_threadlist_media" style="float: left;">' . $li_html_final . '
     </ul>
    </div>
   </div>
  </div>';
        } else {
            $html = '';
        }
        return $html;
    }

    /**
     * 获取当前是否是吧主登录
     * @access public
     * @param string $fid 贴吧id
     * @return boolean
     */
    public function getManageStatus($fid)
    {
        if ($this->uid == null) {
            return false;
        } else {
            $uid  = $this->uid;
            $info = M('forum')->field('owner_id')->where(array('forum_id' => $fid))->find();
            if ($info['owner_id'] == $uid) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 获取帖子类型
     * @access public
     * @param string $tid 帖子id
     * @return string
     */
    public function getThreadType($tid)
    {
        $info = M('thread_type')->where(array('thread_id' => $tid))->find();
        return $info['thread_type'];
    }

    /**
     * 获取用户状态
     * @access public
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return string
     */
    public function getUserStatus($uid, $fid)
    {
        $info        = M('user_status')->field('user_status')->where(array('user_id' => $uid, 'forum_id' => $fid))->find();
        $user_status = $info['user_status'];
        if ($user_status == null) {
            return 'normal';
        } elseif ($user_status == 'black') {
            return 'black';
        } elseif ($user_status == 'block' || $user_status == 'block,black') {
            $block_array = M('block_users')->field('block_date,block_days')->where(array('user_id' => $uid, 'forum_id' => $fid))->order('data_id desc')->find();
            $block_date  = $block_array['block_date'];
            $block_days  = $block_array['block_days'];
            $end_date    = date('Y-m-d H:i:s', strtotime($block_date . $block_days . 'day'));
            $now_date    = getNowDate();
            if (strtotime($now_date) > strtotime($end_date)) {
                $block_status = 0;
            } else {
                $block_status = 1;
            }
            if ($user_status == 'block' && $block_status == 1) {
                return 'block';
            } elseif ($user_status == 'block' && $block_status == 0) {
                return 'normal';
            } elseif ($user_status == 'block,black' && $block_status == 1) {
                return 'block,black';
            } elseif ($user_status == 'block,black' && $block_status == 0) {
                return 'black';
            }
        }
    }

    /**
     * 获取能否发帖
     * @access public
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return boolean
     */
    public function isPostable($uid, $fid)
    {
        $user_status = $this->getUserStatus($uid, $fid);
        if (strpos($user_status, 'block') === false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 图片上传
     * @access public
     */
    public function uploadImg()
    {
        $upload           = new \Think\Upload(); // 实例化上传类
        $upload->maxSize  = 3145728; // 设置附件上传大小
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath = './Public/uploads/forum_images/'; // 设置附件上传根目录
        $upload->saveName = getRandChar(30);
        $upload->autoSub  = false;
        // 上传单个文件
        $info = $upload->uploadOne($_FILES['img1']);
        if (!$info) {
            // 上传错误提示错误信息
            $array['status']  = 'failure';
            $array['content'] = $upload->getError();
        } else {
            // 上传成功 获取上传文件信息
            $array['status']  = 'success';
            $array['content'] = $info['savename'];
        }
        $this->ajaxReturn($array);
    }

    /**
     * 上传头像
     * @access public
     */
    public function uploadAvatar()
    {
        $upload           = new \Think\Upload();
        $upload->maxSize  = 1 * 1024 * 1024;
        $upload->exts     = array('jpg', 'png', 'gif');
        $upload->replace  = true;
        $upload->saveName = getRandChar(30);
        $upload->autoSub  = false;
        $path             = './Public/uploads/forum_avatar/';
        $upload->rootPath = $path;
        $info             = $upload->upload();
        if (!$info) {
            // 上传错误提示错误信息
            $this->ajaxReturn('', $upload->getError(), 0, 'json');
        } else {
            // 上传成功 获取上传文件信息
            $temp_size = getimagesize($path . $info['forum_avatar']['savename']);
            //判断宽和高是否符合头像要求
            if ($temp_size[0] < 100 || $temp_size[1] < 100) {
                $this->ajaxReturn(0, '图片宽或高不得小于100px！', 0, 'json');
            }
            $data['picName'] = $info['forum_avatar']['savename'];
            $data['status']  = 1;
            $data['url']     = __ROOT__ . '/Public/uploads/forum_avatar/' . $data['picName'];
            $data['info']    = $info;
            $this->ajaxReturn($data, 'json');
        }
    }

    /**
     * 裁剪并保存头像
     * @access public
     */
    public function setForumCard()
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $params = I('post.'); //裁剪参数
        $uid    = $this->uid;
        $fid    = $params['forum_id'];
        if ($this->getManageStatus($fid) == false) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        //图片裁剪数据
        if (!isset($params) && empty($params)) {
            $this->ajaxReturn('set-failure');
        }
        $desc = $params['desc'];
        $re_1 = M('forum')->$re_2 = M('forum')->where(array('forum_id' => $fid))->setField('forum_desc', $desc);
        if ($params['src'] != '') {
            //头像目录地址
            $path     = './Public/uploads/forum_avatar/';
            $pic_name = $params['picName'];
            //要保存的图片
            $real_path = $path . $pic_name;
            //临时图片地址
            $pic_path  = $path . $pic_name;
            $Think_img = new \Think\Image();
            //裁剪原图
            $Think_img->open($pic_path)->crop($params['w'], $params['h'], $params['x'], $params['y'])->thumb(150, 150)->save($real_path);
            //把文件名插入数据库
            $re_2 = M('forum')->where(array('forum_id' => $fid))->setField('forum_avatar', $pic_name);
        } else {
            $re_2 = 1;
        }
        $this->ajaxReturn('set-success');
    }

    /**
     * 获取贴吧头像
     * @access public
     * @param string $fid 贴吧id
     */
    public function getAvatar($fid)
    {
        header("Content-type: image/png");
        $info = M('forum')->field('forum_avatar')->where(array('forum_id' => $fid))->find();
        if ($info['forum_avatar'] == '0') {
            $url = './Public/common/images/forum_avatar_default.jpg';
        } else {
            $url = './Public/uploads/forum_avatar/' . $info['forum_avatar'];
        }
        readfile($url);

    }

    /**
     * 是否关注贴吧
     * @access public
     * @param string $fid 贴吧id
     * @param string $uid 用户id
     * @return boolean
     */
    public function isLikeForum($fid, $uid)
    {
        $info = M('forum_fans')->where(array('forum_id' => $fid, 'fans_id' => $uid))->find();
        if ($info == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 前端关注按钮
     * @access public
     * @param string $fid 贴吧id
     */
    public function doLikeForum($fid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if ($this->isLikeForum($fid, $uid) == false) {
            $this->likeForum($fid);
        } else {
            $this->dislikeForum($fid);
        }
    }

    /**
     * 关注贴吧
     * @access private
     * @param string $id 贴吧id
     */
    private function likeForum($fid)
    {

        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        //先查找是否关注过该贴吧
        $info = M('forum_fans')->where(array('forum_id' => $fid, 'fans_id' => $uid))->find();
        if ($info['fans_id'] != $uid) {
            $data['data_id']  = getMikuInt();
            $data['forum_id'] = $fid;
            $data['fans_id']  = $uid;
            $re               = M('forum_fans')->data($data)->add();
            if ($re) {
                $this->ajaxReturn('do-success');
            } else {
                $this->ajaxReturn('do-failure');
            }
        } else {
            $this->ajaxReturn('already-liked');
        }

    }

    /**
     * 取消关注贴吧
     * @access private
     * @param string $id 贴吧id
     */
    private function dislikeForum($fid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid  = $this->uid;
        $info = M('forum_fans')->where(array('forum_id' => $fid, 'fans_id' => $uid))->find();
        if ($info == null) {
            $this->ajaxReturn('never-liked');
        } else {
            $data_id = $info['data_id'];
            $re      = M('forum_fans')->where(array('data_id' => $data_id))->delete();
            if ($re) {
                $this->ajaxReturn('do-success');
            } else {
                $this->ajaxReturn('do-failure');
            }
        }
    }

    /**
     * 牛人排行榜
     * @access public
     * @param string $id 贴吧id
     */
    public function levelRank($id)
    {
        $rank_list = $this->getLevelRankList($id);
        $page      = $rank_list_array[1];
        if ($this->uid != null) {
            $uid        = $this->uid;
            $rank_order = $this->getUserLevelRankOrder($id, $uid);
            $this->assign('rank_order', $rank_order);
        }
        $this->assign('rank_list', $rank_list);
        $this->display();
    }

    /**
     * 吧内头衔说明
     * @access public
     * @param string $id 贴吧id
     */
    public function levelDetail($id)
    {
        $this->getPublic($id);
        $forum_info = $this->getForumInfo($id);
        for ($i = 1; $i <= 18; $i++) {
            $title[$i] = $this->getMemberTitle($id, $i);
        }
        $this->assign('title', $title);
        $this->assign('forum_info', $forum_info);
        $this->display();
    }

    /**
     * 获取用户在贴吧的排行
     * @access private
     * @param string $fid 贴吧id
     * @param string $uid 用户id
     */
    private function getUserLevelRankOrder($fid, $uid)
    {
        $rank_list = $this->getLevelRankList($fid);
        foreach ($rank_list as $key => $value) {
            if ($rank_list[$key]['fans_id'] == $uid) {
                $rank_order = $key + 1;
                break;
            }
        }

        $member_count     = $this->getMemberCount($fid);
        $array['order']   = $rank_order;
        $array['infront'] = $rank_order - 1;
        $array['behind']  = $member_count - $rank_order;
        $array['count']   = $member_count;
        switch (true) {
            case ($rank_order == 1):
                $array['content'] = '传说中的第1名<br>无敌最是寂寞，这才是真正的贴吧大神！';
                break;
            case ($rank_order > 1):
                $array['content'] = '还没水到第1名<br>努力水帖才是王道！';
        }
        return $array;
    }

    /**
     * 获取等级排行列表
     * @access private
     * @param string $fid 贴吧id
     * @return array
     */
    private function getLevelRankList($fid)
    {
        $member_list_array = $this->getMemberList($fid);
        $info              = $member_list_array[0];
        foreach ($info as $key => $value) {
            $info[$key]['exp']   = A('Home')->getExp($info[$key]['fans_id'], $info[$key]['forum_id']);
            $info[$key]['level'] = A('Home')->getLevel($info[$key]['fans_id'], $info[$key]['forum_id']);
        }
        $res = sortArray($info, 'exp', 'desc');
        return $res;
    }

    /**
     * 获取右侧经验
     * @access private
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     */
    private function getRightPanel($uid, $fid)
    {
        $exp          = A('Home')->getExp($uid, $fid);
        $level_array  = A('Home')->getLevel($uid, $fid);
        $level        = $level_array[0];
        $level_css    = $level_array[1];
        $member_title = $this->getMemberTitle($fid, $level);
        $max_exp      = $level_array[2];
        $ratio        = ($exp / $max_exp) * 100;
        $rank_order   = $this->getUserLevelRankOrder($fid, $uid);
        $this->assign('rank_order', $rank_order['order']);
        $this->assign('exp', $exp);
        $this->assign('level', $level);
        $this->assign('level_css', $level_css);
        $this->assign('member_title', $member_title);
        $this->assign('max_exp', $max_exp);
        $this->assign('ratio', $ratio);
    }

    /**
     * 获取帖子数
     * @access public
     * @param string $fid 贴吧id
     * @return int
     */
    public function getPostCount($fid)
    {
        $p    = $this->table_name['post'];
        $t    = $this->table_name['thread'];
        $info = M('post')->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->where(array("{$t}.forum_id" => $fid))->count();
        return $info;
    }

    /**
     * 获取主题数
     * @access private
     * @param string $fid 贴吧id
     * @return int
     */
    private function getThreadCount($fid)
    {
        $info = M('thread')->where(array('forum_id' => $fid))->count();
        return $info;

    }

    /**
     * 获取关注列表
     * @access public
     * @param string $fid 贴吧id
     * $param string $username 用户名
     * @return array
     */
    public function getMemberList($fid, $username = '')
    {
        $ff                    = $this->table_name['forum_fans'];
        $u                     = $this->table_name['users'];
        $t                     = $this->table_name['thread'];
        $p                     = $this->table_name['post'];
        $tt                    = $this->table_name['thread_type'];
        $condition['forum_id'] = $fid;
        $join                  = "{$u} ON {$ff}.fans_id = {$u}.user_id";
        if ($username != '') {
            $condition["{$u}.user_name"] = $username;
        }
        $count = M('forum_fans')->join($join)->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 30, 'active', true);
        $show  = $Pager->show();
        $info  = M('forum_fans')->field("{$u}.user_name,{$ff}.fans_id,{$ff}.forum_id")->join($join)->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        foreach ($info as $key => $value) {
            $info[$key]['level']      = A('Home')->getLevel($info[$key]['fans_id'], $fid);
            $info[$key]['exp']        = A('Home')->getExp($info[$key]['fans_id'], $fid);
            $info[$key]['post_count'] = M('post')->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->where(array("{$p}.user_id" => $info[$key]['fans_id'], "{$t}.forum_id" => $fid))->count();
            $info[$key]['good_count'] = M('thread')->join("{$tt} ON {$tt}.thread_id = {$t}.thread_id")->where(array("{$t}.user_id" => $info[$key]['fans_id'], "{$tt}.thread_type" => array('in', array('good', 'good,top'))))->count();
        }
        $array[0] = $info;
        $array[1] = $show;
        if ($username != '' && $info != null) {
            $count = 1;
        }
        $array[2] = $count;
        $array[3] = $Pager->totalPages;
        return $array;
    }

    /**
     * 获取关注数
     * @access public
     * @param string $fid 贴吧id
     * @return int
     */
    public function getMemberCount($fid)
    {
        $info = $this->getMemberList($fid);
        return $info[2];
    }

    /**
     * 获取成员列表
     * @access public
     * @param string $id 贴吧id
     */
    public function memberList($id)
    {
        $this->getPublic($id);
        $forum_info        = $this->getForumInfo($id);
        $forum_class       = $this->getForumClass($id);
        $member_name       = $this->getMemberName($id);
        $member_list_array = $this->getMemberList($id);
        $member_list       = $member_list_array[0];
        $page              = $member_list_array[1];
        $member_count      = $member_list_array[2];
        $total_page        = $member_list_array[3];
        $this->assign('forum_info', $forum_info);
        $this->assign('forum_class', $forum_class);
        $this->assign('member_name', $member_name);
        $this->assign('member_list', $member_list);
        $this->assign('page', $page);
        $this->assign('member_count', $member_count);
        $this->assign('total_page', $total_page);
        $this->display();
    }

    /**
     * 获取会员名
     * @access public
     * @param string $fid 贴吧id
     * @return array
     */
    public function getMemberName($fid)
    {
        $info = M('member_title')->field('member_name')->where(array('forum_id' => $fid))->find();
        if ($info == null) {
            return '会员';
        } else {
            return $info['member_name'];
        }

    }

    /**
     * 获取头衔名
     * @access public
     * @param string $fid 贴吧id
     * @param string $level 等级
     * @return array
     */
    public function getMemberTitle($fid, $level)
    {
        $info = M('member_title')->field('member_title')->where(array('forum_id' => $fid))->find();
        if ($info == null) {
            $member_title_all = '初级粉丝,中级粉丝,高级粉丝,正式会员,正式会员,核心会员,核心会员,铁杆会员,铁杆会员,知名人士,知名人士,人气楷模,人气楷模,意见领袖,意见领袖,进阶元老,资深元老,荣耀元老';
        } else {
            $member_title_all = $info['member_title'];
        }

        $member_title = explode(',', $member_title_all);
        $key          = $level - 1;
        return $member_title[$key];
    }

    /**
     * 获取友情贴吧列表
     * @access public
     * @param string $fid 贴吧id
     * @return array
     */
    public function getRelatedForumList($fid)
    {
        $f    = $this->table_name['forum'];
        $rf   = $this->table_name['related_forum'];
        $info = M('related_forum')->field("{$rf}.object_id as forum_id,{$f}.forum_name")->join("{$f} ON {$rf}.object_id = {$f}.forum_id")->where(array("{$rf}.forum_id" => $fid))->select();
        return $info;
    }

    /**
     * 获取友情贴吧数量
     * @access public
     * @param string $fid 贴吧id
     * @return int
     */
    public function getRelatedForumCount($fid)
    {
        $info = $this->getRelatedForumList($fid);
        return count($info);
    }

    /**
     * 贴吧页、帖子页公共信息
     * @access public
     * @param string $fid 贴吧id
     */
    public function getPublic($fid)
    {
        if ($this->uid != null) {
            $uid = $this->uid;
            $this->getRightPanel($uid, $fid);
            $sign_count = $this->getSignCount($fid);
            $sign_order = $this->getSignOrder($uid, $fid);
            $this->assign('sign_count', $sign_count);
            $this->assign('sign_order', $sign_order);
        }
        //关注按钮css
        if ($this->isLikeForum($fid, $uid) == false) {
            $concern_btn_css = 'focus_btn islike_focus';
            $is_like_forum   = 0;
        } else {
            $concern_btn_css = 'focus_btn cancel_focus';
            $is_like_forum   = 1;
        }
        $this->assign('is_like_forum', $is_like_forum);
        $this->assign('concern_btn_css', $concern_btn_css);
        $post_count    = $this->getPostCount($fid);
        $member_count  = $this->getMemberCount($fid);
        $sign_html     = $this->getSignHtml($uid, $fid);
        $manage_status = $this->getManageStatus($fid);
        $this->assign('manage_status', $manage_status);
        $this->assign('sign_html', $sign_html);
        $this->assign('member_count', $member_count);
        $this->assign('post_count', $post_count);

    }

    /**
     * 判断是否签到
     * @access public
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return boolean
     */
    public function isSigned($uid, $fid)
    {
        $today_date = date("Y-m-d", time());
        $info       = M('forum_sign')->where(array('user_id' => $uid, 'forum_id' => $fid, 'sign_date' => array('like', $today_date . '%')))->find();
        if ($info == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 获取签到模板
     * @access private
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return string
     */
    private function getSignHtml($uid, $fid)
    {
        $lack_day   = $this->getSignLackDay($uid, $fid);
        $keep_day   = $this->getSignKeepDay($uid, $fid);
        $today_date = date("m月d日", time());
        if ($this->isSigned($uid, $fid) == false) {
            $html = '<div id="signstar_wrapper" class="j_sign_box sign_box_bright">
            <a href="javascript:void(0)" onclick="signForum(\'' . $fid . '\')" title="签到" class="j_signbtn sign_btn_bright j_cansign">
            <span class="sign_today_date">' . $today_date . '</span><span class="sign_month_lack_days">漏签<span class="j_sign_month_lack_days">' . $lack_day . '</span>天 </span></a>
           </div>';
        } else {
            $html = '<div id="signstar_wrapper" class="j_sign_box sign_box_bright sign_box_bright_signed">
            <a href="javascript:void(0)" title="签到完成" class="j_signbtn signstar_signed">
            <span class="sign_keep_span">连续' . $keep_day . '天</span><span class="sign_today_date">' . $today_date . '</span><span class="sign_month_lack_days">漏签<span class="j_sign_month_lack_days">' . $lack_day . '</span>天 </span></a>
           </div>';
        }
        return $html;
    }

    /**
     * 进行签到
     * @access public
     * @param string $fid 贴吧id
     */
    public function signForum($fid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if ($this->isSigned($uid, $fid) == true) {
            $this->ajaxReturn('already-signed');
            return;
        }
        $data['data_id']   = getMikuInt();
        $data['user_id']   = $uid;
        $data['forum_id']  = $fid;
        $data['sign_date'] = getNowDate();
        $yesterday_date    = date("Y-m-d", strtotime("-1 day"));
        $info              = M('forum_sign')->field('keep_day')->where(array('user_id' => $uid, 'forum_id' => $fid, 'sign_date' => array('like', $yesterday_date . '%')))->find();
        if ($info == null) {
            $data['keep_day'] = 1;
        } else {
            $data['keep_day'] = $info['keep_day'] + 1;
        }
        $re = M('forum_sign')->data($data)->add();
        if ($re) {
            $this->ajaxReturn('sign-success');
        } else {
            $this->ajaxReturn('sign-failure');
        }
    }

    /**
     * 获取连续签到天数
     * @access private
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return int
     */
    private function getSignKeepDay($uid, $fid)
    {
        $info     = M('forum_sign')->field('keep_day')->where(array('user_id' => $uid, 'forum_id' => $fid))->order('sign_date desc')->find();
        $keep_day = $info['keep_day'];
        return $keep_day;
    }

    /**
     * 获取漏签天数
     * @access private
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return int
     */
    private function getSignLackDay($uid, $fid)
    {
        //获取第一天和最后一天的日期
        $_first_day = M('forum_sign')->field('sign_date')->where(array('user_id' => $uid, 'forum_id' => $fid))->order('sign_date')->find();
        $_last_day  = M('forum_sign')->field('sign_date')->where(array('user_id' => $uid, 'forum_id' => $fid))->order('sign_date desc')->find();
        $first_day  = date("Y-m-d", strtotime($_first_day['sign_date']));
        $last_day   = date("Y-m-d", strtotime($_last_day['sign_date']));
        $interval   = date_diff(date_create($first_day), date_create($last_day));
        //计算签到总周期
        $during_day = $interval->format('%a') + 1;
        $total_day  = M('forum_sign')->where(array('user_id' => $uid, 'forum_id' => $fid))->count();
        $lack_day   = $during_day - $total_day;
        return $lack_day;
    }

    /**
     * 获取当天签到列表
     * @access private
     * @param string $fid 贴吧id
     * @return array
     */
    private function getSignList($fid)
    {
        $today_date = date("Y-m-d", time());
        $info       = M('forum_sign')->where(array('forum_id' => $fid, 'sign_date' => array('like', $today_date . '%')))->order('sign_date desc')->select();
        return $info;
    }

    /**
     * 获取签到排名
     * @access private
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return int
     */
    private function getSignOrder($uid, $fid)
    {
        $list = $this->getSignList($fid);
        foreach ($list as $key => $value) {
            $_list[$list[$key]['user_id']] = $key + 1;
        }
        return $_list[$uid];
    }

    /**
     * 获取签到总人数
     * @access private
     * @param string $fid 贴吧id
     * @return int
     */
    private function getSignCount($fid)
    {
        $list  = $this->getSignList($fid);
        $count = count($list);
        return $count;
    }

    /**
     * 获取某月的签到状态
     * @access public
     * @param string $month 年-月份
     * @param string $fid 贴吧id
     */
    public function getSignStatus($month, $fid)
    {
        if ($this->uid == null) {
            return;
        }
        $uid  = $this->uid;
        $info = M('forum_sign')->field('sign_date')->where(array('user_id' => $uid, 'forum_id' => $fid, 'sign_date' => array('like', $month . '%')))->select();
        foreach ($info as $key => $value) {
            $sign_date[$key] = intval(date("d", strtotime($info[$key]['sign_date'])));
        }
        $this->ajaxReturn($sign_date);
    }

    /**
     * 获取贴吧数量
     * @access public
     * @return int
     */
    public function getForumCount()
    {
        $info = M('forum')->count();
        return $info;
    }

    /**
     * 导航栏跳转
     * @access public
     * @param string $fname 贴吧名
     */
    public function forumRedirect($fname = '')
    {
        if ($fname == '') {
            $this->error('没有输入内容！');
        }
        $fname = strtolower($fname);
        $info  = M('forum')->where(array('forum_name' => $fname))->find();
        if ($info != null) {
            $this->redirect('Forum/index', array('id' => $info['forum_id']));
        } else {
            $this->redirect('Forum/createForum', array('fname' => $fname));
        }
    }

    /**
     * 创建贴吧
     * @access public
     * @param string $fname 贴吧名
     */
    public function createForum($fname = '')
    {
        $this->assign('forum_name', $fname);
        $this->display();
    }

    /**
     * 处理创建贴吧表单
     * @access public
     */
    public function doCreateForum()
    {
        if ($this->uid == null) {
            $array['msg'] = 'need-login';
            $this->ajaxReturn($array);
            return;
        }
        $uid = $this->uid;
        //表单数据
        $params               = I('post.'); //裁剪参数
        $params['forum_name'] = strtolower($params['forum_name']);
        if (!isset($params) && empty($params)) {
            $this->ajaxReturn('create-failure');
        }
        if ($params['forum_name'] == '') {
            $array['msg'] = 'forum-name-empty';
            $this->ajaxReturn($array);
        }
        if ($params['forum_desc'] == '') {
            $array['msg'] = 'forum-desc-empty';
            $this->ajaxReturn($array);
        }
        $data['forum_id'] = getMikuInt();
        $forum_array      = M('forum')->where(array('forum_name' => $params['forum_name']))->find();
        if ($forum_array != null) {
            $array['msg'] = 'forum-exist';
            $this->ajaxReturn($array);
        }
        $data['forum_name'] = $params['forum_name'];
        $data['owner_id']   = $uid;

        //头像目录地址
        $path     = './Public/uploads/forum_avatar/';
        $pic_name = $params['picName'];
        //要保存的图片
        $real_path = $path . $pic_name;
        //临时图片地址
        $pic_path  = $path . $pic_name;
        $Think_img = new \Think\Image();
        //裁剪原图
        $Think_img->open($pic_path)->crop($params['w'], $params['h'], $params['x'], $params['y'])->thumb(150, 150)->save($real_path);

        $data['forum_avatar'] = $pic_name;
        $data['forum_desc']   = $params['forum_desc'];
        $data['class_id']     = $params['class_cid'];
        $data['parent_id']    = $params['class_pid'];
        $re                   = M('forum')->data($data)->add();
        if ($re) {
            $array['msg'] = 'create-success';
            $array['fid'] = $data['forum_id'];
        } else {
            $array['msg'] = 'create-failure';
        }
        $this->ajaxReturn($array);

    }

    /**
     * ajax获取父级贴吧目录
     * @access public
     */
    public function getForumParentClassAllAjaxList()
    {
        $info = M('forum_class')->field('parent_id,class_name')->where(array('class_id' => 0))->select();
        $this->ajaxReturn($info);
    }

    /**
     * ajax获取子级贴吧目录
     * @access public
     * @param int $pid 父级id
     */
    public function getForumClassAllAjaxListByPid($pid)
    {
        $info = M('forum_class')->field('class_id,class_name')->where(array('parent_id' => $pid, 'class_id' => array('neq', 0)))->select();
        $this->ajaxReturn($info);
    }

    /**
     * 贴吧目录页
     * @access public
     */
    public function forumClass()
    {
        $class_list        = $this->getForumClassList();
        $parent_class_list = $this->getForumParentClassList();
        $this->assign('class_list', $class_list);
        $this->assign('parent_class_list', $parent_class_list);
        $this->display();
    }

    /**
     * 子目录页
     * @access public
     */
    public function forumPark($pid, $cid)
    {
        $class_list       = $this->getForumClassListByPid($pid);
        $forum_list_array = $this->getForumListByPidCid($pid, $cid);
        $forum_list       = $forum_list_array[0];
        $page             = $forum_list_array[1];
        $uid              = $this->uid;
        foreach ($forum_list as $key => $value) {
            $forum_list[$key]['member_count'] = $this->getMemberCount($forum_list[$key]['forum_id']);
            $forum_list[$key]['post_count']   = $this->getPostCount($forum_list[$key]['forum_id']);
            if ($this->isLikeForum($forum_list[$key]['forum_id'], $uid) == false) {
                $forum_list[$key]['concern_btn']['css']   = '';
                $forum_list[$key]['concern_btn']['title'] = '我喜欢';
            } else {
                $forum_list[$key]['concern_btn']['css']   = 'is_like';
                $forum_list[$key]['concern_btn']['title'] = '取消喜欢';
            }
        }
        $this->assign('forum_list', $forum_list);
        $this->assign('page', $page);
        $this->assign('class_list', $class_list);
        $this->display();
    }

    /**
     * 获取贴吧目录
     * @access private
     * @return array
     */
    private function getForumClassList()
    {
        for ($i = 1; $i <= 30; $i++) {
            $info[$i] = M('forum_class')->field('class_id,parent_id,class_name')->where(array('parent_id' => $i))->select();
        }
        return $info;
    }

    /**
     * 获取贴吧父级目录
     * @access private
     * @return array
     */
    private function getForumParentClassList()
    {
        $info = M('forum_class')->where(array('class_id' => 0, 'class_icon' => array('neq', '')))->select();
        return $info;
    }

    /**
     * 通过父类目录获得子类目录名
     * @access private
     * @param int $pid 父类id
     * @return array
     */
    private function getForumClassListByPid($pid)
    {
        $info = M('forum_class')->where(array('parent_id' => $pid))->select();
        return $info;
    }

    /**
     * 通过目录id获得具体的贴吧列表
     * @access private
     * @param string $pid 父类id
     * @param string $cid 子类id
     * @return array
     */
    private function getForumListByPidCid($pid, $cid)
    {
        $condition['parent_id'] = $pid;
        if ($cid != 0) {
            $condition['class_id'] = $cid;
        }
        $count    = M('forum')->where($condition)->count();
        $Pager    = new \Tieba\Library\Pager($count, 20, 'current', false);
        $show     = $Pager->show();
        $info     = M('forum')->field('forum_id,forum_name')->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        $array[0] = $info;
        $array[1] = $show;
        return $array;
    }

    /**
     * 通过父类目录获得其下的贴吧列表
     * @access private
     * @param int $pid 父类id
     * @return array
     */
    private function getForumListByPid($pid)
    {
        $info = M('forum')->field('forum_id,forum_name')->where(array('parent_id' => $pid))->select();
        return $info;
    }

    /**
     * 首页左侧列表ajax菜单列表
     * @access public
     * @param int $pid 父类id
     */
    public function getForumClassAjaxListByPid($pid)
    {
        $class_list = $this->getForumClassListByPid($pid);
        $forum_list = $this->getForumListByPid($pid);
        $class_html = '';
        $forum_html = '';
        $title_html = '<a href="' . U('Forum/forumPark', array('pid' => $class_list[0]['parent_id'], 'cid' => 0)) . '" target="_blank" title="' . $class_list[0]['class_name'] . '">' . $class_list[0]['class_name'] . '</a>';
        foreach ($class_list as $key => $value) {
            if ($key > 0) {
                if ($key == 1) {
                    $class_html = '<a class="d-item" target="_blank" href="' . U('Forum/forumPark', array('pid' => $class_list[$key]['parent_id'], 'cid' => $class_list[$key]['class_id'])) . '">' . $class_list[$key]['class_name'] . '</a>';
                } else {
                    $class_html .= '<span class="d-gap"></span>
      <a class="d-item" target="_blank" href="' . U('Forum/forumPark', array('pid' => $class_list[$key]['parent_id'], 'cid' => $class_list[$key]['class_id'])) . '">' . $class_list[$key]['class_name'] . '</a>';
                }
            }
        }
        foreach ($forum_list as $key => $value) {
            $forum_html .= '<a class="rec-d-item" target="_blank" href="' . U('Forum/index', array('id' => $forum_list[$key]['forum_id'])) . '">' . $forum_list[$key]['forum_name'] . '</a>';
        }
        $array['title']   = $title_html;
        $array['classes'] = $class_html;
        $array['forum']   = $forum_html;
        $this->ajaxReturn($array);
    }

    /**
     * 获取贴吧目录名
     * @access public
     * @param string $fid 贴吧id
     * @return array
     */
    public function getForumClass($fid)
    {
        $info                 = M('forum')->field('class_id,parent_id')->where(array('forum_id' => $fid))->find();
        $info_2               = M('forum_class')->field('class_name')->where(array('class_id' => $info['class_id'], 'parent_id' => $info['parent_id']))->find();
        $info_3               = M('forum_class')->field('class_name')->where(array('class_id' => 0, 'parent_id' => $info['parent_id']))->find();
        $array['class_name']  = $info_2['class_name'];
        $array['parent_name'] = $info_3['class_name'];
        $array['class_id']    = $info['class_id'];
        $array['parent_id']   = $info['parent_id'];
        return $array;
    }

    /**
     * ajax搜索贴吧
     * @access public
     * @param unknown $word 关键字
     */
    public function getForumAjaxList($word)
    {
        $info = M('forum')->field('forum_name,forum_id')->where(array('forum_name' => array('like', '%' . $word . '%')))->select();
        foreach ($info as $key => $value) {
            $info[$key]['member_count']  = $this->getMemberCount($info[$key]['forum_id']);
            $info[$key]['post_count']    = $this->getMemberCount($info[$key]['forum_id']);
            $info[$key]['forum_class']   = $this->getForumClass($info[$key]['forum_id']);
            $info[$key]['forum_name_hl'] = preg_replace("/($word)/i", '<em class="highlight">\\1</em>', $info[$key]['forum_name']);
        }
        if ($info == null) {
            $this->ajaxReturn('no-data');
        } else {
            $this->ajaxReturn($info);
        }
    }

    /**
     * 搜索页
     * @access public
     * @param string $fid 贴吧id
     * @param string $word 关键字
     * @param string $order 排序方式
     */
    public function search($fid = '', $word = '', $order = '')
    {
        if ($word == '') {
            $this->error('没有输入内容！');
        }
        $this->setSearchHistory($word);
        if ($fid != '') {
            $forum_info = $this->getForumInfo($fid);
            $this->assign('forum_info', $forum_info);
            $order_url['default'] = U('Forum/search', array('fid' => $fid, 'word' => $word));
            $order_url['date']    = U('Forum/search', array('fid' => $fid, 'word' => $word, 'order' => 'date'));
            $order_url['thread']  = U('Forum/search', array('fid' => $fid, 'word' => $word, 'order' => 'thread'));
        } else {
            $order_url['default'] = U('Forum/search', array('word' => $word));
            $order_url['date']    = U('Forum/search', array('word' => $word, 'order' => 'date'));
            $order_url['thread']  = U('Forum/search', array('word' => $word, 'order' => 'thread'));
        }
        $result_list_array = $this->getSearchResultList($fid, $word, $order);
        $result_list       = $result_list_array[0];
        $page              = $result_list_array[1];
        $result_count      = $result_list_array[2];
        $total_time        = $result_list_array[3];
        $history_list      = $this->getSearchHistoryList();
        $this->assign('word', $word);
        $this->assign('result_list', $result_list);
        $this->assign('result_count', $result_count);
        $this->assign('order_url', $order_url);
        $this->assign('total_time', $total_time);
        $this->assign('page', $page);
        $this->assign('history_list', $history_list);
        //dump($info);
        $this->display();
    }

    /**
     * 获取搜索结果列表
     * @access private
     * @param string $fid 贴吧id
     * @param string $word 关键字
     * @param string $order 排序方式
     * @return array
     */
    private function getSearchResultList($fid, $word, $order)
    {
        $f = $this->table_name['forum'];
        $p = $this->table_name['post'];
        $t = $this->table_name['thread'];
        $u = $this->table_name['users'];

        if ($fid != '') {
            $condition_is_forum = "AND {$t}.forum_id='{$fid}'";
        } else {
            $condition_is_forum = '';
        }
        switch ($order) {
            case '':
                $order = "post_date desc";
                break;
            case 'date':
                $order = "post_date asc";
                break;
            case 'thread':
                $condition_is_thread = "AND {$p}.floor_id=1";
                $order               = "post_date desc";
                break;
        }

        $sql = "(SELECT tb_post.thread_id,tb_thread.thread_title,tb_post.post_content,tb_post.post_id,tb_post.post_date,tb_post.user_id,tb_forum.forum_name,tb_thread.forum_id,tb_users.user_name,tb_post.floor_id FROM `tb_post` INNER JOIN tb_thread ON tb_post.thread_id = tb_thread.thread_id INNER JOIN tb_forum ON tb_thread.forum_id = tb_forum.forum_id INNER JOIN tb_users ON tb_post.user_id = tb_users.user_id WHERE tb_post.post_content LIKE '%{$word}%' AND tb_post.is_exist = 1  $condition_is_forum $condition_is_thread) UNION (SELECT tb_post.thread_id,tb_thread.thread_title,tb_post.post_content,tb_post.post_id,tb_post.post_date,tb_post.user_id,tb_forum.forum_name,tb_thread.forum_id,tb_users.user_name,tb_post.floor_id FROM `tb_thread` INNER JOIN tb_post ON tb_post.thread_id = tb_thread.thread_id INNER JOIN tb_forum ON tb_thread.forum_id = tb_forum.forum_id INNER JOIN tb_users ON tb_post.user_id = tb_users.user_id WHERE tb_thread.thread_title LIKE '%{$word}%' AND tb_thread.is_exist = 1 AND tb_post.floor_id=1 $condition_is_forum) ";

        $count_array = M()->query($sql);
        $count       = count($count_array);
        $Pager       = new \Tieba\Library\Pager($count, 20, 'cur', false);
        $sql_end     = "ORDER BY $order  LIMIT $Pager->firstRow,$Pager->listRows";
        $show        = $Pager->show();
        //开始计时
        $s_time = microtime(true);
        // $info = M('post')->field("{$p}.thread_id,{$t}.thread_title,{$p}.post_content,{$p}.post_id,{$p}.post_date,{$p}.user_id,{$f}.forum_name,{$t}.forum_id,{$u}.user_name,{$p}.floor_id")->join($join)->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->join("{$u} ON {$p}.user_id = {$u}.user_id")
        // ->where($condition)->group("{$p}.post_id")->order($order)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        $info = M()->query($sql . $sql_end);
        foreach ($info as $key => $value) {
            $info[$key]['post_content_convert'] = $this->getThreadText($info[$key]['post_content'], 'post');
            $info[$key]['post_content_convert'] = str_replace($word, '<em>' . $word . '</em>', $info[$key]['post_content_convert']);
            $info[$key]['thread_title_convert'] = str_replace($word, '<em>' . $word . '</em>', $info[$key]['thread_title']);
        }
        //结束计时
        $e_time     = microtime(true);
        $total_time = number_format($e_time - $s_time, 3);
        $array[0]   = $info;
        $array[1]   = $show;
        $array[2]   = $count;
        $array[3]   = $total_time;
        return $array;
    }

    /**
     * 写入搜索历史
     * @access private
     * @param string $word 关键字
     */
    private function setSearchHistory($word)
    {
        $history = $this->getSearchHistoryList();
        if ($history == null) {
            $new_history = array($word);
        } else {
            if (!in_array($word, $history)) {
                array_unshift($history, $word);
            }
            $new_history = $history;
        }
        $new_history_json = json_encode($new_history);
        cookie('search_history', $new_history_json);
    }

    /**
     * 获取搜索历史
     * @access private
     * @return array
     */
    private function getSearchHistoryList()
    {
        if (cookie('search_history')) {
            $history_json = cookie('search_history');
            $history      = json_decode($history_json, $true);
            return $history;
        } else {
            return null;
        }

    }

    /**
     * 清空搜索记录
     * @access public
     */
    public function clearSearchHistory()
    {
        cookie('search_history', null);
        $this->ajaxReturn('clear-success');
    }

    /**
     * 获取全局搜索框
     * @access public
     */
    public function getGlobalForumList()
    {
        $uid = $this->uid;
        if ($uid != null) {
            $info = A('Home')->getForumList($uid);
        } else {
            $info = A('Index')->getHotForumList();
        }
        foreach ($info as $key => $value) {
            $info[$key]['forum_class']  = $this->getForumClass($info[$key]['forum_id']);
            $info[$key]['member_count'] = $this->getMemberCount($info[$key]['forum_id']);
            $info[$key]['post_count']   = $this->getMemberCount($info[$key]['forum_id']);
        }
        $this->ajaxReturn($info);
    }

}
