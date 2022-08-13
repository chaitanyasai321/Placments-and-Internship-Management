<?php
    include('connection.php');
    $query="select * from call_letters where id=1";
    $data=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($data);

?>


<html>
<body>
    <?php 
        header('Content-type'.$row['doctype']);
        echo ( $row['data'] );
    ?>
   <!-- <object data="data:<?php echo $row['doctype']?>;base64,<?php echo base64_encode($row['data']) ?>" type="<?php echo $row['doctype']?>" style="height:100%;width:100%"></object> -->
</body>
</html>