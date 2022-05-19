<?php 
    include('../connect.php');

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
   
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != "")
        {
            $path = "../food/".$image_name;
            $remove = unlink($path);

            if($remove==false)
            {
                header('location:/manage-food.php');
                die();
            }
        }

        $sql = "DELETE FROM food WHERE fid=$id";

        $res = mysqli_query($con, $sql);

        if($res==true)
        {
            header('location:manage-food.php');
        }
    
    }
    else
    {
        header('location:manage-food.php');
    }
?>