<?php
namespace genesis;

class db {
	/**
	 * Performs an insert into the specified table using the fields and values in the
	 * input array and returns the inserted id if the table has an auto-assign
	 * attribute.
	 *
	 * @param string $table
	 * @param array $data
	 * @return int insert_id
	 */
	public function insert($table, $data) {
		if (!is_array($data)) {
			return;
		}
		$fields = "";
		$values = "";
		foreach ($data as $key => $val) {
			$fields .= !empty($fields) ? ",`".$key."`" : "`".$key."`";
			$values .= !empty($values)
				? ','.(trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : 'NULL')
				: (trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : 'NULL');
		}
		$sql = "INSERT INTO $table ($fields) VALUES ($values);";
		$result = SELF::query($sql);
		if ($result) {
			return mysql_insert_id();
		}

		return FALSE;
	}

	/**
	 * Performs a quest and returns the results object if the query did not generate
	 * an error. If an error was generated then the output of mysql_error() is logged
	 * and also sent to the fatalError function.
	 */
	public function query($query) {
		$result = mysql_query($query);
		if (!$result) {
			$errorMSG = mysql_error();
			$errorMSG .= "\n\n".preg_replace('/\s+/', ' ', $query);
			$oError = new error;
			$oError -> fatalError($errorMSG, $reportCallStack=1);
		}
		return $result;
	}

	/**
	* Generic update function, will only update a single row
	*
	* @param string $table Table to update
	* @param array $data Data to update in the table
	* @param string $condition Any conditional statements (Where id=3)
	*/
	public function update($table, $data, $condition = null) {
		foreach ($data as $key => $val) {
			$values .= !empty($values) ? "," : "";
			$values .= '`'.$key.'`='.(trim($val) != '' ? "'".mysql_real_escape_string($val)."'" : "NULL");
		}
		$sql = "UPDATE $table SET $values $condition";
		return SELF::query($sql);
	}

	/**
	 * Steps through items or arrays in an array and applies mysql_real_escape_array().
	 * Precondition: a connection to the database
	 * @param mixed $array
	 * @return mixed $array
	 */
	public function escape_array($array) {
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$array[$key] = SELF::escape_array($value);
			} else {
				$array[$key] = mysql_real_escape_string($value);
			}
		}
		return $array;
	}

	public function get_array($sql) {
		$result = SELF::query($sql);
		while ($record = mysql_fetch_assoc($result)) {
			$records[] = $record;
		}
		return $records;
	}

	public function get_id_array($sql) {
		$result = SELF::query($sql);
		while (list($id, $txt) = mysql_fetch_row($result)) {
			$records[$id] = $txt;
		}
		return $records;
	}
}
?>
