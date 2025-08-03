<?php
// 代码生成时间: 2025-08-03 11:37:31
// Ensure the autoloader is included to handle class loading.
require_once 'vendor/autoload.php';

use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ShoppingCartController extends AbstractActionController
{
    /**
     * @var TableGateway
     */
    protected $cartTable;

    public function __construct(TableGateway $cartTable)
    {
        $this->cartTable = $cartTable;
    }

    /**
     * Add an item to the shopping cart.
     *
     * @param int $productId
     * @return JsonModel
     */
    public function addItemAction($productId)
    {
        try {
            $cartItem = [
                'product_id' => $productId,
                'quantity' => 1,
                'added_on' => date('Y-m-d H:i:s')
            ];
            $this->cartTable->insert($cartItem);
            return new JsonModel(['success' => true, 'message' => 'Item added to cart']);
        } catch (Exception $e) {
            return new JsonModel(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove an item from the shopping cart.
     *
     * @param int $itemId
     * @return JsonModel
     */
    public function removeItemAction($itemId)
    {
        try {
            $this->cartTable->delete(['id' => $itemId]);
            return new JsonModel(['success' => true, 'message' => 'Item removed from cart']);
        } catch (Exception $e) {
            return new JsonModel(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get the shopping cart items.
     *
     * @return JsonModel
     */
    public function getCartItemsAction()
    {
        try {
            $cartItems = $this->cartTable->select();
            return new JsonModel(['success' => true, 'items' => $cartItems]);
        } catch (Exception $e) {
            return new JsonModel(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
