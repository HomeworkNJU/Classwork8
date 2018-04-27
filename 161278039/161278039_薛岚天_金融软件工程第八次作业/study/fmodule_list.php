<!--本页面用于显示系统中所具有的的父模块及其相关信息；
并提供编辑父模块的接口，同时具有删除某一父模块的功能-->
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
$del_tag=$_GET['del_tag'];
if($del_tag==1){
	$module_id=$_GET['module_id'];//接受要删除的模块id，删除所有隶属于它的子模块及笔记
	$query="select * from son_module_info where father_module_id='$module_id'";
	$rst=$aa->excu($query);
	while($smodule=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
		$sid=$smodule['id'];
		$query1="delete from note_info where module_id='$sid'";
		$aa->excu($query1);
	}
	$query2="delete from son_module_info where father_module_id='$module_id'";
	$aa->excu($query2);
	$query3="delete from father_module_info where id='$module_id'";
	$aa->excu($query3);
	echo "<script> alert('删除操作执行成功,将刷新页面!');</script>";
	header('refresh:1,url="fmodule_list.php"');//删除成功后留在本详情页
}

$query="select * from father_module_info order by show_order";
$rst=$aa->excu($query);
?>

<!--显示层次关系，提供返回上级页面链接-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" rules="none">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>父模块管理</td>
</tr>
</table>

<!--整体父模块信息展示布局-->
<table width="100%" height="390" border="0" cellpadding="0" cellspacing="0" bgcolor="#f0f0f0">
<tbody>
<tr>
<td width="20">&nbsp;</td>
<td valign="top"> <br/> 
<table width="%80%" border="0" align="center" cellpaading="0" cellsapcing="1" bgcolor="#449ae8">
<tr bgcolor="#cccccc">
<td width="92" height="23" bgcolor="#e0eef5"><div align="right"> 编号：</div></td>
<td width="193" bgcolor="#e0eef5"><div align="center">显示序号:</div></td>
<td width="368" bgcolor="#e0eef5"><div align="center">父模块名称:</div></td>
<td colspan="2" bgcolor="#e0eef5"><div align="center">操作:</div></td>
</tr>
<?php
$m=0;
while($module=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
	$m++;
?>
<tr>
<td height="19" bgcolor="#FFFFFF"> <div align="center"><?php echo $m;?></div></td>
<td bgcolor="#FFFFFF"><div align="center" ><?php echo $module['show_order'];?></div></td>
<td bgcolor="#FFFFFF"><div align="center"><?php echo $module['module_name'];?></div></td>
<td width="134" align="center" bgcolor="#FFFFFF"><a href="edit_fmodule.php?module_id=<?php echo $module['id'];?>">编辑</a></td><!--提供编辑页接口-->
<td width="142" align="center" bgcolor="#FFFFFF"><?php
echo "<a href=?del_tag=1&module_id=".$module['id']." onclick=\"if(confirm('确实要删除数据吗？')) return true;else return false; \">删除</a>"//删除操作时以onclick进行确认
?>
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