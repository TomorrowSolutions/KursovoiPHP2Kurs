<?php include('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>
        <?php 
            if (isset($_SESSION['add']))//check session 
            {
                echo $_SESSION['add'];//display session message if set
                unset($_SESSION['add']);//remove session message 
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="Your username">
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Your password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php 
//Process data and save it in database

//Check is submit clicked or not

if(isset($_POST['submit'])){
    //echo "button cliked";

    $full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $raw_password=md5($_POST['password']);//md5 encrypt
    $password=mysqli_real_escape_string($conn,$raw_password);
    //sql save to db
    $sql="INSERT INTO tbl_admin SET 
        full_name='$full_name',
        username='$username',
        password='$password'
    ";

    //execute query and saving data to db
    $res = mysqli_query($conn,$sql) or die(mysqli_error());
    
    //check insert
    if ($res==TRUE) {
        //all right
        //echo "Data inserted";
        //Session var for message
        $_SESSION['add']="<div class='success'>Admin Added successfully</div>";
        //redirect to manage admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else {
        //smth wrong
        //echo "smth wrong";
        //Session var for message
        $_SESSION['add']="<div class='error'>Failed to add admin</div>";
        //redirect to add admin page
        header("location:".SITEURL.'admin/add-admin.php');
        
    }
}

?>