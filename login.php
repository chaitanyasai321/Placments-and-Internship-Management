<?php 
	include("connection.php") ;
	error_reporting(0);
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpMailer/src/Exception.php';	
	require 'phpMailer/src/PHPMailer.php';
	require 'phpMailer/src/SMTP.php';
	//Load composer's autoloader
	require 'vendor/autoload.php';
	session_start();
	$_SESSION['session_id']=0;
	//error_reporting(0);
	$select = "select * from company_details;";
	$data2=mysqli_query($conn,$select);
	echo  "<html> <head> <style> .login-company{ display:none; } #forgets {display:none;}   </style> </head> </html>";

	if(isset($_GET['idd']))
  {
	$id=$_GET['idd'];
	$query= "select * from company_details where idd='$id' ";
	$data1=mysqli_query($conn,$query);
	$row=mysqli_fetch_array($data1);
	echo  "<html> <head> <style> .login-company{ display:block; } </style> </head> </html>";
  }

?>
<?php
    if(isset($_POST['login1']))
    {
      $un1=$_POST['un'];
      $pwd1=$_POST['pwd'];

      
      $query="SELECT * FROM user WHERE (email='$un1' or sid='$un1') and password='$pwd1' ";
      $data=mysqli_query($conn,$query);
      $row= mysqli_fetch_array($data);
      $total=mysqli_num_rows($data);
      if($total!=0) 
      {
      	$_SESSION['session_id']=1;
      	$_SESSION['email']=$un1;
      	$_SESSION['username']= $row['sname'];
      	if($row['role']=='student')
      	{
      		header("location:user_home.php");
      	}
      	elseif ($row['role']=='admin') 
      	{
      		header("location:admin.php");
      	}
      }
      else echo '<script>alert("Your Username or Password might be wrong\nPlease Re-enter")</script>';
  }
?>

<?php
        // forget password
		$sendmail="";
		$password="";
		if(isset($_POST['forgetsss']))
		{
			$_SESSION['refresh']=1;
			$sendmail= $_POST['forget-email'];
			$query= "select * from user where email='$sendmail'";
			$pass_data=mysqli_query($conn,$query);
			$pass_row=mysqli_fetch_array($pass_data);
			if(!$pass_row)
			{
				echo '<script> alert("Email Address Not found"); window.location.href="login.php"; </script> ';

			}
			else{
			//$pass_row=mysqli_fetch_array($pass_data);
			$password= $pass_row['password'];
			
			$mail = new PHPMailer();
   			$mail->CharSet =  "utf-8";

    		$mail->SMTPDebug = 0;    
    	  //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $mail->Username   = 'anitsplacementsinternships@gmail.com';                     //SMTP username
		    $mail->Password   = 'anits@123';                               //SMTP password
		   // $mail->SMTPKeepAlive = true;
		    $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
		    $mail->Port       = 465;//465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 

		    //Recipients
		    $mail->setFrom('anitsplacementsinternships@gmail.com');
		    $mail->addAddress($sendmail);     //Add a recipient

		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		   $mail->Subject = 'Your Password for Anits Placements and Internship';
		    $mail->Body    = 'Your passowrd is '.($password);
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    //$mail->send();
    		if($mail->Send())
             echo  " <script>   alert('Check Your Email for password');  window.location.href='login.php'; </script> ";
          else
          	//echo "noooooooooooo";
          	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
           }
		}
?>

<?php
	$query = ' select   u.sid as sid, u.sname as sname,u.branch as branch ,f.year as year , c.cname as cname , c.crole as crole , c.salary as salary, u.photo as photo 
from fake f
inner join user u
on f.sid=u.sid
inner join company c
on c.cid=f.cid
order by c.salary desc 
limit 5';
	$j_data=mysqli_query($conn,$query);


