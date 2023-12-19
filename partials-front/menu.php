<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest@urant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!--navbar-->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="img/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>               
            </div>
            <div class="menu text-right">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a></li>
                    <li><a href="<?php echo SITEURL; ?>foods.php">Foods</a></li>
                    <li><a href="<?php echo SITEURL; session_destroy();?>/admin">Admin Panel</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>        
    </section>
    <!--navbar-->