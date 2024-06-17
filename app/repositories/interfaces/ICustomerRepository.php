<?php 

interface ICustomerRepository {
    public function store(Customer $customer);
}