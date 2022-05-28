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

       .btngroup{
            margin:10px 30px;
            height: 80px;
            padding: 2%;
            /*background-image: linear-gradient(to right top, #83999b, #87a1a9, #8ea7b8, #9badc5, #adb1d0);*/
            border-top: 1px solid rgba(74, 74, 74, 0.35);
            border-bottom: 1px solid rgba(74, 74, 74, 0.35);
            color: black;
       }

       .btngroup input{
            height: 60%;
            width: 30%;
            padding-left: 10px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid black;
            
            background:transparent;
            color: black;
       }

       .btngroup button{
            height: 35px;
            width: 10%;
            border: none;
            cursor: pointer;
            margin:1% 1%;

       }

       .orderdisplay{
            height: auto;
            margin: 10px 30px;
            padding: 1% 2%;
            /*background-image: linear-gradient(to right top, #83999b, #87a1a9, #8ea7b8, #9badc5, #adb1d0);*/
            border-top: 1px solid rgba(74, 74, 74, 0.35);
            border-bottom: 1px solid rgba(74, 74, 74, 0.35);
            display: none;
       }

       label{
            display: block;
            margin: 5px 0px;

       }
       p{
        padding: 0.5% 3%;
       }

       table{
            border-collapse: collapse;
            margin-left: 30px;
       }

       th,td{
            background-image: none;
            color: black;
            border-bottom: 1px solid rgba(74, 74, 74, 0.35);
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
        <div class="btngroup">
            Order-Id : <input type="text" name="" id="oids" placeholder="xx xx xx xx ">
            <br>
            <button style="background-color: green;color: white;margin-left: 75px; " id="search">Search</button>
            <button style="background-color: red;color: white;" id="reset">Reset</button>

        </div>

        <div class="orderdisplay">
          
           
        </div>
        
    </div>

   

     </body>

     <script src="../js/jquery-3.6.0.min.js"></script>

    <script>
            $(document).ready(function(){

                $("#search").click(function(){
                    var o = $("#oids").val();
                    if(o==""||(/^\s*$/.test(o))){
                        alert("Fill the input");
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'oidsearch.php',
                            data:{
                                oid:o
                            },
                            cache:false,
                            
                            success: function (data) {

                                $(".orderdisplay").html(data);
                                $(".orderdisplay").fadeIn();
                            },
                            
                             error: function(xhr, status, error) {
                                console.error(xhr);
                            }
                        });
                    }
                });

                $("#reset").click(function(){
                    $("#oids").val("");
                });
            });
    </script>
</html>