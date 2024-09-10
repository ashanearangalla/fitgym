<?php
//Database connection paramters
$severname = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to ypur database password
$dbname = "gymdb";

//Create connection
$con = new mysqli($severname,$username,$password,$dbname);

//Check connection 
	 
if ($con->connect_error) {
     die("Connection failed: ".$conn->connect_error);
}
?>