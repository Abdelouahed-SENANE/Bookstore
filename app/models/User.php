<?php

abstract class User {
    private $name;
    private $email;
    private $password;

    public function __construct() {

    }

    public function __get($proprety){
        if (property_exists($this , $proprety)) {
            return $this->$proprety
        }
    }

    public function __set($value , $proprety){
        if (property_exists($this , $proprety)) {
            return $this->$proprety = $value;
        }
    }

    public function login($email , $password){
        try {
            
        } catch (Exception $e) {
            return echo $e->getMessage()
        }
    }
}