<?php
    //inactive time 10 minutes
    $inactive=600;
    ini_set('session.gc_maxlifetime', $inactive);
    session_start();
    if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $inactive)) {
        // last request was more than 5 minutes ago
        session_unset();     // unset $_SESSION variable for this page
        session_destroy();   // destroy session data
    }
    $_SESSION['testing'] = time(); // Update session

    //Constants
    define('SITEURL','http://localhost/restaurant/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','restaurant');


    $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());//db connection
    $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());//select db
?>