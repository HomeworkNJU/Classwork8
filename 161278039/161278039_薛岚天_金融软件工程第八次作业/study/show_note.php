<!--本页面用于显示笔记详情-->
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
#hea{
	font-size: 24px;
	font-family:"楷体";
}
#art{
	font-size: 14px;
	font-family:"宋体";
}
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
 $module_id=$_GET['module_id'];
 $note_id=$_GET['note_id'];
 ?>
 
 <!--显示层次关系，提供返回上级链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>
<?php
echo "<a href=module_list.php?module_id=".$module_id.">";
echo "返回所属章节";
?>
</td>
<td width="27%" align="right" height="30">
<?php
echo "<a href=edit_note.php?module_id=".$module_id."&note_id=".$note_id.">";
echo "<img src='pic/edit.png' alt='修改笔记' width='30px' style='vertical-align:middle'>修改笔记";//提供修改笔记页面接口
?>
</a></td>
</tr>
</table>
 <?php
 $query="select * from note_info where id='$note_id'";
 $result=$aa->excu($query);
 $note=mysqli_fetch_array($result);
 ?>
 <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
 <tr>
 <td width="71%" height="25" align="left" valign="middle" bgcolor="#CCCCCC">标题：<span id=hea><b><?php echo "&nbsp;".$note['title']//显示笔记标题?></b></span></td>
 <td width="29%" height="25" align="center" valign="middle" bgcolor="#CCCCCC">最后修改时间：<?php echo $note['time']//显示笔记最后修改时间?></td>
 </tr>
 <tr>
 <td height="1" colspan="2" bgcolor="#CCCCCC"></td>
 </tr>
 </table>
 <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
 <td align="center" valign="middle" bgcolor="#e0eef5"><font face="宋体" size="+1" ><b>笔记内容</b></font></td>
 </tr>
 <tr>
 <td height="8" bgcolor="#e0eef5">
 </td>
 </tr>
 <tr>
 <td align="center" valign="top" bgcolor="#e0eef5" height='392px'><span id=art><?php echo $note['cont']."&nbsp;"//显示笔记内容?></span></td>
 </tr>
 <tr>
 <td height="8" align="center" bgcolor="#CCCCCC"></td>
 </tr>
 </table> 
<?php
include "inc/foot.php";
?>
</body>
</html>