<?php include('partials/menu.php');?>

        <!-- Main Content Section -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>

                <?php 
                    if (isset($_SESSION['add'])) 
                    {
                        echo $_SESSION['add'];//display session message
                        unset($_SESSION['add']);//remove session message   
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']); 
                    }
                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }
                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }
                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }
                ?>
                <br><br><br>
                <!-- Add Admin button -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br><br><br>
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //get all admins from table
                        $sql="SELECT * FROM tbl_admin";
                        //execute query
                        $res=mysqli_query($conn,$sql);
                        //check wheter query is executed or not
                        if($res==TRUE)
                        {
                            //count raws to check whether we have data in db
                            $count=mysqli_num_rows($res);

                            $sn=1;

                            if($count>0)
                            {
                                //We have data in db
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    $id=$rows['Id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //display info in table
                                    ?>

                                <tr>
                                    <td><?php echo $sn++ ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>

                                    <?php
                                }
                            }
                            else{
                                //We dont have data in db
                            }
                        }
                    ?>

                    
                </table>
            </div>
            
        </div>
        <!-- Main Content Section -->

<?php include('partials/footer.php');?>