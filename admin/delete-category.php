<?php
    //including constants
    include('../config/constants.php');  
    //check whether id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get value and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the image if it's available
        if($image_name!="")
        {
            //image available
            $path="../img/category/".$image_name;
            //remove image
            $remove=unlink($path);
            //if failed to remove image - add error message and stop process
            if($remove==false)
            {
                //Set session message
                $_SESSION['remove']="<div class='error'>Failed to remove category image</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop process
                die();
            }
        }

        //delete data from db
        //sql query
        $sql="DELETE FROM tbl_category WHERE id=$id";
        //execute query
        $res=mysqli_query($conn,$sql);

        //check whether data is deleted from db or not
        if($res==true)
        {
            //set success message and redirect to manage admin page
            $_SESSION['delete']="<div class='success'>Category deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php'); 

        }
        else
        {
            //set fail message and redirect to manage admin page
            $_SESSION['delete']="<div class='error'>Failed to delete category</div>";
            header('location:'.SITEURL.'admin/manage-category.php'); 
        }
        //redirect to manage category page with message

    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');

    }
    
?>