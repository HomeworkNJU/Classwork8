<!--本页面主要用于显示各子模块详情信息；
将显示其中的笔记，笔记内容及修改时间-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学习笔记管理</title>
<link href="inc/style.css" rel="stylesheet" type="text/css">
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
$module_id=$_GET['module_id'];//获取跳转链接时以get方式传递的信息
$del_id=$_GET['del_id'];
if($del_id){
	$query="delete from note_info where id='$del_id'";
	$aa->excu($query);
}
$query="select * from note_info where module_id='$module_id' order by time desc";
$add="module_id=".$module_id."&";
$num_per_page=16;
?>
<style>
a{ text-decoration:none} 
a:hover{ text-decoration:underline} 
a:visited{color:#00F}
</style>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="73%" height="30"><a href="./">学习笔记管理系统</a>>>
<?php
echo "主题：";
echo $bb->sonid_tofname($module_id);
echo ">>章节名：";
echo $bb->sonid_tosname($module_id);
?>
</td>
<!--上面代码用于显示本页面所处层次关系，提供返回首页链接-->
<td width="27%" align="right" valign="middle">
<div>
<?php
echo "<a href=new_note.php?module_id=".$module_id.">";
echo "<img src='pic/add.png' alt='添加笔记' width='30px' style='vertical-align:middle'>添加笔记";
?>
</a>
<!--提供添加笔记链接-->
</div>
</td>
</tr>
</table>

<!--本区域显示笔记详情-->
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td width="%50%" align="center" valign="middle" bgcolor="#CCCCCC"><font face="宋体" size="+1" >标题</font></td>
<td width="%50%" align="center" valign="middle" bgcolor="#CCCCCC"><font face="宋体" size="+1" >记录时间</font></td>
</tr>
<?php
$query="select * from note_info where module_id='$module_id' order by time desc";
$result=$aa->excu($query);
$page_id=$_GET['page_id'];//这里的get接受从其下页码显示代码段传入的本页页码
if($page_id==""){
		$page_id=1;//第一次访问时，页码尚未传入，自动设置为1
	}
$rst=$aa->excu($query);
$num=mysqli_num_rows($rst);//统计模块中笔记条数
if($num==0){
		$page_num=1;

	}
else{$page_num=ceil($num/$num_per_page);//根据每页显示笔记数及总笔记数确定总页数
	}
$page_jump=$num_per_page*($page_id-1);
$query2="select * from note_info where module_id='$module_id' order by time desc limit ".$page_jump.",$num_per_page";
$result2=$aa->excu($query2);
while($note=mysqli_fetch_array($result2)){
	?>
<tr>
<td height="25" align="center" valign="middle">
<?php
$note_id=$note['id'];
echo "<a href=show_note.php?module_id=".$module_id."&note_id=".$note_id." title='点击查看笔记详情'>".$note['title']."</a>";//显示笔记标题，提供详情页接口
echo "&nbsp;&nbsp;&nbsp;<a href=module_list.php?module_id=".$module_id."&page_id=".$page_id."&del_id=".$note['id']." onclick=\"if(confirm('确实要删除数据吗？')) return true;else return false; \" title='删除笔记'><img src='pic/delete.png' alt='删除笔记' width='23px' style='vertical-align:middle'></a>";//提供删除笔记链接，删除时使用'onclink'进行确认
?>
</td>
<td height="25" align="center" valign="middle"><?php echo $note['time'];?></td>
</tr>
<tr>
<td height="1" colspan="2" bgcolor="#CCFFCC"></td>
</tr>
<?php
}
if($num==0){
?>
<tr>
<td height="25" align="center" valign="center" colspan="2">
<?php
echo"暂无笔记";
?>
</td>
</tr>
<?php }?>
</table>

<!--下面一段代码为页码显示代码，每页显示16条信息-->
<style>
#page { 
position: absolute; 
bottom: 31px; 
width: 100%; 
font-family:"Times New Roman", Times, serif;
}  
</style>
<div id=page>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="21" align="center" valign="bottom">
<?php
$page_up=$page_id-1;
$page_down=$page_id+1;
if($page_id==1 and $page_num==1){
	echo "第1页，共1页";
}
else if($page_id==1){
	echo"<a href=?".$add."page_id=$page_down>下一页</a>&nbsp;&nbsp;第".$page_id."页，共".$page_num."页";
}
else if($page_id>=$page_num-1){
	echo"<a href=?".$add."page_id=$page_up>上一页</a>&nbsp;&nbsp;第".$page_id."页，共".$page_num."页";
}
else {
	echo"<a href=?".$add."page_id=$page_up>上一页</a>&nbsp;&nbsp;<a href=?".$add."page_id=$page_down>下一页</a>&nbsp;&nbsp;第".$page_id."页，共".$page_num."页";
}
?>
</td>
</tr>
</table>
</div>

<?php
include "inc/foot.php";
?>
</body>
</html>