?>
<?php 
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
					where f.sid REGEXP('$datas') or c.cname REGEXP('$datas') or c.crole REGEXP('$datas') or u.sname REGEXP('$datas') or u.branch REGEXP('$datas')
					or f.year REGEXP('$datas')
					order by c.salary desc";
		$search_data=mysqli_query($conn,$query);
		$total_search_results= mysqli_num_rows ($search_data);
	}

?>


<!DOCTYPE html>
<html>

<head>
	<link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
	<link href='login1.css' rel='stylesheet'>
<style >
	@import url("https://fonts.googleapis.com/css?family=Lato:300");
.modal {
  	display: none; /* Hidden by default */
  	position: fixed; /* Stay in place */
  	padding-top: 100px; /* Padding at the Top to the box */
  	left: 0; /* Start At top=0 */
  	top: 0; /* Start at Left=0 */
  	width: 100%; /* Full width */
  	height: 100%; /* Full height */
  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */
  	
}

.modal-content { 
  	background-color: white;  
  	margin: auto;
  	padding: 20px;
  	border: 1px solid #888;
  	width: 30%;
  	border-radius: 10px;

}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover , .close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.h1tag1{
	width:100%-40px;
	height:20%; 
	/*background-color:#660066;*/
	background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	padding-left: 40px;
	
}
.anits {
	font-size:60px;
	font-family:'Audiowide';
	color:#F3EDEC;

}
.full-page
{
	width:100%;
	height:720px;
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
.left-scroll
{
	margin:0px;
	transform:translateY(-3.20%);
	color:black;
	font-size:20px;
	position:absolute;
	width:250px;
	overflow:scroll;
	background:lightgrey;
	height:640px;
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
	/*text-align:left;*/
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

/*        Login company                   */

.login-company
{
    /*display: none;*/ /* Hidden by default */
  	position: fixed; /* Stay in place */
  	padding-top: 255px; /* Padding at the Top to the box */
  	left: 0; /* Start At top=0 */
  	top: 0; /* Start at Left=0 */
  	width: 100%; /* Full width */
  	height: 100%; /* Full height */
  	background-color:rgba(0,0,0,0.6); /* Red color in opacity */

}

.company
{
	position:relative;
	height:600px;
	width:70%;
	/*background-color:lightblue;*/
	background: ghostwhite;
	overflow:scroll;
	transform:translateY(-10%);
	left:300px;
	border-radius:10px;
	overflow-x:hidden; 
}
		.about-company h1 , .company-eligibility h1 , .recruitment h1 , .recruitment h2 ,.interviews h1 , .techs h2
		{
			margin-left: 20px;
			background-color:none;
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
			width:82.8%;
			height:580px;
			float:right;
			background:lightblue;
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
		.close1 {
  color: #aaaaaa;
  float: right;
  margin-right: 30px;
  font-size: 40px;
  font-weight: bold;
}

.close1:hover , .close1:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}


/* results page */
.results-tab
{
	width:83%;
	float:right;
	height:600px;
	margin-right:50px;
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

	/* search bar */
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
	height:800px;
	position:absolute;
	top:50%;
	left:50%;
	transform:translate(-50%,-50%);
	border-radius:5px;
}
.top-part
{
	width:100%;
	height:260px;
	border-top-right-radius: 8px;
	border-top-left-radius: 8px;
	position:relative;
	background: white;
}
#inside-searching
{	width:100%;
	position:relative;
	background:white;
	overflow: scroll;
	height:600px;
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

</style>
</head>
<body>
	<h1 class="h1tag1" > <lable class="anits" ><br>ANITS PLACEMENTS & INTERNSHIP</lable></h1>
	<div class="full-page">
		<div class="left-scroll">
			<h2><center> Companies </center></h2>
				<ul>
					<?php while($rowss= mysqli_fetch_array($data2)) { ?>
						<a href="login.php?idd=<?php echo $rowss['idd']; ?>" >   <li onclick="open_company()"  > <?php echo $rowss['company']; ?> </li> </a> 
					<?php } ?>
				</ul>
		</div>

		<div class="search_submit" >
			<center>
				<form  method="POST"  action=""  style="display: inline-block;">
					<input type="text" name="submit_search"  placeholder="Search placements"  required id="submit_search" >
					<input type="submit" value="Search"  name="search" > 
				</form>
				<input type="button" value="Login" name="login" id="myBtn" style="transform:translateX(380%); ">
			</center>
		</div>

		<div class="results-tab">
			<fieldset style="border:3px solid grey;">
			 	<table style="width:95%">
					<tr>
						<legend style="padding: 0px 15px 0px 15px;"> <h1 style="font-size:40px; position:relative;  "   > Top Placements </h1>  </legend>
					</tr>
				<center>
					<tr>
						<?php while($rowes=mysqli_fetch_array($j_data)) { ?>
							<td>
								<div class="picture">
									<div class="logo1">
										<?php echo'<img src="data:image;base64,'.base64_encode($rowes['photo']).'" height="90" width="90"   />'; ?>
									</div>
								     <br>
										<center>
											<label><?php echo strtoupper($rowes['sname']); ?> </label><br>
											<hr style="width:80%">
											<label><?php echo $rowes['sid']."    /"; ?> </label>
											<label style="font-family: Monaco ;"><?php echo strtoupper($rowes['branch']); ?>   </label><br>
											<div class="border-design" >
												<label style="display: inline-block;">    <?php echo $rowes['year']; ?>  </label>
												<label> <?php echo $rowes['cname']; ?>    </label><br>
												<label> <?php echo $rowes['crole']; ?>    </label><br>
												<label style="background:lightgreen; color:black; padding:2px 5px 2px 5px; font-size: 22px; font-weight:bold;">    <?php echo $rowes['salary']." LPA"; ?>  </label>
	   										 </div>
										</center>
								</div>
	  						 </td>
	  					<?php } ?>
					</tr>
				 </center>
				</table> 
			</fieldset>
		</div>
	</div>

	<div id="search_modal" class="search_modal">
		<div id="inside-modal">
			<div class="top-part">
				<span class="close1" onclick="cancel2()">&times;</span>
					<center>
						<fieldset  style="width:87%">
							<legend> <h2 style="font-size:30px;padding:0px 15px 0px 15px;"> Placement Search </h2> </legend>
								<form  method="POST"  action="" >
									<input type="text" name="submit_search" placeholder="Search by Student ID or Student Name or Company Name or Company Role or Year or Branch" required id="submit_search1" >
									<input type="submit" value="Search"  onclick="open_search11()" name="search" > 
				
								</form>	
						</fieldset> 
					</center>
					<p class="my-search">  Search Results For :  <span> <?php echo $datas; ?>  </span>  <span style="float:right; margin-right:90px;"> Profiles found: <?php echo $total_search_results; ?> </span>  </p>
					<hr style="font-weight:bold;"><br>
			</div> 

			<div id="inside-searching">
				<center>
				<?php 
				   if($total_search_results==0)
				   	echo "<h1> No Profiles Found </h1>";
				 ?>
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
													<label style="background:lightgreen; color:black; padding:2px 5px 2px 5px; font-size: 22px; font-weight:bold;">   
														<?php echo $sea['salary']." LPA"; ?>  </label>
												</div>
											</center>
								</div>
	   						</td>
	   						 <?php $i++; if($i==4){ echo '</tr>'; $i=0;}   }  ?>
						</tr>
					</table>
					</center>
			</div>
		</div>
	</div> 

	<div id="myModal" class="modal">
		<center>
  			<div class="login-div">
  				<span class="close" onclick="cancel()">&times;</span>
  					<div id="logs" >
  						<div class="logo" > 
  						</div>
							<div class="title">Login Page </div>
								<form  method="POST"  action="login.php" >
									<div class="fields" >
										<div class="username" ><svg fill="#999" viewBox="0 0 1024 1024"><path class="path1" d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"></path></svg> <input type="text" autocomplete="off" class="user-input" name="un" placeholder="Username"/> 
										</div>
										<div class="password"><svg fill="#999" viewBox="0 0 1024 1024"><path class="path1" d="M742.4 409.6h-25.6v-76.8c0-127.043-103.357-230.4-230.4-230.4s-230.4 103.357-230.4 230.4v76.8h-25.6c-42.347 0-76.8 34.453-76.8 76.8v409.6c0 42.347 34.453 76.8 76.8 76.8h512c42.347 0 76.8-34.453 76.8-76.8v-409.6c0-42.347-34.453-76.8-76.8-76.8zM307.2 332.8c0-98.811 80.389-179.2 179.2-179.2s179.2 80.389 179.2 179.2v76.8h-358.4v-76.8zM768 896c0 14.115-11.485 25.6-25.6 25.6h-512c-14.115 0-25.6-11.485-25.6-25.6v-409.6c0-14.115 11.485-25.6 25.6-25.6h512c14.115 0 25.6 11.485 25.6 25.6v409.6z"></path></svg> <input type="password" class="pass-input" name= "pwd" placeholder="Password"/> 
										</div>
						  			</div> 
									<input type="submit" name="login1" class="signin-button" value="Login" >
									<div class="link" > <a  href="#" onclick="forgetpass()" > Forget Password </a> 
									</div> 
								</form>
					</div>
					<div id="forgets"  >
						<h1> Forget Password </h1>
						<p > No Problem! Enter your email or username below and we will send you an email with your password. </p>
						<form method="POST" action="" style="display:inline-block;">
							<div class="fields" >
								<div class="username" ><svg fill="#999" viewBox="0 0 1024 1024"><path class="path1" d="M896 307.2h-819.2c-42.347 0-76.8 34.453-76.8 76.8v460.8c0 42.349 34.453 76.8 76.8 76.8h819.2c42.349 0 76.8-34.451 76.8-76.8v-460.8c0-42.347-34.451-76.8-76.8-76.8zM896 358.4c1.514 0 2.99 0.158 4.434 0.411l-385.632 257.090c-14.862 9.907-41.938 9.907-56.802 0l-385.634-257.090c1.443-0.253 2.92-0.411 4.434-0.411h819.2zM896 870.4h-819.2c-14.115 0-25.6-11.485-25.6-25.6v-438.566l378.4 252.267c15.925 10.618 36.363 15.925 56.8 15.925s40.877-5.307 56.802-15.925l378.398-252.267v438.566c0 14.115-11.485 25.6-25.6 25.6z"></path></svg> <input type="text" autocomplete="off" class="user-input" name="forget-email" placeholder="Email"/> 
								</div> 
							</div>
							<input type="submit" name="forgetsss" class="signin-button" value="Send Mail"/ >
					    </form>
					    	<div class="link" > <a  href="#" onclick="goback()" > Return to Login </a> 
					    	</div> 
					</div>
				</div>
			</center>
  	</div>


  	<div class="login-company"   id="login-company">
  		<div class="company" id="company" >
			<center>  
				<br>
				<span class="close1" onclick="cancel1()">&times;</span>
				<br>
				<br>
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
		<br> 
		<br>
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
  	 <script>
			var modal = document.getElementById("myModal");
			var btn = document.getElementById("myBtn");
			var logs=document.getElementById("logs");
			var forgets=document.getElementById("forgets");
			btn.onclick = function() {
				modal.style.display = "block";
			}
			window.onclick = function(event) {
				if (event.target == modal) {
		    		modal.style.display = "none";
		  		}
			}
			function cancel() {
		  		modal.style.display = "none";
			}
			function cancel1() {
		  		var opens=document.getElementById("login-company");
				opens.style.display="none";
				window.location.href="login.php";
			}

			function forgetpass()
			{
				//window.location.href="login.php";
				logs.style.display="none";
				forgets.style.display="block";
			}
			function goback()
			{
				logs.style.display="block";
				forgets.style.display="none";
			}
			function cancel2()
			{
				var open=document.getElementById('search_modal');
				open.style.display="none";
			}
	</script>
</body>
</html>