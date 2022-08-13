<?php
	//session_start();
	$sern="localhost";
	$user="root";
	$password="";
	$dbn="ost_project";
	$conn=mysqli_connect($sern,$user,$password,$dbn);
	if(!($conn))
		echo "Connection not Ok";

?>