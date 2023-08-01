<?php require('database.php'); 
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
header('location:index.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Register Form</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="validation.js"></script>
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
   
<div class="container mt-5">
    <!-- Status message -->
    <div class="statusMsg"></div>
    <div id="message"></div>
    <div class="panel-heading">Register page</div>
        <div class="panel-body">
            <form method="POST" id="registrationForm">

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" autocomplete=off required name="name" id="name" placeholder="Enter Name"/>
                    <span class="error" id="username_err"> </span>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" autocomplete=off required name="email" id="email" placeholder="Enter Email"/>
                    <span class="error" id="email_err"> </span>
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control"  required name="password" id="password" placeholder="Enter Password"/>
                    <span class="error" id="password_err"> </span>
                </div>


                <div class="form-group">
                    <label></label>
                    <input type="submit" class="btn btn-primary submitBtn" name="register" value="Register"/>
                </div>
            </form>
        </div>
</div>

<!-- Form Submission-->
<script>
  $(document).ready(function() {

    $('#name').on('input', function () {
        checkuser();
    });
    $('#email').on('input', function () {
        checkemail();
    });
    $('#password').on('input', function () {
        checkpass();
    });

    $('#registrationForm').submit(function(e) {
      e.preventDefault();
      if (!checkuser() && !checkemail() && !checkpass()) {
            $("#message").html(`<div class="alert alert-warning">Please fill all required field</div>`);
        } else if (!checkuser() || !checkemail() || !checkpass()) {
            $("#message").html(`<div class="alert alert-warning">Please fill all required field</div>`);
        }
        else 
        {
            $("#message").html("");
            var form = $('#registrationForm')[0];
            var data = new FormData(form);

            $.ajax({
            type: 'POST',
            url: 'db_register.php',
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#registrationForm').css("opacity",".5");
            },
            success: function(response)
            {
                $('.statusMsg').html('');
                if(response.status == 1){
                    $('#registrationForm')[0].reset();
                    $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                }else{
                    $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                }
                $('#registrationForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
            });
        }
    });
  });
</script>
<style>
    .error {color:red;}
</style>
</body>

</html>