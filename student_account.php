<?php
include('connection.php');
session_start();
if($_SESSION['session_id']==0)
{
	header("location:login.php");
}
$username=$_SESSION['username'];
$select = "select * from company_details;";
$data=mysqli_query($conn,$select);

			/*Company Details */

echo  "<html> <head> <style> .company { display:none; } </style> </head> </html>";
if(isset($_GET['idd']))
{
	$id=$_GET['idd'];
	$query= "select * from company_details where idd='$id' ";
	$data1=mysqli_query($conn,$query);
	$row=mysqli_fetch_array($data1);
	echo  "<html> <head> <style> .mydiv{display:none;} .company{ display:block; } </style> </head> </html>";
}

			/* logout */

if(isset($_GET['ids']))
{
	session_destroy();
	header("location:login.php");
}

			/* Getting Student ID */

$query2="SELECT * FROM user WHERE sname='$username' ";
$data2=mysqli_query($conn,$query2);
$row2=mysqli_fetch_array($data2);
$sid=$row2['sid'];


?>

<?php

			/* Joining Fake & Company Table */

	$j_query= "SELECT * from company c inner join fake f on c.cid=f.cid where type='placements' and sid='$sid'  " ;
	$j_data=mysqli_query($conn,$j_query);
	$j_total=mysqli_num_rows($j_data);
	
?>


<?php

/* Delete  */

echo  "<html> <head> <style>  .DELE{ display:none; } </style> </head> </html>";
echo  "<html> <head> <style> .del{ display:none ; } </style> </head> </html>";
if(isset($_GET['delete']))
{
$sid1=$_GET['delete'];
echo  "<html> <head> <style>  .DELE{ display:block; } </style> </head> </html>";
echo  "<html> <head> <style>  .del{ display:block; } </style> </head> </html>";

if(isset($_POST['delete']))
{
$query3=" delete from user where sid='$sid1' " ;
$data3=mysqli_query($conn,$query3);
        if($data3)
        header("location:student_account.php");
        else
        echo "nooo";
}
}
?>


<?php

/* Edit */

echo  "<html> <head> <style>  .place{ display:none; } </style> </head> </html>";
echo  "<html> <head> <style> .placement{ display:none ; } </style> </head> </html>";
if(isset($_GET['idd2']))
{
$sid1=$_GET['idd2'];
echo  "<html> <head> <style>  .place{ display:block; } </style> </head> </html>";
echo  "<html> <head> <style>  .placement{ display:block; } </style> </head> </html>";

if(isset($_POST['s_update1']))
{
$get_stu= "select * from user where sid='$sid1' ";
$id=$_POST['s_sid1'];
$name=$_POST['s_name1'];
$pass="anits";
$role="student";
$mail=$_POST['s_email1'];
$mobile=$_POST['s_mobile1'];
$joining =substr($_POST['join_date1'],0,4);
$grad =substr($_POST['grad_date1'],0,4);
$batch= $joining."-".$grad;
$branch=$_POST['s_branch1'];
$address=$_POST['s_address1'];
$gender=$_POST['s_gender1'];
//$doc=$_FILES['s_photo']['tmp_name'];
$s_image =addslashes(file_get_contents($_FILES["s_photo1"]["tmp_name"]));
$update_query= "UPDATE `user` SET `sid`='$id' ,`email`='$mail' , `sname`= '$name' , `batch`='$batch' ,`branch`='$branch' ,`phnumber`='$mobile' ,`address`='$address' ,`gender`='$gender' ,`photo`='$s_image' WHERE sid='$sid1' ";
$update_data= mysqli_query($conn,$update_query);
if($update_data)
header("location:student_account.php");
else
echo "nooooooo";  

}

}
?>


<?php


/* Add */

echo  "<html> <head> <style>  .place1{ display:none; } </style> </head> </html>";
echo  "<html> <head> <style> .placement1{ display:none ; } </style> </head> </html>";


if(isset($_GET['adding']))
{
echo  "<html> <head> <style>  .place1{ display:block; } </style> </head> </html>";
echo  "<html> <head> <style>  .placement1{ display:block; } </style> </head> </html>";
if(isset($_POST['s_upload']))
{
$id=$_POST['s_sid'];
$name=$_POST['s_name'];
$pass="anits";
$role="student";
$mail=$_POST['s_email'];
$mobile=$_POST['s_mobile'];
$joining =substr($_POST['join_date'],0,4);
$grad =substr($_POST['grad_date'],0,4);
$batch= $joining."-".$grad;
$branch=$_POST['s_branch'];
$address=$_POST['s_address'];
$gender=$_POST['s_gender'];
//$doc=$_FILES['s_photo']['tmp_name'];
$s_image =addslashes(file_get_contents($_FILES["s_photo"]["tmp_name"]));  
$query= "INSERT INTO `user`(`sid`, `email`, `password`, `sname`, `role`, `batch`, `branch`, `phnumber`, `address`, `gender`, `photo`) VALUES ('$id','$mail','anits','$name','student','$batch','$branch','$mobile','$address','$gender','$s_image') ";
$student_data=mysqli_query($conn,$query);
if($student_data)
header("location:student_account.php");
else
echo "noooooo";

}

}
?>

