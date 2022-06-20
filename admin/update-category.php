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
        <br><br>

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];

                $q = "SELECT * FROM category WHERE cid=$id";
                $res = mysqli_query($con,$q);

                if(mysqli_num_rows($res) == 1){
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else{
                    echo "<script>alert('not found');</script>";
                }
            }
            else{
                header("location:manage-category.php");
            }
        ?>

        <h3 class="text-center">Update Category</h3>
        <br>
        <div class="register" style="width: 50%;">
            <form action="" method="POST" enctype="multipart/form-data">
                <h4>Title</h4>

                <input type="text" name="title" placeholder="Category Title" required value="<?php echo $title; ?>"><br>

                <h4>Current Image</h4>
                <div><?php 
                    if($current_image!=""){
                        echo "<img src=../category/$current_image width=100px height=80px style='object-fit:contain'>";
                    }
                    else{
                        echo "<input type='text' value='Image Not Added.' disabled style='color:red; border:none'>";
                    }

                ?></div>

                <h4>Upload Image</h4>  
                <input type="file" name="image" ><br>

                <h4>Featured</h4>
                <input type="radio" <?php if($featured=="Yes"){echo "checked";} ?> name="featured" value="Yes" style="width: 20%;vertical-align: middle; margin: 1%;" required> Yes 

                <input type="radio" <?php if($featured=="No"){echo "checked";} ?> name="featured" value="No" style="width: 20%;vertical-align: middle; margin: 1%;" required> No 
                <br><br>

                <h4>Active</h4>
                <input type="radio" <?php if($active=="Yes"){echo "checked";} ?> name="active" value="Yes" style="width: 20%;vertical-align: middle; margin: 1%;" required> Yes 

                <input type="radio" <?php if($active=="No"){echo "checked";} ?> name="active" value="No" style="width: 20%;vertical-align: middle; margin: 1%;" required> No 
                <br><br>   

                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input type="submit" name="submit" value="Update Category">
                   

             </form>
        


        </div>  
    </div>

    <?php 
        
            if(isset($_POST['submit']))
            {
              
                $title = mysqli_real_escape_string($con,$_POST['title']);
                $id = $_POST['id'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];


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
                        
                        if($current_image!="")
                        {
                            $remove_path = "../category/".$current_image;

                            $remove = unlink($remove_path);

                            if($remove==false)
                            {
                               
                                header('location:manage-category.php');
                                die();
                            }
                        }

                    }
                    else{
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

            
               

                $sql = "UPDATE category SET title='$title' , image_name='$image_name' , featured='$featured' , active='$active' WHERE cid=$id";
                   

                $res = mysqli_query($con, $sql);

                if($res==true)
                {
                   echo '<div id="error-mssg">Category Updated Successfully.</div>';
                       
                }
                else
                {
                    echo '<div id="error-mssg">';
                       echo "Failed to Update Category.";  
                    echo '</div>';  
                }
            }
        
        ?> 

     </body>
     <script type="text/javascript">
        
        window.setTimeout("closeDiv();", 2000);
        function closeDiv() {
            document.getElementById('error-mssg').style.display ="none";
            window.location="manage-category.php";
        }
    </script>
</html>