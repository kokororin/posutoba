<?php
/**
 * @name 帖子页控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class PostController extends BaseController
{
    /**
     * 初始化父类
     * @access public
     * @see \Tieba\Controller\BaseController::_initialize()
     */
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 主页面
     * @access public
     * @param string $id 帖子id
     * @param int $see_lz 是否只看楼主
     */
    public function index($id, $see_lz = 0)
    {
        $thread_title    = $this->getThreadTitle($id);
        $post_list_array = $this->getPostList($id, $see_lz);
        $post_list       = $post_list_array[0];
        $page            = $post_list_array[1];
        $reply_count     = $post_list_array[2] - 1;
        $total_page      = $post_list_array[3];
        //贴吧信息
        $forum_info = $this->getForumInfoByTid($id);
        if (empty($post_list)) {
            $this->error('您要浏览的帖子不存在。');
            return;
        }
        $forum_id = $forum_info['forum_id'];
        A('Forum')->getPublic($forum_id);
        //区分是主题页还是回复页
        $thread_uid = $this->getThreadUid($id);
        $uid        = $this->uid;
        //$del_auth = $this->isHasAuthority($id);
        if ($this->getStoreStatus($id, $uid) == false) {
            $store_status = '收藏';
        } else {
            $store_status = '已收藏';
        }
        $this->assign('poster_type', 'addpost');
        $this->assign('forum_info', $forum_info);
        $this->assign('thread_title', $thread_title);
        $this->assign('thread_id', $id);
        $this->assign('thread_uid', $thread_uid);
        $this->assign('post_list', $post_list);
        $this->assign('page', $page);
        $this->assign('reply_count', $reply_count);
        $this->assign('total_page', $total_page);
        //$this->assign('del_auth', $del_auth);
        $this->assign('store_status', $store_status);
        $this->display();
    }

    /**
     * 发表回复
     * @access public
     */
    public function addPost()
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid        = $this->uid;
        $forum_info = $this->getForumInfoByTid(I('post.thread_id'));
        $fid        = $forum_info['forum_id'];
        if (A('Forum')->isPostable($uid, $fid) == false) {
            $this->ajaxReturn('block-status');
        }
        //获取楼层数
        $thread_id = I('post.thread_id');
        //获取主题作者
        $thread_uid            = $this->getThreadUid($thread_id);
        $floor_count           = A('Forum')->getFloorCount($thread_id);
        $data['post_id']       = getMikuInt();
        $data['thread_id']     = $thread_id;
        $data['user_id']       = $uid;
        $data['post_content']  = I('post.content');
        $data['post_date']     = getNowDate();
        $data['reply_post_id'] = I('post.replyid');
        $data['floor_id']      = $floor_count + 1;
        $data['is_exist']      = 1;
        if ($data['post_content'] == '') {
            $this->ajaxReturn('content-empty');
            return;
        }
        $re = M('post')->data($data)->add();
        if ($thread_uid != ($data['user_id'])) {
            //添加到提醒表
            $data_2['notify_id']   = getMikuInt();
            $data_2['object_id']   = $data['post_id'];
            $data_2['notify_type'] = 'reply';
            $data_2['is_read']     = 0;
            if ($data['reply_post_id'] == '0') {
                //回复的是楼主
                $data_2['user_id'] = $thread_uid;
            } else {
                //回复的是层主
                $post_uid = $this->getPostUid($data['reply_post_id']);
                if ($post_uid == $data['user_id']) {
                    if ($re) {
                        $this->ajaxReturn('post-success');
                    } else {
                        $this->ajaxReturn('post-failure');
                    }
                    return;
                } else {
                    $data_2['user_id'] = $post_uid;
                }

            }
            $re_2 = M('notify')->data($data_2)->add();
        }
        if ($re) {
            $this->ajaxReturn('post-success');
        } else {
            $this->ajaxReturn('post-failure');
        }

    }

    /**
     * 获取回复列表
     * @access private
     * @param string $tid 帖子id
     * @param int $see_lz 是否只看楼主
     * @return array
     */
    private function getPostList($tid, $see_lz = 0)
    {
        $p                           = getTableName('post');
        $t                           = getTableName('thread');
        $u                           = getTableName('users');
        $condition["{$p}.thread_id"] = $tid;
        $condition["{$p}.is_exist"]  = 1;
        if ($see_lz == 1) {
            //先获得楼主的id
            $info_2                    = M('thread')->field("user_id")->where(array('thread_id' => $tid))->find();
            $thread_user_id            = $info_2['user_id'];
            $condition["{$p}.user_id"] = $thread_user_id;
        }
        $count = M('post')->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 30, 'tP', false);
        $show  = $Pager->show();
        //获取帖子所属的贴吧信息
        $forum_info = $this->getForumInfoByTid($tid);
        $forum_id   = $forum_info['forum_id'];

        $info = M('post')->field("{$p}.post_id,{$p}.thread_id,{$p}.user_id,{$p}.post_content,{$p}.post_date,{$p}.reply_post_id,{$p}.floor_id,{$u}.user_name")->join("{$u} ON {$p}.user_id = {$u}.user_id")->where($condition)->order('post_date')->limit($Pager->firstRow . ',' . $Pager->listRows)
            ->select();
        foreach ($info as $key => $value) {
            $info[$key]['reply_content']        = $this->getReply($info[$key]['reply_post_id']);
            $info[$key]['level_css']            = $this->getLevel($info[$key]['user_id'], $forum_id, 'css');
            $info[$key]['level_level']          = $this->getLevel($info[$key]['user_id'], $forum_id, 'level');
            $info[$key]['level_exp']            = $this->getLevel($info[$key]['user_id'], $forum_id, 'exp');
            $info[$key]['post_content_convert'] = $this->convertPostContent($info[$key]['post_content']);
            $info[$key]['member_title']         = A('Forum')->getMemberTitle($forum_id, $info[$key]['level_level']);
        }
        $array[0] = $info;
        $array[1] = $show;
        $array[2] = $count;
        $array[3] = $Pager->totalPages;
        return $array;
    }

    /**
     * 获取帖子标题
     * @access private
     * @param string $tid 帖子id
     * @return string
     */
    private function getThreadTitle($tid)
    {
        $title = M('thread')->field('thread_title')->where(array('thread_id' => $tid))->find();
        return $title['thread_title'];
    }

    /**
     * 获取主题作者
     * @access private
     * @param string $tid 主题id
     * @return string
     */
    private function getThreadUid($tid)
    {
        $info = M('thread')->field('user_id')->where(array('thread_id' => $tid))->find();
        return $info['user_id'];
    }

    /**
     * 通过帖子id获取主题id
     * @access public
     * @param string $pid 帖子id
     * @return array
     */
    public function getThreadId($pid)
    {
        $info = M('post')->field('thread_id')->where(array('post_id' => $pid))->find();
        return $info['thread_id'];
    }

    /**
     * 获取当前用户是否具有删贴权限
     * @access public
     * @param string $pid
     * @return boolean
     */
    /* public function isHasAuthority($pid) {
    $uid = $this->uid;
    if ($uid == null) {
    return false;
    } else {
    if ($uid == $this->getThreadUid($tid)) {
    return true;
    } else {
    return false;
    }
    }

    } */

    /**
     * 获取帖子作者
     * @access private
     * @param string $pid 帖子id
     * @return string
     */
    private function getPostUid($pid)
    {
        $info = M('post')->field('user_id')->where(array('post_id' => $pid))->find();
        return $info['user_id'];
    }

    /**
     * 转换帖子内容
     * @access private
     * @param string $cont 原内容
     * @return string
     */
    private function convertPostContent($cont)
    {
        $_name = array("呵呵", "哈哈", "吐舌", "啊", "酷", "怒", "开心", "汗", "泪", "黑线", "鄙视", "不高兴", "真棒", "钱", "疑问", "阴险", "吐", "咦", "委屈", "花心", "呼", "笑眼", "冷", "太开心", "滑稽", "勉强", "狂汗", "乖", "睡觉", "惊哭", "生气", "惊讶", "喷", "爱心", "心碎", "玫瑰", "礼物", "彩虹", "星星月亮", "太阳", "钱币", "灯泡", "茶杯", "蛋糕", "音乐", "haha", "胜利",
            "大拇指", "弱", "OK");

        foreach ($_name as $key => $value) {
            $name[$key] = '[emo]' . $value . '[/emo]';
        }
        foreach ($name as $key => $value) {
            $_key = $key + 1;
            $cont = str_replace($value, '<img src="' . __ROOT__ . '/Public/common/images/emo/' . $_key . '.png' . '"/>', $cont);
            $cont = preg_replace("/\[img\](.+?)\[\/img\]/is", '<a target="_blank" href="' . __ROOT__ . '/Public/uploads/forum_images/\\1' . '"><img class="BDE_Image" src=' . __ROOT__ . '/Public/uploads/forum_images/\\1></a>', $cont);
        }
        return nl2br($cont);
    }

    /**
     * 通过主题id获取贴吧信息
     * @access public
     * @param string $tid 帖子id
     * @return array
     */
    public function getForumInfoByTid($tid)
    {
        $f    = getTableName('forum');
        $t    = getTableName('thread');
        $info = M('thread')->field("{$f}.forum_id,{$f}.forum_name")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where(array("{$t}.thread_id" => $tid))->find();
        return $info;
    }

    /**
     * 通过帖子id获取贴吧信息
     * @access public
     * @param string $pid 帖子id
     * @return array
     */
    public function getForumInfoByPid($pid)
    {
        $f    = getTableName('forum');
        $t    = getTableName('thread');
        $p    = getTableName('post');
        $info = M('post')->field("{$f}.forum_id,{$f}.forum_name")->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where(array("{$p}.post_id" => $pid))->find();
        return $info;
    }

    /**
     * 获取帖子的楼层引用（回复）
     * @access private
     * @param string $rid 回复的帖子id
     * @return string
     */
    private function getReply($rid)
    {
        $u = getTableName('users');
        $p = getTableName('post');
        if ($rid != '0') {
            $info = M('post')->field("{$p}.user_id,{$u}.user_name,{$p}.post_content,{$p}.floor_id")->join("{$u} ON {$p}.user_id = {$u}.user_id")->where(array("{$p}.post_id" => $rid))->find();
            $html = '<blockquote class="d_quote"><fieldset><legend> 回复 <a class="at j_user_card" data-uid="' . $info['user_id'] . '" target="_blank" href="' . U('Home/main') . '"/id/' . $info['user_id'] . '>@' . $info['user_name'] . '</a> (' . $info['floor_id']
            . '楼) </legend>
               <p class="quote_content">' . $info['post_content'] . '</p></fieldset></blockquote>';
            return $html;
        } else {
            return;
        }
    }

    /**
     * ajax获取引用内容
     * @access public
     * @param string $pid 楼层id
     */
    public function getQuote($pid)
    {
        $info = $this->getReply($pid);
        $this->ajaxReturn($info);
    }

    /**
     * 获取楼层的用户等级
     * @access private
     * @param string $uid 用户id
     * @param string $forum_id 贴吧id
     * @param string $cont 要获得的参数名
     * @return string
     */
    private function getLevel($uid, $forum_id, $cont)
    {
        $info = A('Home')->getLevel($uid, $forum_id);
        $exp  = A('Home')->getExp($uid, $forum_id);
        switch ($cont) {
            case 'css':
                return $info[1];
                break;
            case 'level':
                return $info[0];
                break;
            case 'exp';
                return $exp;
                break;
        }
    }

    /**
     * 收藏帖子
     * @access public
     * @param string $tid 帖子id
     */
    public function storeThread($tid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
        }
        $uid          = $this->uid;
        $store_status = $this->getStoreStatus($tid, $uid);
        if ($store_status == null) {
            $data['data_id']     = getMikuInt();
            $data['user_id']     = $uid;
            $data['thread_id']   = $tid;
            $data['stored_date'] = getNowDate();
            $re                  = M('stored_thread')->data($data)->add();
            $this->ajaxReturn('do-success');
        } else {
            $re = M('stored_thread')->where(array('thread_id' => $tid, 'user_id' => $uid))->delete();
            $this->ajaxReturn('do-success');
        }
    }

    /**
     * 获取帖子收藏状态
     * @access private
     * @param stirng $tid
     * @param string $uid
     * @return boolean
     */
    private function getStoreStatus($tid, $uid)
    {
        $info = M('stored_thread')->where(array('thread_id' => $tid, 'user_id' => $uid))->find();
        if ($info == null) {
            return false;
        } else {
            return true;
        }
    }

}
