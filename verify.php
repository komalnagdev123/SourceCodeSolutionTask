<?php
require('database.php');

if(isset($_GET['email']) && isset($_GET['v_code']))
{
    $email = base64_decode($_GET['email']);
    $v_code = base64_decode($_GET['v_code']);
    $query = "SELECT * FROM users WHERE email = '$email' AND verification_code = '$v_code'";
    $result = mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result) == 1)
            {
                $result_fetch = mysqli_fetch_assoc($result);
                if($result_fetch['is_verified'] == 0)
                {
                    $update = "UPDATE users SET is_verified = 1 WHERE email = '$email'"; 
                    if(mysqli_query($con,$update))
                    {
                        echo "
                        <script>
                        alert('Email verification successful');
                        window.location.href = 'index.php';
                        </script>
                        ";
                    }
                    else{
                        echo "
                        <script>
                        alert('can not verify user');
                        window.location.href = 'index.php';
                        </script>
                        ";
                    }
                }
                else
                {
                    echo "
                        <script>
                        alert('email already verified');
                        window.location.href = 'index.php';
                        </script>
                        ";
                }
            }
    }
    else
    {
        echo "
        <script>
        alert('Server Down');
        window.location.href = 'index.php';
        </script>
        ";
    }
}
?>