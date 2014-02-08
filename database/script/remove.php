<?php
include '../../dao/config/config.inc';

$username = 'root';
$password = 'Langara2';

foreach ($dbconfig as $key=>$val) {
	removeDatabases($key, $val);
}

function removeDatabases($prefix, $config) {
	global $username, $password;
	foreach ($config['server_list'] as $key=>$val) {
		$conn = mysqli_connect($key, $username, $password);
		for ($ii=$val['min']; $ii<=$val['max']; $ii++) {
			$sql = "DROP DATABASE ".$prefix."_".$ii;
			mysqli_query($conn, $sql);
		}
	}
}
?>