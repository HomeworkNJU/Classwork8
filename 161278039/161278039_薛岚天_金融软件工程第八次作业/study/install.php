<?php
/*由于项目中使用了数据库，需要在数据库中创建相应的数据库及表；
因此使用前使用本程序对创建相应的数据结构，即对系统进行安装*/
include "inc/mysql.inc";
include "inc/myfunction.inc";
$aa=new mysql;
$bb=new mysql;
echo "若下方出现错误提示，请将本页面及mysql.inc中mysqli_connect函数中用户名及密码更改为本机使用用户名及密码!<br>";
$id=mysqli_connect('localhost','root','allevia');
if(!$id){
	die ('未连接数据库');
}
if(mysqli_query($id,"create database bbs_data")){
	echo "数据库创建成功！";
}

//创建父模块信息表
$bb->link("");
$query="create table father_module_info(
id INT(11) NOT NULL auto_increment,
module_name VARCHAR(66) default NULL,
show_order INT(11) default 0,
PRIMARY KEY (id)
)";
$bb->excu($query);
echo "<br>&nbsp;数据表father_module_info创建成功！";

//创建子模块信息表
$query="create table son_module_info(
id INT(11) NOT NULL auto_increment,
father_module_id INT(11) NOT NULL,
module_name varchar(66) NOT NULL,
module_cont text NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (father_module_id) REFERENCES father_module_info(id)
)";
$bb->excu($query);
echo "<br>&nbsp;数据表son_module_info创建成功！";

//创建笔记信息表
$query="create table note_info(
id int(11) NOT NULL auto_increment,
module_id int(11) default 0,
title varchar(88) NOT NULL,
cont text NOT NULL,
time datetime NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (module_id) REFERENCES son_module_info(id)
)";
$bb->excu($query);
echo "<br>&nbsp;数据表note_info创建成功！";

echo "将跳转至用户首页！";
header('refresh:2;url="./"');

?>