<?php

    //including constants
    include('../config/constants.php');    

    //get id of admin to be deleted
    $id=$_GET['id'];

    //sql query to delete
    $sql="DELETE FROM tbl_admin WHERE id=$id";

    //execute query
    $res=mysqli_query($conn,$sql);

    //check whether query executed successfully or not
    if($res==true)
    {
        //all right
        //Create session var to display message
        $_SESSION['delete']="<div class='success'>Admin deleted succesfully</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin

        $_SESSION['delete']="<div class='error'>Failed to delete admin</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //redirect to manage admin page with message (success/error)
?>