<!--新建笔记页面，同时提供修改笔记页面接口-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
<link href="inc/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!--定义整个页面中链接显示情况-->
<style>
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
</style>

<?php
//添加笔记php代码
error_reporting(E_ALL & ~E_NOTICE &~E_DEPRECATED);
include "inc/mysql.inc";
include "inc/myfunction.inc";
include "inc/head.php";
$aa=new mysql;
$bb=new myfunction;
$aa->link("");
$module_id=$_GET['module_id'];//所属子模块id
$title=$_POST['title'];//笔记标题
$cont=$_POST['cont'];//笔记内容
$cont=$bb->str_to($cont);//保证笔记内容能以html格式正常显示
$today=date("Y-m-d H:i:s");//记录笔记添加时间
$tijao=$_POST['submit'];
if($tijao=="提交"){
	if($module_id!="" and $title!="" and $cont!=""){
		$query="insert into note_info(module_id,title,cont,time)values('$module_id','$title','$cont','$today')";
		if($aa->excu($query)){
			echo "<script> alert('笔记添加成功！将跳转至子模块显示页。');</script>";
			header('refresh:0.2;url="module_list.php?module_id='.$module_id.'"');
			}
	}
	else echo "<script> alert('子模块，笔记标题及内容不能为空！');</script>";
}
?>

<!--整体页面布局-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>添加笔记</td>
</tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td height="25" align="center" valign="middle" ><font face="宋体" size="+1" >添加笔记</font></td>
</tr>
<tr>
<td height="25" align="center" valign="middle" bgcolor="#FFFFFF">
<form method="post" action="">
<table width="90%" border="0" cellpadding="0" cellspacing="2">
<tr>
<td width="25%" height="26" align="right" valign="middle" bgcolor="#CCFFFF">隶属模块:</td>
<td width="45%" height="26" align="left" valign="middle" bgcolor="#CCFFFF">
<?php
echo $bb->sonid_tosname($module_id);
?>
</td>
</tr>
<tr>
<td height="26" align="right" valign="middle" bgcolor="#CCFFFF">标题:</td>
<td height="26" align="left" valign="middle" bgcolor="#CCFFFF"><input type="text" name="title"  /></td>
</tr>
<tr>
<td height="26" align="right" valign="middle" bgcolor="#CCFFFF"> 内容:</td>
<td height="26" align="left" valign="middle" bgcolor="#CCFFFF"> <textarea name="cont" rows="10" cols="50"></textarea></td>
</tr>
<tr>
<td height="26" align="right" valign="middle" bgcolor="#CCFFFF">更新时间:</td>
<td height="26" align="left" valign="middle" bgcolor="#CCFFFF">系统自动记录</td>
</tr>
<tr>
<td height="26" align="center" valign="middle" colspan="2" bgcolor="#e0eef5"><input type="submit" name="submit" value="提交" /></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
<?php
include "inc/foot.php";
?>
</body>
</html>