<?php 
  $datas="";
  $total_search_results=0;
	if(isset($_POST['search']))
	{
	echo  "<html> <head> <style> #search_modal {display:block;}   </style> </head> </html>";
		$datas = $_POST['submit_search'];
		$query = "select  u.sid as sid, u.sname as sname,u.branch as branch ,f.year as year , c.cname as cname , c.crole as crole , c.salary as salary, u.photo as photo 
					from fake f
					inner join user u
					on f.sid=u.sid
					inner join company c
					on c.cid=f.cid
					where ( f.sid REGEXP('$datas') or c.cname REGEXP('$datas') or c.crole REGEXP('$datas') or u.sname REGEXP('$datas') or u.branch REGEXP('datas') or f.year REGEXP('$datas') ) and f.type='placements'
					order by c.salary desc";
					
		$search_data=mysqli_query($conn,$query);
		$total_search_results= mysqli_num_rows ($search_data);
	}

?>


<?php 
	echo  "<html> <head> <style>  .outer{ display:none; } </style> </head> </html>";
	echo  "<html> <head> <style> .inner{ display:none ; } </style> </head> </html>";
	if(isset($_GET['idds']))
	{
		echo  "<html> <head> <style>  .outer{ display:block; } </style> </head> </html>";
		echo  "<html> <head> <style>  .inner{ display:block; } </style> </head> </html>";
		if(isset($_POST['change_pass']))
		{
			$old=$_POST['old_pass'];
			$new=$_POST['new_pass'];
			$conform=$_POST['conform_pass'];
			$email=$_SESSION['email'];
			$query2=" SELECT * FROM `user` WHERE email='$email' and password='$old' ";
			$data2=mysqli_query($conn,$query2);
			$total2=mysqli_num_rows($data2);
			if($new!=$conform)
			{
				echo '<html><script> alert("The Password Is Not Matched Please check it");</script></html>' ;
			}
			else if ($total2==0) {
				echo '<html><script> alert("Yor Password is Wrong Please Check It");</script></html>' ;
			}
			else
			{
				$query3=" UPDATE `user` SET  `password`='$new' WHERE email='$email' and password='$old' ";
				$data3=mysqli_query($conn,$query3);
				echo '<html><script> alert("Your Password has Changed Successfully");</script></html>' ;
				header("location:login.php");
			}
		}
	}
?>


<?php
	echo  "<html> <head> <style>  .outer_student{ display:none; } </style> </head> </html>";
	echo  "<html> <head> <style> .inner_student{ display:none ; } </style> </head> </html>";
	if(isset($_GET['student']))
	{
		echo  "<html> <head> <style>  .outer_student{ display:block; } </style> </head> </html>";
		echo  "<html> <head> <style>  .inner_student{ display:block; } </style> </head> </html>";
	}

	echo  "<html> <head> <style>  .outer_student1{ display:none; } </style> </head> </html>";
	echo  "<html> <head> <style> .inner_student1{ display:none ; } </style> </head> </html>";
	if(isset($_GET['student1']))
	{
		echo  "<html> <head> <style>  .outer_student1{ display:block; } </style> </head> </html>";
		echo  "<html> <head> <style>  .inner_student1{ display:block; } </style> </head> </html>";
	}

	echo  "<html> <head> <style>  .outer_student2{ display:none; } </style> </head> </html>";
	echo  "<html> <head> <style> .inner_student2{ display:none ; } </style> </head> </html>";
	if(isset($_GET['student2']))
	{
		echo  "<html> <head> <style>  .outer_student2{ display:block; } </style> </head> </html>";
		echo  "<html> <head> <style>  .inner_student2{ display:block; } </style> </head> </html>";
	}
?>


