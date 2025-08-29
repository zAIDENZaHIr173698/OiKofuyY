<?php
// 代码生成时间: 2025-08-30 06:12:53
 * PHP and Zend Framework, ensuring code maintainability and extensibility.
 */
class ShoppingCart {

    /**
     * @var array An array to hold the cart items.
     */
    private $items = [];

    /**
     * Add an item to the cart.
     *
     * @param string $id The ID of the item.
     * @param int $quantity The quantity of the item.
     * @return void
     * @throws InvalidArgumentException If the quantity is less than 1.
     */
    public function addItem($id, $quantity) {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be 1 or more.');
        }

        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = ['quantity' => $quantity];
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param string $id The ID of the item.
     * @param int $quantity The quantity of the item to remove.
     * @return void
     * @throws InvalidArgumentException If the quantity is less than 1 or more than the item's quantity in the cart.
     */
    public function removeItem($id, $quantity) {
        if ($quantity < 1 || (isset($this->items[$id]) && $quantity > $this->items[$id]['quantity'])) {
            throw new InvalidArgumentException('Invalid quantity to remove.');
        }

        if ($this->items[$id]['quantity'] === $quantity) {
            unset($this->items[$id]);
        } else {
            $this->items[$id]['quantity'] -= $quantity;
        }
    }

    /**
     * Get the total quantity of items in the cart.
     *
     * @return int The total quantity of items.
     */
    public function getTotalQuantity() {
        $totalQuantity = 0;
        foreach ($this->items as $item) {
            $totalQuantity += $item['quantity'];
        }
        return $totalQuantity;
    }

    /**
     * Get the items in the cart.
     *
     * @return array The items in the cart.
     */
    public function getItems() {
        return $this->items;
    }
}
