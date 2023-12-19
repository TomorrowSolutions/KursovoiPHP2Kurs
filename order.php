
<?php include('partials-front/menu.php'); ?>

    <?php
        //check whether food_id is set or not
        if(isset($_GET['food_id']))
        {
            //id is set
            $food_id=$_GET['food_id'];
            //get details
            $sql="SELECT * FROM tbl_food WHERE id=$food_id";
            //execute query
            $res=mysqli_query($conn,$sql);
            //count rows
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                //data available
                $row=mysqli_fetch_assoc($res);
                $title=$row['title'];
                $price=$row['price'];
                $image_name=$row['image_name'];
            }
            else
            {
                //data unavailable
                //redirect to home page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //id isn't set 
            //redirect to home page
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center ">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset class="fld-grey">
                    <legend class="legend">Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                            //check whether image available or not
                            if($image_name=="")
                            {
                                //image not available
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="borsh" class="img-responsive img-curve img-menu">
                                <?php
                            }

                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">

                        <p class="food-price"><?php echo $price; ?></p>  
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset class="fld-grey">
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Full Name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="89xxxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="smth@smth.smth" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="City,street,home" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            
            <?php
                //check whether submit is clicked or not
                if(isset($_POST['submit']))
                {
                    echo "clicked";
                    $food=$_POST['food'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty'];
                    $total=$price*$qty;
                    $order_date=date("Y-m-d h:i:sa");
                    $status="Ordered";//4 states: ordered,on delivery,delivered,cancelled
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $customer_address=$_POST['address'];

                    //save order ind db
                    //sql auery
                    $sql2="INSERT INTO tbl_order SET
                        food='$food',
                        price=$price,
                        qty=$qty,
                        total=$total,
                        order_date='$order_date',
                        status='$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                    ";
                    //execute query
                    $res2=mysqli_query($conn,$sql2);
                    //check whether query is executed successfuly or not
                    if($res2==true)
                    {
                        //success
                        $_SESSION['order']="<div class='success text-center'>Food ordered successfully</div>";
                        header('location:'.SITEURL);

                    }
                    else
                    {
                        //error
                        $_SESSION['order']="<div class='error text-center'>Failed to order food</div>";
                        header('location:'.SITEURL);
                    }


                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php');?>