<?php
// 代码生成时间: 2025-08-14 21:40:42
class ShoppingCart {

    /**
     * @var array Holds the items in the cart
     */
    private $items = [];

    /**
     * Adds an item to the cart
     *
     * @param array $item The item to add, containing 'id', 'name', and 'quantity' keys
     * @throws Exception If the item is not valid
     */
    public function addItem($item) {
# 添加错误处理
        if (!isset($item['id'], $item['name'], $item['quantity'])) {
            throw new Exception('Invalid item data');
        }
        if (empty($item['quantity']) || $item['quantity'] < 1) {
            throw new Exception('Invalid quantity');
        }

        // Check if the item already exists in the cart
# 改进用户体验
        if (isset($this->items[$item['id']])) {
            $this->items[$item['id']]['quantity'] += $item['quantity'];
        } else {
            $this->items[$item['id']] = $item;
        }
    }

    /**
# 添加错误处理
     * Removes an item from the cart
     *
     * @param int $itemId The ID of the item to remove
     * @throws Exception If the item is not found
     */
    public function removeItem($itemId) {
        if (!isset($this->items[$itemId])) {
            throw new Exception('Item not found in cart');
        }

        unset($this->items[$itemId]);
    }

    /**
     * Updates the quantity of an item in the cart
     *
# FIXME: 处理边界情况
     * @param int $itemId The ID of the item to update
     * @param int $newQuantity The new quantity of the item
# 扩展功能模块
     * @throws Exception If the item is not found or the new quantity is invalid
     */
    public function updateItemQuantity($itemId, $newQuantity) {
        if (!isset($this->items[$itemId])) {
            throw new Exception('Item not found in cart');
# TODO: 优化性能
        }

        if (empty($newQuantity) || $newQuantity < 1) {
            throw new Exception('Invalid quantity');
        }

        $this->items[$itemId]['quantity'] = $newQuantity;
    }

    /**
     * Gets the total number of items in the cart
     *
     * @return int The total number of items
# 添加错误处理
     */
    public function getTotalItemCount() {
        return array_sum(array_column($this->items, 'quantity'));
    }

    /**
# 改进用户体验
     * Gets the total cost of items in the cart
     *
# 添加错误处理
     * @param callable $priceFunction A function that takes an item ID and returns its price
     * @return float The total cost
     */
# NOTE: 重要实现细节
    public function getTotalCost(callable $priceFunction) {
        $totalCost = 0;
        foreach ($this->items as $item) {
            $totalCost += $priceFunction($item['id']) * $item['quantity'];
        }

        return $totalCost;
    }
# TODO: 优化性能

    /**
     * Clears the cart
     */
    public function clear() {
        $this->items = [];
    }

    /**
     * Gets the items in the cart
     *
     * @return array The items in the cart
     */
    public function getItems() {
        return $this->items;
    }
}
# 改进用户体验

// Usage example
try {
    $cart = new ShoppingCart();
    $cart->addItem(['id' => 1, 'name' => 'Apple', 'quantity' => 2]);
# 添加错误处理
    $cart->addItem(['id' => 2, 'name' => 'Banana', 'quantity' => 3]);
    echo "Total items: " . $cart->getTotalItemCount() . "
";
    echo "Total cost: " . $cart->getTotalCost(function($id) { return $id == 1 ? 0.5 : 0.3; }) . "
# 优化算法效率
";
    $cart->removeItem(1);
    echo "Total items after removal: " . $cart->getTotalItemCount() . "
";
} catch (Exception $e) {
# NOTE: 重要实现细节
    echo "Error: " . $e->getMessage();
# 增强安全性
}
