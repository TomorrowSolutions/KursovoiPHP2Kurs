<?php include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login - Restaurant System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login ">
            <h1 class="text-center">Login</h1><br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset( $_SESSION['no-login-message']))
                {
                    echo  $_SESSION['no-login-message'];
                    unset( $_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form -->
            <form action="" method="POST" class="text-center">
            Username <br>
            <input type="text" name="username" placeholder="Enter username"><br><br>
            Password<br>
            <input type="password" name="password" placeholder="Enter password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
            </form>
            <!-- Login Form -->

            <a href="<?php echo SITEURL; ?>" class="text-center link">Back to Restaurant</a>
        </div>
    </body>
</html>

<?php 

    //check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //get data from form
        //$username=$_POST['username']; not safe check food-search.php
        //$password=md5($_POST['password']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $raw_password=md5($_POST['password']);
        $password=mysqli_real_escape_string($conn,$raw_password);
        //sql query to check whether user with typed uname and pass exist or not
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";
        //execute query
        $res=mysqli_query($conn,$sql);
        //checking whether user exist or not
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            //user available and login success
            $_SESSION['login']="<div class='success'>Login successful</div>";
            $_SESSION['user']=$username;//to check whether user is logged in or not and logout will unset it

            //redirect to home page/dashoboard
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            //user not available and login failed
            $_SESSION['login']="<div class='error text-center'>Username or password is incorrect</div>";
            //redirect to home page/dashoboard
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>