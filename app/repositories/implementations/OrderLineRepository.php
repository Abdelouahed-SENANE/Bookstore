<?php 

    class orderLineRepository implements IOrderLineRepository {
        
        private $orederLine;

        public function __construct(OrderLine $orderLine)
        {
            $this->orederLine = $orderLine;
        }


        public function store(array $cartItems , $orderID)
        {
            $orderLines = [];
            foreach($cartItems as $cartItem) {
                $orderLines[] = [
                    'orderID' => $orderID,
                    'bookID'=> $cartItem['bookID'],
                    'quantity'=> $cartItem['quantity'],
                ];
            }
            foreach($orderLines as $orderline){
                $this->orederLine->save($orderline);
            }
        }
    }