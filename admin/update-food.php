<?php include('partials/menu.php'); ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all details
        $id=$_GET['id'];
        //sql query
        $sql2="SELECT * FROM tbl_food WHERE id=$id";
        //execute query
        $res2=mysqli_query($conn,$sql2);
        //get values
        $row2=mysqli_fetch_assoc($res2);
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];
        


    }
    else
    {
        //redirect to manage food page 
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>


        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>

            </tr>
            <tr>
                <td>Description</td>
                <td>
                    <textarea name="description"  cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image</td>
                <td>
                    <?php
                        if($current_image=="")
                        {
                            //Image not available
                            echo "<div class='error'>Image not available</div>";
                        }
                        else
                        {
                            //Image available 
                            ?>
                            <img src="<?php echo SITEURL;?>/img/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Select new image</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category">

                        <?php
                            //sql query
                            $sql="SELECT * FROM tbl_category WHERE active='Yes' ";
                            //execute query
                            $res=mysqli_query($conn,$sql);
                            //count rows
                            $count=mysqli_num_rows($res);

                            //check whether category available or not
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title=$row['title'];
                                    $category=$row['id'];
                                    ?>
                                    <option <?php if($current_category==$category){ echo "selected"; } ?> value="<?php echo $category; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category not available
                                echo "<option value='0'>Category not available</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>
            <tr>
                <td>Active</td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?>  type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //get all values from form
                $id=$_POST['id'];
                $title=mysqli_real_escape_string($conn,$_POST['title']);
                $description=mysqli_real_escape_string($conn,$_POST['description']);
                $price=mysqli_real_escape_string($conn,$_POST['price']);
                $current_image=$_POST['current_image'];
                $category=$_POST['category'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //upload image if selected
                //check whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //clicked
                    $image_name=$_FILES['image']['name'];

                    //check whether file available or not
                    if($image_name!="")
                    {
                        //Image available
                        //rename image
                        $ext=end(explode('.',$image_name));
                        $image_name="Food-Name".rand(0000,9999).'.'.$ext;
                        //get source and destination path
                        $src_path=$_FILES['image']['tmp_name'];
                        $dest_path="../img/food/".$image_name;
                        //upload
                        $upload=move_uploaded_file($src_path,$dest_path);
                        //check whether image uploaded or not
                        if($upload==false)
                        {
                            //failed to upload
                            $_SESSION['upload']="<div class='error'>Failed to upload new image</div>";
                            //redirect to manage food page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }
                        //remove current image if it's available
                        if($current_image!="")
                        {
                            //curremt image available
                            $remove_path="../img/food/".$current_image;
                            $remove=unlink($remove_path);
                            //check whether image is removed or not
                            if($remove==false)
                            {
                                //failed to remove
                                $_SESSION['remove-failed']="<div class='error'>Failed to remove image</div>";
                                //redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name=$current_image;//Set default image if new image not selected
                    }
                }
                else
                {
                    //not clicked
                    $image_name=$current_image;//Set default image if buttno isn't clicked
                }
                
                //update data in db

                $sql3="UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";
                //execute query
                $res3=mysqli_query($conn,$sql3);
                //check whether query is executed or not
                //redirect to manage food page with message
                if($res3==true)
                {
                    //query executed
                    $_SESSION['update']="<div class='success'>Food updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update']="<div class='error'>Failed to update food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                

            }

        ?>

    </div>
</div>


<?php include('partials/footer.php');?>