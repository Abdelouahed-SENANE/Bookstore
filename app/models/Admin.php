<?php 

    class Admin extends User {
        

        public function __construct($name , $email , $password)
        {
            parent::__construct($name , $email , $password);
        }

        
    }