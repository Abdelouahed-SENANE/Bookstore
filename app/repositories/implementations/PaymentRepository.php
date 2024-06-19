<?php 

    class PaymentRepository implements IPaymentRepository {
        private $payement;
        public function __construct(Payment $payement)
        {
            $this->payement = $payement;
        }
        
        public function store(Payment $payement)
        {
            $data = [
                'orderID' => $payement->__get('orderID'),
                'status' => $payement->__get('status'),
                'amount' => $payement->__get('amount')
            ];

            return $this->payement->save($data);
        }
    }