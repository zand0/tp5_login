<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"C:\xampp\htdocs\tp\tp5\public/../application/index\view\login\login.html";i:1467280062;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录</title>
</head>
<body>
<form action="/index.php/index/Login/login" method="post">
	<table>
		<tr>
			<td>用户名：</td>
			<td>
				<input type="text" name="account" value="" />
			</td>
		</tr>
		<tr>
			<td>密  码：</td>
			<td>
				<input type="password" name="pass" value="" />
			</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="提交"/></td>
			<td><input onclick="location.href='/index.php/index/Register/reg/'" type="button" name="buttun" value="注册"/></td>
		</tr>
	</table>
</form>

</body>
</html>