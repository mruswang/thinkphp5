<?php
/**
 * Created by PhpStorm.
 * User: wangsir
 * Date: 2017/5/23
 * Time: 20:57
 */

header("content-type:text/html;charset=utf-8");
require 'Phpmailer.php';
require 'Smtp.php';
date_default_timezone_set('PRC');
//建立邮件发送类
$mail = new PHPMailer;
// 使用SMTP方式发送
$mail->IsSMTP();
//调试功能
$mail->SMTPDebug=2;
$mail->Debugoutput='html';
//使用126邮箱服务器
$mail->Host = "smtp.126.com";
//邮箱服务器端口号
$mail->Port = 25;
// 启用SMTP验证功能
$mail->SMTPAuth = true;
//你的126服务器邮箱账号
$mail->Username = "mruswang@126.com";
// 126邮箱授权密码
$mail->Password = "wang82196395";
//发送人设置
$mail->setFrom('mruswang@126.com','mruswang');
//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
$mail->AddAddress("875484737@qq.com", "张三");
$mail->Subject = "PHPMailer SMTP test"; //邮件标题
$mail->msgHTML('mruswang-test-email');
if (!$mail->Send()) {
  echo "Mailer Error:" . $mail->ErrorInfo;
}else{
    echo "Message sent success!";
}
