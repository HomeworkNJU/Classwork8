<!--本模块用于添加子模块-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
</head>
<style type="text/css">
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
</style>

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
	$father_module_id=$_POST['father_module_id'];//接受表单提交的父模块id
	$module_name=$_POST['module_name'];//接收表单提交的子模块名称
	$module_cont=$_POST['cont'];//接受表单提交的子模块内容
	if($father_module_id=="" or $module_name=="" or $module_cont==""){
		echo "<script> alert('隶属父模块，本模块名称及内容简介均不能为空！');</script>";
	}
	else{
		$query="insert into son_module_info (father_module_id,module_name,module_cont)values('$father_module_id','$module_name','$module_cont')";
		if($aa->excu($query)){
			echo "<script> alert('子模块添加成功！将跳转回首页！');</script>";
			header('refresh:0.2;url="index.php"');//子模块添加成功，数据库信息添加完成后返回首页
		}
	}
}
?>

<!--显示层次关系及提供返回首页链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>添加子模块</td>
</tr>
</table>

<!--页面整体布局-->
<table width="100%" height="389" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
<tbody>
<tr>
<td width="20" &nbsp;></td>
<td valign="top" align='center'><font face="宋体" size="+1" >添加子模块</font><br/>
<form action="?add_tag=1" method="post">
<table width="95%" height="87" border="0" align="center" cellpadding="0" cellspacing="1">
<tr bgcolor="#dccccccc">
<td width="25%" height="25"><div align="right">隶属父模块：</div></td>
<td width="69%" >
<!--生成下拉父模块列表-->
<select name="father_module_id">
<?php
$aa->link("");
$query="select * from father_module_info order by id";
$rst=$aa->excu($query);
while($father_module=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
	echo '<option value="'.$father_module['id'].'">'.$father_module['module_name'].'</option>';
	}
?>
</select>
</td>
</tr>
<!--子模块名称输入行-->
<tr bgcolor="#dddddd">
<td height="25"><div align="right">子模块名称:</div></td>
<td><input type="text" size="20" name="module_name" /></td>
</tr>
<!--子模块内容输入行-->
<tr bgcolor="#dddddd">
<td height="25"><div align="right">子模块主要内容:</div></td>
<td><textarea name="cont" cols="42" rows="3"></textarea></td>
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
</tbody>
</table>

<?php
include "inc/foot.php";
?>

</body>
</html>