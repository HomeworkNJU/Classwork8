<!--本页面用于编辑笔记-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>

</head>
<body>
<style>
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
$bb=new myfunction;
$aa->link("");
$module_id=$_GET['module_id'];//要修改的笔记所属模块
$note_id=$_GET['note_id'];//要修改笔记的id
$cont=$_POST['cont'];//获取修改内容
$title=$_POST['title'];//获取修改标题
$cont=$bb->str_to($cont);//保证笔记以html格式正常显示
$today=date("Y-m-d H:i:s");//记录修改时间
$tijiao=$_POST['submit'];
if($tijiao=="提交"){
if($cont!="" and $title!=""){
	$query1="update note_info set cont='$cont',time='$today',title='$title' where id='$note_id'";
	if($aa->excu($query1)){
		echo "<script> alert('笔记更新成功！将跳转至详情页。');</script>";
		header('refresh:0.2;url="show_note.php?module_id='.$module_id.'&note_id='.$note_id.'"');//更新成功后自动返回上级页面
	}
}
	else echo "<script> alert('更新失败，内容及标题均不能为空！');</script>";	
}
?>

<!--显示层次关系及提供返回上级链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>编辑笔记</td>
</tr>
</table>

<!--修改笔记表单布局-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td height="25" align="center" valign="middle" ><font face="宋体" size="+1" >编辑笔记</font></td>
</tr>
<tr>
<td height="25" align="center" valign="middle" bgcolor="#FFFFFF">
<form action="" method="post">
<table width="500" border="0" cellpadding="0" cellspacing="2">
<tr>
<td width="122" height="26" align="right" valign="middle" bgcolor="#CCFFFF">隶属模块:</td>
<td width="372" height="26" align="left" valign="middle"bgcolor="#CCFFFF">
<?php
echo $bb->sonid_tosname($module_id);//显示原笔记隶属模块
?>
</td>
</tr>
<tr>
<td height="26" align="right" valign="middle" bgcolor="#CCFFFF">标题:</td>
<td height="26" align="left" valign="middle" bgcolor="#CCFFFF"><input name="title" value="<?php echo $bb->noteid_totitle($note_id);//显示原笔记标题?>" /></td>
</tr>
<tr>
<td height="26" align="right" valign="middle" bgcolor="#CCFFFF"> 内容:</td>
<td height="26" align="left" valign="middle" bgcolor="#CCFFFF"> <textarea name="cont" rows="10" cols="50">
<?php 
$query="select * from note_info where id='$note_id'";
$rst=$aa->excu($query);
$note=mysqli_fetch_array($rst);
$cc=$note['cont'];//显示原笔记内容
$cc1=strip_tags($cc);//使文本正常显示
echo $cc1;
?>
</textarea></td>
</tr>
<tr>
<td height="26" align="right" valign="middle"bgcolor="#CCFFFF">更新时间:</td>
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
</body>
</html>