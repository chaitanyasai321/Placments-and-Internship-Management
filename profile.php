<?php
include('connection.php');
session_start();
if($_SESSION['session_id']==0)
{
  header("location:login.php");
}
$username=$_SESSION['username'];
$query="SELECT * FROM user WHERE sname='$username' ";
$data=mysqli_query($conn,$query);
$row= mysqli_fetch_array($data);
$name=$row['sname'];
$mail=$row['email'];
$id=$row['sid'];
$role=$row['role'];
$batch=$row['batch'];
$branch=$row['branch'];
$phn=$row['phnumber'];
$address=$row['address'];
$gender=$row['gender'];
$photo=$row['photo'];
//echo  "<html> <head> <style> .mydiv { display:block; } </style> </head> </html>";
?>

<html>

<head>

<style >
  .all-box
  {
    width:100%;
      height:585px;
      float:right;
      background: ghostwhite;
      padding-bottom:50px; 
  }
  .left-box
  {
    position:relative;
    width:320px;
    border-radius:8px;
    height:320px;
    /*background-color:ghostwhite;*/
          background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    top:80px;
    left:220px;
  }
  .right-top
  {
    position:relative;
    border-radius:8px;
    width:660px;
    height:237px;
    /*background-color:ghostwhite;*/
          background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    left:590px;
    bottom:240px;
    padding:10px;
  }
  .right-down
  {
    position:relative;
    border-radius:8px;
    width:660px;
    height:150px;
    /*background-color:ghostwhite;*/
          background: #67B26F;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #4ca2cd, #67B26F);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4ca2cd, #67B26F); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    left:590px;
    bottom:200px;
    padding-top:5px;
  }
 .left-box table
 {
  border-spacing: 5px;
 }
 .left-box td
 {
  text-align: left;
  font-size:18px;
 }
 .labels
 {
  font-weight: bold;
 }
 .right-top table
{
  width:100%;
}
.right-top table, .right-top td
{
 border: 2px solid black;
  border-collapse: collapse;
  font-size:18px;
  padding:10px;
}
</style>


</head>
<body>
<div class="all-box" >
  <div class="left-box">
    <br>
   <center> <?php echo'<img  style="border-radius:50%;"   src="data:image;base64,'.base64_encode($photo).'" height="130" width="130"   />'; ?>
   <h3> <?php echo strtoupper($name) ?> </h3></center>
   <hr>
   <table>
    <tr>
      <td class="labels"> Student Id</td>
      <td> : </td>
      <td> <?php echo $id ?> </td>
    </tr>
    <tr>
      <td class="labels"> Batch : </td>
      <td> : </td>
      <td> 2018-22 </td>
    </tr>
    <tr>
      <td class="labels"> Branch</td>
      <td> : </td>
      <td> <?php echo strtoupper($branch); ?> </td>
    </tr>
  </table>
  </div>

  <div class="right-top">
    <h2> More Information </h2>
    <center>
  <table>
    <tr>
      <td class="labels">  Email Id</td>
      <td > : </td>
      <td > <?php echo $mail; ?> </td>
    </tr>
    <tr>
      <td class="labels"> Mobile Number</td>
      <td> : </td>
      <td> <?php echo $phn; ?> </td>
    </tr>
    <tr>
      <tr>
      <td class="labels"> Academic Year</td>
      <td> : </td>
      <td> 2021 </td>
    </tr>
    <tr>
      <td class="labels"> Gender </td>
      <td> : </td>
      <td> <?php echo $gender; ?></td>
    </tr>
  </table>
</center>

  </div>
  <div class="right-down">
    <h2 > Address </h2>
    <center ><p style="font-size:20px;  margin:30px;  border:1px solid black;  " > <?php echo $address; ?> </p> </center>
  </div>
</div>
</body>

</html>