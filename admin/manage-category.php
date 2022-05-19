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
            font-size: 12px;
            font-weight: bold;
        }

        .action:hover{
            background-color: grey;
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
        </div>
        <br>
        <h3 class="text-center">Category List</h3>
        <br>

        <table cellspacing="0">
            <tr>
                <th style="width: 2%">SN.</th>
                <th style="width: 9%">TITLE</th>
                <th style="width: 6%">IMAGE</th>
                <th style="width: 2%">FEATURED</th>
                <th style="width: 2%">ACTIVE</th>
                <th style="width: 5%">ACTIONS</th>
            </tr>

            <?php

                $q = "SELECT * FROM category";

                $res = mysqli_query($con,$q);

                 $sn = 1;
                if(mysqli_num_rows($res)>0){

                    while ($row = mysqli_fetch_assoc($res)) {
                       
                        $id = $row['cid'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        echo "<tr>
                            <td>$sn</td>
                            <td>$title</td>
                            <td>
                            ";
                            if($image_name!=""){
                                echo "<img src= ../category/$image_name width=150px height=80px style='object-fit:cover'>";
                            }
                            else{
                                echo "Image not Added.";
                            }
                            echo "
                             </td>
                            <td>$featured</td>
                            <td>$active</td>
                            <td>
                            &nbsp;<a href=update-category.php?id=$id class='action'>UPDATE</a> &nbsp;&nbsp;&nbsp;
                            <a href=delete-category.php?id=$id&image_name=$image_name class='action'>DELETE</a>
                            </td>
                            </tr>
                        ";
                        $sn = $sn+1;
                    }
                }
                else{
                    echo "
                        <tr>
                        <td colspan=6>No Category Added.</td>
                        </tr>
                    ";
                }
            ?>
        </table>
        
    </div>
   

     </body>
     <script type="text/javascript">
        
        window.setTimeout("closeDiv();", 3000);
        function closeDiv() {
            document.getElementById('error-mssg').style.display ="none";
        }
    </script>
</html>