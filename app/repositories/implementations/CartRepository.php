<?php 

    class CartRepository implements ICartRepository {

        private $repository;

        public function __construct(Cart $cart)
        {
            $this->repository = $cart;
        }

        public function store(Cart $cart)
        {
            $data = [
                'userID' => $cart->__get('userID')
            ];
            $this->repository->save($data);
        }
        public function findCartOfCustomer($userID)
        {
            return $this->repository->findOneByColumn('userID' , $userID);
        }
    }