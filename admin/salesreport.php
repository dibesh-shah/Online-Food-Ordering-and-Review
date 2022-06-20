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
       .restlist{
            min-height: 100vh;
       }

       #popup{
            width: 50%;
            height: auto;
            
            margin:10px 30px;
            padding: 2%;
            border-top: 1px solid rgba(74, 74, 74, 0.35);
            border-bottom: 1px solid rgba(74, 74, 74, 0.35);
            color: black;
        }

        #popup p{
            border: none;

        }

        #popup input{
            width: 90%;
            height: 40px;
            padding: 1% 1% 1% 2%;
            font-size: 16px;
        }

        #popup button{
            padding: 2%;
            border: none;
            margin-top: 15px;
            margin-right: 30px;
            cursor: pointer;
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
            <a href="salesreport.php">Sales Report</a>
        </div>
        <div style="bottom: 10px;left: 14px; position: fixed; color: #B4B4B4;">
            <h6>Copyright@2022 Food Inc.</h6>
        </div>
        
    </div>

    <div class="restlist">
        <div class="restheader">
            <img src="../images/logo.png" height="50px" width="60px" >
            <div class="logoutbtn"><a href="logout.php">Logout</a></div>
        </div>
        <br>
        <div id="popup" >
            <form action="report.php" method="POST" target="_blank">
                <div id="start" style="width: 50%;float: left;">
                    <p>Start Date</p>
                    <input type="date" id="sstart" name="start">
                </div>
                <div id="end" style="width: 50%;float: right;">
                    <p>End Date</p>
                    <input type="date" id="eend" name="end">
                </div>
                <div style="clear: both;"></div>
                <button style="background-color: green;color: white;" id="submit">Generate</button>
                <button style="background-color: red;color: white;" id="clear">CLEAR</button>
            </form>
        </div>
        
    </div>

   

     </body>

     <script src="../js/jquery-3.6.0.min.js"></script>

    <script>
            $(document).ready(function(){

                $("#submit").click(function(){
                    var s = $("#sstart").val();
                    var e = $("#eend").val();

                    if(s==""||(/^\s*$/.test(s))){
                        alert("Please select the date.");
                        return false;
                    }
                   
                });

                $("#clear").click(function(){
                    $("#sstart").val("");
                    $("#eend").val("");
                    return false;
                });
            });
    </script>
</html>