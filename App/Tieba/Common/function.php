<?php
/**
 * 截取字符串
 * @access public
 * @param string $str 字符串
 * @param int $start 开始位置
 * @param int $length 长度
 * @param string $charset 编码
 * @param boolen $suffix
 * @return string
 */
function mysubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        if ($suffix && strlen($str) > $length) {
            return mb_substr($str, $start, $length, $charset) . "...";
        } else {
            return mb_substr($str, $start, $length, $charset);
        }

    } elseif (function_exists('iconv_substr')) {
        if ($suffix && strlen($str) > $length) {
            return iconv_substr($str, $start, $length, $charset) . "...";
        } else {
            return iconv_substr($str, $start, $length, $charset);
        }

    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    if ($suffix) {
        return $slice . "…";
    }

    return $slice;
}

/**
 * 转换日期
 * @access public
 * @param string $date 日期
 * @param string $type 方式
 * @return string
 */
function convertDate($date, $type = null)
{
    switch ($type) {
        case 'intel':
            $today = date("Y-m-d", time());
            $date_ = date("Y-m-d", strtotime($date));
            if ($today == $date_) {
                $result = date("H:i", strtotime($date));
            } else {
                $result = date("m-d", strtotime($date));
            }
            break;
        case 'without_second':
            $result = date("Y-m-d H:i", strtotime($date));
            break;
        case 'without_year':
            $result = date("m-d H:i", strtotime($date));
            break;
        case 'cn':
            $result = date("m月d日 H:i", strtotime($date));
            break;
        case 'with_enter':
            $result = date("Y-m-d\nH:i", strtotime($date));
            $result = nl2br($result);
            break;
    }
    return $result;
}

/**
 * 获取用户id
 * @access public
 * @return string
 */
function getUid()
{
    $uid_res = A('Base')->uid;
    return $uid_res;
}

/**
 * 获取用户名
 * @access public
 * @return string
 */
function getUsername()
{
    $uid  = getUid();
    $info = M('users')->field('user_name')->where(array('user_id' => $uid))->find();
    return $info['user_name'];
}

/**
 * 获取时间
 * @access public
 * @return string
 */
function getNowDate()
{
    return date("Y-m-d H:i:s", time());
}

/**
 * 生成随机字符串
 * @access public
 * @param int $length 字符串长度
 * @return string
 */
function getRandChar($length = 30)
{
    $str    = null;
    $strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
    $max    = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }
    return md5($str);
}

/**
 * 生成用户id 帖子id等各种id
 * @access public
 * @return string
 */
function getMikuInt()
{
    $endtime = 1356019200; //2012-12-21时间戳
    $curtime = time(); //当前时间戳
    $newtime = $curtime - $endtime; //新时间戳
    $rand    = rand(0, 99); //两位随机
    $all     = $rand . $newtime;
    $onlyid  = base_convert($all, 10, 36);
    $info    = M('uuid')->where(array('uuid' => $onlyid))->find();
    if (empty($info)) {
        $data['uuid'] = $onlyid;
        M('uuid')->data($data)->add();
        return $onlyid;
    } else {
        getMikuInt();
    }
}

/**
 * 获取表全名
 * @access public
 * @param $table 表名
 * @return string
 */
function getTableName($table)
{
    return C('DB_PREFIX') . $table;
}

/**
 * 二维数组按指定的键值排序
 * @access public
 * @param array $array 数组
 * @param string $keys 指定键值
 * @param string $type 方式
 * @return array
 */
function sortArray($array, $keys, $type = 'asc')
{
    if (!isset($array) || !is_array($array) || empty($array)) {
        return '';
    }
    if (!isset($keys) || trim($keys) == '') {
        return '';
    }
    if (!isset($type) || $type == '' || !in_array(strtolower($type), array('asc', 'desc'))) {
        return '';
    }
    $keysvalue = array();
    foreach ($array as $key => $val) {
        $val[$keys]  = str_replace('-', '', $val[$keys]);
        $val[$keys]  = str_replace(' ', '', $val[$keys]);
        $val[$keys]  = str_replace(':', '', $val[$keys]);
        $keysvalue[] = $val[$keys];
    }
    asort($keysvalue); //key值排序
    reset($keysvalue); //指针重新指向数组第一个
    foreach ($keysvalue as $key => $vals) {
        $keysort[] = $key;
    }
    $keysvalue = array();
    $count     = count($keysort);
    if (strtolower($type) != 'asc') {
        for ($i = $count - 1; $i >= 0; $i--) {
            $keysvalue[] = $array[$keysort[$i]];
        }
    } else {
        for ($i = 0; $i < $count; $i++) {
            $keysvalue[] = $array[$keysort[$i]];
        }
    }
    return $keysvalue;
}

/**
 * 获取字符长度
 * @access public
 * @param string $str 字符
 * @return int
 */
function getUtf8Strlen($str)
{
    $count = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $value = ord($str[$i]);
        if ($value > 127) {
            $count++;
            if ($value >= 192 && $value <= 223) {
                $i++;
            } elseif ($value >= 224 && $value <= 239) {
                $i = $i + 2;
            } elseif ($value >= 240 && $value <= 247) {
                $i = $i + 3;
            } else {
                die('Not a UTF-8 compatible string');
            }

        }
        $count++;
    }
    return $count;
}
/**
 * 生成不规范的json数据
 * @access public
 * @param array $data 原数据
 * @param int $type 类型
 * @return string
 */
function newJson($data, $type)
{
    switch ($type) {
        case 1:
            return str_replace('"', "'", json_encode($data));
            break;
        case 2:
            return str_replace('"', "", json_encode($data));
            break;
    }
}

/**
 * discuz加密算法
 * @param string $string 原文或者密文
 * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
 * @param string $key 密钥
 * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
 * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
 * @example
 *   $a = authcode('abc', 'ENCODE', 'key');
 *   $b = authcode($a, 'DECODE', 'key');  // $b(abc)
 *
 *   $a = authcode('abc', 'ENCODE', 'key', 3600);
 *   $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
 */
function authCode($string, $operation, $key = 'posutoba', $expiry = 0)
{

    $ckey_length = 4;

    $key  = md5($key ? $key : "kalvin.cn");
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey   = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string        = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box    = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp     = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a       = ($a + 1) % 256;
        $j       = ($j + $box[$a]) % 256;
        $tmp     = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }

}
