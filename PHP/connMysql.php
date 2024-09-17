<?php
	//資料庫主機設定
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "p@ss0909";
	$db_name = "all_in_a_dream";
	//連線資料庫
	$db_link = new mysqli($db_host, $db_username, $db_password, $db_name);
	//錯誤處理
	if ($db_link->connect_error != "") {
		echo "資料庫連結失敗！";
	}else{
		//設定字元集與編碼
        // SET NAMES 'utf8' 的 SQL 語句，設定資料庫編碼為 utf8。
		$db_link->query("SET NAMES 'utf8'");
	}
?>