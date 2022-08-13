
 <?php 
include("connection.php");
 $select = "select * from try";
 $data=mysqli_query($conn,$select);
 $row=mysqli_fetch_array($data);
 $dq=$row['textarea'];
 $div= explode(".",$dq);
 $len= count($div) -1 ;
 echo $div[2];
 ?>
 <html>
 <body>
 	<ul>
 		<?php 
 		for($i=0;$i<$len;$i++)
 		{ ?>
 			<li>   <?php echo $div[$i]."."; ?> </li>
 		<?php } ?>
 	</ul>
 </body>
</html>

 