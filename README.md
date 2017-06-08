1.tp5的构架；
2.hui-admin的后台ui框架；
3.设置了前台和后台控制模板；
4.封装了邮件发送模块；
5.封装地图模块；
6.需要composer install安装后才能使用；
7.如需交流，请加QQ：875484737；
8.修改tothink/think-captcha/srrc/helper.php文件的方法，以便点击验证码刷新操作;
<pre>
function captcha_img($id = "")
  {
      $js_src="this.src='" . captcha_src($id) . "'";
      return '<img src="' . captcha_src($id) . '" alt="点击刷新二维码" onclick="'.$js_src.'" />';
 
  }
</pre>
