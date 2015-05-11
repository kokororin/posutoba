<?php
/**
 * @name 基类控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class BaseController extends Controller
{
    /**
     * @access public
     * @var 数据表名
     */
    public $table_name;

    /**
     * @access public
     * @var 登录用户id
     */

    /**
     * @access public
     * @var 用户id
     */
    public $uid;

    /**
     * 初始化方法
     * @access public
     */
    public function _initialize()
    {
        $this->table_name = $this->getTableName();
        $this->uid        = $this->decryptUid();
    }

    /**
     * 获取表名
     * @access private
     * @return array
     */
    private function getTableName()
    {
        $tables       = ['block_users', 'forum', 'forum_class', 'forum_fans', 'log', 'member_title', 'notify', 'post', 'related_forum', 'forum_sign', 'stored_thread', 'thread', 'thread_type', 'user_fans', 'users', 'uuid', 'user_status', 'user_visitor'];
        $table_name   = array();
        $table_prefix = C('DB_PREFIX');
        foreach ($tables as $value) {
            $table_name[$value] = $table_prefix . $value;
        }
        return $table_name;
    }

    /**
     * 是否登录并解密cookie
     * @access public
     * @return boolean
     */
    public function decryptUid()
    {
        if (cookie('posutoba')) {
            $uid     = cookie('posutoba');
            $uid_res = authCode($uid, 'DECODE');
            return $uid_res;
        } else {
            return null;
        }
    }
}
