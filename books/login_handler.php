<?php
	require_once 'dbmanager.php';
	$manager=DBManager::getInstance();
	$con=$manager->getConnection();
	mysql_select_db("books",$con);
	
	$email=$_POST['email'];
	$password=$_POST['password'];
	
	$quer=mysql_query("select first_name, second_name from Users where email like '$email' and password like '$password';");
	$fname=array();
	$lname=array();
	$counter=0;
	while($row=mysql_fetch_array($quer)) {
		$fname[$counter]=$row['first_name'];
		$lname[$counter]=$row['second_name'];
		$counter++;
	}
	$sz=count($fname);
	if(($sz==0) or ($sz>1)) {
		echo "not good to go";
	} else {
		echo $fname[0]." ".$lname[0];
	}
?>