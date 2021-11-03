<?php
/*
This file contains database configuration assuming you are 
running mysql using user "root and password"(by default in xampp)
*/
//to define a case sensitive constant
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');

//Try connecting to the database

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);//to connect the server username password and name with sql

//check the connection
if($conn == false){//if the connection is not made
    dir('Error: Cannot connet');
}



?>