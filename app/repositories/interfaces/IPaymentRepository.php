<?php 
    interface IPaymentRepository {

        public function store(Payment $payement);
    }