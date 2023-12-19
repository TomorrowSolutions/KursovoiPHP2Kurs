<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
            //getting id
            $id=$_GET['id'];
            //sql query
            $sql="SELECT * FROM tbl_admin WHERE id=$id";
            //execute query
            $res=mysqli_query($conn, $sql);
            //check whether query is executed or not
            if($res==true)
            {
                //check whether data is available or not
                $count=mysqli_num_rows($res);
                if($count==1)
                {
                    //get data
                    $row=mysqli_fetch_assoc($res);
                    $full_name=$row['full_name'];
                    $username=$row['username'];
                }
                else
                {
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update admin" class="btn-secondary">

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
        //get values from form
        $id=$_POST['id'];
        $full_name=mysqli_real_escape_string($conn,$_POST['full_name']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        //sql query
        $sql="UPDATE tbl_admin SET
        full_name='$full_name',
        username='$username'
        WHERE id='$id'
        ";

        //execute query
        $res=mysqli_query($conn,$sql);
        //check whether query is executed successfully or not
        if($res==true)
        {
            //query executed and admin updated successfully
            $_SESSION['update']="<div class='success'>Admin updated successfully</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //smth going wrong
            $_SESSION['update']="<div class='error'>Failed to update admin</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }



    }

?>

<?php include('partials/footer.php');?>