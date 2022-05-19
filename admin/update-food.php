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

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];

                $q = "SELECT * FROM food WHERE fid=$id";
                $res = mysqli_query($con,$q);

                if(mysqli_num_rows($res) == 1){
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_image = $row['image_name'];
                    $current_category = $row['category_id'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else{
                    echo "<script>alert('not found');</script>";
                }
            }
            else{
                header("location:manage-food.php");
            }
        ?>

        <h3 class="text-center">Update Category</h3>
        <br>
        <div class="register" style="width: 50%;">
            <form action="" method="POST" enctype="multipart/form-data">
                <h4>Title</h4>

                <input type="text" name="title" placeholder="Food Title" required value="<?php echo $title; ?>"><br>

                <h4>Description</h4>
                <textarea name="description"  placeholder="Description of the Food." ><?php echo $description; ?></textarea>
                <br>

                <h4>Price</h4>
                <input type="text" name="price" value="<?php echo $price; ?>"><br>

                <h4>Current Image</h4>
                <div><?php 
                    if($current_image!=""){
                        echo "<img src=../food/$current_image width=100px height=80px style='object-fit:contain'>";
                    }
                    else{
                        echo "<input type='text' value='Image Not Added.' disabled style='color:red; border:none'>";
                    }

                ?></div>

                <h4>Upload New Image</h4>  
                <input type="file" name="image" ><br>

                <h4>Category</h4>
                <select name="category">

                     <?php 
                        $sql = "SELECT * FROM category WHERE active='Yes'";

                        $res = mysqli_query($con, $sql);

                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['cid'];
                                
                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            echo "<option value='0'>Category Not Available.</option>";
                        }

                    ?>

                </select>

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
                
                $id = $_POST['id'];
                $title = mysqli_real_escape_string($con,$_POST['title']);
                $description = mysqli_real_escape_string($con,$_POST['description']);
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];


                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    
                    if($image_name != "")
                    {
                        $ext = explode('.', $image_name);
                        $ext = end($ext);

                        $image_name = "Food_".uniqid().'.'.$ext;
                        
                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../food/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if($upload==false)
                        {
                              echo "<div id='error-mssg'>Failed to Upload Image.</div>";
                       
                            header('location:add-food.php');
                            die();
                        }
                        
                        if($current_image!="")
                        {
                            $remove_path = "../food/".$current_image;

                            $remove = unlink($remove_path);

                            if($remove==false)
                            {
                               
                                header('location:manage-food.php');
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

            
        
                $q = "UPDATE food SET title='$title' ,description = '$description',price = $price, image_name='$image_name' ,category_id = '$category', featured='$featured' , active='$active' WHERE fid=$id";
                   

                $res = mysqli_query($con, $q);

                if($res==true)
                {
                   echo '<div id="error-mssg">Food Updated Successfully.</div>';
                       
                }
                else
                {
                    echo '<div id="error-mssg">';
                       echo "Failed to Update Food.";  
                    echo '</div>';  
                }
            }
        
        ?> 

     </body>
     <script type="text/javascript">
        
        window.setTimeout("closeDiv();", 2000);
        function closeDiv() {
            document.getElementById('error-mssg').style.display ="none";
            window.location="manage-food.php";
        }
    </script>
</html>