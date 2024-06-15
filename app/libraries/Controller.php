<?php

    class Controller{
        // Load Model
        public function model($model) {
            // Require model file 
            require_once '../app/models/'. $model .'.php';
            // Instance model
            return new $model();
        }
        // load Service  ================
        public function service($service) {
            $servicePathFile = '../app/services/'. $service .'.php';
            // Require Service file 
            if (file_exists($servicePathFile)) {
                require_once $servicePathFile;
                // Instance Service
                return new $service();
            }else {
                echo "File not Exists";
            }
            
        }
        // load View 
        public function view($view , $data = []) {
            // Check for View file 
            if (file_exists('../app/views/' . $view . '.php')) {
                // Required File from Views
                require_once '../app/views/' . $view . '.php';
            }else {
                echo "File not Exists";
            }
        }

    }
?>