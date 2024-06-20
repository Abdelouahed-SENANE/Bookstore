
<?php
interface IOrderRepository
{

    public function store(Order $order);
    public function delete($orderID);
    public function update(Order $order);
    public function getOneOrderById($orderID);
    public function updateStatusOrder($orderID, $status);
}
