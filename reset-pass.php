<?php
    require_once 'assets/php/Auth.php';
    $user = new Auth();
    $msg = '';

    if(isset($_GET['email']) && isset($_GET['token'])){
        $email = $user->testInput($_GET['email']);
        $token = $user->testInput($_GET['token']);
        $auth_user = $user->resetPassword($email,$token);
        if($auth_user != null){
            if(isset($_POST['submit'])){
                $newPass = $_POST['password'];
                $CPass = $_POST['password2'];

                if($newPass == $CPass){
                    $hashPwd = password_hash($newPass,PASSWORD_DEFAULT);
                    $user->updatePassword($hashPwd,$email);
                    $msg= 'Password changed successfully<br><a href="index.php">Login Here</a>';
                }else{
                    $msg="Passwords do not match!";
                }
            }
        }else{
            header('location:index.php');
            exit();
        }
    }else{
        header('location:index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container"><div class="container">
        <!-- Login Form Start -->
        <div class="row justify-content-center wrapper">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card rounded-left justify-content-center myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Reset Your Password!</h1>
                        
                    </div>
                    <div class="card rounded-right p-4" style="flex-grow:2;">
                        <h1 class="text-center font-weight-bold text-primary">Create New Password</h1>
                        <hr class="my-3">
                        <form action="" method="POST" class="px-3">
                           <div class="text-center lead mb-2"><?= $msg; ?></div>

                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="fas fa-key fa-lg"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" 
                                     class="form-control rounded-0"
                                     placeholder="Enter New Password" required>
                            </div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="fas fa-key fa-lg"></i>
                                    </span>
                                </div>
                                <input type="password" name="password2" 
                                    class="form-control rounded-0"
                                     placeholder="Confirm New Password" required>
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" value="Reset Password" 
                                    name="submit" class="btn btn-primary btn-block btn-lg myBtn"
                                >
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</body>
</html>