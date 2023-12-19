<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        
            <table class="tbl-30">

            <tr>
                <td>Title</td>
                <td>
                    <input type="text" name="title" placeholder="title for food">
                </td>
            </tr>
            
            <tr>
                <td>Description</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="description for food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price</td>
                <td>
                    <input type="number" name="price" >
                </td>
            </tr>

            <tr>
                <td>Select Image</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>

            <tr>
                <td>Category</td>
                <td>
                    <select name="category">

                        <?php
                            //display categories from db
                            //sql query
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute query
                            $res=mysqli_query($conn,$sql);
                            //count rows to check whether we have categories or not
                            $count=mysqli_num_rows($res);

                            // if rows>0 - we have categories, else we dont have
                            if($count>0)
                            {
                                //we have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get details of categories
                                    $id=$row['id'];
                                    $title=$row['title'];

                                    ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php
                                    

                                }
                            }
                            else
                            {
                                //we dont have catefories
                                ?>
                                <option value="0">No category found</option>
                                <?php
                            }

                            //display in dropdown
                        ?>

                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured</td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
                </tr>
            <tr>
                <td>Active</td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr>    

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>


            </table>

        </form>

        <?php
            //check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //geting data from form
                $title=mysqli_real_escape_string($conn,$_POST['title']);
                $description=mysqli_real_escape_string($conn,$_POST['description']);
                $price=mysqli_real_escape_string($conn,$_POST['price']);
                $category=mysqli_real_escape_string($conn,$_POST['category']);

                //check whether radio buttons is checked or not
                if(isset($_POST['featured']))
                {
                    $featured=$_POST['featured'];
                }
                else
                {
                    $featured="No";//setting default value
                }
                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else
                {
                    $active="No";//setting default value
                }


                //upload image if it's selected
                //check whether image select button is clicked or not and if image selected we upload it
                if(isset($_FILES['image']['name']))
                {
                    //get details of selected image
                    $image_name=$_FILES['image']['name'];
                    //check whether image selected or not and upload if it's selected
                    if($image_name!="")
                    {
                        //image is selected
                        //1.Rename image
                        //getting extension of image(jpg,png,etc)
                        $ext=end(explode('.',$image_name));
                        //create new name for image
                        $image_name="Food-Name".rand(0000,9999).".".$ext;//example: Food-Name9999.jpg 
                        //2. Upload image
                        //get source and destination paths
                        $src=$_FILES['image']['tmp_name'];
                        $dst="../img/food/".$image_name;
                        //upload image
                        $upload=move_uploaded_file($src,$dst);
                        //check whether image is uploaded or not
                        if($upload==false)
                        {
                            //failed to upload - redirect to manage food page with error message and  stop process
                            $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }

                    }
                }
                else
                {
                    $image_name="";//setting default value
                }

                //insert data in db

                //sql query
                $sql2="INSERT INTO tbl_food SET 
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id=$category,
                    featured='$featured',
                    active='$active'
                ";
                //execute query
                $res2=mysqli_query($conn,$sql2);
                //check whether data is inserted or not

                if($res2==true)
                {
                    //data inserted successfully
                    $_SESSION['add']="<div class='success'>Food added successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add']="<div class='error'>Failed to add food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                //redirect to manage food page with message

            }

        ?>

    </div>
</div>
<?php include('partials/footer.php');?>