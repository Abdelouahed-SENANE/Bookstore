<?php 
require_once APPROOT . '/libraries/Model.php';
class Book extends Model {
    
    private int $bookID;
    private int $ISBN;
    private string $title;
    private string $description;
    private DateTime $publishDate;
    private string $bookImage;
    private float $price;

    public function __construct()
    {
        parent::__construct('books');
    }

    public function __get($proprety)
    {
        if (property_exists($this , $proprety)) {
            return $this->$proprety;
        }
        return null;
    }

    public function __set($proprety, $value)
    {
        if (property_exists($this , $proprety)) {
            return $this->$proprety = $value;
        }
    }
}