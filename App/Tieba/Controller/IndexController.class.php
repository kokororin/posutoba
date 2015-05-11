<?php
/**
 *
 *
 * @name 首页控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class IndexController extends BaseController
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
     * 首页
     * @access public
     */
    public function index()
    {
        $uid = $this->uid;
        if ($uid != null) {
            $forum_list = A('Home')->getForumList($uid);
            $this->assign('forum_list', $forum_list);
        }
        $thread_list = $this->getThreadList();
        $hot_forum_list = $this->getHotForumList();
        $hot_thread_list = $this->getHotThreadList();
        $interest_num = $this->getInterestNum();
        $slide_list = $this->getThreadHasImgList();
        $class_list = $this->getForumClassList();
        $notice_list = $this->getNoticeList();
        $this->assign('interest_num', $interest_num);
        $this->assign('thread_list', $thread_list);
        $this->assign('hot_forum_list', $hot_forum_list);
        $this->assign('hot_thread_list', $hot_thread_list);
        $this->assign('slide_list', $slide_list);
        $this->assign('class_list', $class_list);
        $this->assign('notice_list', $notice_list);
        $this->display();
    }

    /**
     * 上方兴趣吧
     * @access private
     * @return string
     */
    private function getInterestNum()
    {
        $forum_count = A('Forum')->getForumCount();
        $length = strlen($forum_count);
        for ($i = 0; $i < $length; $i++) {
            $divide[$i] = substr($forum_count, $i, 1);
        }
        switch ($length) {
            case 1:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss(0);
                $cont['c'] = $this->getInterestNumCss(0);
                $cont['d'] = $this->getInterestNumCss(0);
                $cont['e'] = $this->getInterestNumCss(0);
                $cont['f'] = $this->getInterestNumCss(0);
                $cont['g'] = $this->getInterestNumCss($divide[0]);
                break;
            case 2:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss(0);
                $cont['c'] = $this->getInterestNumCss(0);
                $cont['d'] = $this->getInterestNumCss(0);
                $cont['e'] = $this->getInterestNumCss(0);
                $cont['f'] = $this->getInterestNumCss($divide[0]);
                $cont['g'] = $this->getInterestNumCss($divide[1]);
                break;
            case 3:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss(0);
                $cont['c'] = $this->getInterestNumCss(0);
                $cont['d'] = $this->getInterestNumCss(0);
                $cont['e'] = $this->getInterestNumCss($divide[0]);
                $cont['f'] = $this->getInterestNumCss($divide[1]);
                $cont['g'] = $this->getInterestNumCss($divide[2]);
                break;
            case 4:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss(0);
                $cont['c'] = $this->getInterestNumCss(0);
                $cont['d'] = $this->getInterestNumCss($divide[0]);
                $cont['e'] = $this->getInterestNumCss($divide[1]);
                $cont['f'] = $this->getInterestNumCss($divide[2]);
                $cont['g'] = $this->getInterestNumCss($divide[3]);
                break;
            case 5:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss(0);
                $cont['c'] = $this->getInterestNumCss($divide[0]);
                $cont['d'] = $this->getInterestNumCss($divide[1]);
                $cont['e'] = $this->getInterestNumCss($divide[2]);
                $cont['f'] = $this->getInterestNumCss($divide[3]);
                $cont['g'] = $this->getInterestNumCss($divide[4]);
                break;
            case 6:
                $cont['a'] = $this->getInterestNumCss(0);
                $cont['b'] = $this->getInterestNumCss($divide[0]);
                $cont['c'] = $this->getInterestNumCss($divide[1]);
                $cont['d'] = $this->getInterestNumCss($divide[2]);
                $cont['e'] = $this->getInterestNumCss($divide[3]);
                $cont['f'] = $this->getInterestNumCss($divide[4]);
                $cont['g'] = $this->getInterestNumCss($divide[5]);
                break;
            case 7:
                $cont['a'] = $this->getInterestNumCss($divide[0]);
                $cont['b'] = $this->getInterestNumCss($divide[1]);
                $cont['c'] = $this->getInterestNumCss($divide[2]);
                $cont['d'] = $this->getInterestNumCss($divide[3]);
                $cont['e'] = $this->getInterestNumCss($divide[4]);
                $cont['f'] = $this->getInterestNumCss($divide[5]);
                $cont['g'] = $this->getInterestNumCss($divide[6]);
                break;
        }
        return $cont;

    }

    /**
     * 获取兴趣吧css
     * @access private
     * @param int $int 数字
     * @return string
     */
    private function getInterestNumCss($int)
    {
        switch ($int) {
            case 1:
                $css = 'background-position: -2px -29px';
                break;
            case 2:
                $css = 'background-position: -2px -56px';
                break;
            case 3:
                $css = 'background-position: -2px -83px';
                break;
            case 4:
                $css = 'background-position: -2px -110px';
                break;
            case 5:
                $css = 'background-position: -2px -137px';
                break;
            case 6:
                $css = 'background-position: -2px -164px';
                break;
            case 7:
                $css = 'background-position: -2px -191px';
                break;
            case 8:
                $css = 'background-position: -2px -218px';
                break;
            case 9:
                $css = 'background-position: -2px -245px';
                break;
            case 0:
                $css = 'background-position: -2px -272px';
                break;
        }
        return $css;
    }

    /**
     * 获取中部主题
     * @access private
     * @return array
     */
    private function getThreadList()
    {
        $f = getTableName('forum');
        $t = getTableName('thread');
        $p = getTableName('post');
        $u = getTableName('users');
        $info = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$t}.user_id,{$u}.user_name,{$p}.post_content,{$p}.post_date,{$t}.forum_id,{$f}.forum_name")->join("{$p} ON {$t}.thread_id = {$p}.thread_id")->join("{$u} ON {$t}.user_id = {$u}.user_id")
            ->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where(array("{$p}.floor_id" => 1, "{$t}.is_exist" => 1))->order("{$p}.post_date desc")->select();
        foreach ($info as $key => $value) {
            $info[$key]['reply_count'] = A('Forum')->getReplyCount($info[$key]['thread_id']);
            $info[$key]['last_date'] = A('Forum')->getLastDate($info[$key]['thread_id']);
            $info[$key]['post_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content']);
            $info[$key]['thread_image'] = A('Home')->getThreadImg($info[$key]['post_content']);
            $info[$key]['forum_class'] = A('Forum')->getForumClass($info[$key]['forum_id']);
            $info[$key]['style_id'] = mt_rand(0, 4);
        }
        return $info;
    }

    /**
     * 贴吧推荐
     * @access public
     * @return array
     */
    public function getHotForumList()
    {
        $uid = $this->uid;
        $info = M('forum')->field('forum_id,forum_name,forum_desc')->order('rand()')->limit(10)->select();
        foreach ($info as $key => $value) {
            if (A('Forum')->isLikeForum($info[$key]['forum_id'], $uid) == false) {
                $info[$key]['concern_btn_css'] = 'pii_focus';
            } else {
                $info[$key]['concern_btn_css'] = 'pii_focus_d';
            }
        }
        return $info;

    }

    /**
     * 贴吧精选
     * @access private
     * @return array
     */
    private function getHotThreadList()
    {
        $info = M('thread')->field('thread_title,thread_id')->order('rand()')->limit(5)->select();
        return $info;
    }

    /**
     * 获取有图的帖子
     * @access public
     * @return string
     */
    public function getThreadHasImgList()
    {
        $t = getTableName('thread');
        $p = getTableName('post');
        $info = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$p}.post_content")->join("{$p} ON {$t}.thread_id = {$p}.thread_id")->where(array("{$p}.floor_id" => 1, "{$t}.is_exist" => 1, "{$p}.post_content" => array('like', '%[img]%[/img]%')))->order("{$p}.post_date desc")->limit(6)
            ->select();
        foreach ($info as $key => $value) {
            $info[$key]['thread_image'] = $this->getThreadImg($info[$key]['post_content']);
        }
        return $info;
    }

    /**
     * 提取帖子内容中的图片
     * @access private
     * @param string $cont 原内容
     * @return string
     */
    private function getThreadImg($cont)
    {
        preg_match('/\[img\](.+?)\[\/img\]/is', $cont, $matches);
        $img_name = $matches[1];
        $img_url = __ROOT__ . '/Public/uploads/forum_images/' . $img_name;
        return $img_url;
    }

    /**
     * 获取贴吧目录列表
     * @access private
     * @return array
     */
    private function getForumClassList()
    {
        $parent_id_arr = M('forum_class')->distinct(true)->field('parent_id')->where(array('class_icon' => array('neq', '')))->select();
        foreach ($parent_id_arr as $key => $value) {
            $parent_id[$key] = $parent_id_arr[$key]['parent_id'];
        }
        $limit = array(6, 6, 6, 6, 6, 9, 8, 6, 9, 6, 11, 9, 7);
        foreach ($parent_id as $key => $value) {
            $info[$key] = M('forum_class')->where(array('parent_id' => $value))->limit($limit[$key])->select();
        }
        return $info;
    }

    /**
     * 获取公告
     * @access private
     * @return array
     */
    private function getNoticeList()
    {
        $info = M('thread')->where(array('forum_id' => '1925784', 'user_id' => '19254'))->order('thread_date desc')->limit(5)->select();
        return $info;
    }

}