<html>
<head>
	<title> Placements </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		function hello()
		{
			var content = document.getElementById("content");
			content.style.display = "block";
			if(document.getElementById('profile'))
			{
				$(document).ready(function(){
		    
		   		$('#content').load("profile.php");

				});

			}
		}
		
	</script>

	<style>	
		*
		{

			margin:0px;
			padding:0px;
			font-family:times;
		}
		body
		{
			background-color:#ebebe0;
		}

			/* Header Part */ 

		.inside-box
		{
    		width:95%;
    		height:100%;
    		/*background:transparent;
    		background:white;*/
    		color:black;
    		top:50%;
    		left:50%;
    		position:absolute;
    		transform:translate(-50%,-50%);
    		box-sizing: border-box;
    		/padding: 30px 30px 40px 30px;/
    		padding-top: 0px;
    		margin-top: 0px;
		}
		.header ul
		{
    		list-style: none;
    		padding:0px;

		}
		.header ul li
		{
			/*background:#660066;*/
			/*background: #67B26F;  /* fallback for old browsers */
           /*background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
           /*  background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    		width:145px;
    		color:white;
    		position: relative;
    		height:50px;
    		font-size: 20px;
    		line-height: 20px;
    		text-align: center;
    		float:left;
    		margin-top: 0px;
    		top:50px;
		}
		.header
		{
			margin:0px;
			padding:0px;
			width:100%;
			height:120px;
			/*background:#660066;*/
			background: #67B26F;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    		background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		}
		.header a:link
		{
			text-decoration: none;
			color:white;

		}		
		.header a:visited
		{
			text-decoration: none;
			color:white;
		}
		.header a:hover
		{
			text-decoration: none;
			color:gold;
		}
		.header a:active
		{
			text-decoration: none;
			color:silver;
		}
		.header ul ul{
			position:absolute;
			display:none;
		}
		.header ul li:hover > ul
		{
			display:block;
		}
		.header ul ul li{
			width:145px;
			/*background:#660066;*/
			background: #67B26F;  /* fallback for old browsers */
    		background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    		background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			opacity:0.6;
			float:none;
			display:list-item;
			position:relative;
			padding-top: 15px;
			height:44px;
		}
		.header ul ul li:hover
		{
			/*background:#660066;*/
			background: #67B26F;  /* fallback for old browsers */
    		background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    		background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
			opacity:1;
		}


		.left-scroll
		{
			margin:0px;
			transform:translateY(18.40%);
			color:black;
			font-size:20px;
			position:fixed;
			width:250px;
			overflow:scroll;
			background:lightgrey;
			height:650px;
		}
		.left-scroll ul a{
			text-decoration: none;
			color:black;
		}
		.left-scroll ul
		{
			list-style: none;
			padding:0px;
			margin:0px;
		}
		.left-scroll ul li 
		{
			text-align:left;
			padding: 10px;
			margin-top:0px;
			height:30px;
			margin:3px;
			text-align: center;
		}
		.left-scroll ul li:hover
		{
			background: grey;
			opacity:0.5;
			color:white;

		}


				/* Loading Div */
		
		.mydiv{
			width:82.8%;
			height:580px;
			float:right;
			padding-bottom:50px;
		}
		.mydiv button{
			width: 200px;
			height: 50px;
			font-size: 25px;
			border-radius: 10px;
			background:#67B26F;
		}
		.mydiv button:hover{
			background:black;
			color: white;
		}
		#content{
			width: 82.8%;
			height:580px;
		}
		


		.company
		{
			width:83%;
			height:585px;
			float:right;
			background:ghostwhite;
			overflow-y:scroll; 
			padding-bottom:50px;
			background-color: ghostwhite;
		}
		.about-company h1 , .company-eligibility h1 , .recruitment h1 , .recruitment h2 ,.interviews h1 , .techs h2
		{
			margin-left: 20px;
		}
		.about-company p 
		{
			margin-left:20px;
			padding-right: 50px;
			font-size:20px;
		}
		.company-eligibility ul , .recruitment ul ,.tasks ul , .techs ul
		{
			list-style:square; 
			margin:20px;
			padding-left:20px;
			padding-right:50px;
			font-size:20px;
		}
		.geta
		{
			font-weight:bold;
			text-decoration: none;
			color:#2980b9;
		}
		.geta:hover
		{
			color:black;
		}


				/* Placements Inner Header */

		
		.add{
			width:80%;
			border:none;
			height: 10%;
			background-color:#67B26F ;
			margin: 10%;
			margin-top: 5%;
			margin-bottom: 0%;
			padding-top: 30px;

		}
		.add label{
			font-size: 30px;
			margin-left: 6%;

		}
		.add a{
			color: white;
			text-decoration: none;
			
		}
		.add li  {
			margin-left: 700px;
			position: relative;
			display: inline-block;
			background-color:#4ca2cd;
			color: white;
			text-decoration: none;
			padding: 15px;
			border-radius: 8px;
			width: 190px;
			border:2px solid black;
			transform: translateY(-100%);
		}

				/* Placements Inner Body */

		.records{
			width:80%;
			height: 60%;
			margin: 10%;
			margin-top: 0%;
			/*overflow: scroll;
			overflow-x: hidden;*/
		}
		.records table {
		  border-collapse: collapse;
		  width: 100%;
		}

		.records th,.records  td {
		  text-align: center;
		  padding: 8px;
		  border-bottom: 2px solid black;
		  font-size:18px;
		}

		.records tr{background-color:lightyellow}

		.records th {
		  background-color: black;
		  color: white;
}

				/* Delete Popup Outer Part */

		.DELE{
			
		  	position: fixed; /* Stay in place */
		  	padding-top: 100px; /* Padding at the Top to the box */
		  	left: 0; /* Start At top=0 */
		  	top: 0; /* Start at Left=0 */
		  	width: 100%; /* Full width */
		  	height: 100%; /* Full height */
		  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */
		}

				/* Delete Popup Inner Part */

		.del{
			background-color: white;  
		  	margin: auto;
		  	padding: 20px;
		  	border: 1px solid #888;
		  	width: 30%;
		  	border-radius: 10px;
		}

				/* Edit Popup Outer Part */

		.place{
			position: fixed; /* Stay in place */
		  	padding-top: 100px; /* Padding at the Top to the box */
		  	left: 0; /* Start At top=0 */
		  	top: 0; /* Start at Left=0 */
		  	width: 100%; /* Full width */
		  	height: 100%; /* Full height */
		  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */
		}

				/* Edit Popup Inner Part */

		.placement{
  width:750px;
  height: 700px;
  padding: 60px 35px 35px 35px;
  border-radius: 40px;
  background: ghostwhite;
  -webkit-border-radius: 40px;
  -moz-border-radius: 40px;
  -ms-border-radius: 40px;
  -o-border-radius: 40px;
  position: relative;
  top: -0px;
}

.design{
width: 300px;
  margin:20px;
  border-radius: 25px;
  box-shadow: inset 8px 8px 8px #aaaaaa,
            inset -8px -8px 8px #ffffff;
        display:inline-block;
        }
      input,select,textarea{
  border: none;
  outline:none;
  background: none;
  font-size: 18px;
  color: #555;
  padding:10px 5px 10px 5px;
}
input[type="button"],input[type="submit"] {
 outline: none;
 border:none;
 cursor: pointer;
 width:120px;
 height: 30px;
 border-radius: 30px;
 font-size: 18px;
 font-weight: 700;
 font-family: 'Lato', sans-serif;
 color:#fff;
 text-align: center;
 background: #24cfaa;
 box-shadow: 3px 3px 8px lightgrey,
             -3px -3px 8px #ffffff;
 transition: 0.5s;
}
input[type="button"]:hover,input[type="submit"]:hover {
 background-color:black;
 color:white;
 font-size:20px;
}
input[type="file"]
{
    border:1px solid;
    background : transparent;
   outline:none;
   width:200px;
   height:30px;
   font-size:14px;
   color: white;
}


