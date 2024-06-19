<?php
    class Order extends Model {
        private int $orderID;
        private int $userID;
        private string $status;
        private DateTime $orderDate;
        private float $totalPrice;

        public function __construct()
        {
            parent::__construct('orders');

        }

        public function __get($proprety)
        {
            if (property_exists($this , $proprety)) {
                return $this->$proprety;
            }
            return null;
        }
    
        public function __set($proprety, $value)
        {
            if (property_exists($this , $proprety)) {
                return $this->$proprety = $value;
            }
        }

    }