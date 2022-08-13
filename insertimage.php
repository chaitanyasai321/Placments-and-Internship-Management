<?php
include("connection.php");
if(isset($_POST['submit']))
{
	$file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
      $query = "INSERT INTO doc(image) VALUES ('$file')";  
      if(mysqli_query($conn, $query))  
      {  
           echo 'success';  
      }  
}


 ?>

<hmtl>
	<body>
		<form action="insertimage.php" method="POST" enctype="multipart/form-data" >
			<input type="file" name="image" >
			<input type="submit" name="submit" value="submit" >
		</form>
		<div>
			<?php  
                $query = "select * from doc";  
                $result = mysqli_query($conn, $query);  
                while($row = mysqli_fetch_array($result))  
                {  
                     echo '  
                          <tr>  
                               <td>  
                                    <img src="data:image;base64,'.base64_encode($row['image'] ).'" height="300" width="700"  />  
                               </td>  
                          </tr>  
                     ';  
                }  
                ?>  
        </div>
	</body>
</hmtl>