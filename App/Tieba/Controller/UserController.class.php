<?php
/**
 * @name 用户分控制器
 * @author Kokororin <ritsuka.sunny@gmail.com>
 * @copyright (c) 2014-2015 http://return.moe All rights reserved.
 * @version 1.0
 */
namespace Tieba\Controller;

use Think\Controller;

class UserController extends BaseController
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
     * 登录
     * @access public
     */
    public function login()
    {
        $username = I('post.username');
        $password = md5(I('post.password'));
        $info     = M('users')->where(array('user_name' => $username))->find();
        if ($info != null) {
            if ($info['user_pass'] == $password) {
                cookie('posutoba', authCode($info['user_id'], 'ENCODE'), 60 * 60 * 24 * 365);
                $this->ajaxReturn('login-success');
            } else {
                $this->ajaxReturn('password-error');
            }
        } else {
            $this->ajaxReturn('no-user');
        }

    }

    /**
     * 注销
     * @access public
     */
    public function logout()
    {
        cookie('posutoba', null);
        $this->ajaxReturn('logout-success');
    }

    /**
     * 注册页面
     * @access public
     */
    public function register()
    {
        if (isset($_GET['key'])) {
            $key   = $_GET['key'];
            $array = json_decode(base64_decode($key), true);
            $this->assign('qq', $array);
        }

        $this->display();
    }

    /**
     * 注册
     * @access public
     */
    public function doRegister()
    {
        $param    = I('post.');
        $username = $param['username'];
        $password = $param['password'];
        $code     = $param['verifyCode'];
        if ($username == '') {
            $this->ajaxReturn('empty-username');
        }
        if ((preg_match("/[ '.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $username))) {
            $this->ajaxReturn('invalid-username');
        }
        if (A('Base')->getUtf8Strlen($username) > 12) {
            $this->ajaxReturn('too-long-username');
        }
        $info = M('users')->where(array('user_name' => $username))->find();
        if ($info != null) {
            $this->ajaxReturn('username-exist');
        }
        if (strlen($password) < 6 || strlen($password) > 30) {
            $this->ajaxReturn('invalid-password');
        }
        if ($this->checkVerifyCode($code) == false) {
            $this->ajaxReturn('error-code');
        }
        $data['user_name']    = $username;
        $data['user_pass']    = md5($password);
        $data['user_id']      = A('Base')->getMikuInt();
        $data['user_sex']     = 1;
        $data['user_avatar']  = 0;
        $data['user_regdate'] = A('Base')->getDate();
        $data['user_openid']  = $param['openid'];
        $re                   = M('users')->data($data)->add();
        if ($re) {
            $this->ajaxReturn('register-success');
        } else {
            $this->ajaxReturn('register-error');
        }
    }

    /**
     * 验证码
     * @access public
     */
    public function verifyCode()
    {
        $config = array('fontSize' => 50, 'length' => 4, 'useNoise' => false, 'useCurve' => false, 'fontttf' => '4.ttf');
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    /**
     * 检测验证码正确
     * @access private
     * @param string $code 验证码
     * @param string $id 验证码id
     * @return boolean
     */
    private function checkVerifyCode($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 注册成功跳转
     * @access public
     * @param string $u url
     */
    public function registerSuccess($u = null)
    {
        if ($u == null) {
            $url = __ROOT__ . '/';
        } else {
            $url = base64_decode($u);
        }
        redirect($url);
    }

    /**
     * qq验证
     * @access public
     */
    public function qqAuth()
    {
        $qq = new \Tieba\Library\Connect();
        $qq->getAuthCode();
    }

    /**
     * qq回调地址
     * @access public
     */
    public function qqCallback()
    {
        $qq     = new \Tieba\Library\Connect();
        $result = $qq->getUsrInfo();
        $info   = M('users')->where(array('user_openid' => $result['open_id']))->find();
        if (empty($info)) {
            $array['qq_avatar']   = $result['figureurl_2'];
            $array['qq_username'] = $result['nickname'];
            $array['qq_openid']   = $result['open_id'];
            $key                  = base64_encode(json_encode($array));
            $this->redirect(U('User/register', array('key' => $key)));
        } else {
            cookie('posutoba', $this->encryptCookie($info['user_id'], $this->encrypt_key), 60 * 60 * 24 * 365);
            redirect(__ROOT__ . '/');
        }
    }

    /**
     * 忘记密码
     * @access public
     * @param int $step 步骤id
     */
    public function forgetPassword($step = 1)
    {
        switch ($step) {
            case 1:

                break;
            case 2:

                break;
            case 3:
                if (!isset($_GET['key'])) {
                    $this->error('不存在或已经被点击过！');
                }
                $key = $_GET['key'];
                $this->assign('key', $key);
                $info = M('password_key')->where(array('key' => $key))->find();
                if (empty($info)) {
                    $this->error('不存在或已经被点击过！');
                } else {
                    $user_id   = $info['user_id'];
                    $user_info = A('Home')->getBaseUserInfo($user_id);
                    $this->assign('user_info', $user_info);
                }
                break;
        }
        $this->assign('step', $step);
        $this->display();
    }

    /**
     * 处理忘记密码表单
     * @access public
     */
    public function doForgetPassword()
    {
        $param     = I('post.');
        $user_name = $param['username'];
        $code      = $param['verifyCode'];
        if ($this->checkVerifyCode($code) == false) {
            $this->ajaxReturn('error-code');
        }
        $info = M('users')->field('user_id,user_name,user_email')->where(array('user_name' => $user_name))->find();
        if (empty($info)) {
            $this->ajaxReturn('no-username');
        } else {
            $user_email = $info['user_email'];
            $user_id    = $info['user_id'];
            if ($this->sendMail($user_email, $user_name, $user_id)) {
                $this->ajaxReturn('send-success');
            } else {
                $this->ajaxReturn('send-failure');
            }
        }
    }

    /**
     * 重置密码表单
     * @access public
     */
    public function resetPassword()
    {
        $param     = I('post.');
        $password  = $param['password'];
        $verifypwd = $param['verifypwd'];
        $key       = $param['key'];
        $info      = M('password_key')->where(array('key' => $key))->find();
        if (empty($info)) {
            $this->ajaxReturn('invalid-key');
        }
        $user_id = $info['user_id'];
        echo $user_id;
        if ($password == '') {
            $this->ajaxReturn('empty-password');
        }
        if ($verifypwd == '') {
            $this->ajaxReturn('empty-verifypwd');
        }
        if (strlen($password) < 6 || strlen($password) > 30) {
            $this->ajaxReturn('invalid-password');
        }
        if ($password != $verifypwd) {
            $this->ajaxReturn('diff-password');
        }
        $re_1 = M('users')->where(array('user_id' => $user_id))->setField('user_pass', md5($password));
        $re_2 = M('password_key')->where(array('key' => $key))->delete();
        if ($re_1 && $re_2) {
            $this->ajaxReturn('reset-success');
        } else {
            $this->ajaxReturn('reset-failure');
        }

    }

    /**
     * 发送邮件
     * @access public
     * @param string $to 收件人地址
     * @param stirng $user_name 用户名
     * @param string $user_id 用户id
     * @return boolen
     */
    private function sendMail($to, $user_name, $user_id)
    {
        $info = M('password_key')->where(array('user_id' => $user_id))->find();
        if (!empty($info)) {
            return false;
        }
        $data['user_id'] = $user_id;
        $data['key']     = getRandChar($length = 64);
        $re              = M('password_key')->data($data)->add();
        if ($re) {
            $url = 'http://post.return.moe' . U('User/forgetPassword/step/3/key/' . $data['key']);
        } else {
            return false;
        }
        $title   = 'Posutoba贴吧系统：重置密码';
        $content = '<div style="margin: 16px 40px;background-color: #eef2fa;border: 1px solid #d8e3e8;padding: 0 15px;-moz-border-radius: 5px;-webkit-border-radius: 5px;-khtml-border-radius: 5px;border-radius: 5px">
    <p>' . $user_name . '：您收到这封邮件，是由于这个邮箱地址在 Posutoba贴吧系统 被登记为用户邮箱， 且该用户请求使用 Email 密码重置功能所致。</p>
    <p><strong>！！！重要！！！</strong></p>
    <p>如果您没有提交密码重置的请求或不是 Posutoba贴吧系统 的注册用户，请立即忽略 并删除这封邮件。只有在您确认需要重置密码的情况下，才需要继续阅读下面的 内容。</p>
    <p><strong>！！！密码重置说明！！！</strong></p>
    <p>您只需在提交请求后的三天内，通过点击下面的链接重置您的密码：</p>
    <p><a href="' . $url . '">' . $url . '</a></p>
    <p>(如果上面不是链接形式，请将该地址手工粘贴到浏览器地址栏再访问)
在上面的链接所打开的页面中输入新的密码后提交，您即可使用新的密码登录网站了。您可以在用户控制面板中随时修改您的密码。</p>
    <p>时间：' . getNowDate() . '</p>
    <p>此致</p>
    <p>Posutoba贴吧系统 管理团队. http://post.return.moe/</p>
</div>';
        Vendor('PHPMailer.PHPMailerAutoload');
        $mail = new \PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host     = 'smtp.exmail.qq.com'; //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = true; //启用smtp认证
        $mail->Username = 'posutoba@return.moe'; //你的邮箱名
        $mail->Password = 'Posutoba123'; //邮箱密码
        $mail->From     = 'posutoba@return.moe'; //发件人地址（也就是你的邮箱地址）
        $mail->FromName = 'Posutoba贴吧系统'; //发件人姓名
        $mail->AddAddress($to, $user_name);
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(true); // 是否HTML格式邮件
        $mail->CharSet = 'utf-8'; //设置邮件编码
        $mail->Subject = $title; //邮件主题
        $mail->Body    = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        return ($mail->Send());
    }

}
