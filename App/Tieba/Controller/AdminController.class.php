<?php
/**
 * @name 吧务控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class AdminController extends BaseController
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
     * 后台首页
     * @access public
     * @param string $id 贴吧id
     */
    public function index($id)
    {
        $this->getPublic();
        $member_count = A('Forum')->getMemberCount($id);
        $post_count   = A('Forum')->getPostCount($id);
        $forum_class  = A('Forum')->getForumClass($id);
        $census_data  = $this->getCensusData($id);
        $this->assign('member_count', $member_count);
        $this->assign('post_count', $post_count);
        $this->assign('class_name', $forum_class['class_name']);
        $this->assign('census_data', $census_data);
        $this->display();
    }

    /**
     * 验证权限
     * @access private
     * @param string $fid 贴吧id
     */
    private function checkAuthority($fid)
    {
        $uid = $this->uid;
        if ($uid == null) {
            $this->error('未登录！');
            return;
        }
        $manage_status = A('Forum')->getManageStatus($fid);
        $this->assign('manage_status', $manage_status);
        if ($manage_status == -1) {
            $this->error('权限验证失败！');
            return;
        }

    }

    /**
     * 获取公共部分
     * @access private
     */
    private function getPublic()
    {
        $fid = $_GET['id'];
        $this->checkAuthority($fid);
        $uid        = $this->uid;
        $user_info  = A('Home')->getBaseUserInfo($uid);
        $forum_list = $this->getForumList($uid);
        $forum_info = A('Forum')->getForumInfo($fid);
        $this->assign('user_info', $user_info);
        $this->assign('forum_list', $forum_list);
        $this->assign('forum_info', $forum_info);
    }

    /**
     * 获取管理的所有贴吧
     * @access private
     * @param string $uid 用户id
     * @return array
     */
    private function getForumList($uid)
    {
        $fm   = getTableName('forum_manager');
        $f    = getTableName('forum');
        $info = M('forum_manager')->field("{$f}.forum_name,{$fm}.forum_id")->join("{$f} ON {$fm}.forum_id = {$f}.forum_id")->where(array("{$fm}.user_id" => $uid))->select();
        return $info;
    }

    /**
     * 获取某天的统计数据
     * @access private
     * @param string $date 日期格式2015-02-01
     * @param string $fid 贴吧id
     * @return array
     */
    private function getCensusDataByDate($date, $fid)
    {
        $array['thread_count'] = M('thread')->where(array('thread_date' => array('like', $date . '%'), 'forum_id' => $fid))->count();
        $p                     = getTableName('post');
        $t                     = getTableName('thread');
        $array['post_count']   = M('post')->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->where(array("{$p}.post_date" => array('like', $date . '%'), "{$t}.forum_id" => $fid))->count() - $array['thread_count'];
        $array['sign_count']   = M('forum_sign')->where(array('sign_date' => array('like', $date . '%'), 'forum_id' => $fid))->count();
        $array['sign_ratio']   = number_format(($array['sign_count'] / $array['member_count']) * 100, 2);
        return $array;
    }

    /**
     * 获取总的统计数据
     * @access private
     * @param string $fid 贴吧id
     * @return array
     */
    private function getCensusData($fid)
    {
        //先把日期遍历到数组中方便调用
        for ($i = 0; $i < 30; $i++) {
            $days_30[$i] = date('Y-m-d', strtotime(' -' . $i . 'day'));
        }
        for ($i = 0; $i < 7; $i++) {
            $days_7[$i] = date('Y-m-d', strtotime(' -' . $i . 'day'));
        }
        for ($i = 0; $i < 2; $i++) {
            $days_2[$i] = date('Y-m-d', strtotime(' -' . $i . 'day'));
        }
        //30天数组开始
        foreach ($days_30 as $key => $value) {
            $all_data_30[$key] = $this->getCensusDataByDate($value, $fid);
        }
        //计算平均数
        foreach ($all_data_30 as $key => $value) {
            $thread_count_array_30[$key] = $all_data_30[$key]['thread_count'];
            $post_count_array_30[$key]   = $all_data_30[$key]['post_count'];
            $sign_count_array_30[$key]   = $all_data_30[$key]['sign_count'];
            $sign_ratio_array_30[$key]   = $all_data_30[$key]['sign_ratio'];
        }
        $array_30['thread_count'] = array_sum($thread_count_array_30);
        $array_30['post_count']   = array_sum($post_count_array_30);
        $array_30['sign_count']   = array_sum($sign_count_array_30);
        $array_30['sign_ratio']   = number_format(array_sum($sign_ratio_array_30) / 30, 2);
        //7天数组开始
        foreach ($days_7 as $key => $value) {
            $all_data_7[$key] = $this->getCensusDataByDate($value, $fid);
        }
        //计算平均数
        foreach ($all_data_7 as $key => $value) {
            $thread_count_array_7[$key] = $all_data_7[$key]['thread_count'];
            $post_count_array_7[$key]   = $all_data_7[$key]['post_count'];
            $sign_count_array_7[$key]   = $all_data_7[$key]['sign_count'];
            $sign_ratio_array_7[$key]   = $all_data_7[$key]['sign_ratio'];
        }
        $array_7['thread_count'] = array_sum($thread_count_array_7);
        $array_7['post_count']   = array_sum($post_count_array_7);
        $array_7['sign_count']   = array_sum($sign_count_array_7);
        $array_7['sign_ratio']   = number_format(array_sum($sign_ratio_array_7) / 7, 2);

        //2天数组开始
        foreach ($days_2 as $key => $value) {
            $array_2[$key]         = $this->getCensusDataByDate($value, $fid);
            $array_2[$key]['date'] = date('m月d日', strtotime($value));
        }

        //底部7天日期
        foreach ($days_7 as $key => $value) {
            $array['days_7'][$key] = date('m.d', strtotime($value));
        }
        //底部7天日期
        foreach ($days_30 as $key => $value) {
            $array['days_30'][$key] = date('m.d', strtotime($value));
        }
        //json数据
        $array['json']['days_7']  = newJson($array['days_7'], 1);
        $array['json']['days_30'] = newJson($array['days_30'], 1);
        foreach ($days_7 as $key => $value) {
            $array['not_json']['days_7'][$key] = $this->getCensusDataByDate($value, $fid);
        }
        foreach ($days_30 as $key => $value) {
            $array['not_json']['days_30'][$key] = $this->getCensusDataByDate($value, $fid);
        }
        foreach ($array['not_json']['days_7'] as $key => $value) {
            $array['not_json']['days_7']['thread_count'][$key] = $array['not_json']['days_7'][$key]['thread_count'];
            $array['not_json']['days_7']['post_count'][$key]   = $array['not_json']['days_7'][$key]['post_count'];
            $array['not_json']['days_7']['sign_count'][$key]   = $array['not_json']['days_7'][$key]['sign_count'];
            $array['not_json']['days_7']['sign_ratio'][$key]   = $array['not_json']['days_7'][$key]['sign_ratio'];
        }
        foreach ($array['not_json']['days_30'] as $key => $value) {
            $array['not_json']['days_30']['thread_count'][$key] = $array['not_json']['days_30'][$key]['thread_count'];
            $array['not_json']['days_30']['post_count'][$key]   = $array['not_json']['days_30'][$key]['post_count'];
            $array['not_json']['days_30']['sign_count'][$key]   = $array['not_json']['days_30'][$key]['sign_count'];
            $array['not_json']['days_30']['sign_ratio'][$key]   = $array['not_json']['days_30'][$key]['sign_ratio'];
        }
        $array['json']['days_7_thread_count']  = newJson($array['not_json']['days_7']['thread_count'], 2);
        $array['json']['days_7_post_count']    = newJson($array['not_json']['days_7']['post_count'], 2);
        $array['json']['days_7_sign_count']    = newJson($array['not_json']['days_7']['sign_count'], 2);
        $array['json']['days_7_sign_ratio']    = newJson($array['not_json']['days_7']['sign_ratio'], 2);
        $array['json']['days_30_thread_count'] = newJson($array['not_json']['days_30']['thread_count'], 2);
        $array['json']['days_30_post_count']   = newJson($array['not_json']['days_30']['post_count'], 2);
        $array['json']['days_30_sign_count']   = newJson($array['not_json']['days_30']['sign_count'], 2);
        $array['json']['days_30_sign_ratio']   = newJson($array['not_json']['days_30']['sign_ratio'], 2);

        $array[30] = $array_30;
        $array[7]  = $array_7;
        $array[2]  = $array_2;
        return $array;
    }

    /**
     * 数据统计
     * @access public
     * @param string $id 贴吧id
     * @param string $type 图表显示天数类型
     */
    public function censusData($id, $type = '')
    {
        $this->getPublic();
        $census_data  = $this->getCensusData($id);
        $member_count = A('Forum')->getMemberCount($id);
        $this->assign('census_data', $census_data);
        $this->assign('member_count', $member_count);
        $this->display();
    }

    /**
     * 贴子管理日志
     * @access public
     * @param string $id 贴吧id
     * @param string $action 操作名
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     */
    public function postLogList($id, $action = 'all', $username = '', $utype = '', $startTime = '', $endTime = '')
    {
        $this->getPublic();
        $log_list_array    = $this->getPostLogList($id, $action, $username, $utype, $startTime, $endTime);
        $log_list          = $log_list_array[0];
        $page              = $log_list_array[1];
        $log_count         = $log_list_array[2];
        $total_page        = $log_list_array[3];
        $action_name_array = $this->getLogType($action);
        $action_name       = $action_name_array['name'];
        $this->assign('log_list', $log_list);
        $this->assign('page', $page);
        $this->assign('log_count', $log_count);
        $this->assign('total_page', $total_page);
        $this->assign('action_name', $action_name);
        $this->display();
    }

    /**
     * 获取贴子管理日志
     * @access private
     * @param string $fid 贴吧id
     * @param string $action 操作名
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @return array
     */
    private function getPostLogList($fid, $action = 'all', $username, $utype, $startTime, $endTime)
    {
        $t                          = getTableName('thread');
        $p                          = getTableName('post');
        $l                          = getTableName('log');
        $u                          = getTableName('users');
        $condition["{$l}.forum_id"] = $fid;
        //公共join
        $join = "{$p} ON {$l}.object_id = {$p}.post_id";
        if ($action != 'all') {
            $condition["{$l}.log_type"] = $action;
        }
        if ($username != '') {
            $uid_array = M('users')->field('user_id')->where(array('user_name' => $username))->find();
            $uid_value = $uid_array['user_id'];
            if ($utype == 'post') {
                $condition["{$p}.user_id"] = $uid_value;
            } elseif ($utype == 'action') {
                $condition["{$l}.user_id"] = $uid_value;
            }

        }
        if ($startTime != '' && $endTime != '') {
            $condition["{$l}.log_date"] = array('between', array($startTime, $endTime));
        }
        $count = M('log')->join($join)->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 20, 'active', true);
        $show  = $Pager->show();
        $info  = M('log')->field("{$l}.log_type,{$l}.user_id as action_userid,user_log.user_name as action_username,{$l}.log_date,{$p}.post_content,{$p}.user_id,{$p}.post_date,user_post.user_name,{$t}.thread_title,{$t}.thread_id,{$p}.post_id,{$p}.floor_id")->join($join)
                         ->join("{$t} ON {$p}.thread_id = {$t}.thread_id")->join("{$u} as user_log ON {$l}.user_id = user_log.user_id")->join("{$u} as user_post ON {$p}.user_id = user_post.user_id")->where($condition)->order("{$l}.log_date desc")->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        foreach ($info as $key => $value) {
            $info[$key]['post_content_convert'] = A('Forum')->getThreadText($info[$key]['post_content'], 'post');
            $info[$key]['log_action']           = $this->getLogType($info[$key]['log_type']);
        }
        $array[0] = $info;
        $array[1] = $show;
        $array[2] = $count;
        $array[3] = $Pager->totalPages;
        return $array;
    }

    /**
     * 获取操作类型
     * @access private
     * @param string $type 英文类型
     * @return array
     */
    private function getLogType($type)
    {
        switch ($type) {
            case 'all':
                $array['name'] = '全部操作';
                break;
            case 'set-good':
                $array['name'] = '加精';
                $array['css']  = 'label_17';
                break;
            case 'cancel-good':
                $array['name'] = '取消加精';
                $array['css']  = 'label_18';
                break;
            case 'set-top':
                $array['name'] = '置顶';
                $array['css']  = 'label_25';
                break;
            case 'cancel-top':
                $array['name'] = '取消置顶';
                $array['css']  = 'label_26';
                break;
            case 'del-post':
                $array['name'] = '删贴';
                $array['css']  = 'label_12';
                break;
            case 'restore-post':
                $array['name'] = '恢复';
                $array['css']  = 'label_13';
                break;
            case 'block-user':
                $array['name'] = '封禁';
                break;
            case 'restore-block':
                $array['name'] = '解除封禁';
                break;
            case 'restore-black':
                $array['name'] = '取消黑名单';
                break;
            case 'black-user':
                $array['name'] = '加入黑名单';
                break;
        }
        return $array;
    }

    /**
     * 设置帖子类型
     * @access public
     * @param string $type 类型
     * @param string $tid 帖子id
     */
    public function setThreadType($type, $tid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid        = $this->uid;
        $forum_info = A('Post')->getForumInfoByTid($tid);
        $fid        = $forum_info['forum_id'];
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $old_type = A('Forum')->getThreadType($tid);
        switch ($type) {
            case 'set-good':
                if ($old_type == 'normal') {
                    $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'good');
                    $re_2 = $this->setLog($type, $tid, $fid);
                } else {
                    if (($old_type == 'good') || ($old_type == 'good,top')) {
                        $this->ajaxReturn('already-do');
                    } else {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'good,top');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    }
                }
                break;
            case 'cancel-good':
                if ($old_type == 'normal') {
                    $this->ajaxReturn('no-thread-type');
                } else {
                    if ($old_type == 'good') {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'normal');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    } elseif ($old_type == 'top') {
                        $this->ajaxReturn('invalid-thread-type');
                    } else {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'top');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    }
                }
                break;
            case 'set-top':
                $tt        = getTableName('thread_type');
                $t         = getTableName('thread');
                $top_count = M('thread_type')->join("{$t} ON {$tt}.thread_id = {$t}.thread_id")->where(array("{$t}.forum_id" => $fid, "{$tt}.thread_type" => array('in', array('top', 'good,top'))))->count();
                if ($top_count >= 2) {
                    $this->ajaxReturn('top-limit');
                }
                if ($old_type == 'normal') {
                    $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'top');
                    $re_2 = $this->setLog($type, $tid, $fid);
                } else {
                    if (($old_type == 'top') || ($old_type == 'good,top')) {
                        $this->ajaxReturn('already-do');
                    } else {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'good,top');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    }
                }
                break;
            case 'cancel-top':
                if ($old_type == 'normal') {
                    $this->ajaxReturn('no-thread-type');
                } else {
                    if ($old_type == 'top') {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'normal');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    } elseif ($old_type == 'good') {
                        $this->ajaxReturn('invalid-thread-type');
                    } else {
                        $re_1 = M('thread_type')->where(array('thread_id' => $tid))->setField('thread_type', 'good');
                        $re_2 = $this->setLog($type, $tid, $fid);
                    }
                }
                break;

        }
        if ($re_1 && $re_2) {
            $this->ajaxReturn('do-success');

        } else {
            $this->ajaxReturn('do-failure');
        }
    }

    /**
     * 管理帖子用户写日志
     * @access private
     * @param string $type 类型
     * @param string $obj_id 对象id
     * @param string $fid 贴吧id
     * @return object
     */
    private function setLog($type, $obj_id, $fid)
    {
        $data['data_id']   = getMikuInt();
        $data['log_type']  = $type;
        $data['object_id'] = $obj_id;
        $data['forum_id']  = $fid;
        $data['user_id']   = $this->uid;
        $data['log_date']  = getNowDate();
        $re                = M('log')->data($data)->add();
        return $re;
    }

    /**
     * 删除帖子
     * @access public
     * @param unknown $pid 帖子id
     */
    public function delPost($pid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid        = $this->uid;
        $forum_info = A('Post')->getForumInfoByPid($pid);
        $fid        = $forum_info['forum_id'];
        $tid        = A('Post')->getThreadId($pid);
        if (A('Forum')->getManageStatus($fid) == -1) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        //获取是主题还是帖子
        $floor_array = M('post')->field('floor_id')->where(array('post_id' => $pid))->find();
        $floor_id    = $floor_array['floor_id'];
        if ($floor_id == 1) {
            //置顶精品不能被删除
            $thread_type_array = M('thread_type')->field('thread_type')->where(array('thread_id' => $pid))->find();
            $thread_type       = $thread_type_array['thread_type'];
            if ($thread_type != 'normal') {
                $this->ajaxReturn('need-normal');
            } else {
                $re_1 = M('thread')->where(array('thread_id' => $pid))->setField('is_exist', 0);
                $re_2 = $this->setLog('del-post', $pid, $fid);
            }

        } else {
            $re_1 = M('post')->where(array('post_id' => $pid))->setField('is_exist', 0);
            $re_2 = $this->setLog('del-post', $pid, $fid);
        }
        if ($re_1 && $re_2) {
            $this->ajaxReturn('delete-success');
        } else {
            $this->ajaxReturn('already-delete');
        }

    }

    /**
     * 恢复帖子
     * @access public
     * @param string $pid 帖子id
     */
    public function restorePost($pid)
    {
        $forum_info = A('Post')->getForumInfoByPid($pid);
        $fid        = $forum_info['forum_id'];
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        //获取是主题还是帖子
        $floor_array = M('post')->field('floor_id')->where(array('post_id' => $pid))->find();
        $floor_id    = $floor_array['floor_id'];
        if ($floor_id == 1) {
            $is_exist_array = M('thread')->field('is_exist')->where(array('thread_id' => $pid))->find();
            $is_exist       = $is_exist_array['is_exist'];
            if ($is_exist == 1) {
                $this->ajaxReturn('already-restore');
            } else {
                $re_1 = M('thread')->where(array('thread_id' => $pid))->setField('is_exist', 1);
                $re_2 = $this->setLog('restore-post', $pid, $fid);
            }
        } else {
            $is_exist_array = M('post')->field('is_exist')->where(array('post_id' => $pid))->find();
            $is_exist       = $is_exist_array['is_exist'];
            if ($is_exist == 1) {
                $this->ajaxReturn('already-restore');
            } else {
                $re_1 = M('post')->where(array('post_id' => $pid))->setField('is_exist', 1);
                $re_2 = $this->setLog('restore-post', $pid, $fid);
            }

        }
        if ($re_1 && $re_2) {
            $this->ajaxReturn('restore-success');
        } else {
            $this->ajaxReturn('already-restore');
        }

    }

    /**
     * 封禁用户
     * @access public
     * @param string $fid 贴吧id
     * @param string $id 用户id
     * @param int $day 天数
     */
    public function blockUser($fid, $id, $day)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        if ($day != 1 && $day != 3 && $day != 10) {
            $this->ajaxReturn('invalid-day');
        } else {
            //先检测有无封禁情况
            $old_status = A('Forum')->getUserStatus($id, $fid);
            $uuid       = getMikuInt();
            $uuid_2     = getMikuInt();
            if ($old_status == 'normal') {
                $data_1['data_id']     = $uuid;
                $data_1['user_id']     = $id;
                $data_1['forum_id']    = $fid;
                $data_1['user_status'] = 'block';
                $re_1                  = M('user_status')->data($data_1)->add();
                $data_2['data_id']     = $uuid_2;
                $data_2['user_id']     = $id;
                $data_2['forum_id']    = $fid;
                $data_2['block_date']  = getNowDate();
                $data_2['block_days']  = $day;
                $re_2                  = M('block_users')->data($data_2)->add();
            } elseif ($old_status == 'block') {
                $re_1                 = 1;
                $data_2['data_id']    = $uuid_2;
                $data_2['user_id']    = $id;
                $data_2['forum_id']   = $fid;
                $data_2['block_date'] = getNowDate();
                $data_2['block_days'] = $day;
                $re_2                 = M('block_users')->data($data_2)->add();
            } elseif ($old_status == 'black') {
                $re_1                 = M('user_status')->where(array('user_id' => $id, 'forum_id' => $fid))->setField('user_status', 'block,black');
                $data_2['data_id']    = $uuid_2;
                $data_2['user_id']    = $id;
                $data_2['forum_id']   = $fid;
                $data_2['block_date'] = getNowDate();
                $data_2['block_days'] = $day;
                $re_2                 = M('block_users')->data($data_2)->add();
            } elseif ($old_status == 'block,black') {
                $re_1                 = 1;
                $data_2['data_id']    = $uuid_2;
                $data_2['user_id']    = $id;
                $data_2['forum_id']   = $fid;
                $data_2['block_date'] = getNowDate();
                $data_2['block_days'] = $day;
                $re_2                 = M('block_users')->data($data_2)->add();
            }
            $re_3 = $this->setLog('block-user', $uuid_2, $fid);
            if ($re_1 && $re_2 && $re_3) {
                $this->ajaxReturn('block-success');
            } else {
                $this->ajaxReturn('block-failure');
            }

        }
    }

    /**
     * 取消封禁
     * @access public
     * @param string $fid 贴吧id
     * @param string $uid 用户id
     */
    public function restoreBlock($fid, $uid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $old_status = A('Forum')->getUserStatus($uid, $fid);
        if (($old_status == 'normal') || ($old_status == 'black')) {
            $this->ajaxReturn('never-block');
        } elseif ($old_status == 'block') {
            $re_1 = M('user_status')->where(array('forum_id' => $fid, 'user_id' => $uid))->delete();
        } elseif ($old_status == 'block,black') {
            $re_1 = M('user_status')->where(array('forum_id' => $fid, 'user_id' => $uid))->setField('user_status', 'black');
        }
        $re_2 = $this->setLog('restore-block', $uid, $fid);
        if ($re_1 && $re_2) {
            $this->ajaxReturn('restore-success');
        } else {
            $this->ajaxReturn('restore-failure');
        }
    }

    /**
     * 取消黑名单
     * @access public
     * @param string $uid
     * @param string $fid
     */
    public function restoreBlack($uid, $fid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $old_status = A('Forum')->getUserStatus($uid, $fid);
        if (strpos($old_status, 'black') === false) {
            $this->ajaxReturn('never-black');
        } elseif ($old_status == 'black') {
            $re_1 = M('user_status')->where(array('forum_id' => $fid, 'user_id' => $uid))->delete();
        } elseif ($old_status == 'block,black') {
            $re_1 = M('user_status')->where(array('forum_id' => $fid, 'user_id' => $uid))->setField('user_status', 'block');
        }
        $re_2 = $this->setLog('restore-black', $uid, $fid);
        if ($re_1 && $re_2) {
            $this->ajaxReturn('restore-success');
        } else {
            $this->ajaxReturn('restore-failure');
        }

    }

    /**
     * 拉黑用户
     * @access public
     * @param string $fid 贴吧id
     * @param string $id 用户id
     */
    public function blackUser($fid, $id)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $old_status = A('Forum')->getUserStatus($id, $fid);
        if ($old_status == 'normal') {
            $data_1['data_id']     = getMikuInt();
            $data_1['user_id']     = $id;
            $data_1['forum_id']    = $fid;
            $data_1['user_status'] = 'black';
            $re_1                  = M('user_status')->data($data_1)->add();
        } elseif ($old_status == 'block') {
            $re_1 = M('user_status')->where(array('user_id' => $id, 'forum_id' => $fid))->setField('user_status', 'block,black');
        } else {
            $this->ajaxReturn('already-black');
        }
        $re_2 = $this->setLog('black-user', $id, $fid);
        if ($re_1 && $re_2) {
            $this->ajaxReturn('black-success');
        } else {
            $this->ajaxReturn('black-failure');
        }
    }

    /**
     * 删贴日志
     * @access public
     * @param unknown $id 贴吧id
     */
    public function postDelList($id, $username = '', $utype = '', $startTime = '', $endTime = '')
    {
        $this->getPublic();
        $del_list_array = $this->getPostLogList($id, $action = 'del-post', $username, $utype, $startTime, $endTime);
        $del_list       = $del_list_array[0];
        $page           = $del_list_array[1];
        $del_count      = $del_list_array[2];
        $total_page     = $del_list_array[3];
        $this->assign('del_list', $del_list);
        $this->assign('page', $page);
        $this->assign('del_count', $del_count);
        $this->assign('total_page', $total_page);
        $this->display();
    }

    /**
     * 会员列表
     * @access public
     * @param string $id 贴吧id
     * @param string $username 用户名
     */
    public function memberList($id, $username = '')
    {
        $this->getPublic();
        $member_list_array = A('Forum')->getMemberList($id, $username);
        $member_list       = $member_list_array[0];
        $page              = $member_list_array[1];
        $member_count      = $member_list_array[2];
        $total_page        = $member_list_array[3];
        $this->assign('member_list', $member_list);
        $this->assign('page', $page);
        $this->assign('member_count', $member_count);
        $this->assign('total_page', $total_page);
        $this->display();
    }

    /**
     * 用户封禁列表
     * @access public
     * @param string $id 贴吧id
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     */
    public function blockMemberList($id, $username = '', $utype = '', $startTime = '', $endTime = '')
    {
        $this->getPublic();
        $block_list = $this->getBlockMemberList($id, $username, $utype, $startTime, $endTime);
        $this->assign('block_list', $block_list);
        $this->display();
    }

    /**
     * 获取封禁列表
     * @access private
     * @param string $fid 贴吧id
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @return array
     */
    private function getBlockMemberList($fid, $username, $utype, $startTime, $endTime)
    {
        $u  = getTableName('users');
        $l  = getTableName('log');
        $bu = getTableName('block_users');

        $member_list = M('forum_fans')->field('fans_id')->where(array('forum_id' => $fid))->select();
        foreach ($member_list as $key => $value) {
            $member_small_list[$key] = $member_list[$key]['fans_id'];
        }
        foreach ($member_small_list as $key => $value) {
            $user_status = A('Forum')->getUserStatus($value, $fid);
            if (strpos($user_status, 'block') === false) {
                unset($member_small_list[$key]);
            }
        }
        if (count($member_small_list) == 0) {
            return null;
        }
        $condition["{$l}.log_type"] = 'block-user';
        $condition["{$bu}.user_id"] = array('in', $member_small_list);
        if ($username != '') {
            $uid_array = M('users')->field('user_id')->where(array('user_name' => $username))->find();
            $uid_value = $uid_array['user_id'];
            if ($utype == 'action') {
                $condition["{$l}.user_id"] = $uid_value;
            }

        }
        if ($startTime != '' && $endTime != '') {
            $condition["{$l}.log_date"] = array('between', array($startTime, $endTime));
        }
        $info = M('log')->field("user_block.user_id as block_userid,user_block.user_name as block_username,user_log.user_id as action_userid,user_log.user_name as action_username,{$bu}.block_date,{$bu}.block_days")->join("{$bu} ON {$l}.object_id = {$bu}.data_id")
                        ->join("{$u} as user_block ON {$bu}.user_id = user_block.user_id")->join("{$u} as user_log ON {$l}.user_id = user_log.user_id")->where($condition)->order("{$bu}.block_date desc")->select();
        $count = count($info);
        //进行倒序循环
        foreach ($info as $key => $value) {
            for ($i = $count; $i >= 0; $i--) {
                if ($info[$key]['block_userid'] == $info[$i]['block_userid'] && $key != $i) {
                    unset($info[$i]);
                }
            }
        }

        //这里采用数组搜索
        if ($username != '' && $utype = 'object') {
            foreach ($info as $key => $value) {
                if ($info[$key]['block_userid'] != $uid_value) {
                    unset($info[$key]);
                }
            }
        }
        //最后将key限制为30
        foreach ($info as $key => $value) {
            if ($count >= 30) {
                if ($key > 30) {
                    unset($info[$key]);
                }
            }
        }

        return $info;
    }

    /**
     * 黑名单列表
     * @access public
     * @param string $id 贴吧id
     * @param string $username 用户名
     */
    public function blackMemberList($id, $username = '')
    {
        $this->getPublic();
        $black_list_array = $this->getBlackMemberList($id, $username);
        $black_list       = $black_list_array[0];
        $page             = $black_list_array[1];
        $black_count      = $black_list_array[2];
        $total_page       = $black_list_array[3];
        $this->assign('black_list', $black_list);
        $this->assign('page', $page);
        $this->assign('black_count', $black_count);
        $this->assign('total_page', $total_page);
        $this->display();
    }

    /**
     * 获取黑名单列表
     * @access private
     * @param string $fid 贴吧id
     * @param string $username 用户名
     * @return array
     */
    private function getBlackMemberList($fid, $username = '')
    {
        $l  = getTableName('log');
        $u  = getTableName('users');
        $us = getTableName('user_status');

        $member_list = M('forum_fans')->field('fans_id')->where(array('forum_id' => $fid))->select();
        foreach ($member_list as $key => $value) {
            $member_small_list[$key] = $member_list[$key]['fans_id'];
        }
        foreach ($member_small_list as $key => $value) {
            $user_status = A('Forum')->getUserStatus($value, $fid);
            if (strpos($user_status, 'black') === false) {
                unset($member_small_list[$key]);
            }
        }
        if (count($member_small_list) == 0) {
            return null;
        }
        $condition["{$l}.log_type"]  = 'black-user';
        $condition["{$l}.forum_id"]  = $fid;
        $condition["{$l}.object_id"] = array('in', $member_small_list);
        if ($username != '') {
            $uid_array                   = M('users')->field('user_id')->where(array('user_name' => $username))->find();
            $uid_value                   = $uid_array['user_id'];
            $condition["{$l}.object_id"] = $uid_value;
        }
        $count = M('log')->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 20, 'active', true);
        $show  = $Pager->show();
        $info  = M('log')->field("user_log.user_name as action_username,user_log.user_id as action_userid,user_black.user_name as black_username,user_black.user_id as black_userid,{$l}.log_date")->join("{$u} as user_log ON {$l}.user_id = user_log.user_id")
                         ->join("{$u} as user_black ON {$l}.object_id = user_black.user_id")->where($condition)->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        $array[0] = $info;
        $array[1] = $show;
        $array[2] = $count;
        $array[3] = $Pager->totalPages;
        return $array;
    }

    /**
     * 用户管理日志
     * @access public
     * @param string $id 贴吧id
     * @param string $action 操作
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     */
    public function memberLogList($id, $action = 'all', $username = '', $utype = '', $startTime = '', $endTime = '')
    {
        $this->getPublic();
        $log_list_array    = $this->getMemberLogList($id, $action, $username, $utype, $startTime, $endTime);
        $log_list          = $log_list_array[0];
        $page              = $log_list_array[1];
        $log_count         = $log_list_array[2];
        $total_page        = $log_list_array[3];
        $action_name_array = $this->getLogType($action);
        $action_name       = $action_name_array['name'];
        $this->assign('log_list', $log_list);
        $this->assign('page', $page);
        $this->assign('log_count', $log_count);
        $this->assign('total_page', $total_page);
        $this->assign('action_name', $action_name);
        $this->display();
    }

    /**
     * 获取用户管理日志
     * @access private
     * @param string $fid 贴吧id
     * @param string $action 操作
     * @param string $username 用户名
     * @param string $utype 用户类型
     * @param string $startTime 开始时间
     * @param string $endTime 结束时间
     * @return array
     */
    private function getMemberLogList($fid, $action, $username, $utype, $startTime, $endTime)
    {
        $l                          = getTableName('log');
        $u                          = getTableName('users');
        $us                         = getTableName('user_status');
        $bu                         = getTableName('block_users');
        $condition["{$l}.forum_id"] = $fid;
        $condition["{$l}.log_type"] = array('in', array('block-user', 'black-user', 'restore-block', 'restore-black'));
        if ($action != 'all') {
            $condition["{$l}.log_type"] = $action;
        }
        if ($username != '') {
            $uid_array = M('users')->field('user_id')->where(array('user_name' => $username))->find();
            $uid_value = $uid_array['user_id'];
            if ($utype == 'action') {
                $condition["{$l}.user_id"] = $uid_value;
            }
        }
        if ($startTime != '' && $endTime != '') {
            $condition["{$l}.log_date"] = array('between', array($startTime, $endTime));
        }
        $count = M('log')->where($condition)->count();
        $Pager = new \Tieba\Library\Pager($count, 20, 'active', true);
        $show  = $Pager->show();
        $info  = M('log')->field("user_log.user_id as action_userid,user_log.user_name as action_username,{$l}.log_date,{$l}.log_type,{$l}.object_id")->join("{$u} as user_log ON {$l}.user_id = user_log.user_id")->where($condition)->order("{$l}.log_date desc")
                         ->limit($Pager->firstRow . ',' . $Pager->listRows)->select();
        foreach ($info as $key => $value) {
            $info[$key]['log_action'] = $this->getLogType($info[$key]['log_type']);
            if ($info[$key]['log_type'] == 'black-user') {
                $black_user_array        = M('users')->field('user_name')->where(array('user_id' => $info[$key]['object_id']))->find();
                $info[$key]['user_name'] = $black_user_array['user_name'];
                $info[$key]['user_id']   = $info[$key]['object_id'];
                $info[$key]['days']      = '永久';
            } elseif ($info[$key]['log_type'] == 'block-user') {
                $block_user_array        = M('block_users')->field("{$u}.user_id,{$u}.user_name,{$bu}.block_days")->join("{$u} ON {$bu}.user_id = {$u}.user_id")->where(array("{$bu}.data_id" => $info[$key]['object_id']))->order("{$bu}.block_date desc")->find();
                $info[$key]['user_name'] = $block_user_array['user_name'];
                $info[$key]['user_id']   = $block_user_array['user_id'];
                $info[$key]['days']      = $block_user_array['block_days'] . '天';
            } elseif (($info[$key]['log_type'] == 'restore-black') || ($info[$key]['log_type'] == 'restore-block')) {
                $black_user_array        = M('users')->field('user_name')->where(array('user_id' => $info[$key]['object_id']))->find();
                $info[$key]['user_name'] = $black_user_array['user_name'];
                $info[$key]['user_id']   = $info[$key]['object_id'];
                $info[$key]['days']      = '---';
            }
        }
        //这里采用数组搜索
        if ($username != '' && $utype = 'object') {
            foreach ($info as $key => $value) {
                if ($info[$key]['user_id'] != $uid_value) {
                    unset($info[$key]);
                }
            }
        }
        $array[0] = $info;
        $array[1] = $show;
        $array[2] = $count;
        $array[3] = $Pager->totalPages;
        return $array;
    }

    public function managerPendList($id)
    {
        $this->getPublic();
        $this->display();
    }

    /**
     * 本吧设置
     * @access public
     * @param string $id 贴吧id
     */
    public function adminTools($id)
    {
        $this->getPublic();

        for ($i = 1; $i <= 18; $i++) {
            $member_title[$i] = A('Forum')->getMemberTitle($id, $i);
        }
        $member_name        = A('Forum')->getMemberName($id);
        $related_forum_list = A('Forum')->getRelatedForumList($id);
        $forum_class        = A('Forum')->getForumClass($id);
        $this->assign('member_title', $member_title);
        $this->assign('member_name', $member_name);
        $this->assign('related_forum_list', $related_forum_list);
        $this->assign('forum_class', $forum_class);
        $this->display();
    }

    /**
     * 设置吧头衔
     * @access public
     */
    public function setMemberTitle()
    {

        $param        = I('post.');
        $info         = M('member_title')->where(array('forum_id' => $param['fid']))->find();
        $member_title = '';
        for ($i = 1; $i <= 18; $i++) {
            if (!preg_match('/[\x{4e00}-\x{9fa5}\w]+$/u', $param['member_title' . $i] . $param['member_name'])) {
                $this->ajaxReturn('invalid-name');
            }
            if (getUtf8Strlen($param['member_title' . $i]) > 8 && getUtf8Strlen($param['member_name']) > 8) {
                $this->ajaxReturn('invalid-length');
            }
            $member_title = $member_title . ',' . $param['member_title' . $i];
        }
        $member_title = trim($member_title, ',');
        if ($info == null) {
            $data['forum_id']     = $param['fid'];
            $data['member_name']  = $param['member_name'];
            $data['member_title'] = $member_title;
            $re                   = M('member_title')->data($data)->add();
        } else {
            $data['member_name']  = $param['member_name'];
            $data['member_title'] = $member_title;
            $re                   = M('member_title')->where(array('forum_id' => $param['fid']))->setField($data);
        }
        if ($re) {
            $this->ajaxReturn('set-success');
        } else {
            $this->ajaxReturn('no-data-update');
        }
    }

    /**
     * 添加友情贴吧
     * @access public
     * @param string $fid 贴吧id
     * @param string $fname 贴吧名
     */
    public function addRelatedForum($fid, $fname)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $old_count      = A('Forum')->getRelatedForumCount($fid);
        $forum_id_array = M('forum')->field('forum_id')->where(array('forum_name' => $fname))->find();
        if ($forum_id_array == null) {
            $this->ajaxReturn('invalid-forum');
        }
        $new_fid = $forum_id_array['forum_id'];
        if ($old_count <= 5) {
            $info = M('related_forum')->where(array('forum_id' => $fid, 'object_id' => $new_fid))->find();
            if ($info != null) {
                $this->ajaxReturn('already-add');
            } else {
                $data['data_id']   = getMikuInt();
                $data['forum_id']  = $fid;
                $data['object_id'] = $new_fid;
                $re                = M('related_forum')->data($data)->add();
            }
        } else {
            $this->ajaxReturn('only-five');
        }
        if ($re) {
            $this->ajaxReturn('add-success');
        } else {
            $this->ajaxReturn('add-failure');
        }
    }

    /**
     * 删除友情贴吧
     * @access public
     * @param string $fid 贴吧id
     * @param string $obj_id 要删除的贴吧id
     */
    public function deleteRelatedForum($fid, $obj_id)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $re = M('related_forum')->where(array('forum_id' => $fid, 'obj_id' => $obj_id))->delete();
        if ($re) {
            $this->ajaxReturn('del-success');
        } else {
            $this->ajaxReturn('del-failure');
        }
    }

    /**
     * 修改贴吧目录
     * @access public
     * @param string $fid 贴吧id
     * @param string $pid 父目录id
     * @param string $cid 子目录id
     */
    public function modifyForumClass($fid, $pid, $cid)
    {
        if ($this->uid == null) {
            $this->ajaxReturn('need-login');
            return;
        }
        $uid = $this->uid;
        if (A('Forum')->getManageStatus($fid) != 0) {
            $this->ajaxReturn('invalid-authority');
            return;
        }
        $data['class_id']  = $cid;
        $data['parent_id'] = $pid;
        $re                = M('forum')->where(array('forum_id' => $fid))->setField($data);
        if ($re) {
            $this->ajaxReturn('set-success');
        } else {
            $this->ajaxReturn('set-failure');
        }
    }

}
