<?php
    session_start();
    require_once "Auth.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $user = new Auth();

    // handle register
    if(isset($_POST['action']) && $_POST['action'] === 'register'){
        $name = $user->testInput($_POST['name']);
        $email = $user->testInput($_POST['email']);
        $password = $user->testInput($_POST['password']);

        // Hash password
        $hashPwd = password_hash($password,PASSWORD_DEFAULT);

        // check if email is already registered
        if($user->userExist($email)){
            echo $user->displayMessage('warning',"This E-mail is already registered!");
        }else{
            if($user->register($name,$email,$hashPwd)){
                echo "Registered";
                $_SESSION['user'] = $email;
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                // $mail->SMTPDebug  = 2;
                $mail->Username   = "a4d387291a1e74";                    
                $mail->Password   = "db0843923090c1";                              
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                $mail->Port       = 587;

                $mail->setFrom("XpressManiac@mail.com",'Xpress Website');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = '<h3>Click the link below to Verify your E-mail. <br>
                    <a href="http://localhost/User_System/verify-email.php?email='.$email.'">Click here to verify your E-mail</a>
                    <br>Regards<br>Xpress Website</h3>';
                $mail->send();
            }else{
                echo $user->displayMessage('warning',"Server Error");
            }
        }
    }

    // handle login
    if(isset($_POST['action']) && $_POST['action'] === 'login'){
        // print_r($_POST);
        $email = $user->testInput($_POST['email']);
        $pass = $user->testInput($_POST['password']);

        $loggedInUser = $user->login($email);
        if($loggedInUser != null){
            if(password_verify($pass,$loggedInUser['password'])){
                if(!empty($_POST['rem'])){
                    setcookie('email',$email,time()+(30*24*60*60),'/');
                    setcookie('password',$pass,time()+(30*24*60*60),'/');
                }else{
                    setcookie('email','',1,'/');
                    setcookie('password','',1,'/');
                }
                echo 'login';
                $_SESSION['user'] = $email;
            }else{
                echo $user->displayMessage('danger','Password is incorrect');
            }
        }else{
            echo $user->displayMessage('danger','User not found!');
        }
    }

    // forgot password
    if(isset($_POST['action']) && $_POST['action'] === 'forgot'){
        $email = $user->testInput($_POST['email']);
        $userFound = $user->currentUser($email);
        if($userFound != null){
            $token =uniqid();
            $token = str_shuffle($token);
            $user->forgot_password($token,$email);
            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username   = Database::USERNAME;                    
                $mail->Password   = Database::PASSWORD;                              
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                $mail->Port       = 587;

                $mail->setFrom(Database::USERNAME,'Xpress Website');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body = '<h3>Click the link below to reset your password. <br>
                    <a href="http://localhost/User_System/reset-pass.php?email='.$email.'&token='.$token.'">Click here to Reset Password</a>
                    <br>Regards<br>Xpress Website</h3>';
                $mail->send();
                echo $user->displayMessage('success','A resest link has been sent to your email!');

            }catch(Exception $e){
                echo $user->displayMessage('danger','Oops something went wrong! please try again');
            }
        }else{
            echo $user->displayMessage('warning','This Email is not registered!');
        }
    }