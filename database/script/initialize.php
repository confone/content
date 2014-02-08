<?php
include '../../dao/config/config.inc';

$username = 'root';
$password = 'Langara2';

foreach ($dbconfig as $key=>$val) {
	createDatabases($key, $val);
}

//========================================================================================== user
//
function createDatabases($prefix, $config) {
	global $username, $password;
	foreach ($config['server_list'] as $key=>$val) {
		$conn = mysqli_connect($key, $username, $password);
		for ($ii=$val['min']; $ii<=$val['max']; $ii++) {

			$sql = "CREATE DATABASE ".$prefix."_".$ii;
			mysqli_query($conn, $sql);
			mysqli_select_db($conn, $prefix."_".$ii);
			$sql = file_get_contents('../schema/'.$prefix.'.sql');
			$sql = str_replace('{$dbName}', $prefix."_".$ii, $sql);
			$sql = str_replace('{$uname}', $config['username'], $sql);
			$sql = str_replace('{$passwd}', $config['password'], $sql);

			if (mysqli_multi_query($conn, $sql)) {
				do {
			        if ($result = mysqli_store_result($conn)) {
			            while ($row = mysqli_fetch_row($conn)) {}
			            mysqli_free_result($result);
			        }
				} while (mysqli_next_result($conn));
			} else {
				die( mysqli_error($conn) );
			}
		}
	}
}