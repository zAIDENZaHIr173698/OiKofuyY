<?php
// 代码生成时间: 2025-08-18 16:05:50
class ShoppingCart {

    private $items = [];

    /**
     * Adds an item to the shopping cart.
     *
     * @param array $item
     */
    public function addItem($item) {
        if (!isset($item['id']) || !isset($item['name']) || !isset($item['price']) || !isset($item['quantity'])) {
            throw new InvalidArgumentException('Item must have id, name, price, and quantity.');
        }

        if (!array_key_exists($item['id'], $this->items)) {
            $this->items[$item['id']] = $item;
        } else {
            $this->items[$item['id']]['quantity'] += $item['quantity'];
        }
    }

    /**
     * Removes an item from the shopping cart.
     *
     * @param int $itemId
     */
    public function removeItem($itemId) {
        if (array_key_exists($itemId, $this->items)) {
            unset($this->items[$itemId]);
        } else {
            throw new InvalidArgumentException('Item not found in cart.');
        }
    }

    /**
     * Updates the quantity of an item in the shopping cart.
     *
     * @param int $itemId
     * @param int $quantity
     */
    public function updateQuantity($itemId, $quantity) {
        if (array_key_exists($itemId, $this->items)) {
            if ($quantity <= 0) {
                $this->removeItem($itemId);
            } else {
                $this->items[$itemId]['quantity'] = $quantity;
            }
        } else {
            throw new InvalidArgumentException('Item not found in cart.');
        }
    }

    /**
     * Returns the total number of items in the shopping cart.
     *
     * @return int
     */
    public function getTotalItems() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }

    /**
     * Returns the total cost of all items in the shopping cart.
     *
     * @return float
     */
    public function getTotalCost() {
        $totalCost = 0.0;
        foreach ($this->items as $item) {
            $totalCost += $item['price'] * $item['quantity'];
        }
        return $totalCost;
    }

    /**
     * Returns the list of items in the shopping cart.
     *
     * @return array
     */
    public function getItems() {
        return $this->items;
    }
}

// Example usage:
try {
    $cart = new ShoppingCart();
    $cart->addItem(['id' => 1, 'name' => 'Laptop', 'price' => 999.99, 'quantity' => 1]);
    $cart->addItem(['id' => 2, 'name' => 'Mouse', 'price' => 19.99, 'quantity' => 2]);
    echo "Total items: " . $cart->getTotalItems() . "
";
    echo "Total cost: $" . $cart->getTotalCost() . "
";
    $cart->updateQuantity(2, 1);
    echo "Updated total cost: $" . $cart->getTotalCost() . "
";
    $cart->removeItem(1);
    echo "Total items after removal: " . $cart->getTotalItems() . "
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
