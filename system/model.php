<?php

/**
 * Handles database and mysql query related operations
 *
 * Class Model
 */
class Model extends mysqli
{
    /**
     * Initialize database connection
     *
     * Model constructor.
     */
    public function __construct()
    {
        global $config;

        parent::__construct($config['dbHost'], $config['dbUsername'], $config['dbPassword'], $config['dbName'], 3306);

        if ($this->connect_errno) {
            die('Connect Error (' . $this->connect_errno . ') ' . $this->connect_error);
        }

        if (!$this->select_db($config['dbName'])) {
            die($this->error);
        }
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public function escapeString($string)
    {
        return str_replace(['%', '_'], ['\%', '\_'], $string);
    }

    /**
     * @param $values
     * @return string
     * @throws Exception
     */
    public function getParamsTypes($values)
    {
        $types = '';
        $params = [];

        foreach ($values as $i => $value) {
            if ($value === null || is_integer($value)) {
                $types .= 'i';
                $params[] = $value;
                continue;
            }

            if (is_bool($value)) {
                $types .= 'i';
                $value = (int)$value;
                $params[] = $value;
                continue;
            }

            if (is_float($value)) {
                $types .= 'd';
                $params[] = $value;
                continue;
            }

            if (is_string($value)) {
                $types .= 's';
                $params[] = $value;
                continue;
            }

            throw new Exception('Unknown type passed.');
        }

        return $types;
    }

    /**
     * @param $sql
     * @param null $params
     *
     * @return mysqli_stmt
     */
    public function prepareStatement($sql, $params = null)
    {
        $statement = new mysqli_stmt($this, $sql);

        if ($params !== null) {
            $types = $this->getParamsTypes($params);
            $refs = [];

            foreach ($params as $i => $param)
                $refs[] = &$params[$i];

            call_user_func_array([$statement, 'bind_param'], array_merge([$types], $refs));
        }

        return $statement;
    }

    /**
     * @param $sql
     * @param null $params
     * @return bool|mysqli_result
     */
    public function doQuery($sql, $params = null)
    {
        if (!$params) {
            $params = null;
        }

        $statement = $this->prepareStatement($sql, $params);
        $statement->execute();
        return $statement->get_result();
    }

    /**
     * @param $sql
     * @param null $params
     * @return mixed
     */
    public function fetchArray($sql, $params = null)
    {
        $result = $this->doQuery($sql, $params);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param $sql
     * @param null $params
     * @return array
     */
    public function fetchAssoc($sql, $params = null)
    {
        $result = $this->doQuery($sql, $params);

        return $result->fetch_assoc();
    }

    /**
     * @param $table
     * @param $column
     * @return array
     * @throws Exception
     */
    public function getEnumValues($table, $column)
    {
        $enum = [];
        if (!$table || !$column) {
            throw new Exception("Table name and column name are required!");
        }

        $sql = "SHOW COLUMNS FROM $table LIKE '$column'";
        $result = $this->doQuery($sql);
        $row = $result->fetch_assoc();
        $type = $row['Type'];
        preg_match('/enum\((.*)\)$/', $type, $matches);
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }

        return $enum;
    }

    /**
     * @param $table
     * @param $array
     * @return mixed
     */
    public function doInsert($table, $array)
    {
        $fields = '';
        $values = '';
        $params = [];

        $cnt = 0;
        foreach ($array as $key => $val) {
            $f = ($cnt == 0) ? "(" : "";
            $fields .= $f;
            $values .= $f;

            $fields .= $key;
            $values .= "?";
            $params[] = $this->escapeString($val);

            $cnt++;

            $v = ($cnt == count($array)) ? ")" : ",";
            $fields .= $v;
            $values .= $v;


        }

        $query = "INSERT INTO $table $fields VALUES $values";
        $this->doQuery($query, $params);

        return $this->insert_id;
    }

}

?>
