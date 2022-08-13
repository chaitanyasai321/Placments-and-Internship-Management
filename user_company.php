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
echo  "<html> <head> <style> .company { display:none; } </style> </head> </html>";
if(isset($_GET['idd']))
{
	$id=$_GET['idd'];
	$query= "select * from company_details where idd='$id' ";
	$data1=mysqli_query($conn,$query);
	$row=mysqli_fetch_array($data1);
	echo  "<html> <head> <style> .mydiv{display:none;} .company{ display:block; } </style> </head> </html>";
}
if(isset($_GET['ids']))
{
	session_destroy();
	header("location:login.php");
}

?>

<html>
<head>
	<title> user_home </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		function hello()
		{
			var company = document.getElementById("company");
			company.style.display = "none";
			var content = document.getElementById("content");
			content.style.display = "block";
			if(document.getElementById('profile'))
			{
				$(document).ready(function(){
		    
		   		$('#content').load("profile.php");

				});

			}
		}
		function placements()
		{
			var company = document.getElementById("company");
			company.style.display = "none";
			var content = document.getElementById("content");
			content.style.display = "block";
			if(document.getElementById('placements'))
			{
				$(document).ready(function(){
		    
		   		$('#content').load("placements.php");

				});

			}

		}
		function internship()
		{
			var company = document.getElementById("company");
			company.style.display = "none";
			var content = document.getElementById("content");
			content.style.display = "block";
			if(document.getElementById('internship'))
			{
				$(document).ready(function(){
		    
		   		$('#content').load("internship.php");

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
    		padding: 30px 30px 40px 30px;
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
			background:#660066;
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
			background:#660066;
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
			top:20px;
			display:none;
		}
		.header ul li:hover > ul
		{
			display:block;
		}
		.header ul ul li{
			width:145px;
			background:#660066;
			opacity:0.6;
			float:none;
			display:list-item;
			position:relative;
			padding-top: 15px;
			height:44px;
		}
		.header ul ul li:hover
		{
			background:#660066;
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

		.company
		{
			/*width:82.8%;*/
			width:86%;
			height:585px;
			float:right;
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
		
		.mydiv{
			width:86%;
			height:580px;
			float:right;
			background:ghostwhite;
			padding-bottom:50px;
			background-color: lightblue;
		}
		.mydiv button{
			width: 200px;
			height: 50px;
			font-size: 25px;
			border-radius: 10px;
			background:#660066;
		}
		.mydiv button:hover{
			background:black;
			color: white;
		}
		#content{
			width: 86%;
			height:0px;
			background:ghostwhite;
		}
	</style>
</head>


<body>
	


	<div class="inside-box">
		
		<div class="left-scroll">
			<h2><center> Companies </center></h2><br>
			<ul class="companies">
				<?php while($rowss= mysqli_fetch_array($data)) { ?>
					<a href="user_home.php?idd=<?php echo $rowss['idd']; ?>" >   <li> <?php echo $rowss['company']; ?> </li> </a> 
				<?php } ?>

			</ul>
		</div>


		<div class="header">
			<ul>
				<li style= "margin-right:10px; margin-left:30px; position:relative; top:15px;" > <a href="user_home.php" ><img src="anitswhite.png" width=90px height=90px > </a></li>
				<li><a href="#" name="Placements" id="placements" onclick="placements()">	 Placements</a> </li>
				<li><a href="#"  name="Internship" id="internship" onclick="internship()">	 Internships</a> </li>
				<li><a href="#">	 Results</a> </li>
				<li> </li>
				<li></li>
				<li style="  float:right; text-align:right; margin-right:100px;   width:400px; "><a href="www.google.com">Welcome <?php echo $username; ?> &#x25BE;</a>
					<ul style="margin-left:255px;">
						<a href="#" name="profile" id="profile" onclick="hello()"> <li> Profile </li></a> 
						<a href="user_home.php?ids=<?php echo 404; ?>" > <li>Logout</li> </a>
		 			</ul>
				</li>
			</ul>
		</div>
	
		<div  class="mydiv" id="content">
			<center>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<table>
					<tr>
						<td style="padding-right: 100px; padding-left: 100px;">
							<button id="placements" onclick="placements()"  >Placements</button>
						</td>
						<td style="padding-right: 100px; padding-left: 100px;">
							<button id="internship" onclick="internship()"  >Internship</button>
						</td>
					</tr>
				</table>
			</center>
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


</body>

</html>