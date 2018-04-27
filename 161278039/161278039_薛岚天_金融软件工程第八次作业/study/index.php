<!--用户主界面，
提供通往父子模块管理添加页接口；
显示笔记组织层次；
提供通往子模块详情页接口；-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
<link href="inc/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include "inc/mysql.inc";
include "inc/myfunction.inc";
include "inc/head.php";
$aa=new mysql;
$bb=new myfunction;
$aa->link("");
?>
<style type="text/css">
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
#choice { 
	font-size: 19px;
	font-family:Georgia, "Times New Roman", Times, serif;
}  
</style>

<!--父子模块管理页布局-->
<table width="98%" align="center" cellpadding="0" cellspacing="1" rules="cols" height="30">
<tr>
<td  width="25%" align="center" valign="middle"><a href=fmodule_add.php><img src='pic/new.png' width='20px' style='vertical-align:middle' alt='add'><span id="choice">&nbsp;添加父模块</span></a></td>
<td width="25%" align="center" valign="middle"><a href=fmodule_list.php><img src='pic/manage1.png' width='20px' style='vertical-align:middle' ><span id="choice">&nbsp;管理父模块</span></a></td>
<td  width="25%" align="center" valign="middle"><a href=smodule_add.php><img src='pic/new.png' width='20px' style='vertical-align:middle' alt='add'><span id="choice">&nbsp;添加子模块</span></a></td>
<td width="25%" align="center" valign="middle"><a href=smodule_list.php><img src='pic/manage1.png' width='20px' style='vertical-align:middle'><span id="choice">&nbsp;管理子模块</span></a></td>
</tr>
</table>

<!--笔记结构展示区布局-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff">
<tr>
<td width="60%" height="25" align="center" valign="middle" bgcolor="#CCCCCC"><font face="宋体" size="+1" >主题</font></td>
<td width="10%" align="center" valign="middle" bgcolor="#CCCCCC"><font face="宋体" size="+1">笔记</font></td>
<td width="30%" align="center" valign="middle" bgcolor="#CCCCCC"><font face="宋体" size="+1">最新笔记及修改时间</font></td>
</tr>
<tr>
<td colspan="5">
<!--从数据库中获取相应信息-->
<?php
$query="select * from father_module_info order by show_order";
$result=$aa->excu($query);
while($father_module=mysqli_fetch_array($result)){//当存在父模块时循环
?>
<style type="text/css"> 
#ftitle { 
	font-size: 19px;
	font-family:"微软雅黑";
}  
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="30" colspan="6" bgcolor="#CCFFFF"><b><span id="ftitle">&nbsp;&nbsp;&nbsp;<?php echo $father_module["module_name"]?></span></b></td><!--输出父模块名称-->
</tr>
<?php
$query2="select * from son_module_info where father_module_id='$father_module[id]' order by id";
$result2=$aa->excu($query2);
while($son_module=mysqli_fetch_array($result2)){
?>
<tr>
<td width="15%" height="40" align="center" valign="middle"></td>
<td width="45%" align="center" valign="middle">
<?php
echo "<img src='pic/star.png' width='20px' style='vertical-align:middle'>&nbsp;&nbsp;章节:&nbsp;&nbsp;<b><a href=module_list.php?module_id=".$son_module['id']."><font color=0000ff>".$son_module["module_name"]."</font></a></b><br>";
echo "主要内容:&nbsp;&nbsp;".$son_module["module_cont"];//输出子模块标题及简介
?>
</td>
<td width="10%" align="center" valign="middle" > <?php echo $bb->son_module_id_tonum($son_module["id"]);?> </td><!--输出模块中的笔记数-->
<td width="30%" align="left" valign="middle"> <?php echo $bb->son_module_idtolast($son_module["id"]);?> </td><!--输出最新笔记-->
</tr>

<?php } ?>
</table>
<?php } ?>
</td>
</tr>
<tr>
<table style='position:absolute; bottom:40px;' width="100%" align='center' border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="25px" bgcolor="CCFFFF" align='center' width='98%'></td>
</tr>
</table>
<tr>
</table>
<?php
include "inc/foot.php";
?>
</body>
</html>