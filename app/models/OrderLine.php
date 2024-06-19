<?php
     class OrderLine extends Model {
        private int $orderLineID;
        private int $orderID;
        private int $bookID;
        private int $quantity;
        private float $price;
        
        public function __construct()
        {
            parent::__construct('orderLines');
        }
        public function __get($proprety){
            if (property_exists($this , $proprety)) {
                return $this->$proprety;
            }
        }
    
        public function __set($value , $proprety){
            if (property_exists($this , $proprety)) {
                return $this->$proprety = $value;
            }
        }
     }