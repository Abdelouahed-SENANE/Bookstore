<?php
require_once APPROOT . '/librearies/Model.php'; 
  class User extends Model {
    private $userID;
    private $name;
    private $email;
    private $password;

    public function __construct() {
        parent::__construct('users');
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