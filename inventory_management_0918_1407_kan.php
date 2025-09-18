<?php
// 代码生成时间: 2025-09-18 14:07:18
require 'vendor/autoload.php';

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

// Database configuration
$adapter = new Adapter(
    array(
        'driver'   => 'Pdo_Mysql',
        'database' => 'inventory_db',
        'username' => 'db_user',
        'password' => 'db_password',
        'hostname' => 'localhost'
    )
);

// Product Table Gateway
$productTable = new TableGateway('products', $adapter);

class InventoryManagement {
    protected $productTable;

    // Constructor
    public function __construct(TableGateway $productTable) {
        $this->productTable = $productTable;
    }

    // Add a new product to the inventory
    public function addProduct($productId, $productName, $productQuantity) {
        try {
            $this->productTable->insert(
                array(
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'product_quantity' => $productQuantity
                )
            );
        } catch (Exception $e) {
            // Handle exceptions or log errors
            echo "Error adding product: " . $e->getMessage();
        }
    }

    // Update an existing product in the inventory
    public function updateProduct($productId, $productName, $productQuantity) {
        try {
            $this->productTable->update(
                array(
                    'product_name' => $productName,
                    'product_quantity' => $productQuantity
                ),
                array('product_id' => $productId)
            );
        } catch (Exception $e) {
            // Handle exceptions or log errors
            echo "Error updating product: " . $e->getMessage();
        }
    }

    // Delete a product from the inventory
    public function deleteProduct($productId) {
        try {
            $this->productTable->delete(array('product_id' => $productId));
        } catch (Exception $e) {
            // Handle exceptions or log errors
            echo "Error deleting product: " . $e->getMessage();
        }
    }

    // Retrieve all products from the inventory
    public function getAllProducts() {
        try {
            return $this->productTable->select();
        } catch (Exception $e) {
            // Handle exceptions or log errors
            echo "Error retrieving products: " . $e->getMessage();
        }
    }
}

// Example usage
$inventory = new InventoryManagement($productTable);
$inventory->addProduct(1, 'Product 1', 100);
$inventory->updateProduct(1, 'Updated Product 1', 150);
$inventory->deleteProduct(2);
$products = $inventory->getAllProducts();
print_r($products);
