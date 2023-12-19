<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        

        <?php

            //Check whether id is set or not
            if(isset($_GET['id']))
            {
                //get id and all details
                $id=$_GET['id'];
                //sql query
                $sql="SELECT * FROM tbl_category WHERE id=$id";
                //execute query
                $res=mysqli_query($conn,$sql);
                //count rows
                $count=mysqli_num_rows($res);

                if($count==1)
                {
                    //get all data
                    $row=mysqli_fetch_assoc($res);
                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else
                {
                    //redirect to manage category page with error message
                    $_SESSION['no-category-found']="<div class='error'>Category not found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');

            }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current image</td>
                    <td>
                        <?php                             
                            if($current_image!="")
                            {
                                //display image
                                ?>
                                <img src="<?php echo SITEURL;?>img/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image not added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked"; }  ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){ echo "checked"; }  ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked"; }  ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){ echo "checked"; }  ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                    
                </tr>

            </table>
        </form>
        
        <?php
            if(isset($_POST['submit']))
            {
                //get values from form
                $id=$_POST['id'];
                $title=mysqli_real_escape_string($conn,$_POST['title']);
                $current_image=$_POST['current_image'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];
                //updating new image if it's selected
                //check whether image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name=$_FILES['image']['name'];

                    //check whether image available or not
                    if($image_name!="")
                    {
                        //image available
                        //1.upload new image
                        
                        //Auto rename image
                        //get extension of image (jpg,png,gif,etc)
                        $ext=end(explode('.',$image_name));

                        //rename image
                        $image_name="Food_Category_".rand(000,999).'.'.$ext;//name be like Food_Category_000.jpg


                        $source_path=$_FILES['image']['tmp_name'];

                        $destination_path="../img/category/".$image_name;

                        //Finally upload the image
                        $upload=move_uploaded_file($source_path,$destination_path);
                        //Check whether image is uploaded or not
                        //If image isn't uploaded - stop proccess and redirect with error
                        if($upload==false)
                        {
                            //set session message
                            $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop process
                            die();
                        }

                        //2.remove current image if available
                        if($current_image!="")
                        {
                            $remove_path="../img/category/".$current_image;
                            $remove=unlink($remove_path);
                            //check whether image is removed or not
                            //if failed to remove - display message and stop process
                            if($remove==false)
                            {
                                //failed to remove
                                $_SESSION['failed-remove']="<div class='error'>Failed to remove current image</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();//stop process
                            }
                        }
                        
                    }
                    else
                    {
                        //image unavailable - set current image name
                        $image_name=$current_image;
                    }
                }
                else
                {
                    $image_name=$current_image;
                }


                //update data in db
                $sql2="UPDATE tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";
                //execute query
                $res2=mysqli_query($conn,$sql2);
                //Redirect to manage category page with message
                //check whether query is executed or not
                if($res2==true)
                {   
                    //category updated
                    $_SESSION['update']="<div class='success'>Category updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update']="<div class='error'>Failed to update category</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    
                }

                
            }
        ?>
        
    </div>
</div>

<?php include('partials/footer.php');?>