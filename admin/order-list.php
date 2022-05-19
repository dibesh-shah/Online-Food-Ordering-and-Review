<?php
    session_start();
    if(!isset($_SESSION['adminemail'],$_SESSION['role'])){
        header('location:login.php');
        die();
    }
    
    include('../connect.php');
    ?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <style type="text/css">
        #error-mssg{
            width: auto;
            height: 4vh;
            position: absolute;
            padding: 1.5% 1% 1% 1%;
            right: 1.5%;
            bottom: 2%;
            color: white;
            background-color: #ab8e17;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
            border-radius: 7px;
            transition: 0.4s;
        }

        .action{
            text-decoration: none;
            color: white;
            background-color: black;
            padding: 4%;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .action:hover{
            background-color: grey;
        }

        .orderl{
            overflow-x: auto;
            min-height: 89vh;
        }

        table{
            width: 155%;
            border-collapse: collapse;
        }

        td{
            background-image: none;
        }

        tr{
            background-color: white;
           box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        }



    </style>
</head>
<body>
    <div class="sidebar text-center">
        <img src="../images/logo.png">
        <br>
        <h4 style="font-size: 17px;font-weight: 600;color: rgb(206, 240, 253);">ADMIN</h4>
        <br>
        <div class="innerside">
            <a href="dashboard.php">Dashboard</a>
            <a href="add-category.php">Add Category</a>
            <a href="manage-category.php">Manage Category</a>
            <a href="add-food.php">Add Food</a>
            <a href="manage-food.php">Manage Food</a>
            <a href="order-list.php">Order List</a>
            <a href="searchorder.php">Search Order</a>
        </div>
        <div style="bottom: 10px;left: 14px; position: fixed; color: #B4B4B4;">
            <h5>Copyright@2022 Food Inc.</h5>
        </div>
        
    </div>
    <div class="restlist">
        <div class="restheader">
            <img src="../images/logo.png" height="50px" width="60px" >
            <div class="restheaderbtn">
                <button id="today">Today</button>
                <button id="schedule">Schedule</button>

            </div>
        </div>
                <br>
        <div class="orderl">
            <table cellspacing="0">
                <tr>
                    <th >OID</th>
                    <th >FOOD</th>
                    <th >PRICE</th>
                    <th >QUANTITY</th>
                    <th >TOTAL</th>
                    <th >INSRUCTION</th>
                    <th >DATE</th>
                    <th >STATUS</th>
                    <th >NAME</th>
                    <th >ADDRESS</th>
                    <th >CONTACT</th>
                    <th >ACTION</th>
                </tr>

               <?php

                    $todaydate =  date("Y-m-d");
                    $q = "SELECT * FROM `order` WHERE status!='cart' and `order-date`  LIKE '$todaydate%:__:%' order by `oid` DESC";

                    $res = mysqli_query($con,$q);

                     $sn = 1;
                    if(mysqli_num_rows($res)>0){

                        while ($row = mysqli_fetch_assoc($res)) {
                           
                            $oid = $row['oid'];
                            $food = $row['food'];
                            $price = "Rs ".$row['price'];
                            $quantity = $row['quantity'];
                            $total = $row['total'];
                            $instruction = $row['instruction'];
                            $date = $row['order-date'];
                            $status = $row['status'];
                            $name = $row['c-name'];
                            $address = $row['c-address'];
                            $contact = $row['c-contact'];
                            $sn++;
                            ?>

                            <tr style='<?php if($sn%2!=0) echo "background-color: #f5f5f5"?>'>
                                
                                <td class="oidd"><?php echo $oid; ?>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $instruction; ?></td>
                                <td><?php echo $date; ?></td>

                                <td class="statusbtn">
                                    <?php 

                                        echo "<label class='label'>$status</label>";
                                        
                                    ?>
                                </td>

                                <td><?php echo $name; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $contact; ?></td>
                                <td>
                                    <button class="b1">OnDelivery</button>
                                    <button class ="b2">Delivered</button>
                                    <button class ="b3">Cancelled</button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else{
                        echo "
                            <tr>
                            <td colspan=8 class='text-center'>No Order Placed.</td>
                            </tr>
                        ";
                    }

                    
                ?>
            </table>
        </div>
        
    </div>
   
     </body>
    
<script src="../js/jquery-3.6.0.min.js"></script>

    <script>
            $(document).ready(function(){

               $('.b1').click(function(){

                    var z = $(this).parent().parent().find('.statusbtn .label');

                    var a = $(this).parent().parent().find('.oidd').html();

                    $.ajax({
                        type:'POST',
                        url:'update-status.php',
                        data:{
                           oid:a,
                           status:'On Delivery'
                        },
                        cache:false,
                        
                        success: function (data) {

                           z.html(data);
                           

                        },
                        
                         error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });


                });


                $('.b2').click(function(){

                    var z = $(this).parent().parent().find('.statusbtn .label');

                    var a = $(this).parent().parent().find('.oidd').html();
                    $.ajax({
                        type:'POST',
                        url:'update-status.php',
                        data:{
                           oid:a,
                           status:'Delivered'
                        },
                        cache:false,
                        
                        success: function (data) {

                            z.html(data);

                        },
                        
                         error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                        });


                });


                 $('.b3').click(function(){

                    var z = $(this).parent().parent().find('.statusbtn .label');

                    var a = $(this).parent().parent().find('.oidd').html();

                    $.ajax({
                        type:'POST',
                        url:'update-status.php',
                        data:{
                           oid:a,
                           status:'Cancelled'
                        },
                        cache:false,
                        
                        success: function (data) {

                            z.html(data);
                        },
                        
                         error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                        });


                });

                 $('#schedule').click(function(){
                    window.location ="orderlist-schedule.php";
                 });

                 $('#today').click(function(){
                    document.location.reload(true);
                 });

            });

    </script>
</html>