/* Add Popup Outer Part */

.place1{
position: fixed; /* Stay in place */
  padding-top: 100px; /* Padding at the Top to the box */
  left: 0; /* Start At top=0 */
  top: 0; /* Start at Left=0 */
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  background-color:rgba(0,0,0,0.6); /* Red color in opacity */
}

/* Add Popup Inner Part */

.placement1{

  width:750px;
  height: 720px;
  padding: 60px 35px 35px 35px;
  border-radius: 40px;
  background: ghostwhite;
  -webkit-border-radius: 40px;
  -moz-border-radius: 40px;
  -ms-border-radius: 40px;
  -o-border-radius: 40px;
  position: relative;
  top: -0px;
}


/* All Input Css */

/*.placement1 input[type="text"] , .placement input[type="text"]{
width: 350px;
margin-bottom: 10px;
font-family: times;
height: 20px;
border: solid 3px black;
border-radius: 3px;
}*/
					/* Popup span Part */

		.close {
		    color: #aaaaaa;
		    float: right;
			font-size: 40px;
			font-weight: bold;
		}

		.close:hover , .close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}

			/* Plus Symbol */

		.svg-circleplus { 
			height: 40px; 
			stroke: white; 
			position: absolute;
			transform: translateY(-10px);
			padding-left: 10px;
		}

				/* search tab */

.close1 {
  color: #aaaaaa;
  float: right;
  font-size: 40px;
  margin-right:20px;
  font-weight: bold;
}

.close1:hover , .close1:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.search_modal
{
   display:none;
  position:absolute; /* Stay in place */
 /* Padding at the Top to the box */
    left: 0; /* Start At top=0 */
    top: 0; /* Start at Left=0 */
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background-color:rgba(0,0,0,0.6); /* Red color in opacity */
}
#inside-modal
{
	width:80%;
	position:absolute;
	top:50%;
	left:50%;
	transform:translate(-50%,-50%);
	border-radius:5px;
}
.top-part
{f
	width:100%;
	height:200px;
	border-top-right-radius: 8px;
	border-top-left-radius: 8px;
	position:relative;
	background: white;
	border-bottom: 2px solid black;
}
#inside-searching
{	width:100%;
	position:relative;
	background:white;
	overflow: scroll;
	height:400px;
}

.border-design {

	border:2px solid #67B26F;
	width:70%;
	border-color-left: #67B26F;  /* fallback for old browsers */
    border-color-top: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    border-color-bottom: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
.my-search
{
	position:relative;
	left:60px;
	font-size:20px;
	font-weight:bold;
}
.my-search span
{
	color:ghostwhite;
	padding:1px 5px 1px 5px;
	text-transform: capitalize;
	background:grey;
	font-size:25px;
	font-style:italic;
}

::placeholder {
  font-size:18px;
}
.search_submit input[type="text"] ,#inside-modal input[type="text"] {
	width:800px;
	height:35px;
	font-size: 18px;
	/*border:2px solid black;*/
	margin-bottom: 30px;
  /*border-radius: 25px;*/
  box-shadow: inset 8px 8px 8px #aaaaaa,
              inset -8px -8px 8px #ffffff;
	border-radius: 10px;
	margin-right: 5px;
	position:relative ; 
	top:3px;
}
.search_submit input[type="submit"],#inside-modal input[type="submit"]  { 
	height:37px;
	width:90px;
	border-radius: 10px;
	border:2px solid ;
	font-weight: bold ;
	font-size: 20px;
	font-family: times;
	/*background-color: #660066;*/
	background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	color: white;
	text-align: center;

}
.search_submit input[type="button"] {
	height:37px;
	width:90px;
	border-radius: 10px;
	border:2px solid ;
	font-weight: bold ;
	font-size: 20px;
	font-family: times;
	/*background-color: #660066;*/
	background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	color: white;
	text-align: center;

}

