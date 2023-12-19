<?php
    //including constants
    include('../config/constants.php');  

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        
        //get id and image name
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];
        //remove image if it's available
        //check whether image is available or not and delete if it's available
        if($image_name!="")
        {
            //image available
            //get image path
            $path="../img/food/".$image_name;
            //remove file from folder
            $remove=unlink($path);
            //check whether image is removed or not
            if($remove==false)
            {
                //failed to remove
                $_SESSION['upload']="<div class='error'>Failed to remove image</div>";
                //redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }
        else
        {
            //image unavailable
        }




        //delete data from db
        $sql="DELETE FROM tbl_food WHERE id=$id";
        //execute query
        $res=mysqli_query($conn,$sql);

        //check whether query is executed or not and set session message
        //redirect to manage food page with message
        if($res==true)
        {
            //data deleted
            $_SESSION['delete']="<div class='success'>Food deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete data
            $_SESSION['delete']="<div class='error'>Failed to delete food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorize']="<div class='error'>Unauthorized access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>