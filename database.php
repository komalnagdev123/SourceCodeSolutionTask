<?php

    $con = mysqli_connect("localhost:3307","root","","corephptask");
    if (!$con)
    {
        echo "<script>alert('cannot connect to database');</script>";
        exit();
       // echo "MySQL Error: " . mysqli_connect_error();
    }


?>