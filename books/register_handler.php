<?php
require_once 'dbmanager.php';
$manager=DBManager::getInstance();
$con=$manager->getConnection();
mysql_select_db("books",$con);
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$password=$_POST['password'];
$username=$email;
$quer=mysql_query("insert into Users (first_name, second_name, email, username, password) values ('$fname', '$lname', '$email', '$username', '$password');");
echo $fname." ".$lname;
?>