<?php 
    class Payment extends Model {
        private int $payementID;
        private int $orderID;
        private float $amount;
        private string $sessionID;
        private string $status;

        public function __construct()
        {
            parent::__construct('payments');
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