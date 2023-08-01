<?php
    require('database.php');

    //use this for sending mail through PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //function to send Mail
    function sendMail($email,$v_code)
    {
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';        

        $email_encode = base64_encode($email);
        $vcode_encode = base64_encode($v_code);
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'komalsfood@gmail.com';                     //SMTP username
            $mail->Password   = 'cmuhxwcbsucpjwds';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('komalsfood@gmail.com', 'Komal Nagdev');
            $mail->addAddress($email);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification code by ABC.COM';
            $mail->Body    = "Thanks for registration!
            click the link to verify the email address. <a href='http://localhost/corephptask/verify.php?email=$email_encode&&v_code=$vcode_encode'>Verify</a>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //Registration Process 
    $data = $_POST;

    // Prevent SQL injection using prepared statements
    function sanitizeInput($data) {
        return htmlspecialchars(trim($data));
    }
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        // Validate and sanitize user input
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

        $user_exist_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con,$user_exist_query);
        
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
                $response['status'] = 0; 
                $response['message'] = "Email Already Exists. Use Different Email.";
            }
            else
            {
                $v_code = bin2hex(random_bytes(16));
                $query = "INSERT INTO `users`(`name`, `email`, `password`, `verification_code`, `is_verified`) 
                        VALUES ('$name','$email','$password','$v_code','0')";
                if(mysqli_query($con,$query) && sendMail($email,$v_code))
                {
                    $response['status'] = 1; 
                    $response['message'] = "Data Inserted Successfully. check your eamil and confirm the mail";
                }
                else
                {
                    $response['status'] = 0; 
                    $response['message'] = "Can Not Query!";
                }
                
            }
        }
        else
        {
            $response['status'] = 0; 
            $response['message'] = "Can not run query."; 
        }
        

        // Return response 
        echo json_encode($response);
    }

?>