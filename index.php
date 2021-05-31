<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('location:home.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Login Form Start -->
        <div class="row justify-content-center wrapper" id="login-box">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card rounded-left p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Sign in to Account</h1>
                        <hr class="my-3">
                        <form action="" method="POST" id="login-form" class="px-3">
                            <div id="loginAlert"></div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="far fa-envelope fa-lg"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" 
                                    id="email" class="form-control rounded-0" 
                                    placeholder="Enter E-mail" required
                                    value="<?php if(isset($_COOKIE['email'])){echo $_COOKIE['email']; }?>"
                                >
                            </div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="fas fa-key fa-lg"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" 
                                    id="password" class="form-control rounded-0"
                                     placeholder="Enter Password" required
                                     value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password']; }?>"
                                >
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox float-left">
                                    <input type="checkbox" name="rem" id="customCheck"
                                     class="custom-control-input" <?php if(isset($_COOKIE['email'])){ ?> checked <?php } ?> >
                                    <label for="customCheck" class="custom-control-label">Remember Me</label>
                                </div>
                                <div class="forgot float-right">
                                    <a href="#" id="forgot-link">Forgot Password</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Sign in" 
                                    id="login-btn" class="btn btn-primary btn-block btn-lg myBtn"
                                >
                            </div>
                        </form>
                    </div>
                    <div class="card rounded-right justify-content-center myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Hello Friends!</h1>
                        <hr class="my-3 bg-light myHr">
                        <p class="text-center text-light font-weight-bolder lead">
                            Enter Your Personal Details and start your journey with us!
                        </p>
                        <buttton class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" 
                            id="register-link">Sign up
                        </buttton>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Form End -->
        <!-- Register form start -->

        <div class="row justify-content-center wrapper" id="register-box" style="display:none;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card rounded-left justify-content-center myColor p-4">
                            <h1 class="text-center font-weight-bold text-white">Welcome Back!</h1>
                            <hr class="my-3 bg-light myHr">
                            <p class="text-center text-light font-weight-bolder lead">
                                To keep connected with us please login with your details!
                            </p>
                            <buttton class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="login-link">Sign in</buttton>
                    </div>
                    <div class="card rounded-right p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Create Account</h1>
                        <hr class="my-3">
                        <form action="" method="POST" id="register-form" class="px-3">
                            <div id="regAlert"></div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="far fa-user fa-lg"></i>
                                    </span>
                                </div>
                                <input type="text" name="name" 
                                    id="name" class="form-control rounded-0" 
                                    placeholder="Enter Full name" required
                                >
                            </div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="far fa-envelope fa-lg"></i>
                                    </span>
                                </div>
                                <input type="email" name="email"
                                     id="r-email" class="form-control rounded-0"
                                      placeholder="Enter E-mail" required
                                >
                            </div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="fas fa-key fa-lg"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" 
                                    id="r-password" class="form-control rounded-0" 
                                    placeholder="Enter Password" required minlength="5"
                                >
                            </div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="fas fa-key fa-lg"></i>
                                    </span>
                                </div>
                                <input type="password" name="cpassword" 
                                    id="cpassword" class="form-control rounded-0" 
                                    placeholder="Confirm Password" required minlength="5"
                                >
                                
                            </div>
                            <div class="form-group">
                                <span id="passMsg" class="font-weight-bold text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Sign up" 
                                    id="register-btn" class="btn btn-primary btn-block btn-lg myBtn"
                                >
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Register form end -->
        <!-- Forgot Password form start-->
        <div class="row justify-content-center wrapper" id="forgot-box" style="display:none;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card rounded-left justify-content-center myColor p-4">
                            <h1 class="text-center font-weight-bold text-white">Forgot Password!</h1>
                            <hr class="my-3 bg-light myHr">
                            
                            <buttton class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" 
                                id="back-link">Back
                            </buttton>
                    </div>
                    <div class="card rounded-right p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Reset Your Password</h1>
                        <hr class="my-3">
                        <p class="lead text-center text-secondary">
                            To reset your password entered your registered email and we will send you a reset link
                        </p>
                        <form action="" method="POST" id="forgot-form" class="px-3">
                            <div id="forgotAlert"></div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">   
                                        <i class="far fa-envelope fa-lg"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" 
                                    id="f-email" class="form-control rounded-0" 
                                    placeholder="Enter E-mail" required
                                >
                            </div>                           
    
                            <div class="form-group">
                                <input type="submit" value="Reset Password" 
                                    id="forgot-btn" class="btn btn-primary btn-block btn-lg myBtn"
                                >
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Forgot PAssword End -->
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script src="assets/js/script.js"></script>  
</body>
</html>