<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br><br>

        <!-- Add category form -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" placeholder="category title">
                    </td>
                </tr>

                <tr>
                    <td>Select image</td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add category form -->

        <?php 
        
            //check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
               //get the values from form
               $title=mysqli_real_escape_string($conn,$_POST['title']);

               //check is radio selected or not
               if(isset($_POST['featured']))
               {
                    //get value from form
                    $featured=$_POST['featured'];
               }
               else
               {
                    //set default value
                    $featured="No"; 
               }
               if(isset($_POST['active']))
               {
                    //get value from form
                    $active=$_POST['active'];
               }
               else
               {
                    //set default value
                    $active="No"; 
               }


               //check whether image is selected or not and set the value for image name
               if(isset($_FILES['image']['name']))
               {
                    //upload image
                    //to upload image we need image name,source path and destination path
                    $image_name=$_FILES['image']['name'];
                    if($image_name!="")
                    {

                        //upload image if it's selected
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
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop process
                            die();
                        }
                    }
               }
               else
               {
                    //dont upload image and set image name value as blank(empty)
                    $image_name="";
               }

               //sql query
               $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
               ";
               //execute query
               $res=mysqli_query($conn,$sql);
               //check whether query is executed or not
               if($res==true)
               {
                    //query executed,category added
                    $_SESSION['add']="<div class='success'>Category added successfully</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');

               }
               else
               {
                    //Failed to add category
                    $_SESSION['add']="<div class='error'>Failed to add category</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
               }
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php');?>