.search_submit input[type="submit"]:hover , .search_submit input[type="button"]:hover , #inside-modal input[type="submit"]:hover{
	background: black;
    border: 2px white solid;
    color:white;
    border-radius: 10px;
}

	.picture{
		width: 300px;
		height: 350px;
		background-color: rgba(0,0,0,0.8);
		padding-top: 40px;
		border-radius: 4px;
		/*position:relative;*/
	}
	.picture img{
		
		border-radius: 70%
	}
	.picture label{
		font-family: 'Alata' , sans-serif ;
		color: white;
		line-height:30px; 
		margin-top: 2px;
		border-spacing:5px;
		margin-bottom: 2px;
		font-size:18px;
	}
	.picture span{
		color: white;
		display: inline-block;
	}
	.picture .logo1{
		  
		  background-repeat: no-repeat;
		  background-size: cover;
		  width:90px;
		  height: 90px;
		  border-radius: 50%;
		  margin:0 auto;
		  border:4px solid #fff;
	}

		.outer{
			position: fixed; /* Stay in place */
		  	padding-top: 100px; /* Padding at the Top to the box */
		  	left: 0; /* Start At top=0 */
		  	top: 0; /* Start at Left=0 */
		  	width: 100%; /* Full width */
		  	height: 100%; /* Full height */
		  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */

		}
		.inner{
			width:330px;
  			height: 500px;
  			padding: 60px 35px 35px 35px;
  			border-radius: 40px;
  			background: ghostwhite;
  			/*box-shadow: 13px 13px 20px #cbced1,              -13px -13px 20px #ffffff;*/
  			-webkit-border-radius: 40px;
  			-moz-border-radius: 40px;
  			-ms-border-radius: 40px;
  			-o-border-radius: 40px;
		}
		.close1 {
		    color: #aaaaaa;
		    float: right;
			font-size: 36px;
			font-weight: bold;
			position:relative;
			top:-30px;
		}

		.close:hover , .close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}

		.design{
 			margin-bottom: 30px;
  			border-radius: 25px;
  			box-shadow: inset 8px 8px 8px #aaaaaa,
            inset -8px -8px 8px #ffffff;
    	}
    	.inner input[type="text"]{
	  		border: none;
	  		outline:none;
	  		background: none;
	  		font-size: 18px;
	  		color: #555;
	  		padding:10px 5px 10px 5px;
		}
	.inner input[type="button"],.inner input[type="submit"] {
		  outline: none;
		  border:none;
		  cursor: pointer;
		  width:120px;
		  height: 30px;
		  border-radius: 30px;
		  font-size: 18px;
		  font-weight: 700;
		  font-family: 'Lato', sans-serif;
		  color:#fff;
		  text-align: center;
		  background: #24cfaa;
		  box-shadow: 3px 3px 8px lightgrey,
		              -3px -3px 8px #ffffff;
		  transition: 0.5s;
	}
		.inner input[type="button"]:hover,input[type="submit"]:hover {
		  background-color:black;
		  color:white;
		  font-size:20px;
		}


		.outer_student , .outer_student1 , .outer_student2{
			position: fixed; /* Stay in place */
		  	padding-top: 200px; /* Padding at the Top to the box */
		  	left: 0; /* Start At top=0 */
		  	top: 0; /* Start at Left=0 */
		  	width: 100%; /* Full width */
		  	height: 100%; /* Full height */
		  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */
		}

		.inner_student , .inner_student1 , .inner_student2{

			width:330px;
  			height: 250px;
  			padding: 30px;
  			border-radius: 40px;
  			background: ghostwhite;
  			/*box-shadow: 13px 13px 20px #cbced1,              -13px -13px 20px #ffffff;*/
  			-webkit-border-radius: 40px;
  			-moz-border-radius: 40px;
  			-ms-border-radius: 40px;
  			-o-border-radius: 40px;
		}

		.inner_student button , .inner_student1 button , .inner_student2 button  {
			width: 300px;
			border:none;
			height: 50px;
			font-size: 25px;
			border-radius: 10px;
			/*background:#660066;*/
			background: #67B26F;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    		background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		}
		.inner_student button:hover , .inner_student1 button:hover , .inner_student2 button:hover{
			background:black;
			color: white;
		}

		
	</style>
</head>


<body>
	


	<div class="inside-box">
		
		<div class="left-scroll">
			<h2><center> Companies </center></h2><br>
			<ul class="companies">
				<?php while($rowss= mysqli_fetch_array($data)) { ?>
					<a href="student_account.php?idd=<?php echo $rowss['idd']; ?>" >   <li> <?php echo $rowss['company']; ?> </li> </a> 
				<?php } ?>

			</ul>
		</div>


		<div class="header">
			<ul>
				<li style= "margin-right:10px; margin-left:30px; position:relative; top:15px;" > <a href="admin.php" ><img src="anitswhite.png" width=90px height=90px > </a></li>
				<li><a href="student_account.php?student=1"  >	 Student</a> </li>
				<li><a href="student_account.php?student1=1"  >	 Admin</a> </li>
				<li><a href="student_account.php?student2=1"  >	 Company</a> </li>
				<li><a href="#" onclick="popup()">	 Results</a> </li>
				
				<li> </li>
				<li></li>
				<li style="  float:right; text-align:right; margin-right:100px;   width:400px; "><a href="www.google.com">Welcome <?php echo $username; ?> &#x25BE;</a>
					<ul style="margin-left:255px;">
						<a href="#" name="profile" id="profile" onclick="hello()"> <li> Profile </li></a> 
						<a href="admin.php?idds=<?php echo $username ?>" > <li>Change Password</li> </a>
						<a href="admin.php?ids=<?php echo 404; ?>" > <li>Logout</li> </a>
		 			</ul>
				</li>
			</ul>
		</div>
		
		<div id="change" class="outer" >
			<center>
			<div class="inner">
				<span class="close1" onclick="cancel6()" >&times;</span>
				<br><br>
				<form method="POST"  action="">
					<br>
					<label style="font-size:29px;font-weight:bold;">Change Password</label><br><br><br>
					<div class="design"> <input type="text"  name="old_pass" placeholder=" Old Password " required></div><br>
					<div class="design"> <input type="text"  name="new_pass" placeholder=" New Password " required></div><br>
					<div class="design"> <input type="text"  name="conform_pass" placeholder=" Conform Password " required></div><br>
					<input type="submit" name="change_pass"  value="Change" >
					<input type="button"  value="Back" onclick="window.location.href='admin.php'"><br>
					<br>
					<label>Note: U have to Relogin After the Password Is Succfully Changed</label><br><br>
				</form>
			</div>
			</center>
		</div>

		<div id="student" class="outer_student">	
			<center>
				<div class="inner_student">
					<span class="close" onclick="cancel3()" >&times;</span><br><br><br>
						<center>
							<table >
								<tr>
									<td >
										<button  onclick="window.location.href='student_account.php';"  >Student Account</button><br>
									</td>
								</tr>
								<tr>
									<td >
										<button  onclick="window.location.href='student_internship.php';"  >Student Internship</button><br>
									</td>
								</tr>
								<tr>
									<td >
										<button  onclick="window.location.href='student_placement.php';"  >Student Placements</button><br>
									</td>
								</tr>
							</table>
						</center>
				</div>
			</center>
		</div>

		<div id="student1" class="outer_student1">	
			<center>
				<div class="inner_student1">
					<span class="close" onclick="cancel4()" >&times;</span><br><br><br>
						<center>
							<table style="transform: translateY(100%);">
								<tr>
									<td >
										<button  onclick="window.location.href='admin_account';"  >Account</button><br>
									</td>
								</tr>
								
							</table>
						</center>
				</div>
			</center>
		</div>

		<div id="student2" class="outer_student2">	
			<center>
				<div class="inner_student2">
					<span class="close" onclick="cancel5()" >&times;</span><br><br><br>
						<center>
							<table >
								<tr >
								</tr>
								<tr>
									<td >
										<button  onclick="window.location.href='placement_company.php';"  >Companies</button><br>
									</td>
								</tr>
								<tr>
									<td >
										<button  onclick="window.location.href='company.php';"  >Company Details</button><br>
									</td>
								</tr>
							</table>
						</center>
				</div>
			</center>
		</div>


		<div  class="mydiv" id="content">
			
			<div class="add">

				<label style="font-size:34px;color:ghostwhite;">Student Records</label>
				<a href='student_account.php?adding=<?php echo 999; ?> ' name="addplacement"  value="Add New Placement" id="addplacement"  >
					<li>
						ADD Student Record
						<svg class="svg-circleplus" viewBox="0 0 100 100">
					  		<circle cx="50" cy="50" r="45" fill="none" stroke-width="7.5"></circle>
					  		<line x1="32.5" y1="50" x2="67.5" y2="50" stroke-width="5"></line>
					  		<line x1="50" y1="32.5" x2="50" y2="67.5" stroke-width="5"></line>
						</svg>
					</li>
				</a>
			</div>
			<div class="records">
				<table>
				<tr>
					<th> Student ID </th>
					<th> Email  </th>
					<th> Full Name </th>
					<th> Batch </th>
					<th> Branch </th>
					<th> Mobile Number </th>
					<th> Gender </th>
					<th> Actions </th>


				</tr>
			<?php

			  $get_user_query= "select * from user order by sid ASC";
			  $j_data=mysqli_query($conn,$get_user_query);
			  $j_total=mysqli_num_rows($j_data);
			if($j_total!=0)
			{
			  while($jrows=mysqli_fetch_array($j_data)) { if($jrows['role']=='admin') continue; ?>
			<tr>
			<td >
			<center>
			<?php echo $jrows['sid']; ?>
			</center>
			</td>
			<td>
			<center>
			<?php echo $jrows['email']; ?>
			</center>
			</td>
			<td >
			<center>
			<?php echo ucwords($jrows['sname']); ?>
			</center>
			</td>
			<td >
			<center>
			<?php echo $jrows['batch']; ?>
			</center>
			</td>
			<td >
			<center>
			<?php echo strtoupper($jrows['branch']); ?>
			</center>
			</td>
			<td >
			<center>
			<?php echo $jrows['phnumber']; ?>
			</center>
			</td>
			<td >
			<center>
			<?php echo ucwords($jrows['gender']); ?>
			</center>
			</td>
			   <td >
			    <center>

			    <a href='student_account.php?idd2=<?php echo $jrows['sid']; ?>' id="edit" name="edit" ><i class="fa fa-pencil" style="color:black;font-size:24px;"></i></a>
			    <a href='student_account.php?delete=<?php echo $jrows['sid']; ?>' id="delete" name="delete" > <i class="fa fa-trash-o" style="font-size:24px;color:red"></i> </a>
			    </center>
			   </td>
			  </tr>
			  <?php  }  

			}
			?>
			  </table>
			 
			</div>
			<div id="MYDELE" class="DELE">
			<center>
			  <div id="mydel" class="del">
			<span class="close" onclick="cancel()" >&times;</span>
			<br>
			<form method="POST"  action="">
			<b>Are U Sure That U Want To Delete This Record !!</b><br><br>
			<center>
			<input type="button" name="cancel" value="Cancel" id="Cancle" onclick="cancel()">
			<input type="submit" name="delete" value="ok" id="ok">
			</center>
			</form>
			</div>
			</center>
			</div>
			<!-- edit -->
			<div id="PLACED" class="place">
			<center>
			<div class="placement">
			<span class="close" onclick="cancel1()" >&times;</span><br><br>
			<h1> Edit Record </h1><br>

			<form action="" method="POST" enctype="multipart/form-data" >
			<div class="design" style="float:left;"> <input type="text" id="s_sid1" name="s_sid1" placeholder="Student ID"  ></div>
			<div class="design" style="float:right;"> <input type="text" id="s_name1" name="s_name1" placeholder="Student Name"  ></div><br><br>
			<div class="design" style="float:left;"> <input type="email" id="s_email1" name="s_email1" placeholder="Student Mail" ></div>
			<div class="design"style="float:right;"> <input type="text" id="s_mobile1" name="s_mobile1" placeholder="Mobile Number" ></div><br><br>
			<div class="design">Joining Date <input type="date" id="join_date1" name="join_date1" placeholder="Joining Date" ></div>
			<div class="design"> Graduation Date<input type="date" id="grad_date1" name="grad_date1"  ></div><br>
			<div class="design"> Select Branch
			<select name="s_branch1" >
			<option value="select"> Select </option>
			<option value="CSE" > CSE </option>
			<option value="ECE"> ECE </option>
			<option value="IT" > IT </option>
			</select>
			</div>
			<div class="design" style="float:right;">
			Gender
			<select name="s_gender1"  >
			<option value="Select" > Select </option>
			<option value="Male" > Male </option>
			<option value="Female"> Female </option>
			</select>
			</div><br>
			<div class="design">
			<textarea name="s_address1" id="s_address" row="20" col="100" placeholder="Address" style="width:600px; height:100px;" ></textarea>
			</div><br><br>
			Student Photo
			<input type="file" id="s_photo" name="s_photo1" ><br>
			<br> <br>
			<input type="submit" name="s_update1" id="s_upload" value="Upload" >
			<input type="button" name="back" id="back1" value="Back" onclick="window.location.href='student_account.php'"><br>
			</form>
			</div>
			</center>
			</div>
			<!-- Upload -->
			<div id="PLACED1" class="place1">
			<center>
			<div class="placement1">
			<span class="close" onclick="cancel2()" >&times;</span><br><br><br>
			<h1> Add New Record</h1><br>
			<form action="" method="POST" enctype="multipart/form-data" >
			<div class="design" style="float:left;"> <input type="text" id="s_sid" name="s_sid" placeholder="Student ID"  required></div>
			<div class="design" style="float:right;"> <input type="text" id="s_name" name="s_name" placeholder="Student Name"  required></div><br><br>
			<div class="design" style="float:left;"> <input type="email" id="s_email" name="s_email" placeholder="Student Mail" required></div>
			<div class="design"style="float:right;"> <input type="text" id="s_mobile" name="s_mobile" placeholder="Mobile Number" required></div><br><br>
			<div class="design">Joining Date <input type="date" id="join_date" name="join_date" placeholder="Joining Date" required></div>
			<div class="design"> Graduation Date<input type="date" id="grad_date" name="grad_date"  required></div><br>
			<div class="design"> Select Branch
			<select name="s_branch" required>
			<option value="CSE" > CSE </option>
			<option value="ECE"> ECE </option>
			<option value="IT" > IT </option>
			</select>
			</div>
			<div class="design" style="float:right;">
			Gender
			<select name="s_gender" required >
			<option value="Select" > Select </option>
			<option value="Male" > Male </option>
			<option value="Female"> Female </option>
			</select>
			</div><br>
			<div class="design">
			<textarea name="s_address" id="s_address" row="20" col="100" placeholder="Address" style="width:600px; height:100px;" ></textarea>
			</div><br><br>
			Student Photo
			<input type="file" id="s_photo" name="s_photo" ><br>
			<br> <br>
			<input type="submit" name="s_upload" id="s_upload" value="Upload" >
			<input type="button" name="back" id="back1" value="Back" onclick="window.location.href='student_account.php'"><br>
			</form>
			</div>
			</center>
			</div>
		</div>
	

		<div class="company" id="company" >
				<center>  
					<br><br>
					<?php echo'<img src="data:image;base64,'.base64_encode($row['cimage']).'" height="50%" width="250"  />'; ?>
				</center>

				<div class="about-company">
				 	<h1> About <?php echo $row['company']; ?>:- </h1><br>
				 	<p style="text-align:justify;"> <?php echo $row['cabout']; ?>    </p><br>
				</div>

				<center >
					<hr style="border: 1px solid black; width:85%;"> 
				</center>

				<div class="company-eligibility">
					<h1> Eligibility:- </h1>
					<?php 
						$div= explode("#",$row['celigibility']);
	 					$len= count($div) -1 ;
	 				?>
					<ul>
	 					<?php 
		 				for($i=0;$i<$len;$i++)
		 				{ ?>
		 					<li>  <?php echo $div[$i]; ?> </li>
	 					<?php } ?>
	 				</ul>
				</div>

				<center> 
					<hr style="border: 1px solid black; width:85%;"> 
				</center>
				
				<div class="recruitment" ><br>
					<h1> Recruitment Process:- </h1><br>
						<?php 
							$div= explode("#",$row['cprocess']);
		 					$len= count($div) -1 ;
	 					?>
						<h2> It consists of <?php echo $len; ?> processes </h2> 
						<ul>
	 					<?php 
		 					for($i=0;$i<$len;$i++)
		 					{ ?>
		 						<li>  <?php echo $div[$i]; ?> </li>
		 				    <?php } ?>
	 				    </ul>			
					<div class="tasks" >
						<?php 
	 					for($i=0;$i<$len;$i++)
	 					{ ?>
	 						<h2> <?php echo $div[$i]; ?> </h2>
	 						<br>
	 						<ul>
	 							<?php 
	 							$ind= $i+1;
	 						    $var_table= "task".($ind);
								$divs= explode("#",$row[$var_table]);
	 							$lens= count($divs) -1 ;
	 								for($j=0;$j<$lens;$j++)
	 								{ ?>
	 									<li>  <?php echo $divs[$j]; ?> </li>
	 								<?php } ?>
	 				    	</ul>
	 				    <?php } ?>
	 				</div>

	 			</div>
	 			<center> 
	 				<hr style="border: 1px solid black; width:85%;"> 
	 			</center>

	 			<div class="interviews"> <br>
					<h1> Frequently Asked Interview Question:- </h1><br>
					<div class="techs">
						<h2 style="margin-bottom:0px;"> Technical Questions:- </h2>
					<?php 
						$div= explode("#",$row['technical']);
	 					$len= count($div) -1 ;
	 				?>
					<ul>
	 					<?php 
	 					for($i=0;$i<$len;$i++)
	 					{ ?>
	 						<li>  <?php echo $div[$i]; ?> </li>
	 					<?php } ?>
	 				</ul>
				</div>

				<div class="techs">
					<h2 style="margin-bottom:0px;"> HR Questions:- </h2>
					<?php 
						$div= explode("#",$row['hr']);
	 					$len= count($div) -1 ;
	 				?>
					<ul>
	 					<?php 
	 					for($i=0;$i<$len;$i++)
	 					{ ?>
	 						<li>  <?php echo $div[$i]; ?> </li>
	 					<?php } ?>
	 				</ul>
				</div>

			</div>
			<center> 
				<hr style="border: 1px solid black; width:85%;"> 
			</center>
			<br> <br>
		 	<?php 
		 		$link = $row['clink']; 
		 	?>
			<center> 
				<h2 style="margin-left: 20px;"> 
					To know more about the company 
					<a href=" <?php echo $link;?>" target="_blank" class="geta" > click here </a> 
				</h2> 
			</center>
		</div>

	</div>


	


		<div id="search_modal" class="search_modal">
			<div id="inside-modal">
				<div class="top-part">
					<br>
					<span class="close1" onclick="cancel2()">&times;</span>
					<br>
					<center>
					<fieldset  style="width:87%; border:2px solid black;">
					<legend> <h2 style="font-size:30px;padding:0px 10px 0px 10px;"> Results </h2> </legend>
					<form  method="POST"  action="" >
							<input type="text" name="submit_search" placeholder="Search by Student ID or Student Name or Company Name or Company Role or Year or Branch" required id="submit_search1" >
							<input type="submit" value="Search"  onclick="open_search11()" name="search" > 
						</center>
					</form>	
				</fieldset> 
				<?php if($datas!="") { ?>
					<br><br>
				<p class="my-search">  Search Results For :  <span> <?php echo $datas; ?>  </span>  <span style="float:right; margin-right:90px;"> Profiles found: <?php echo $total_search_results; ?> <span>  <p>
				<?php }?>
				<hr style="font-weight:bold; border:2px;"> <br>
			      <br>
			</div> 

			<div id="inside-searching"><center>
				<?php if($datas!="") { ?>
				<?php 
				   if($total_search_results==0)
				   	echo "<h1> No Profiles Found </h1>";
				 ?>
				 <br>
				<table style="width:90%">
			<tr>
			<?php $i=0; while($sea=mysqli_fetch_array($search_data)) { ?>
			<td>
			<div class="picture">
		<div class="logo1"><?php echo'<img src="data:image;base64,'.base64_encode($sea['photo']).'" height="90" width="90"   />'; ?></div>
		<br>
		<center>
		<label><?php echo strtoupper($sea['sname']); ?> </label><br>
		<hr style="width:80%">
		<label><?php echo $sea['sid']."   /"; ?> </label>
		<label style="font-family: Monaco ;"><?php echo strtoupper($sea['branch']); ?>   </label><br>
		<div class="border-design">
		<label style="display: inline-block;">    <?php echo $sea['year']; ?>  </label>
		<label> <?php echo $sea['cname']; ?>    </label><br>
		<label> <?php echo $sea['crole']; ?>    </label><br>
		<label style="background:lightgreen; color:black; padding:2px 5px 2px 5px; font-size: 22px; font-weight:bold;">   <?php echo $sea['salary']." LPA"; ?>  </label>
	    </center>
</div>
		</div>
	   </td>
	    <?php $i++; if($i==4){ echo '</tr>'; $i=0;}   }  ?>
	</tr>
	</table> <?php }?> </center>
			</div>
			</div>
		</div>


<script type="text/javascript">
	function cancel() {
  		MYDELE.style.display = "none";

  		window.location.href="student_account.php";
	}
	function cancel1() {
  		PLACED.style.display = "none";

  		window.location.href="student_account.php";
	}
	function cancel2() {
  		PLACED1.style.display = "none";

  		window.location.href="student_account.php";
	}

	function cancel2()
	{
		var open=document.getElementById('search_modal');
		open.style.display="none";
		window.location.href="student_account.php";
	}
	function popup()
	{
		var open=document.getElementById('search_modal');
		open.style.display="block";
	}

	function cancel6() 
	{
	  	change.style.display = "none";
		window.location.href="student_account.php";
	}

	function cancel3() {
  		student.style.display = "none";

  		window.location.href="student_account.php";
	}

	function cancel4() {
  		student1.style.display = "none";

  		window.location.href="student_account.php";
	}

	function cancel5() {
  		student2.style.display = "none";

  		window.location.href="student_account.php";
	}
</script>

</body>

</html>