<?php
class Cart extends Model
{
    private int $cartID;
    private int $userID;

    public function __construct()
    {
        parent::__construct('carts');
    }
    
    public function __get($proprety)
    {
        if (property_exists($this, $proprety)) {
            return $this->$proprety;
        }
        return null;
    }

    public function __set($proprety, $value)
    {
        if (property_exists($this, $proprety)) {
            return $this->$proprety = $value;
        }
    }
}
