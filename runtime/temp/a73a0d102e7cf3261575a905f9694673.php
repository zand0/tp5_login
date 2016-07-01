<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"C:\xampp\htdocs\tp\tp5\public/../application/index\view\login\reg.html";i:1467170117;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>注册</title>
</head>
<body>
<form action="/index.php/index/Register/reg" method="post">
	<table>
		<tr>
			<td>用户名：</td>
			<td>
				<input type="text" name="uname" value="" />
			</td>
		</tr>
		<tr>
			<td>密  码：</td>
			<td>
				<input type="password" name="pass" value="" />
			</td>
		</tr>
		<tr><td><input type="submit" name="submit" value="注册"/></td></tr>
	</table>
</form>

</body>
</html>