<!--本页面用于编辑子模块，可以修改子模块所属父模块、
子模块标题及主要内容，更新时间将由系统自动记录-->

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
//当收到编辑请求后对数据库中内容进行修改
if($edit_tag==1){
	$father_module_id=$_POST['father_module_id'];//获取新选择所属父模块
	$module_name=$_POST['module_name'];//获取更新的模块名称
	$cont=$_POST['cont'];//获取更新的模块内容
	if($module_name=="" or $cont=="" or $father_module_id==""){
		echo "<script> alert('模块名与显示顺序均不能为空！');</script>";
	}
	else{
		$query="update son_module_info set father_module_id='$father_module_id',module_name='$module_name',module_cont='$cont' where id='$module_id'";
		if($aa->excu($query)){
			echo "<script> alert('编辑子模块成功，将跳转至详情页！');</script>";
			header('refresh:0.2,url="smodule_list.php"');//模块编辑完成后返回子模块管理页
		}
	}
}

$query="select * from son_module_info where id='$module_id'";
$rst=$aa->excu($query);
$module=mysqli_fetch_array($rst,MYSQLI_ASSOC);
?>

<!--显示层次关系及提供返回主页面链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>编辑子模块</td>
</tr>
</table>

<!--编辑页面整体布局-->
<table width="100%" height="389" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
<tbody>
<tr>
<td width="20" &nbsp;></td>
<td valign="top"> <br/>
<form action="?edit_tag=1&module_id=<?php echo $module_id?>" method="post">
<table width="95%" height="87" border="0" align="center" cellpadding="0" cellspacing="1">
<tr bgcolor="#dccccccc">
<td width="25%" height="25"><div align="right">隶属父模块：</div></td>
<td width="69%" >

<!--生成父模块选择下拉列表-->
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

<tr bgcolor="#dddddd">
<td height="25"><div align="right">子模块名称:</div></td>
<td><input type="text" size="20" name="module_name" value=<?php echo $module['module_name'];?> /></td>
</tr>
<tr bgcolor="#dddddd">
<td height="25"><div align="right">子模块主要内容:</div></td>
<td><textarea name="cont" cols="42" rows="3"><?php echo $module['module_cont'];?></textarea></td>
</tr>
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