<?php
/**
 * Created by PhpStorm.
 * User: wangsir
 * Date: 2017/5/23
 * Time: 22:24
 发送邮件类库
 */
namespace phpmailer;



 class Email{
    public static function send($to,$title,$content){

        date_default_timezone_set('PRC');
        if(empty($to)){
            return false;
        }
        try{
            //建立邮件发送类
            $mail = new Phpmailer;
            // 使用SMTP方式发送
            $mail->IsSMTP();
            //调试功能
           // $mail->SMTPDebug=2;
            $mail->Debugoutput='html';
            //使用126邮箱服务器
            $mail->Host = config('email.host');
            //邮箱服务器端口号
            $mail->Port = config('email.port');
            // 启用SMTP验证功能
            $mail->SMTPAuth = true;
            //你的126服务器邮箱账号
            $mail->Username = config('email.username');
            // 126邮箱授权密码
            $mail->Password = config('email.password');
            //发送人设置
            $mail->setFrom(config('email.username'),config('email.name'));
            //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
            $mail->AddAddress($to);
            $mail->Subject = $title; //邮件标题件标题
            $mail->msgHTML($content);
            if (!$mail->Send()) {
                return false;
            }else{
                return true;
            }
        }catch (phpmailerException $e){
            return false;
        }

    }

 }