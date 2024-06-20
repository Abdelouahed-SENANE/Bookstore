<?php 
    interface IPaymentRepository {

        public function store(Payment $payement);
        public function updateStatus($sessionID , $value);
        public function getPaymentBySessionID(string $sessionID);
    }