<?php
session_start();
$_SESSION['user_name']="";
if(isset($_POST['submit'])){
	$tijiao=$_POST["submit"];
	if($tijiao=="提交"){
		$user_name=$_POST["user_name"];
		$user_pw=$_POST["user_pw"];
		$id=mysqli_connect('localhost',"root","allevia","bbs_data");
		$query="select * from user_info where user_name='$user_name'";
		$rst=mysqli_query($id,$query);
		if(!$rst){
			printf("Error: %s\n", mysqli_error($id));
 			exit();
		}
		$user=mysqli_fetch_array($rst);
		if($user_pw==$user['user_pw']){
			$_SESSION['user_name']=$user['user_name'];
		}
	}
	if($tijiao=="安全退出"){
		$_SESSION["user_name"]="";
	}
}
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr><form method="post" action="1.php">
<td width="80%" height="25" align="left" valign="middle" bgcolor="#CCFFFF">&nbsp;
<?php
if($_SESSION['user_name']!=""){
	echo "<font color=ffffff>欢迎您:".$_SESSION['user_name']."</font>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
 }
else{
?>
用户名：<input type="text" name="user_name" size="8"/>
密码：<input type="text" name="user_pw" size="8"/>
<input type="submit" name="submit" value="提交"/>
&nbsp;&nbsp;<a href="register.php"><font color="#FFFFFF">立即注册</font></a>
<?php
}
?>
</td>
</form>