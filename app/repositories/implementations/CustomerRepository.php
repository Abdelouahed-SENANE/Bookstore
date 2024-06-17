<?php 
    class CustomerRepositoy implements ICustomerRepository {
        private $repository;

        public function __construct(Customer $customer)
        {
            $this->repository = $customer;
        }
        public function store(Customer $customer)
        {
            $data = [
                'userID' => $customer->__get('userID')
            ];
            $this->repository->save($data);
        }
    }