<?php
namespace Core;

class Db
{
    /*
     * The PDO connection using in this object to interact with database
     * You can specified the PDO connection in a method __construct() or setConnection() bellow
     * If you not specified the PDO connection, a new PDO connection will be create with config at define.php
     */
    public static \PDO $connection;
    /*
     * The table you want to interact with
     * You can specified the table by method table() bellow
     */
    protected $table;
    /*
     * The error code when during in this object
     */
    protected $error = null;
    /*
     * The error message when during in this object
     */
    protected $errorText = null;
    /*
     * The statement that store the sql after binding value
     */
    protected $statement = null;
    /*
     * The result when exec the statement of this
     */
    private $result = null;
    /*
     * The where condition clause to using in get data, delete data, update data
     * You can add more one condition by using more than one time of method where bellow
     */
    private $where = [];
    /*
     * The fields that you want to get in get data
     * You can add more one fields by using more than one time of method select() bellow
     */
    private $select = [];
    /*
     * Ordering when get data
     * You can add more one order state by using method order() bellow
     */
    private $order = [];
    /*
     * Stored the position of row that you want to start get data from
     * You can specified the offset by using the method offset() 
     */
    private $offset = null;
    /*
     * Stored the number of row that you want to get data
     * You can specified this by using the method limit()
     */
    private $limit = null;
    /*
     * Stored the group clause to using in get data
     * You can add more than one group clase by using more than one method group()
     */
    private $group = [];

