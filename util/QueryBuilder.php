<?php
class QueryBuilder {

	private $object = null;
	private $async = false;
	private $query = '';
	private $and = false;
	private $isInsert = false;
	private $connection = null;
	private $result = null;

	public function __construct($object, $async=false) {
		$this->object = $object;
		$this->async = $async;
		$this->getConnection();
	}

	public function insert($inserts, $table=null) {
		if (!isset($table)) {
			$table = $this->object->getTableName();
		}

		$this->isInsert = true;

		$fileds = '(';
		$values = '(';
		foreach ($inserts as $key=>$val)
		{
			if ( isset($val) )
			{
				$fileds .= $key . ',';
				$values .= $this->checkNull($val) . ',';
			}
		}
		$fileds = rtrim($fileds, ',') . ')';
		$values = rtrim($values, ',') . ')';

		$this->query.= "INSERT INTO $table $fileds VALUES $values";

		return $this;
	}

	public function update($set, $table=null) {
		if (!isset($table)) {
			$table = $this->object->getTableName();
		}

		$update = "UPDATE $table SET ";
		foreach ($set as $key=>$val) {
			$update.= $key.'='.$this->checkNull($val).',';
		}

		$this->query.= rtrim($update, ',');

		return $this;
	}

	public function select($fields, $table=null) {
		if (!isset($table)) {
			$table = $this->object->getTableName();
		}

		$select = 'SELECT ';
		if (is_array($fields)) {
			foreach ($fields as $field) {
				$select.= $field.',';
			}
			$select = rtrim($select, ',');
		} else {
			$select.= trim($fields);
		}

		$this->query.= $select.' FROM '.$table;

		return $this;
	}

	public function delete($table=null) {
		if (!isset($table)) {
			$table = $this->object->getTableName();
		}

		$this->query.= "DELETE FROM $table";

		return $this;
	}

	public function where($field, $value, $operator='=') {
		$where = $this->and ? ' AND' : ' WHERE';

		$where.=" $field".$operator."'".mysqli_real_escape_string($this->connection, $value)."'";

		$this->and = true;

		$this->query.= $where;

		return $this;
	}

	public function in($field, $range) {
		$in = $this->and ? ' AND' : ' WHERE';

		$in.= " $field IN (";
		foreach ($range as $value) {
			$in.= $value.",";
		}
		$in = rtrim($in, ',').')';

		$this->and = true;

		$this->query.= $in;

		return $this;
	}

	public function limit($start, $size) {
		$this->query.= " LIMIT $start, $size";

		return $this;
	}

	public function order($field, $desc=false) {
		$this->query.= " ORDER BY $field";

		if ($desc) {
			$this->query.= " DESC";
		}

		return $this;
	}

	public function query() {
		if ($this->isInsert) {
			if ($this->async) {
				$this->result = $this->connection->query($this->query, MYSQLI_ASYNC);
			} else {
				if ($this->connection->query($this->query)) {
					$this->result = $this->connection->insert_id;
				} else {
					$this->result = -1;
				}
			}
		} else {
			$this->result = $this->connection->query($this->query); 
		}

		return $this->result;
	}

    public function find() {
    	$this->query();

		if ($this->result) {
			$result = $this->result->fetch_array(MYSQLI_ASSOC);
		} else {
			$result = null;
		}

		return $result;
    }

	public function findList() {
    	$this->query();

		if ($this->result) {
			$rows = array();
			while ($row = $this->result->fetch_array(MYSQLI_ASSOC)) {
				array_push($rows, $row);
			}
			return $rows;
		}

		return array();
	}

	public function getQuery() {
		return $this->query;
	}

// =========================================================================================== private

    private function getConnection() {
    	if (!isset($this->object)) { return; }

    	global $dbconfig;
		$domain = $this->object->getShardDomain();

		$db_username = $dbconfig[$domain]['username'];
		$db_password = $dbconfig[$domain]['password'];

		$this->connection = mysqli_connect( 'p:'.$this->object->getServerAddress(), 
											$db_username,
											$db_password,
											$this->object->getShardedDatabaseName() );
		if( !$this->connection->connect_errno ) {
			$this->connection->query("SET character_set_results=utf8");
			$this->connection->query("SET character_set_client=utf8"); 
			$this->connection->query("SET character_set_connection=utf8");
		} else {
			Logger::fatal('Cannot establish database connection!');
		}
    }

    private function checkNull($input)
    {
    	return (isset($input) ? "'". $this->connection->real_escape_string($input) . "'" : "NULL");
    }
}