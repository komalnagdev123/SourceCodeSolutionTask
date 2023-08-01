
<?php 
require('database.php');
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    
<nav class="navbar navbar-expand-sm bg-light">
<?php 
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
    <ul class="nav navbar-nav navbar-right">
        <li class="nav-item active" style="float: right; width: 100%;">
            <a class="nav-link" href="logout.php"><?php echo $_SESSION['username']; ?> - Logout</a>
        </li>
    </ul>
    <?php } else {?>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
        </li>
    </ul>
    <?php } ?>
</nav>
   
<div class="container p-3 col-md-6">
    <?php 
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        echo "<h1>Welcome User -  $_SESSION[username]</h1>";
        }
        else
        {
            echo "<h4>Please Login or Register to access website</h4>";
        }
    ?>

   
    
</div>

</body>

</html>