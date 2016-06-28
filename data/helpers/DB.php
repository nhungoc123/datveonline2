<?php
require_once (HELPER_DIR . 'Connection.php');
/**
 * class modify from eccube 
 * use PDO library
 *
 */
class DB
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance()->_db();
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function begin()
    {
        return $this->conn->beginTransaction();
    }

    public function inTransaction()
    {
        return $this->conn->inTransaction();
    }

    public function insert($table, $arrVal)
    {
        $strcol = '';
        $strval = '';
        $arrValForQuery = array();

        foreach ($arrVal as $key => $val) {
            $strcol .= $key . ',';
            if (strcasecmp('Now()', $val) === 0) {
                $strval .= 'Now(),';
            } else if (strcasecmp('CURRENT_TIMESTAMP', $val) === 0) {
                $strval .= 'CURRENT_TIMESTAMP,';
            } else {
                $strval .= '?,';
                $arrValForQuery[] = $val;
            }
        }
        $strcol = rtrim($strcol, ',');
        $strval = rtrim($strval, ',');

        $sqli = "INSERT INTO $table($strcol) VALUES($strval)";
        return $this->sql($sqli, $arrValForQuery);
    }

    public function update($table, $arrVal, $where = '', $arrWhereVal = array())
    {
        $arrCol = array();
        $arrValForQuery = array();

        foreach ($arrVal as $key => $val) {
            if (strcasecmp('Now()', $val) === 0) {
                $arrCol[] = $key . '= Now()';
            } else if (strcasecmp('CURRENT_TIMESTAMP', $val) === 0) {
                $arrCol[] = $key . '= CURRENT_TIMESTAMP';
            } else {
                $arrCol[] = $key . '= ?';
                $arrValForQuery[] = $val;
            }
        }

        if (empty($arrCol)) {
            return false;
        }

        $strcol = implode(', ', $arrCol);

        $sqlup = "UPDATE $table SET $strcol";
        if (strlen($where) >= 1) {
            $sqlup .= " WHERE $where";
            if (!empty($arrWhereVal)) {
                $arrValForQuery = array_merge($arrValForQuery, $arrWhereVal);
            }
        }
        return $this->sql($sqlup, $arrValForQuery);
    }

    public function sql($sql, $arrValForQuery = array())
    {
        $stmt = $this->conn->prepare($sql);
        if (empty($arrValForQuery)) {
            return $stmt->execute();
        }
        return $stmt->execute($arrValForQuery);
    }

    public function select($cols, $from, $where = '', $arrWhereVal = array())
    {
        $sqlse = "SELECT $cols";
        $sqlse .= " FROM $from";

        if (strlen($where) > 0) {
            $sqlse .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($sqlse);

        if (empty($arrWhereVal)) {
            $stmt->execute();
        } else {
            $stmt->execute($arrWhereVal);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne($cols, $from, $where = '', $arrWhereVal = array())
    {
        $sqlse = "SELECT $cols";
        $sqlse .= " FROM $from";

        if (strlen($where) > 0) {
            $sqlse .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($sqlse);

        if (empty($arrWhereVal)) {
            $stmt->execute();
        } else {
            $stmt->execute($arrWhereVal);
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($table, $where = '', $arrWhereVal = array())
    {
        if (strlen($where) <= 0) {
            $sqlde = "DELETE FROM $table";
            return $this->sql($sqlde);
        } else {
            $sqlde = "DELETE FROM $table WHERE $where";
            return $this->sql($sqlde, $arrWhereVal);
        }
    }
    
    public function destroy()
    {
        $this->conn = null;
    }
}