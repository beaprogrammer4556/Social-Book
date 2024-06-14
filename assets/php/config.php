<?php
session_start();
$server="127.0.0.1:3308";
$username="root";
$password="";
$db="social_book";

$con = mysqli_connect($server,$username,$password,$db);
if(!$con){
    die($con->error);
}
?>