
<?php include('partials-front/menu.php'); ?>

    <!--food search-->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL;?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="search smth">
                <input type="submit" name="submit" value="search" class="btn btn-primary">
            </form>


        </div>
    </section>
    <!--food search-->
    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>
    <!--categories-->
    <section class="categories">
        <div class="container">
            
            <h2 class="text-center">Categories</h2>

            <?php 
                //display all categories that are active and featured
                //sql query
                $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //execute query
                $res=mysqli_query($conn,$sql);
                //count rows
                $count=mysqli_num_rows($res);

                if($count>0)
                {
                    //categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get values from db
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //check whether image is available or not
                                    if($image_name=="")
                                    {
                                        //display message
                                        echo "<div class='error'>Image not available</div>";
                                    }
                                    else
                                    {
                                        //image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name;?>" alt="Food" class="img-responsive img-curve img-cat">
                                        <?php
                                    }
                                ?>
                                
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //categories not available
                    echo "<div class='error'>Category not added</div>";
                }
            ?>

            
            <div class="clearfix"></div>
        </div>
        
    </section>
    <!--categories-->
    <!--menu-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php
                
                //getting food from db which active and featured
                //sql query
                $sql2="SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                //execute query
                $res2=mysqli_query($conn,$sql2);
                //count rows
                $count2=mysqli_num_rows($res2);
                //check whether food available or not
                if($count2>0)
                {
                    //food available
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //get values
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name=$row['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                
                                    //check whether image is available or not
                                    if($image_name=="")
                                    {
                                        //image not available
                                        echo "<div class='error'>Image not available</div>";
                                    }
                                    else
                                    {
                                        //image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>/img/food/<?php echo $image_name; ?>" alt="Food" class="img-responsive img-curve img-menu">
                                        <?php
                                    }

                                ?>
                                
                            </div>
                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price;?>rub</p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>
                                <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                            <!-- <div class="clearfix"></div> -->
                        </div>

                        <?php
                    }
                }
                else
                {
                    //food not available
                    echo "<div class='error'>Food not available</div>";
                }




            ?>


            <div class="clearfix"></div>
        </div>    
    </section>
    <!--menu-->
<?php include('partials-front/footer.php');?>