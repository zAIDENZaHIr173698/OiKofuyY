<?php
// 代码生成时间: 2025-09-01 07:58:26
// Ensure the autoloader is included
require 'vendor/autoload.php';

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class OrderProcessing {

    protected $dbAdapter;
    protected $orderTable;
    protected $orderItemTable;

    /**
     * Constructor
     *
     * @param Adapter $dbAdapter Database adapter
     * @param string $orderTableName Order table name
     * @param string $orderItemTableName Order item table name
     */
    public function __construct(Adapter $dbAdapter, $orderTableName, $orderItemTableName) {
        $this->dbAdapter = $dbAdapter;
        $this->orderTable = new TableGateway($orderTableName, $dbAdapter);
        $this->orderItemTable = new TableGateway($orderItemTableName, $dbAdapter);
    }

    /**
     * Process an order
     *
     * @param array $orderData Order data
     * @return bool
     */
    public function processOrder($orderData) {
        try {
            // Start transaction
            $this->dbAdapter->getDriver()->getConnection()->beginTransaction();

            // Insert order into the orders table
            $this->orderTable->insert($orderData);

            // Insert order items into the order_items table
            foreach ($orderData['items'] as $item) {
                $this->orderItemTable->insert($item);
            }

            // Commit transaction
            $this->dbAdapter->getDriver()->getConnection()->commit();

            return true;
        } catch (Exception $e) {
            // Rollback transaction
            $this->dbAdapter->getDriver()->getConnection()->rollback();

            // Log error and handle exception
            // error_log($e->getMessage());

            return false;
        }
    }

    /**
     * Get order details by ID
     *
     * @param int $orderId Order ID
     * @return array|null
     */
    public function getOrderDetails($orderId) {
        try {
            $order = $this->orderTable->select(['id' => $orderId])->current();
            if ($order) {
                $order['items'] = $this->orderItemTable->select(['order_id' => $orderId]);
                return $order;
            } else {
                return null;
            }
        } catch (Exception $e) {
            // Log error and handle exception
            // error_log($e->getMessage());

            return null;
        }
    }

}

// Usage example
/**
 * Database configuration
 */
$dbConfig = [
    'driver'    => 'Pdo',
    'dsn'       => 'mysql:dbname=your_database;host=localhost',
    'database'  => 'your_database',
    'username'  => 'your_username',
    'password'  => 'your_password',
];

$dbAdapter = new Adapter($dbConfig);

/**
 * Instantiate OrderProcessing and process an order
 */
$orderProcessor = new OrderProcessing($dbAdapter, 'orders', 'order_items');
$orderData = [
    'customer_id' => 1,
    'status' => 'pending',
    'items' => [
        ['product_id' => 1, 'quantity' => 2],
        ['product_id' => 2, 'quantity' => 1],
    ],
];

$result = $orderProcessor->processOrder($orderData);
if ($result) {
    echo "Order processed successfully.";
} else {
    echo "Order processing failed.";
}
