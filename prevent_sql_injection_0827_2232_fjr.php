<?php
// 代码生成时间: 2025-08-27 22:32:50
// prevent_sql_injection.php
// This file demonstrates how to prevent SQL injection using Zend Framework's DB component

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

class DbService {
    /**
     * Database adapter
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
    private $dbAdapter;

    public function __construct() {
        $this->dbAdapter = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'test_db'
        ));
    }

    /**
     * Fetches data from the database using prepared statements to prevent SQL injection
     *
     * @param string $query The SQL query to execute
     * @param array $params Parameters to bind to the query
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function fetchData($query, $params = array()) {
        try {
            $stmt = $this->dbAdapter->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            // Handle error
            error_log('SQL Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Inserts data into the database using prepared statements to prevent SQL injection
     *
     * @param string $table The table name to insert into
     * @param array $data Data to insert
     * @return int The last insert ID or 0 if no insert was made
     */
    public function insertData($table, $data) {
        try {
            // Begin transaction
            $this->dbAdapter->beginTransaction();
            
            // Prepare SQL statement
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            $stmt = $this->dbAdapter->prepare($query);
            
            // Bind parameters and execute
            $stmt->execute($data);
            
            // Commit transaction
            $this->dbAdapter->commit();

            // Return last insert ID
            return $this->dbAdapter->lastInsertId();
        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->dbAdapter->rollBack();
            // Handle error
            error_log('SQL Error: ' . $e->getMessage());
            throw $e;
        }
    }
}

// Usage
$dbService = new DbService();

// Fetch data example
$query = 'SELECT * FROM users WHERE id = :id';
$params = array('id' => 1);
$data = $dbService->fetchData($query, $params);

// Insert data example
$table = 'users';
$data = array('username' => 'john_doe', 'email' => 'john@example.com');
$insertId = $dbService->insertData($table, $data);
