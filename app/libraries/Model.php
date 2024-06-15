<?php 
    abstract class Model {
        private string $tableName;
        private array $columns = [];
        private object $connection ;

        public function __construct($tableName)
        {
            
        }



    }