    /**
     * Create an instance of active record
     * You can passed the connection to handle database connection,
     * but you don't passed the connection, the connection with the parameter in define.php will use to create default connection.
     * 
     * @param object $connection PDO connection to use in active record
     */
    public function __construct($connection = null)
    {
        $this->error = null;
        $this->statement = null;
        if (null != $connection) {
            $this->setConnection($connection);
        } else if (!isset ($this::$connection)){
            $dbConfig = new \App\Config\Db();
            $dsn = "mysql:host=".$dbConfig->dbHost.";dbname=" . $dbConfig->dbName . ";charset=utf8";
            $this::$connection = new \PDO($dsn, $dbConfig->dbUser, $dbConfig->dbPass);
            $this::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * Set the PDO connection
     * 
     * you can set the PDO connection at whenever you want. The already connection will be replace by new that you passed in.
     * 
     * @param object $connection PDO connection to set into this object
     * @return object this object that after implement new connection
     */
    public function setConnection($connection)
    {
        $this::$connection = $connection;
        return $this;
    }

    /**
     * Get current connection object
     * 
     * @return object current connection object of this object
     */
    public function getConnection()
    {
        return $this::$connection;
    }

    /**
     * Set the effect table to action with
     * 
     * @param string $tableName Description
     * @return object ActiveRecord object that after specified the table name to action with
     */
    public function table($tableName)
    {
        $this->table = $tableName;
        return $this;
    }

    /**
     * Insert the data into the table specified before
     * 
     * @param mixed $data the data to insert into the table specified before
     * @return bool
     */
    public function insert($data = [])
    {
        $sql = 'INSERT INTO __table__(__fields__) VALUES (__values__)';
        $sql = str_replace('__table__', $this->table, $sql);

        $fields = array_keys($data);
        $sql = str_replace('__fields__', implode(", ", $fields), $sql);

        $values = [];
        foreach ($data as $key => $item) {
            array_push($values, ":" . $key);
        }
        $sql = str_replace('__values__', implode(", ", $values), $sql);
        $this->statement = $this::$connection->prepare($sql);
        foreach ($data as $key => $item) {
            $this->statement->bindValue(":" . $key, $item);
        }
        return $this->getResult();
    }

    /**
     * Override the data into the table specified before
     * 
     * @param mixed $data the data to override into the table specified before
     * @return bool
     */
    public function update($data = [])
    {
        $sql = 'UPDATE __table__ SET __set__ __where__';
        $sql = str_replace('__table__', $this->table, $sql);

        $set = [];
        foreach ($data as $key => $item) {
            array_push($set, $key . "=" . ":set_" . $key);
        }
        $setStr = implode(", ", $set);
        $sql = str_replace('__set__', $setStr, $sql);

        $sql = str_replace('__where__', $this->getWhereString(), $sql);

        $this->statement = $this::$connection->prepare($sql);
        foreach ($data as $key => $item) {
            $this->statement->bindValue(":set_" . $key, $item);
        }
        $this->bindWhereStatement();
        return $this->getResult();
    }

    /**
     * Delete the data in the table that was specified earlier
     * 
     * You can set the condition to delete data. If not, all data of table will be deleted.
     * 
     * @return bool true if delete successful, false if get an error when deleting the data
     */
    public function delete()
    {
        $sql = 'DELETE FROM __table__ __where__';
        $sql = str_replace("__table__", $this->table, $sql);
        $sql = str_replace("__where__", $this->getWhereString(), $sql);
        $this->statement = $this::$connection->prepare($sql);

        $this->bindWhereStatement();

        return $this->getResult();
    }

    /**
     * Add the fields to select in the get data
     * 
     * If you not specified the select, "*" will be using when get the data
     * @param string $select fields to select in the get data.
     * @return object ActiveRecord object after add fields passed
     */
    public function select($select = '')
    {
        array_push($this->select, $select);
        return $this;
    }

    /**
     * Get the data from statement of ActiveRecord
     * 
     * @return array|bool An array of result if it is not empty, otherwise return false
     */
    public function result()
    {
        $data = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($data)) {
            return false;
        }
        return $data;
    }

    /**
     * Create a statement for get data
     * 
     * @return object ActiveRecord that after create statement for get data
     */
    public function get()
    {
        $sql = 'SELECT __select__ FROM __table__ __where__ __group__ __order__ __limit__ __offset__';
        $sql = str_replace("__table__", $this->table, $sql);
        $sql = str_replace("__select__", $this->getSelectString(), $sql);
        $sql = str_replace("__where__", $this->getWhereString(), $sql);
        $sql = str_replace("__group__", $this->getGroupString(), $sql);
        $sql = str_replace("__order__", $this->getOrderString(), $sql);
        $sql = str_replace("__limit__", $this->getLimitString(), $sql);
        $sql = str_replace("__offset__", $this->getOffsetString(), $sql);
        $this->statement = $this::$connection->prepare($sql);
        $this->bindWhereStatement();
        $this->getResult();

        return $this;
    }

    /**
     * Add condition for actions on the the table
     * 
     * You can add the condition for deleting data, get data on the table specified
     * 
     * @param array|string $field An array (as format field=>value) of condition with operation of "=", or a string of field to adding into condition
     * @param string $value the value of condition 
     * @param string $operation the operation to compare, if you not specified, the operation "=" will be using.
     * @return object ActiveRecord object after add condition
     */
    public function where()
    {
        $input = func_get_args();
        if (1 == count($input)) {
            if (is_array($input[0])) {
                foreach ($input[0] as $key => $value) {
                    $this->addWhere($key, $value);
                }
            }
        } else {
            if (!isset($input[2])) {
                $input[2] = '=';
            }
            $this->addWhere($input[0], $input[1], $input[2]);
        }
        return $this;
    }

    /**
     * Add order to get data
     * 
     * @param array $order An array as orderField=>orderType
     * @return object ActiveRecord object after add order to get data
     */
    public function order($order = [])
    {
        foreach ($order as $key => $item) {
            $this->order[$key] = strtoupper($item);
        }
        return $this;
    }

    /**
     * Set the total of records to get data
     * 
     * @param int $limit The number of records
     * @return object ActiveRecord after set the total of records to get data
     */
    public function limit($limit = 1)
    {
        $this->limit = preg_replace('/[^0-9]/i', '', $limit);
        if ('' === trim($this->limit)) {
            $this->limit = 1;
        }
        return $this;
    }

    /**
     * Set the start offset the get data
     * 
     * @param int $offset the position of row to start get data
     * @return object ActiveRecord object after set the start offset to get data
     */
    public function offset($offset = 0)
    {
        $this->offset = preg_replace('/[^0-9]/i', '', $offset);
        if ('' === trim($this->offset)) {
            $this->offset = 0;
        }
        return $this;
    }

    /**
     * Add the fields to group data
     * 
     * @param string $group Groups separated by comma (",")
     * @return object ActiveRecord after add fields to group data
     */
    public function group($group)
    {
        array_push($this->group, $group);
        return $this;
    }

    /**
     * Run any sql command
     * 
     * @param string $sql The sql command to run
     * @return  int|bool if run sql with no error, return true, otherwise, return error code
     */
    public function execSql($sql)
    {
        $this->error = null;
        $this->statement = null;
        try {
            $this->statement = $this::$connection->prepare($sql);
            $result = $this->statement->execute();
        } catch (Exception $ex) {
            $result = $ex->getCode();
            $this->error = $ex->getCode();
        }
        return $result;
    }

    /**
     * Reset all state of ActiveRecord into default state as initial
     * 
     * @return object ActiveRecord after reset all state into default
     */
    public function reset()
    {
        $this->error = null;
        $this->errorText = null;
        $this->statement = null;
        $this->result = null;
        $this->where = [];
        $this->select = [];
        $this->order = [];
        $this->offset = null;
        $this->limit = null;
        $this->group = [];
        return $this;
    }
    public function getError(){
        return $this->error;
    }
    public function getErrorText(){
        return $this->errorText;
    }

    private function addWhere($field, $value, $comparation = '=')
    {
        array_push($this->where, [
            'field' => $field,
            'value' => $value,
            'comparation' => $comparation
        ]);
    }

    private function getResult()
    {
        try {
            $this->result = $this->statement->execute();
        } catch (Exception $ex) {
            $this->result = false;
            $this->error = $ex->getCode();
            $this->errorText = $ex->getMessage();
        }
        return $this->result;
    }

    private function getWhereString()
    {
        if (empty($this->where)) {
            return "";
        } else {
            $where = [];
            foreach ($this->where as $key => $item) {
                array_push($where, $item['field'] ." ". $item['comparation'] ." ". ":where_" . $key . "_" . $item['field']);
            }
            $whereStr = "WHERE " . implode(" AND ", $where);
            return $whereStr;
        }
    }

    private function getLimitString()
    {
        if (!isset($this->limit)) {
            return "";
        } else {
            return "LIMIT " . $this->limit;
        }
    }

    private function getOffsetString()
    {
        if (!isset($this->offset)) {
            return "";
        } else {
            return "OFFSET " . $this->offset;
        }
    }

    private function getOrderString()
    {
        if (empty($this->order)) {
            return '';
        } else {
            $orderAr = [];
            foreach ($this->order as $key => $value) {
                array_push($orderAr, $key . " " . $value);
            }
            return $order = "ORDER BY " . implode(", ", $orderAr);
        }
    }

    private function getGroupString()
    {
        if (empty($this->group)) {
            return '';
        } else {
            return $order = "GROUP BY " . implode(", ", $this->group);
        }
    }

    private function getSelectString()
    {
        if (empty($this->select)) {
            return "*";
        }
        return implode(", ", $this->select);
    }

    private function bindWhereStatement()
    {
        if (!empty($this->where)) {
            foreach ($this->where as $key => $item) {
                $this->statement->bindValue(":where_" . $key . "_" . $item['field'], $item['value']);
            }
        }
    }

}
