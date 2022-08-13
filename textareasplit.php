

<?php
include("connection.php");
if(isset($_POST['submit']))
{
	$text=$_POST['company'];
	$insert= "insert into try values('$text'); ";
	$data=mysqli_query($conn,$insert);
	if($data)
	{
		echo " hahah";
	}
	else echo "noo";
}
else
	echo "noooooooooo";

?>

<html>
<body>
	<form method="POST" >
		<textarea name="company" id="company" row="20" col="100" style="width:600px; height:100px;" ></textarea>
		<input type="submit" name="submit" onclick="go()" value="submit" >
 
	</form>
	<script>
		/*function go()
		{
			var k=document.getElementById('company').value;
			alert(k);
		}*/
	</script>
</body>
</html>  