<?php
    include('connection.php');
    if(isset($_POST['submit']))
    {
    	$name= $_FILES['docu']['name'];
    	$type=$_FILES['docu']['type'];
    	//$name="wow";
    	//$type="please";
    	$doc= $_FILES['docu']['tmp_name'];
    	$data = mysqli_real_escape_string($conn, file_get_contents($doc));
    	$query= "insert into call_letters(name,doctype,data) values('$name','$type','$doc')";
    	$record= mysqli_query($conn,$query);
    	if($record)
    		echo "successful";
    	else
    		echo "failed";

    }

?>


<html>
<body>
	<form method="POST" enctype="multipart/form-data" >
		<input type="file" name="docu" >
		<input type="submit" name="submit" value="Submit" >
	</form>
</body>
</html>