<?php 
    class CustomerRepositoy implements ICustomerRepository {
        private $customer;

        public function __construct(Customer $customer)
        {
            $this->customer = $customer;
        }
        public function store(Customer $customer)
        {
            $data = [
                'userID' => $customer->__get('userID')
            ];
            $this->customer->save($data);
        }
    }