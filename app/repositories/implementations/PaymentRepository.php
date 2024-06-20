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

        public function updateStatus($sessionID , $value)
        {
            $condition = [
                'sessionID' => $sessionID
            ];
            $this->payement->updateOneColumn('status' , $value , $condition);
        }

        public function getPaymentBySessionID(string $sessionID)
        {
            return $this->payement->findOneByColumn('sesseionID' , $sessionID);
        }
    }