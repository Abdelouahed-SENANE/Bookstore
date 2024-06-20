<?php 

    interface IOrderLineRepository {
        public function store(array $data , $orderID);
    }