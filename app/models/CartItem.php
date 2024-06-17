<?php
    class CartItem extends Model {
        private int $quantity;
        private int $bookID;
        private int $cartID;

        public function __construct()
        {
            parent::__construct('CartItems');

        }
        public function __get($proprety)
        {
            if (property_exists($this, $proprety)) {
                return $this->$proprety;
            }
            return null;
        }
    
        public function __set($proprety, $value)
        {
            if (property_exists($this, $proprety)) {
                return $this->$proprety = $value;
            }
        }
    }