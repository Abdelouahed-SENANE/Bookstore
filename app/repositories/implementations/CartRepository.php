<?php 

    class CartRepository implements ICartRepository {

        private $cart;

        public function __construct(Cart $cart)
        {
            $this->cart = $cart;
        }

        public function store(Cart $cart)
        {
            $data = [
                'userID' => $cart->__get('userID')
            ];
            $this->cart->save($data);
        }
        public function findCartOfCustomer($userID)
        {
            return $this->cart->findOneByColumn('userID' , $userID);
        }
    }