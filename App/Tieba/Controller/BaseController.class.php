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
     * @var 用户id
     */
    public $uid;

    /**
     * 初始化方法
     * @access public
     */
    public function _initialize()
    {
        $this->uid = $this->decryptUid();
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
