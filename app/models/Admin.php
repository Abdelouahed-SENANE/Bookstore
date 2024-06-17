<?php 
    require './User.php';
    class Admin extends User {
        private int $userID;

        public function __construct()
        {
        }

        public function __get($proprety)
        {
            if (property_exists($this , $proprety)) {
                return $this->$proprety;
            }
            return null;
        }
        
        public function __set($value, $proprety)
        {
            if (property_exists($this , $proprety)) {
                return $this->$proprety = $value;
            }
            return null;
        }
    }