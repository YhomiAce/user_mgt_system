<?php
    session_start();
    require_once 'Auth.php';
    $current_user = new Auth();

    if(!isset($_SESSION['user'])){
        header('location:index.php');
        die;
    }

    $currentEmail = $_SESSION['user'];

    $data = $current_user->currentUser($currentEmail);
    $cid = $data['id'];
    $cname = $data['name'];
    $cpass = $data['password'];
    $cphone = $data['phone'];
    $cgender = $data['gender'];
    $cdob = $data['dob'];
    $cphoto = $data['photo'];
    $created_at = $data['created_at'];
    $date = date('d M Y',strtotime($created_at));
    $verified = $data['verified'];
    $fname = strtok($cname,' ');
    if($verified == 0){
        $verified = "Not Verified";
    }else{
        $verified = "Verified";
    }
?>