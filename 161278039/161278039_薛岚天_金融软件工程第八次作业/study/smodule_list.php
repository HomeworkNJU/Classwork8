<!--本页面用于显示系统中所具有的子模块及其相关信息；
并提供编辑子模块的接口，同时具有删除某一子模块的功能-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
</head>
<body>

<!--设置本页面中链接样式-->
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
$bb=new myfunction;
$aa->link("");
$del_tag=$_GET['del_tag'];
if($del_tag==1){
	$module_id=$_GET['module_id'];//删除本模块及所有属于本模块的笔记
	$query="delete from note_info where module_id='$module_id'";
	$aa->excu($query);
	$query1="delete from son_module_info where id='$module_id'";
	$aa->excu($query1);
	echo "<script> alert('删除操作执行成功,将刷新页面!')</script>";
	header('refresh:0.2,url="smodule_list.php"');//删除操作执行后刷新本页面
}

$query="select * from father_module_info order by show_order";
$rst=$aa->excu($query);
?>

<!--显示层次关系及提供返回上级页面链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>子模块管理</td>
</tr>
</table>

<!--页面整体布局-->
<table width="100%" height="390" border="0" cellpadding="0" cellspacing="0" bgcolor="#f0f0f0">
<tbody>
<tr>
<td width="20">&nbsp;</td>
<td valign="top"> <br/> 
<table width="%80%" border="0" align="center" cellpaading="0" cellsapcing="1" bgcolor="#449ae8">
<tr bgcolor="#cccccc">
<td width="92" height="23" bgcolor="#e0eef5" align="center"> 显示序号</td>
<td width="276" bgcolor="#e0eef5"><div align="center">编号</div></td>
<td width="368" bgcolor="#e0eef5"><div align="center">模块名称</div></td>
<td colspan="2" bgcolor="#e0eef5"><div align="center">操作</div></td>
</tr>
<?php
while($father_module=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
	$father_module_id=$father_module['id'];
	$father_module_name=$father_module['module_name'];//以父模块组织各子模块
?>
<tr>
<td height="19" bgcolor="#FFFFFF"> <div align="center"><?php echo $father_module['show_order'];?></div></td>
<td colspan="4" align="middle" valign="middle" bgcolor="#cccccc"><i><?php echo 隶属父模块：;echo $father_module_name;?></i></td>
</tr>
<?php
$query1="select * from son_module_info where father_module_id='$father_module_id' order by id";
$rst2=$aa->excu($query1);
$m=0;
while($module=mysqli_fetch_array($rst2,MYSQLI_ASSOC)){
	$m++;
?>
<tr>
<td height="19" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $m;?></td>
<td bgcolor="#FFFFFF"><div align="center"><?php echo $module['module_name'];?></div></td>
<td width="134" align="center" bgcolor="#FFFFFF"><a href="edit_smodule.php?module_id=<?php echo $module['id'];?>">编辑</a></td><!--提供编辑子模块接口-->
<td width="142" align="center" bgcolor="#FFFFFF">
<?php
echo "<a href=?del_tag=1&module_id=".$module['id']." onclick=\"if(confirm('确实要删除数据吗？')) return true;else return false; \">删除</a>"//删除前用onclick事件确认
?>
</td>
<?php } ?>
</tr>
<?php } ?>
</table>
</td>
<td width="20">&nbsp;</td>
</tr>
</tbody>
</table>
<?php
include "inc/foot.php";
?>

</body>
</html>