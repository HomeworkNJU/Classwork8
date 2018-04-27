<?php
/*
程序中需要用到的数据库连接及查询操作封装在mysql类中；
为整个项目提供支持；
*/

class mysql{
	public $database;
	public $server_name;
	public $userpassword;
	function mysql()//用于定义数据库连接用户名及密码
	{
		$this->server_name="root";
		$this->userpassword="allevia";
	}
	
	function link($database){//连接数据库函数
		if($database==""){
			$this->database="bbs_data";
		}else{
			$this->database=$database;
		}
		if($id=mysqli_connect('localhost',$this->server_name,$this->userpassword)){
			if(!mysqli_select_db($id,$this->database)){
				echo "数据库连接错误!";
				exit;
			}
		}else{
			echo"服务器正在维护中，请稍后重试";
			exit;
		}
	}
	
	function excu($query){//数据库执行相关操作函数
		$id=mysqli_connect('localhost',$this->server_name,$this->userpassword,"bbs_data");
		if($result=mysqli_query($id,$query)){
				return $result;
		}else{
			echo "sql语句执行错误！请重试！".mysqli_error($id);
			exit;
			}
		}
}
?>