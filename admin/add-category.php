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
        <br><br><br>
        <h3 class="text-center">Add Category</h3>
        <br>
        <div class="register" style="width: 50%;">
            <form action="" method="POST" enctype="multipart/form-data">
                <h4>Title</h4>

                <input type="text" name="title" placeholder="Category Title" required><br><br>

                <h4>Upload Image</h4>  
                <input type="file" name="image" ><br><br>

                <h4>Featured</h4>
                <input type="radio" name="featured" value="Yes" style="width: 20%;vertical-align: middle; margin: 1%;" required> Yes 
                <input type="radio" name="featured" value="No" style="width: 20%;vertical-align: middle; margin: 1%;" required> No 
                <br><br>

                <h4>Active</h4>
                <input type="radio" name="active" value="Yes" style="width: 20%;vertical-align: middle; margin: 1%;" required> Yes 
                <input type="radio" name="active" value="No" style="width: 20%;vertical-align: middle; margin: 1%;" required> No 
                <br><br>   

                <input type="submit" name="submit" value="Add Category">
                   

             </form>
        


        </div>  
    </div>

    <?php 
        
            if(isset($_POST['submit']))
            {
              
                $title = mysqli_real_escape_string($con,$_POST['title']);

                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }


                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    
                    if($image_name != "")
                    {
                        $ext = explode('.', $image_name);
                        $ext = end($ext);

                        $image_name = "Category_".uniqid().'.'.$ext;
                        
                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../category/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if($upload==false)
                        {
                              echo "<div id='error-mssg'>Failed to Upload Image.</div>";
                       
                            header('location:add-category.php');
                            die();
                        }

                    }
                }
                else
                {
                    $image_name="";
                }

                $q = "INSERT INTO category (title,image_name,featured,active) VALUES ('$title','$image_name','$featured','$active')";
                   

                $res = mysqli_query($con, $q);

                if($res==true)
                {
                   echo '<div id="error-mssg">Category Added Successfully.</div>';
                       
                }
                else
                {
                    echo '<div id="error-mssg">';
                       echo "Failed to Add Category.";  
                    echo '</div>';  
                }
            }
        
        ?> 

     </body>
     <script type="text/javascript">
        
        window.setTimeout("closeDiv();", 3000);
        function closeDiv() {
            document.getElementById('error-mssg').style.display ="none";
        }
    </script>
</html>