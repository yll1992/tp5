<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 练习接受数据过滤
 * @param  mixed $data 待过滤的数据
 * @return mixed
 */
function filterData($data) {
	return 'itcast@'.$data; //给接受的数据增加前缀
}


/**
 * 无限极递归分类（先父后子）
 * @param string $categorys 所有分类数据
 * @param string $pid       指定父级ID （$pid=0表示顶级分类）
 * @param string $level     级别（$level=0表示顶级）
 * 注意：过滤后的数据在超全局变量$GLOBALS['tree']中
 */

  function getTree($categorys, $pid = 0, $level = 0)
{
    foreach ($categorys as $category)
    {
        if ($category->pid == $pid)
        {
            //给$category变量增加一个属性
            $category->level = $level;
            $GLOBALS['tree'][] = $category;
            //查找当前父级分类所有子级
            getTree($categorys, $category->cat_id, $level + 1);
        }
    }


}

    /**
 * 发送短信
 * @param int $mobile 手机号
 * @param int $code   验证码
 * 
 */

    function sendSms($mobile,$code){
        $params = array(
                'key'   => '9433e13155f12e5b15323a42d67759e4', //您申请的APPKEY
                'mobile'    => $mobile, //接受短信的用户手机号码
                'tpl_id'    => '162616', //您申请的短信模板ID，根据实际情况修改
                'tpl_value' =>'%23code%23%3D'.$code //您设置的模板变量，根据实际情况修改
                    );

        $paramstring ="http://v.juhe.cn/sms/send?".http_build_query($params);
        $result = json_decode(file_get_contents($paramstring), true);
        if (isset($result['error_code']) && $result['error_code'] ==0) {
            return true;
        } else {
            //请求异常
            return $result['reason'];
        }
}


/**
 * 发送邮件
 * @param  string $title   邮件标题
 * @param  string $content 邮件内容
 * @param  string $address 收件人
 * @return 
 */
    function sendEmail($title,$content,$address){
        require_once EXTEND_PATH ."/email/class.phpmailer.php";
        require_once EXTEND_PATH ."/email/class.smtp.php";

        $mail = new PHPMailer(); //实例化PHPMailer核心类
        $mail->SMTPDebug = 1;    //调试模式:1-开发环境，0-生产环境
        $mail->isSMTP();               //使用smtp鉴权方式发送邮件
        $mail->SMTPAuth = true;        //smtp需要鉴权 这个必须是true
        $mail->Host = 'smtp.163.com';  //链接qq域名邮箱的服务器地址
        $mail->SMTPSecure = 'ssl';     //设置使用ssl加密方式登录鉴权
        $mail->Port = 465;             //设置ssl连接smtp服务器的远程服务器端口号
        $mail->CharSet = 'UTF-8';      //设置发送的邮件的编码
        // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = '传智播客上海PHP学院';
        $mail->Username = 'tsgioern@163.com';//邮箱账号
        $mail->Password = 'yll3838438';         //授权码（第一次开启smtp服务设置的）
        //设置发件人邮箱地址,同登录账号
        $mail->From = 'tsgioern@163.com';
        $mail->isHTML(true);                     //是否支持HTML
        $mail->addAddress($address);//收件人邮箱
        $mail->Subject = $title;        //邮件标题
        $mail->Body = $content; //内容
        $mail->addAttachment('./test.pdf');      //附件
        $status = $mail->send();                 //布尔
        // echo '<hr />';
        // var_dump($status);
        return $status;

    }
