
<?php include('partials-front/menu.php'); ?>

    <!--food search-->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="search smth">
                <input type="submit" name="submit" value="search" class="btn btn-primary">
            </form>


        </div>
    </section>
    <!--food search-->



    <!--menu-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //display all foods that are active
                $sql="SELECT * FROM tbl_food WHERE active='Yes'";
                //execute query
                $res=mysqli_query($conn,$sql);
                //count rows
                $count=mysqli_num_rows($res);
                if($count>0)
                {
                    //Foods available
                    while($row=mysqli_fetch_assoc($res))
                    {
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
                                        <img src="<?php echo SITEURL; ?>/img/food/<?php echo $image_name; ?>" alt="Borsh" class="img-responsive img-curve img-menu">
                                        <?php
                                    }
                                ?>
                                
                            </div>
                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?>rub</p>
                                <p class="food-detail">
                                    <?php echo $description;?>
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
                    //Foods not available
                    echo "<div class='error'>Food not found</div>";
                }
            ?>

            

            

            <div class="clearfix"></div>
        </div> 
    </section>
    <!--menu-->

<?php include('partials-front/footer.php');?>