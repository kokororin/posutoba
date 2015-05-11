<?php
/**
 *
 *
 * @name 用户主控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class HomeController extends BaseController
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
     * @param string $id 用户id
     */
    public function main($id)
    {
        $user_info    = $this->getUserInfo($id);
        $forum_list   = $this->getForumList($id);
        $fans_list    = $this->getFansList($id);
        $concern_list = $this->getConcernList($id);
        $visitor_list = $this->getVisitorList($id);
        $this->assign('visitor_list', $visitor_list);
        $this->assign('fans_list', $fans_list);
        $this->assign('concern_list', $concern_list);
        $this->assign('forum_list', $forum_list);
        $this->assign('user_info', $user_info);
        if ($this->uid != null) {
            $uid = $this->uid;
            if ($uid == $id) {
                //自己的主页
                $thread_list = $this->getLikedThreadList($id);
                $this->assign('thread_list', $thread_list);
                $this->display('myhome');
            } else {
                $this->getOthersMain($id);
            }
        } else {
            $this->getOthersMain($id);
        }

    }

    /**
     * 获取其他人主页
     * @access private
     * @param string $id 用户id
     */
    private function getOthersMain($id)
    {
        //访问主页
        if ($this->uid != null) {
            $this->visitUser($id);
            $uid = $this->uid;
        }
        //关注按钮
        if ($this->getLikeStatus($id, $uid) == false) {
            $concern_btn_css = 'btn_concern';
        } else {
            $concern_btn_css = 'btn_concern_done';
        }

        $this->assign('concern_btn_css', $concern_btn_css);
        $post_list = $this->getPostList($id);
        $this->assign('post_list', $post_list);
        $this->display('others');

    }

    /**
     * 获取用户信息用于显示首页
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getUserInfo($uid)
    {
        $info = $this->getBaseUserInfo($uid);
        unset($info['user_age'], $info['user_pass'], $info['user_avatar'], $info['user_regdate']);
        $info['user_age']      = $this->getAge($uid);
        $info['post_count']    = $this->getPostCount($uid);
        $info['fans_count']    = $this->getFansCount($uid);
        $info['concern_count'] = $this->getConcernCount($uid);
        $info['user_sex']      = $this->getSex($uid);
        if ($info['user_sex'] == 'female') {
            $info['user_sex_cn']   = '女';
            $info['user_sex_pron'] = '她';
        } else {
            $info['user_sex_cn']   = '男';
            $info['user_sex_pron'] = '他';
        }
        return $info;
    }

    /**
     * 获取用户基本信息
     * @access public
     * @param string $uid 用户id
     * @return array
     */
    public function getBaseUserInfo($uid)
    {
        $info = M('users')->where(array('user_id' => $uid))->find();
        return $info;
    }

    /**
     * 获取贴吧列表
     * @access public
     * @param string $uid 用户id
     * @param boolean $page 是否分页
     * @return array
     */
    public function getForumList($uid, $page = false)
    {
        $f                          = $this->table_name['forum'];
        $ff                         = $this->table_name['forum_fans'];
        $condition["{$ff}.fans_id"] = $uid;
        if ($page == true) {
            $count = M('forum_fans')->where($condition)->count();
            $Pager = new \Tieba\Library\Pager($count, 20, 'current', false);
            $show  = $Pager->show();
            $info  = M('forum_fans')->join("{$f} ON {$ff}.forum_id = {$f}.forum_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        } else {
            $info = M('forum_fans')->join("{$f} ON {$ff}.forum_id = {$f}.forum_id")->where($condition)->select();
        }
        foreach ($info as $key => $value) {
            $level_array                 = $this->getLevel($uid, $info[$key]['forum_id']);
            $info[$key]['level_level']   = $level_array[0];
            $info[$key]['level_css']     = $level_array[1];
            $info[$key]['exp']           = $this->getExp($uid, $info[$key]['forum_id']);
            $info[$key]['manage_status'] = A('Forum')->getManageStatus($info[$key]['forum_id']);
            $info[$key]['member_title']  = A('Forum')->getMemberTitle($info[$key]['forum_id'], $info[$key]['level_level']);
            if (A('Forum')->isSigned($uid, $info[$key]['forum_id']) == true) {
                $info[$key]['sign_status'] = 'sign';
            } else {
                $info[$key]['sign_status'] = 'unsign';
            }
        }
        $res = sortArray($info, 'exp', 'desc');
        if ($page == true) {
            $array[0] = $res;
            $array[1] = $show;
            return $array;
        } else {
            return $res;
        }
    }

    /**
     * 获取性别
     * @access private
     * @param string $uid 用户id
     * @return string
     */
    private function getSex($uid)
    {
        $info = $this->getBaseUserInfo($uid);
        if ($info['user_sex'] == 0) {
            return 'female';
        } else {
            return 'male';
        }
    }

    /**
     * 获取吧龄
     * @access private
     * @param string $uid 用户id
     * @return string
     */
    private function getAge($uid)
    {
        $info  = $this->getBaseUserInfo($uid);
        $minus = time() - strtotime($info['user_regdate']);
        return number_format($minus / 24 / 3600 / 365, 1);
    }

    /**
     * 获取发帖数
     * @access private
     * @param string $uid 用户id
     * @return int
     */
    private function getPostCount($uid)
    {
        $info = M('post')->where(array('user_id' => $uid))->count();
        return $info;
    }

    /**
     * 编辑资料
     * @access public
     * @param string $id 用户id
     */
    public function profile($id)
    {
        $this->checkAuthority();
        $user_info = $this->getUserInfo($id);
        $this->assign('user_info', $user_info);
        $this->display();
    }

    /**
     * 上传头像
     * @access public
     */
    public function uploadImg()
    {
        $upload           = new \Think\Upload();
        $upload->maxSize  = 1 * 1024 * 1024;
        $upload->exts     = array('jpg', 'png', 'gif');
        $upload->replace  = true;
        $upload->saveName = getRandChar(30);
        $upload->autoSub  = false;
        $path             = './Public/uploads/user_avatar/';
        $upload->rootPath = $path;
        $info             = $upload->upload();
        if (!$info) {
            // 上传错误提示错误信息
            $this->ajaxReturn('', $upload->getError(), 0, 'json');
        } else {
            // 上传成功 获取上传文件信息
            $temp_size = getimagesize($path . $info['user_avatar']['savename']);
            //判断宽和高是否符合头像要求
            if ($temp_size[0] < 100 || $temp_size[1] < 100) {
                $this->ajaxReturn(0, '图片宽或高不得小于100px！', 0, 'json');
            }
            $data['picName'] = $info['user_avatar']['savename'];
            $data['status']  = 1;
            $data['url']     = __ROOT__ . '/Public/uploads/user_avatar/' . $data['picName'];
            $data['info']    = $info;
            $this->ajaxReturn($data, 'json');
        }
    }

    /**
     * 裁剪并保存用户头像
     * @access public
     */
    public function setProfile()
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        //图片裁剪数据
        $params = I('post.'); //裁剪参数
        if (!isset($params) && empty($params)) {
            $this->ajaxReturn('set-failure');
        }
        $sex = $params['sex'];
        if ($sex != 0 && $sex != 1) {
            $this->ajaxReturn('empty-sex');
        }
        $re_1 = M('users')->where(array('user_id' => $uid))->setField('user_sex', $sex);
        if ($params['src'] != '') {
            //头像目录地址
            $path     = './Public/uploads/user_avatar/';
            $pic_name = $params['picName'];
            //要保存的图片
            $real_path = $path . $pic_name;
            //临时图片地址
            $pic_path  = $path . $pic_name;
            $Think_img = new \Think\Image();
            //裁剪原图
            $Think_img->open($pic_path)->crop($params['w'], $params['h'], $params['x'], $params['y'])->thumb(110, 110)->save($real_path);
            //把文件名插入数据库
            $re_2 = M('users')->where(array('user_id' => $uid))->setField('user_avatar', $pic_name);
        }

        $this->ajaxReturn('set-success');

    }

    /**
     * 获取用户头像
     * @access public
     * @param string $uid 用户id
     */
    public function getAvatar($uid)
    {
        header("Content-type: image/png");
        $info = M('users')->field('user_avatar')->where(array('user_id' => $uid))->find();
        if ($info['user_avatar'] == '0') {
            $url = './Public/common/images/user_avatar_default.jpg';
        } else {
            $url = './Public/uploads/user_avatar/' . $info['user_avatar'];
        }
        readfile($url);
    }

    /**
     * 获取用户名片信息
     * @access public
     * @param string $uid 用户id
     */
    public function getPanel($uid)
    {
        $info = $this->getUserInfo($uid);
        $this->ajaxReturn($info);
    }

    /**
     * 获取用户经验
     * @access public
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return int
     */
    public function getExp($uid, $fid)
    {
        $t = $this->table_name['thread'];
        $p = $this->table_name['post'];
        //主题贴
        $thread_count = M('thread')->where(array('user_id' => $uid, 'forum_id' => $fid))->count();
        //回复贴
        $post_count = M('post')->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->where(array("{$p}.user_id" => $uid, "{$t}.forum_id" => $fid))->count() - $thread_count;
        //主题被回复次数
        $reply_count = M('post')->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->where(array("{$p}.user_id" => array('neq', $uid), "{$t}.forum_id" => $fid, "{$t}.user_id" => $uid))->count();
        //经验=主题数*5+回复数×2+被回复数*3
        $exp = $thread_count * 5 + $post_count * 2 + $reply_count * 3;
        return $exp;
    }

    /**
     * 获取等级
     * @access public
     * @param string $uid 用户id
     * @param string $fid 贴吧id
     * @return int
     */
    public function getLevel($uid, $fid)
    {
        $exp = $this->getExp($uid, $fid);
        switch (true) {
            case ($exp >= 0 && $exp < 5):
                $level  = 1;
                $css    = '1';
                $maxexp = 5;
                break;
            case ($exp >= 5 && $exp < 15):
                $level  = 2;
                $css    = '1';
                $maxexp = 15;
                break;
            case ($exp >= 15 && $exp < 30):
                $level  = 3;
                $css    = '1';
                $maxexp = 30;
                break;
            case ($exp >= 30 && $exp < 50):
                $level  = 4;
                $css    = '2';
                $maxexp = 50;
                break;
            case ($exp >= 50 && $exp < 100):
                $level  = 5;
                $css    = '2';
                $maxexp = 100;
                break;
            case ($exp >= 100 && $exp < 200):
                $level  = 6;
                $css    = '2_1';
                $maxexp = 200;
                break;
            case ($exp >= 200 && $exp < 500):
                $level  = 7;
                $css    = '2_1';
                $maxexp = 500;
                break;
            case ($exp >= 500 && $exp < 1000):
                $level  = 8;
                $css    = '2_2';
                $maxexp = 1000;
                break;
            case ($exp >= 1000 && $exp < 2000):
                $level  = 9;
                $css    = '2_3';
                $maxexp = 2000;
                break;
            case ($exp >= 2000 && $exp < 3000):
                $level  = 10;
                $css    = '3';
                $maxexp = 3000;
                break;
            case ($exp >= 3000 && $exp < 6000):
                $level  = 11;
                $css    = '3';
                $maxexp = 6000;
                break;
            case ($exp >= 6000 && $exp < 10000):
                $level  = 12;
                $css    = '3';
                $maxexp = 10000;
                break;
            case ($exp >= 10000 && $exp < 18000):
                $level  = 13;
                $css    = '3';
                $maxexp = 18000;
                break;
            case ($exp >= 18000 && $exp < 30000):
                $level  = 14;
                $css    = '3';
                $maxexp = 30000;
                break;
            case ($exp >= 30000 && $exp < 60000):
                $level  = 15;
                $css    = '3';
                $maxexp = 60000;
                break;
            case ($exp >= 60000 && $exp < 100000):
                $level  = 16;
                $css    = '4';
                $maxexp = 100000;
                break;
            case ($exp >= 100000 && $exp < 300000):
                $level  = 17;
                $css    = '4';
                $maxexp = 300000;
                break;
            case ($exp >= 300000):
                $level  = 18;
                $css    = '4';
                $maxexp = 999999;
                break;
        }

        $array[0] = $level;
        $array[1] = $css;
        $array[2] = $maxexp;
        return $array;

    }

    /**
     * 获取回帖记录
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getPostList($uid)
    {
        $p    = $this->table_name['post'];
        $t    = $this->table_name['thread'];
        $f    = $this->table_name['forum'];
        $info = M('post')->field("{$p}.post_id,{$p}.thread_id,{$p}.user_id,{$p}.post_content,{$p}.post_date,{$p}.floor_id,{$t}.thread_title,{$t}.forum_id,{$f}.forum_name")->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")
                         ->where(array("{$p}.user_id" => $uid, "{$p}.is_exist" => 1))->order("{$p}.post_date desc")->select();
        foreach ($info as $key => $value) {
            $info[$key]['thread_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content']);
            $info[$key]['post_content_convert']   = A('Forum')->getThreadText($info[$key]['post_content'], 'post');
            $info[$key]['thread_image']           = $this->getThreadImg($info[$key]['post_content']);
        }
        return $info;
    }

    /**
     * 获取关注状态
     * @access private
     * @param string $cur_uid 被关注用户
     * @param string $obj_uid 关注发起者
     * @return boolean
     */
    private function getLikeStatus($cur_uid, $obj_uid)
    {
        //cur_uid是否被obj_uid关注
        $info = M('user_fans')->where(array('user_id' => $cur_uid, 'fans_id' => $obj_uid))->find();
        if ($info == null) {
            return false; //没有关注
        } else {
            return true;
        }

    }

    /**
     * 前台关注用户按钮
     * @access public
     * @param string $id
     */
    public function doLikeUser($id)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if ($this->getLikeStatus($id, $uid) == false) {
            $this->likeUser($id);
        } else {
            $this->dislikeUser($id);
        }
    }

    /**
     * 关注用户
     * @access private
     * @param string $id 用户id
     */
    private function likeUser($id)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if ($uid == $id) {
            $this->ajaxReturn('permit-like-self');
            return;
        }
        //查找是否关注过该用户
        $info = M('user_fans')->where(array('user_id' => $id))->find();
        if ($info['fans_id'] != $uid) {
            $data['data_id'] = getMikuInt();
            $data['user_id'] = $id;
            $data['fans_id'] = $uid;
            $re              = M('user_fans')->data($data)->add();
            //写入提醒表
            $data_2['notify_id']   = getMikuInt();
            $data_2['object_id']   = $data['fans_id'];
            $data_2['notify_type'] = 'fans';
            $data_2['is_read']     = 0;
            $data_2['user_id']     = $data['user_id'];
            $re_2                  = M('notify')->data($data_2)->add();
            if ($re && $re_2) {
                $this->ajaxReturn('do-success');
            } else {
                $this->ajaxReturn('do-failure');
            }
        } else {
            $this->ajaxReturn('already-liked');
        }

    }

    /**
     * 取消关注用户
     * @access private
     * @param string $id 用户id
     */
    private function dislikeUser($id)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid  = $this->uid;
        $info = M('user_fans')->where(array('user_id' => $id, 'fans_id' => $uid))->find();
        if ($info == null) {
            $this->ajaxReturn('never-liked');
        } else {
            $data_id = $info['data_id'];
            $re      = M('user_fans')->where(array('data_id' => $data_id))->delete();
            if ($re) {
                $this->ajaxReturn('do-success');
            } else {
                $this->ajaxReturn('do-failure');
            }
        }

    }

    /**
     * 获取关注列表
     * @access private
     * @param string $uid 用户id
     * @param boolean $page 是否分页
     * @return array
     */
    private function getConcernList($uid, $page = false)
    {
        if ($this->uid != null) {
            $logined_uid = $this->uid;
        }
        $u                          = $this->table_name['users'];
        $uf                         = $this->table_name['user_fans'];
        $condition["{$uf}.fans_id"] = $uid;
        if ($page == true) {
            $count = M('user_fans')->where($condition)->count();
            $Pager = new \Tieba\Library\Pager($count, 20, 'cur', false);
            $show  = $Pager->show();
            $info  = M('user_fans')->field("{$uf}.user_id,{$u}.user_name")->join("{$u} ON {$uf}.user_id     = {$u}.user_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
            foreach ($info as $key => $value) {
                $info[$key]['fans_count']    = $this->getFansCount($info[$key]['user_id']);
                $info[$key]['concern_count'] = $this->getConcernCount($info[$key]['user_id']);
            }
            $array[0] = $info;
            $array[1] = $show;
            return $array;
        } elseif ($page == false) {
            $info = M('user_fans')->field('user_id')->where($condition)->select();
            return $info;
        }

    }

    /**
     * 获取关注数
     * @access private
     * @param string $uid 用户id
     * @return int
     */
    private function getConcernCount($uid)
    {
        $info  = $this->getConcernList($uid);
        $count = count($info);
        return $count;
    }

    /**
     * 获取粉丝列表
     * @access private
     * @param string $uid 用户id
     * @param boolean $page 是否分页
     * @return array
     */
    private function getFansList($uid, $page = false)
    {
        if ($this->uid != null) {
            $logined_uid = $this->uid;
        }
        $u                          = $this->table_name['users'];
        $uf                         = $this->table_name['user_fans'];
        $condition["{$uf}.user_id"] = $uid;
        if ($page == true) {
            $count = M('user_fans')->where($condition)->count();
            $Pager = new \Tieba\Library\Pager($count, 20, 'cur', false);
            $show  = $Pager->show();
            $info  = M('user_fans')->field("{$uf}.fans_id,{$u}.user_name")->join("{$u} ON {$uf}.fans_id     = {$u}.user_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
            foreach ($info as $key => $value) {
                $info[$key]['fans_count']    = $this->getFansCount($info[$key]['fans_id']);
                $info[$key]['concern_count'] = $this->getConcernCount($info[$key]['fans_id']);
                if ($this->getLikeStatus($info[$key]['fans_id'], $logined_uid) == false) {
                    $info[$key]['btn_css'] = 'btn_follow';
                } else {
                    $info[$key]['btn_css'] = 'btn_followed';
                }
            }
            $array[0] = $info;
            $array[1] = $show;
            return $array;
        } elseif ($page == false) {
            $info = M('user_fans')->field('fans_id')->where($condition)->select();
            return $info;
        }

    }

    /**
     * 获取粉丝数
     * @access private
     * @param string $uid 用户id
     * @return int
     */
    private function getFansCount($uid)
    {
        $info  = $this->getFansList($uid);
        $count = count($info);
        return $count;
    }

    /**
     * 关注页面
     * @access public
     * @param string $id 用户id
     */
    public function concernList($id)
    {
        $user_info          = $this->getUserInfo($id);
        $concern_list_array = $this->getConcernList($id, true);
        $concern_list       = $concern_list_array[0];
        $page               = $concern_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('concern_list', $concern_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 粉丝页面
     * @access public
     * @param string $id 用户id
     */
    public function fansList($id)
    {
        $user_info = $this->getUserInfo($id);
        $this->clearNotify('fans');
        $fans_list_array = $this->getFansList($id, true);
        $fans_list       = $fans_list_array[0];
        $page            = $fans_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('fans_list', $fans_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 访问用户的主页
     * @access private
     * @param string $id 用户id
     */
    private function visitUser($id)
    {
        if ($this->uid == null) {
            return;
        }
        $uid                = $this->uid;
        $data['data_id']    = getMikuInt();
        $data['user_id']    = $id;
        $data['visitor_id'] = $uid;
        //先查看是否访问过
        $info = M('user_visitor')->where(array('user_id' => $id, 'visitor_id' => $uid))->find();
        //获取总来访数
        $info_2        = M('user_visitor')->field("max(visitor_order)")->where(array('user_id' => $id))->find();
        $visitor_count = $info_2['max(visitor_order)'];
        //没有访问过
        if ($info == null) {
            //要插入表中的来访次序
            $data['visitor_order'] = $visitor_count + 1;
            $re_1                  = M('user_visitor')->data($data)->add();
        } else {
            //来访过
            //获取当前访客之前的次序
            $info_3        = M('user_visitor')->field('visitor_order')->where(array('user_id' => $id, 'visitor_id' => $uid))->find();
            $current_order = $info_3['visitor_order'];
            //将在他之后来访的人的次序-1
            $re_2 = M('user_visitor')->where(array('user_id' => $id, 'visitor_order' => array('gt', $current_order)))->setDec('visitor_order');
            //再把当前访客的次序设置为最大
            $re_3 = M('user_visitor')->where(array('user_id' => $id, 'visitor_id' => $uid))->setField('visitor_order', $visitor_count);
        }
    }

    /**
     * 获取访客列表
     * @access private
     * @param string $id 用户id
     * @return array
     */
    private function getVisitorList($id)
    {
        $info = M('user_visitor')->where(array('user_id' => $id))->order('visitor_order desc')->select();
        return $info;
    }

    /**
     * 获取提醒数目
     * @access public
     */
    public function getNotifyCount()
    {
        if ($this->uid != null) {
            $uid = $this->uid;
        }
        $info['fans']  = intval(M('notify')->where(array('user_id' => $uid, 'notify_type' => 'fans', 'is_read' => 0))->count());
        $info['reply'] = intval(M('notify')->where(array('user_id' => $uid, 'notify_type' => 'reply', 'is_read' => 0))->count());
        $info['all']   = intval(M('notify')->where(array('user_id' => $uid, 'is_read' => 0))->count());
        $this->ajaxReturn($info);
    }

    /**
     * 检测权限
     * @access private
     */
    private function checkAuthority()
    {
        $id = $_GET['id'];
        if ($this->uid == null) {
            redirect(__ROOT__);
        }
        $uid = $this->uid;
        if ($uid != $id) {
            redirect(U('Home/main', array('id' => $uid)));
        }
    }

    /**
     * 我的回复提醒
     * @access public
     * @param string $id 用户id
     */
    public function replyMe($id)
    {
        $this->checkAuthority();
        $this->clearNotify('reply');
        $user_info        = $this->getUserInfo($id);
        $reply_list_array = $this->getReplyList($id);
        $reply_list       = $reply_list_array[0];
        $page             = $reply_list_array[1];
        $this->assign('reply_list', $reply_list);
        $this->assign('page', $page);
        $this->assign('user_info', $user_info);
        $this->display();
    }

    /**
     * 清除提醒
     * @access private
     * @param string $type 提醒类型
     */
    private function clearNotify($type)
    {
        $uid = $this->uid;
        $re  = M('notify')->where(array('notify_type' => $type, 'user_id' => $uid))->setField('is_read', 1);
    }

    /**
     * 获取回复列表
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getReplyList($uid)
    {
        $t                             = $this->table_name['thread'];
        $p                             = $this->table_name['post'];
        $u                             = $this->table_name['users'];
        $n                             = $this->table_name['notify'];
        $f                             = $this->table_name['forum'];
        $condition["{$n}.notify_type"] = 'reply';
        $condition["{$n}.user_id"]     = $uid;
        $count                         = M('notify')->where($condition)->count();
        $Pager                         = new \Tieba\Library\Pager($count, 20, 'current', false);
        $show                          = $Pager->show();
        $info                          = M('notify')->field("{$p}.post_id,{$u}.user_name,{$p}.user_id,{$p}.thread_id,{$t}.thread_title,{$p}.post_date,{$p}.post_content,{$t}.thread_title,{$t}.forum_id,{$f}.forum_name")->join("{$p} ON {$n}.object_id = {$p}.post_id")->join("{$u} ON {$p}.user_id = {$u}.user_id")
                                                    ->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->order("{$p}.post_date desc")->select();
        foreach ($info as $key => $value) {
            $info[$key]['post_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content'], 'post');
        }
        $array[0] = $info;
        $array[1] = $show;
        return $array;
    }

    /**
     * 获取热门动态
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getLikedThreadList($uid)
    {
        $f          = $this->table_name['forum'];
        $t          = $this->table_name['thread'];
        $p          = $this->table_name['post'];
        $u          = $this->table_name['users'];
        $forum_list = $this->getForumList($uid);
        foreach ($forum_list as $key => $value) {
            $small_forum_list[$key] = $forum_list[$key]['forum_id'];
        }
        if (empty($small_forum_list)) {
            return null;
        }
        $info = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$t}.user_id,{$u}.user_name,{$p}.post_content,{$p}.post_date,{$t}.forum_id,{$f}.forum_name")->join("{$p} ON {$t}.thread_id = {$p}.thread_id")->join("{$u} ON {$t}.user_id = {$u}.user_id")
                           ->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where(array("{$p}.floor_id" => 1, "{$t}.is_exist" => 1, "{$t}.forum_id" => array('in', $small_forum_list)))->order("{$p}.post_date desc")->select();
        foreach ($info as $key => $value) {
            $info[$key]['reply_count']          = A('Forum')->getReplyCount($info[$key]['thread_id']);
            $info[$key]['last_date']            = A('Forum')->getLastDate($info[$key]['thread_id']);
            $info[$key]['post_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content']);
            $info[$key]['thread_image']         = $this->getThreadImg($info[$key]['post_content']);
        }
        return $info;
    }

    /**
     * 获取主题的图片缩略图
     * @access public
     * @param string $cont 原内容
     * @return string
     */
    public function getThreadImg($cont)
    {
        $img_count = preg_match_all('/\[img\](.+?)\[\/img\]/is', $cont, $matches);
        if ($img_count >= 3) {
            $img_count = 3;
        }
        for ($i = 0; $i < $img_count; $i++) {
            $img_name[$i] = $matches[1][$i];
        }
        if ($img_count != 0) {
            //生成拼接的li块数组
            $li_html_start = '<li class="threadlist_pic_li"><img style="height: 90px;" title="点击查看大图" src="';
            $li_html_end   = '" class="m_pic"/>';
            //最终的li块
            $li_html_final = '';
            for ($i = 0; $i < $img_count; $i++) {
                $img_src[$i]   = __ROOT__ . '/Public/uploads/forum_images/' . $img_name[$i];
                $li_html[$i]   = $li_html_start . $img_src[$i] . '" data-order="' . $i . $li_html_end;
                $li_html_final = $li_html_final . $li_html[$i];
            }
            $html = '<ul class="n_media n_img clearfix">' . $li_html_final . '</ul>';
        } else {
            $html = '';
        }
        return $html;
    }

    /**
     * 关注的贴吧
     * @access public
     * @param string $id 用户id
     */
    public function forumList($id)
    {
        $this->checkAuthority();
        $user_info        = $this->getUserInfo($id);
        $forum_list_array = $this->getForumList($id, $page = true);
        $forum_list       = $forum_list_array[0];
        $page             = $forum_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('forum_list', $forum_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 收藏的帖子
     * @access public
     * @param string $id 用户id
     */
    public function storedThread($id)
    {
        $this->checkAuthority();
        $user_info         = $this->getUserInfo($id);
        $thread_list_array = $this->getStoredThreadList($id);
        $thread_list       = $thread_list_array[0];
        $page              = $thread_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('thread_list', $thread_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 获取收藏的帖子列表
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getStoredThreadList($uid)
    {
        $f                          = $this->table_name['forum'];
        $t                          = $this->table_name['thread'];
        $st                         = $this->table_name['stored_thread'];
        $u                          = $this->table_name['users'];
        $condition["{$st}.user_id"] = $uid;
        $count                      = M('stored_thread')->where($condition)->count();
        $Pager                      = new \Tieba\Library\Pager($count, 20, 'current', false);
        $show                       = $Pager->show();
        $info                       = M('stored_thread')->field("{$st}.thread_id,{$st}.stored_date,{$t}.thread_title,{$f}.forum_name,{$t}.forum_id,{$t}.user_id,{$u}.user_name")->join("{$t} ON {$st}.thread_id = {$t}.thread_id")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->join("{$u} ON {$t}.user_id = {$u}.user_id")
                                                        ->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->order("{$st}.stored_date desc")->select();
        $array[0] = $info;
        $array[1] = $show;
        return $array;
    }

    /**
     * 我的主题
     * @access public
     * @param string $id 用户id
     */
    public function threadList($id)
    {
        $this->checkAuthority();
        $user_info         = $this->getUserInfo($id);
        $thread_list_array = $this->getThreadList($id);
        $thread_list       = $thread_list_array[0];
        $page              = $thread_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('thread_list', $thread_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 获取主题列表
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getThreadList($uid)
    {
        $t                         = $this->table_name['thread'];
        $f                         = $this->table_name['forum'];
        $condition["{$t}.user_id"] = $uid;
        $count                     = M('thread')->where($condition)->count();
        $Pager                     = new \Tieba\Library\Pager($count, 20, 'cur', false);
        $show                      = $Pager->show();
        $info                      = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$t}.thread_date,{$f}.forum_name,{$f}.forum_id")->join("{$f} ON {$t}.forum_id     = {$f}.forum_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->order("{$t}.thread_date desc")->select();
        foreach ($info as $key => $value) {
            $info[$key]['reply_count'] = A('Forum')->getReplyCount($info[$key]['thread_id']);
        }
        $array[0] = $info;
        $array[1] = $show;
        return $array;
    }

    /**
     * 我的回复
     * @access public
     * @param string $id 用户id
     */
    public function replyList($id)
    {
        $this->checkAuthority();
        $user_info        = $this->getUserInfo($id);
        $reply_list_array = $this->getReplyPostList($id);
        $reply_list       = $reply_list_array[0];
        $page             = $reply_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('reply_list', $reply_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 获取回复列表
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getReplyPostList($uid)
    {
        $p                          = $this->table_name['post'];
        $t                          = $this->table_name['thread'];
        $f                          = $this->table_name['forum'];
        $condition["{$p}.user_id"]  = $uid;
        $condition["{$p}.is_exist"] = 1;
        $condition["{$p}.floor_id"] = array('neq', 1);
        $count                      = M('post')->where($condition)->count();
        $Pager                      = new \Tieba\Library\Pager($count, 20, 'cur', false);
        $show                       = $Pager->show();
        $info                       = M('post')->field("{$p}.post_id,{$p}.thread_id,{$p}.post_content,{$p}.post_date,{$t}.thread_title,{$t}.forum_id,{$f}.forum_name")->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->where($condition)->order("{$p}.post_date desc")
                                               ->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        foreach ($info as $key => $value) {
            $info[$key]['post_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content'], 'post');
            $info[$key]['reply_count']          = A('Forum')->getReplyCount($info[$key]['thread_id']);
        }
        $array[0] = $info;
        $array[1] = $show;
        return $array;
    }

    /**
     * 我的精品
     * @access public
     * @param string $id 用户id
     */
    public function goodList($id)
    {
        $this->checkAuthority();
        $user_info       = $this->getUserInfo($id);
        $good_list_array = $this->getGoodList($id);
        $good_list       = $good_list_array[0];
        $page            = $good_list_array[1];
        $this->assign('user_info', $user_info);
        $this->assign('good_list', $good_list);
        $this->assign('page', $page);
        $this->display();
    }

    /**
     * 获取精品列表
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getGoodList($uid)
    {
        $tt                             = $this->table_name['thread_type'];
        $t                              = $this->table_name['thread'];
        $l                              = $this->table_name['log'];
        $u                              = $this->table_name['users'];
        $f                              = $this->table_name['forum'];
        $condition["{$t}.user_id"]      = $uid;
        $condition["{$tt}.thread_type"] = array('in', array('good', 'good,top'));
        $condition["{$l}.log_type"]     = 'set-good';
        $join1                          = "{$tt} ON {$t}.thread_id = {$tt}.thread_id";
        $join2                          = "{$l} ON {$t}.thread_id = {$l}.object_id";
        $count                          = M('thread')->join($join1)->join($join2)->where($condition)->count();
        $Pager                          = new \Tieba\Library\Pager($count, 20, 'cur', false);
        $show                           = $Pager->show();
        $info                           = M('thread')->field("{$t}.thread_id,{$t}.thread_title,{$t}.forum_id,{$f}.forum_name,{$l}.log_date,{$l}.user_id,{$u}.user_name")->join($join1)->join($join2)->join("{$f} ON {$t}.forum_id = {$f}.forum_id")->join("{$u} ON {$l}.user_id = {$u}.user_id")->where($condition)
                                                     ->group("{$l}.object_id")->order("{$l}.log_date desc")->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        $array[0] = $info;
        $array[1] = $show;
        return $array;

    }

}
