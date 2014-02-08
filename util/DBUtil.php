<?php
class DBUtil {

    public static function getConn($object) {
    	global $dbconfig;
		$domain = $object->getShardDomain();

		$db_username = $dbconfig[$domain]['username'];
		$db_password = $dbconfig[$domain]['password'];

		$mysqli = mysqli_connect($object->getServerAddress(), $db_username, $db_password, $object->getShardedDatabaseName());

		if( !$mysqli->connect_errno ) {
			$mysqli->query("SET character_set_results=utf8");
			$mysqli->query("SET character_set_client=utf8"); 
			$mysqli->query("SET character_set_connection=utf8");
			$mysqli->select_db($db_username);
		}

		return $mysqli;
    }

    public static function selectData($db_connection, $query) {
		if ( isset($db_connection) && !$db_connection->connect_errno ) {
			$select_result = $db_connection->query($query);
			if ($select_result) {
				$result = $select_result->fetch_array(MYSQLI_ASSOC);
			} else {
				$result = null;
			}

			return $result;
		}

		return null;
    }

    public static function deleteData($db_connection, $query)
    {
    	$result = false;

		if (isset($db_connection) && !$db_connection->connect_errno) {
			$result = $db_connection->query($query);
		}

		return $result;
    }

	public static function selectDataList($db_connection, $query)
	{
		if ( isset($db_connection) && !$db_connection->connect_errno )
		{
			$select_result = $db_connection->query($query);
			if ($select_result) {
				$rows = array();
				while ($row = $select_result->fetch_array(MYSQLI_ASSOC)) {
					array_push($rows, $row);
				}
				return $rows;
			}
		}

		return null;
	}

    public static function insertData($db_connection, $query)
    {
    	$result = false;

		if (isset($db_connection) && !$db_connection->connect_errno) {
			if ($db_connection->query($query)) {
				$result = $db_connection->insert_id;
			} else {
				$result = -1;
			}
		}
		else {
			$result = -1;
		}

		return $result;
    }

    public static function updateData($db_connection, $query)
    {
    	$result = false;

		if ( isset($db_connection) && !$db_connection->connect_errno ) {
			$result = $db_connection->query($query);
		}

		return $result;
    }

    public static function checkNull($db_connection, $input)
    {
    	return (isset($input) ? "'". $db_connection->real_escape_string($input) . "'" : "NULL");
    }
}
?>