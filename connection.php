<?php 
    $connection = mysqli_connect("db-main-master.ctauiqqlg2bt.ap-southeast-1.rds.amazonaws.com", "xrundb", "xrundatA6a52!!" ,"xrun"); 
    $sql = mysqli_query($connection, "SELECT * FROM homepagenotice"); 
    $result = array(); 
     
    while ($row = mysqli_fetch_assoc($sql)) { 
        $data[] = $row; 
    } 
 
    echo json_encode(array("result" => $data)); 
?>
