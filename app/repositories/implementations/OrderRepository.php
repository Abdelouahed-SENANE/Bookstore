<?php 

    class OrderRepository implements IOrderRepository {

        private $order;

        public function __construct(Order $order)
        {
            $this->order = $order;

        }


        public function store(Order $order)
        {
            $data = [
                'userID' => $order->__get('userID'),
                'status' => $order->__get('status'),
                'orderDate' => $order->__get('orderDate'),
                'totalPrice' => $order->__get('totalPrice'),
            ];
            return $this->order->save($data);
        }

        public function delete($orderID)
        {
            $this->order->delete('orderID' , $orderID);
        }

        public function update(Order $order)
        {
            
        }

        public function updateStatusOrder($orderID , $status){

            $condition = [
                'orderID' => $orderID
            ];
             $this->order->updateOneColumn('status' , $status, $condition);
        }

        public function getOneOrderById($orderID)
        {
            return $this->order->findOneByColumn('orderID' , $orderID);
        }
    }