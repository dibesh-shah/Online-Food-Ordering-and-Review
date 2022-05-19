<?php
        
    session_start();

    include('../connect.php');

    $oid = $_POST['oid'];
    $status = $_POST['status'];
   

    $q = " UPDATE `order` SET status='$status' WHERE  oid='$oid'";

    $res = mysqli_query($con,$q);

    if($res){

       $q = " SELECT status FROM `order` WHERE oid='$oid'";

        $res = mysqli_query($con,$q);

        while ($row = mysqli_fetch_assoc($res)) {

            $a = $row['status'] ;
        }

        echo $a;


    }




  ?>