<!--本页面用于编辑父模块内容，可以更改其显示顺序，修改该模块名称-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
</head>
<body>
<style type="text/css">
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
</style>

<?php
error_reporting(E_ALL & ~E_NOTICE &~E_DEPRECATED);
include "inc/mysql.inc";
include "inc/myfunction.inc";
include "inc/head.php";
$aa=new mysql;
$module_id=$_GET['module_id'];
$edit_tag=$_GET['edit_tag'];
//当收到编辑请求时对输入数据进行处理
if($edit_tag==1){
	$module_name=$_POST['module_name'];
	$show_order=$_POST['show_order'];
	if($module_name=="" or $show_order==""){
		echo "<script> alert('模块名与显示顺序均不能为空！');</script>";
	}
	else{
		$query="update father_module_info set module_name='$module_name',show_order='$show_order' where id='$module_id'";
		if($aa->excu($query)){
			echo "<script> alert('编辑父模块成功，将跳转至详情页！');</script>";
			header('refresh:0.2,url="fmodule_list.php"');//编辑成功，数据库内容已经修改，返回父模块管理页
		}
	}
}

$query="select * from father_module_info where id='$module_id'";
$rst=$aa->excu($query);
$module=mysqli_fetch_array($rst,MYSQLI_ASSOC);
?>

<!--显示层次关系，提供返回主页面链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>编辑父模块</td>
</tr>
</table>

<!--页面整体布局-->
<table width="100%" height="389" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
<tbody>
<tr>
<td width="20" &nbsp;></td>
<td valign="top"> <br/>
<form action="?edit_tag=1&module_id=<?php echo $module_id;?>" method="post">
<table width="95%" height="87" border="0" align="center" cellpadding="0" cellspacing="1">
<!--显示序号输入行-->
<tr bgcolor="#dccccccc">
<td width="25%" height="25"><div align="right">显示序号：</div></td>
<td width="69%" > <input type="text" size="6" name="show_order" value="<?php echo $module['show_order']?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请修改模块显示顺序,仅可输入数字</td>
</tr><!--使用正则表达式限制输入显示顺序仅可为数字-->
<!--父模块名称输入行-->
<tr bgcolor="#dddddd">
<td height="25"><div align="right">父模块名称:</div></td>
<td><input type="text" size="20" name="module_name" value="<?php echo $module['module_name']?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请修改模块名称</td>
</tr>
<!--提交行-->
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