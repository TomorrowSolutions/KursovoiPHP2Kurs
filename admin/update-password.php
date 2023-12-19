<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Current password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current password">
                    </td>
                </tr>
                <tr>
                    <td>New password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php 
    //check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Get data from form
        $id=$_POST['id'];
        $raw_current_password=md5($_POST['current_password']);
        $raw_new_password=md5($_POST['new_password']);
        $raw_confirm_password=md5($_POST['confirm_password']);
        $current_password=mysqli_real_escape_string($conn,$raw_current_password);
        $new_password=mysqli_real_escape_string($conn,$raw_new_password);
        $confirm_password=mysqli_real_escape_string($conn,$raw_confirm_password);

        //Check whether user with id and  current password exist or not
        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        //execute query
        $res=mysqli_query($conn,$sql);
        if($res==true)
        {
            //check whether data is available or not
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                //user exist and password can be changed
                //check whether new password and confirm password are equal
                if($new_password==$confirm_password)
                {
                    //update the password
                    $sql2="UPDATE tbl_admin SET 
                        password='$new_password'
                        WHERE id=$id  
                    ";

                    //execute query 
                    $res2=mysqli_query($conn, $sql2);

                    //check whether query  executed or not
                    if($res2==true)
                    {
                        //display success message
                        //redirect to manage admin page with success message
                        $_SESSION['change-pwd'] = "<div class='success'>Password changed succesfully</div>";
                        //redirect to manage admin page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //display error message
                        //redirect to manage admin page with error message
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change password</div>";
                        //redirect to manage admin page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //redirect to manage admin page with error message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Passwords not equals</div>";
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');

                }
            }
            else
            {
                //User does not exist . Set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not found</div>";
                //redirect to manage admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //Check whether new password and confrim password are equal or not

        //Change password
    }
?>


<?php include('partials/footer.php');?>