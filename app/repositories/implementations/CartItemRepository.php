<?php


class CartItemRepository implements ICartItemRepository
{
    private $repository;
    private $connection;
    public function __construct(CartItem $cartItem)
    {
        $this->connection = Database::getInstance()->connect();
        $this->repository = $cartItem;
    }
    public function addToCart($cartID, $bookID , $quantity)
    {
        $data = [
            'cartID' => $cartID,
            'bookID' => $bookID,
            'quantity' => $quantity
        ];
        $this->repository->save($data);
    }
    public function deleteFromCart($cartID, $bookID)
    {
        try {
            $query = 'DELETE FROM cartItems WHERE cartID = :cartID AND bookID = :bookID';
            $statment = $this->connection->prepare($query);
            $statment->bindParam(':cartID' , $cartID);
            $statment->bindParam(':bookID' , $cartID);
            $statment->execute();
        } catch (Exception $e) {
            die('Error Throw Database' . $e->getMessage());
        }
    }

    public function showBooksInCart($cartID)
    {
        return $this->repository->findByColumn('cartID' , $cartID);
    }
}
