<?php 
    class Category extends Model {
        private int $categoryID;
        private string $title;
        private string $description;

        public function __construct()
        {
            parent::__construct('categories');
        }

        public function __get($proprety){
            if (property_exists($this , $proprety)) {
                return $this->$proprety;
            }
        }
    
        public function __set($value , $proprety){
            if (property_exists($this , $proprety)) {
                return $this->$proprety = $value;
            }
        }
    }