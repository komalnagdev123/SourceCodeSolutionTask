<?php
    require('database.php');
    session_start();
    //Login Process
    $data = $_POST;

    // Prevent SQL injection using prepared statements
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
         // Validate and sanitize user input
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);

        $user_exist_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con,$user_exist_query);

        if($result)
        {
            if(mysqli_num_rows($result) == 1)
            {
                $result_fetch = mysqli_fetch_assoc($result);

                if($result_fetch['is_verified'] == 1)
                {
                    if (password_verify($password, $result_fetch['password']))
                    {
                        //if password matched
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $result_fetch['name'];
                        $response['status'] = 1; 
                        $response['message'] = "User Logged In successfully.";
                    }
                    else
                    {
                        //password not matched
                        $response['status'] = 0; 
                        $response['message'] = "Please enter correct password.";
                    }
                }
                else
                {
                    $response['status'] = 0; 
                    $response['message'] = "Please Verify your email first to login.";
                }
                
            }
            else
            {
                $response['status'] = 0; 
                $response['message'] = "No User Found.";
            }
        }
        else
        {
            $response['status'] = 0; 
            $response['message'] = "Can Not Query!";
        }
    }
        

    // Return response 
    echo json_encode($response);
    

?>