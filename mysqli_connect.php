<?php
$host = 'localhost'; 
$username = 'danrivero'; 
$password = 'danrivero'; 
$database = 'members_rivero'; 


$dbc= mysqli_connect($host, $username, $password, $database);


if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
