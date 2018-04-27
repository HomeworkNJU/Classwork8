<!--本页面用于添加父模块信息-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
</head>
<body>
<?php
error_reporting(E_ALL & ~E_NOTICE &~E_DEPRECATED);
include "inc/mysql.inc";
include "inc/myfunction.inc";
include "inc/head.php";
$aa=new mysql;
$bb=new myfunction;
$aa->link("");

$add_tag=$_GET['add_tag'];
if($add_tag==1){
	$show_order=$_POST['show_order'];//获取提交的显示序号
	$module_name=$_POST['module_name'];//获取提交的父模块名称
	if($show_order=="" or $module_name==""){
		echo"<script> alert('添加父模块时模块名与显示顺序均不能为空！');</script>";
	}
	else{
		$query="insert into father_module_info (module_name,show_order)values('$module_name','$show_order')";
		if($aa->excu($query)){
			echo "<script> alert('父模块添加成功！将跳转回首页！');</script>";
			header('refresh:0.2;url="index.php"');//父模块添加成功，数据库操作执行完毕后返回首页
		}
	}
}
?>

<style type="text/css">
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
</style>

<!--显示层次关系及提供返回首页连接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>添加父模块</td>
</tr>
</table>

<table width="100%" height="389" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
<tr>
<td width="20">&nbsp;</td>
<td valign="top" align='center'><font face="宋体" size="+1" >添加父模块</font><br/>
<form action="?add_tag=1" method="post">
<table width="95%" height="87" border="0" align="center" cellpadding="0" cellspacing="1">
<!--显示序号行，使用正则表达式限制输入仅可为数字-->
<tr bgcolor="#dccccccc">
<td width="25%" height="25"><div align="right">显示序号：</div></td>
<td width="69%" > <input type="text" size="6" name="show_order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>&nbsp;&nbsp;&nbsp;请填写一整数，其将决定模块显示顺序</td>
</tr>
<!--父模块名称行-->
<tr bgcolor="#dddddd">
<td height="25"><div align="right">父模块名称:</div></td>
<td><input type="text" size="20" name="module_name" /></td>
</tr>
<!--提交按钮行-->
<tr bgcolor="#dddddd">
<td height="33" colspan="2" bgcolor="#e0eef5"><div align="center"><input name="submit" type="submit" value="提交" /></div></td>
</tr>
</table>
</form>
<br/>
<br/></td>
<td width="20">&nbsp;</td>
</tr>
</table>

<?php
include "inc/foot.php";
?>
</body>
</html>