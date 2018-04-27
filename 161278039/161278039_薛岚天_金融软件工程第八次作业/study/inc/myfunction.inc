<?php
/*整个项目中常用函数封装*/
class myfunction{
	//使文本以html格式正常显示
	function str_to($str){
		$str=str_replace(" ","&nbsp;",$str);
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(">","&gt;",$str);
		$str=nl2br($str);
		return $str;
	}
	
	//从id找到本模块中笔记数
	function son_module_id_tonum($son_module_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from note_info where module_id='$son_module_id'";
		$rst=$aa->excu($query);
		return mysqli_num_rows($rst);
	}
	
	//从id找到本模块中最新笔记
	function son_module_idtolast($son_module_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from note_info where module_id='$son_module_id' order by time desc limit 0,1";
		$rst=$aa->excu($query);
		$note=mysqli_fetch_array($rst,MYSQLI_ASSOC);
		if($note){
			echo "标题:&nbsp;".$note["title"];
			echo "<br>";
			echo "修改时间:&nbsp;".$note["time"]."&nbsp";
		}
	}
	
	//生成下拉子模块列表
	function son_module_list($father_module_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from father_module_info order by id";
		$rst=$aa->excu($query);
		echo "<select name='module_id'>";
		while($father_module=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
			echo '<option value=>'.$father_module['module_name'].'</option>';
			$father_module_id=$father_module['id'];
			$query="select * from son_module_info where father_module_id='$father_module_id' order by id";
			$rst2=$aa->excu($query);
			while($son_module=mysqli_fetch_array($rst2,MYSQLI_ASSOC)){
				echo '<option value="'.$son_module['id'].'">&nbsp;&nbsp;'.$son_module['module_name'].'</option>';
			}
		}
		echo "</select>";
	}
	
	//生成下拉父模块，即每门科目列表
	function father_module_list($father_module_id){
		$aa=new mysql;
		$aa->link("");
		echo "<select name='father_module_id'>";
		if($father_module_id==""){
			echo "<option selected>请选择………</option>";
			}else{
			$query=" select from father_module_info where id='$father_module_id'";
			$rst=$aa->excu($query);
			$father_module_id=mysqli_fetch_array($rst,MYSQLI_ASSOC);
			echo "<option value=".$father_module['id'].">".$father_module['module_name']."</option>";
		}
		$query="select * from father_module_info order by show_order";
		$rst=$aa->excu($query);
		while($father_module_id=mysqli_fetch_array($rst,MYSQLI_ASSOC)){
			echo "<option value=".$father_module['id'].">".$father_module['module_name']."</option>";
			}
		echo"</select>";
	}
	
	//由笔记的id返回其标题
	function noteid_totitle($note_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from note_info where id='$note_id'";
		$rst=$aa->excu($query);
		$note=mysqli_fetch_array($rst,MYSQLI_ASSOC);
		return $note['title'];
	}
	
	//由子模块的id返回其父模块的名称
	function sonid_tofname($son_module_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from son_module_info where id='$son_module_id'";
		$rst=$aa->excu($query);
		$cons=mysqli_fetch_array($rst,MYSQLI_ASSOC);
		$idd=$cons['father_module_id'];
		$query2="select * from father_module_info where id='$idd'";
		$rst2=$aa->excu($query2);
		$cons2=mysqli_fetch_array($rst2,MYSQLI_ASSOC);
		return $cons2['module_name'];
	}
	
	//由子模块的id返回本模块的名称
	function sonid_tosname($son_module_id){
		$aa=new mysql;
		$aa->link("");
		$query="select * from son_module_info where id='$son_module_id'";
		$rst=$aa->excu($query);
		$cons=mysqli_fetch_array($rst,MYSQLI_ASSOC);
		return $cons['module_name'];
	}
	
}
?>
		
		
		
		
		
		