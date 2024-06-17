
<?php 
    interface ICartRepository {
        public function store(Cart $cart);
        public function findCartOfCustomer($userID);

    }