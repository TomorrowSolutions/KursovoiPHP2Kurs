<?php
    //include constants
    include('../config/constants.php');
    //destroy session
    session_destroy();//unset SESSION['user']
    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>