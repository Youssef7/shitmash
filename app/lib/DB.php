<?php

class DB {

	/**
	 * Instance of the DB Object.
	 *
	 * @var DB Object
	 */
    private static $instance = null;

	/**
	 * PDO instance of the database connection.
	 *
	 * @var PDO Object
	 */    
    private $pdo;

	/**
	 * The statement object returned by the PDO's prepare function
	 *
	 * @var PDOStatement Object
	 */
    private $query;
    
    /**
     * An array containing all of the result set rows 
     *
     * @var array
     */
    private $results;
    
    /**
     * The number of rows affected by the last SQL statement
     *
     * @var int
     */
    private $count = 0;

    /**
     * TRUE on success or FALSE on failure of the query() function  
     *
     * @var bool
     */
    private $error = false;

    /**
     * Sets the $pdo property with a PDO instance once for all. 
     *
     */
    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DBNAME, USERNAME, PASSWORD);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Returns an instance of DB after checking if it's already instancied   
     *
     * @return DB Object
     */
    public static function get_instance() {
        if(!isset(self::$instance)) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    /**
     * Executes a generic sql statement. In the occurence of an error
     * it sets the $error property to True.
     *
     * @param string $sql The sql statement.
     * @param array $params The values to bind. 
     * @return DB Object
     */
    public function query($sql, $params = []) {
        $this->error = false;

        if($this->query = $this->pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->query->execute()) {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        }

        return $this;
    }

    /**
     * Executes an action using the query() function. Generally,
     * Delete or SELECT.
     *  
     * @param string $action Delete's action for example.
     * @param string $table The table name.
     * @param array $where The where condition. An array of the field 
     *        on which the action will occur, the comparator and the new value.
     *
     * @return DB|false DB object, false otherwise.	
     */
    public function action($action, $table, $where = []) {
        if(count($where) === 3) {
            $operators = ['=', '>', '<', '>=', '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }

        }

        return false;
    }

    /**
     * Inserts a new row in the database using the query() function.
     *   
     * @param string $table The table name.
     * @param array $fields The row fields.
	 *
	 * @return bool If the row is inserted or not.	
     */
    public function insert($table, $fields = []) {
        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    /**
     * Updates a table's row by the $id using the query() function.
     *  
     * @param string $table The table name.
     * @param int $id The row id.
     * @param array $fields The new fields.
     *
     * @return bool If the row is updated or not.
     */
    public function update($table, $id, $fields = []) {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count ($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    /**
     * Deletes a row using the action() function.
     *  
     * @param string $table The table name.
     * @param array $where The where condition. An array of the field 
     *        on which the action will occur, the comparator and the new value.
     *
     * @return DB|false DB object, false otherwise.
     */
    public function delete($table, $where = []) {
        return $this->action('DELETE ', $table, $where);
    }

    /**
     * Retrieves a table rows that conform to the condition.
     *  
     * @param string $table The table name.
     * @param array $where The where condition. An array of the field 
     *        on which the action will occur, the comparator and the new value.
     *
     * @return DB|false DB object, false otherwise.
     */
    public function get($table, $where = []) {
        return $this->action('SELECT *', $table, $where);
    }

    /**
     * Returns the $results property.
     *  
     * @return array
     */
    public function results() {
        return $this->results;
    }

    /**
     * Returns the first element of $results, which is an array itself.
     *  
     * @return array
     */
    public function first() {
        return $this->results()[0];
    }

    /**
     * Returns the $count property.
     *  
     * @return int
     */
    public function count() {
        return $this->count;
    }

    /**
     * Returns the $error property.
     *  
     * @return bool
     */
    public function error() {
        return $this->error;
    }
}