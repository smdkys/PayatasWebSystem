<?php

    function connection() { 
        
        $host = "localhost";
        $username = "root";
        $password = "araya";
        $database = "request_system";

        $con = new mysqli( $host, $username,  $password,  $database);

        if ($con->connect_error) {
            echo $con->connect_error;
        } else{
            return $con;
        }
        $con->set_charset("utf8mb4");
    }