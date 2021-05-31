<?php
    require_once 'session.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    // Handle Add New Note Ajax Request
    if(isset($_POST['action']) && $_POST['action'] == 'add_note'){
       $title = $current_user->testInput($_POST['title']);
       $note = $current_user->testInput($_POST['note']);

       $current_user->addNewNote($cid,$title,$note);
       $current_user->saveNotification($cid,'admin','Note Added');
    }

    // handle fetch request
    if(isset($_POST['action']) && $_POST['action'] == 'fetch_notes'){
        $output = '';
        $notes = $current_user->fetchUsersNote($cid);
        if($notes){
            $output .='<table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($notes as $key=>$row){
                $output .='<tr>
                <td>'.($key+1).'</td>
                <td>'.$row['title'].'</td>
                <td>'.substr($row['note'],0,30).'...</td>
                <td>
                    <a href="#" id="'.$row['id'].'" title="View details" class="text-success infoBtn">
                    <i class="fas fa-info-circle fa-lg"></i>&nbsp;
                    </a>
                    <a href="#" id="'.$row['id'].'" title="Edit Note" class="text-primary editBtn">
                    <i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i>&nbsp;
                    </a>
                    <a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteBtn">
                    <i class="fas fa-trash-alt fa-lg"></i>
                    </a>
                </td>
            </tr>';
            }
            $output .='</tbody>
            </table>';
            echo $output;
        }else{
            echo '<h3 class="text-secondary text-center">You have not written any Note. Click on Add New Note to write.!</h3>';
        }
    }

    // handle Edit note of User
    if(isset($_POST['editID'])){
        $id = $_POST['editID'];
        $fetchedNote = $current_user->editNote($id);
        echo json_encode($fetchedNote);
    }

    // Handle update note
    if(isset($_POST['action']) && $_POST['action'] == 'update_note'){
        $id = $current_user->testInput($_POST['id']);
        $title = $current_user->testInput($_POST['title']);
        $note = $current_user->testInput($_POST['note']);
        $current_user->updateNote($id,$title,$note);
        $current_user->saveNotification($cid,'admin','Note Updated');
    }

    // delete note
    if(isset($_POST['deleteID'])){
        $id = $_POST['deleteID'];
        $current_user->deleteNote($id);
        $current_user->saveNotification($cid,'admin','Note Deleted');
    }

    // display note in details
    if(isset($_POST['infoID'])){
        $id =$_POST['infoID'];
        $row = $current_user->editNote($id);
        echo json_encode($row);
    }

    // Handle profile update
    if(isset($_FILES['image']) || isset($_POST['name']) || isset($_POST['gender']) || isset($_POST['dob']) || isset($_POST['phone'])){
       $name = $current_user->testInput($_POST['name']);
       $gender = $current_user->testInput($_POST['gender']);
       $dob = $current_user->testInput($_POST['dob']);
       $phone = $current_user->testInput($_POST['phone']);
       $oldImage = $_POST['oldImage'];
       $folder ='uploads/';

       if(isset($_FILES['image']['name']) && ($_FILES['image']['name']) != ''){
           $newImage = $folder.$_FILES['image']['name'];
           move_uploaded_file($_FILES['image']['tmp_name'],$newImage);
           if($oldImage != null){
               unlink($oldImage);
           }
       }else{
           $newImage = $oldImage;
           
       }
       $current_user->updateProfile($name,$gender,$dob,$phone,$newImage,$cid);
       $current_user->saveNotification($cid,'admin','Profile Updated');
    }

    // Handle Change Password
    if(isset($_POST['action']) && $_POST['action'] == 'change_password'){
        $currPass = $_POST['curpass'];
        $newpass = $_POST['newpass'];
        $cnewpass = $_POST['cnewpass'];
        $hashPwd = password_hash($newpass,PASSWORD_DEFAULT);
        if($newpass != $cnewpass){
            echo $current_user->displayMessage('danger','Passwords Do not match');
        }else{
            if(password_verify($currPass,$cpass)){
                $current_user->changePassword($hashPwd,$cid);
                $current_user->saveNotification($cid,'admin','Password Changed');
                echo $current_user->displayMessage('success','Password Change Successfully');
            }else{
                echo $current_user->displayMessage('danger','Current Password is Incorrect');
            }
        }
    }

    // Handle Verify Email Request
    if(isset($_POST['action']) && $_POST['action'] == 'Verify_Email'){
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            // $mail->SMTPDebug  = 2;
            $mail->Username   = "a4d387291a1e74";                    
            $mail->Password   = "db0843923090c1";                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->Port       = 587;

            $mail->setFrom("XpressManiac@mail.com",'Xpress Website');
            $mail->addAddress($currentEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = '<h3>Click the link below to Verify your E-mail. <br>
                <a href="http://localhost/User_System/verify-email.php?email='.$currentEmail.'">Click here to verify your E-mail</a>
                <br>Regards<br>Xpress Website</h3>';
            $mail->send();
            echo $current_user->displayMessage('success','Verification Email Sent to your mail box');

        }catch(Exception $e){
            echo $current_user->displayMessage('danger','Oops something went wrong! please try again');
        }
    }

    // Handle Feedback Request
    if(isset($_POST['action']) && $_POST['action'] == 'feedback'){
        $subject = $current_user->testInput($_POST['subject']);
        $feedback = $current_user->testInput($_POST['feedback']);
        $current_user->sendFeedback($subject,$feedback,$cid);
        $current_user->saveNotification($cid,'admin','Feedback Written');
    }


    // Handle Fetch Noticifation Request
    if(isset($_POST['action']) && $_POST['action'] == 'fetch_notification'){
        $notification = $current_user->fetchNotification($cid);
        $output = '';
        if($notification){
            foreach($notification as $row){
                $output .= '<div class="alert alert-info alert-dismissible mt-2 m-0" role="alert">
                <button type="button" id='.$row['id'].' class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">New Notification</h4>
                <p class="mb-0 lead">'.$row['message'].'</p>
                <hr class="my-2">
                <p class="mb-0 float-left">Reply of feedback from Admin</p>
                <p class="mb-0 float-right">'.$current_user->timeInAgo($row['created_at']).'</p>
                <div class="clearfix"></div>
                </div>';
            }
            echo $output;
        }else{
            echo '<h3 class="text-center text-secondary mt-5">No New Notification</h3>';
        }
    }


    // Check Notification
    if(isset($_POST['action']) && $_POST['action'] == 'check_notification'){
        if($current_user->fetchNotification($cid)){
            echo '<i class="fas fa-circle fa-sm text-danger"></i>';
        }else{
            echo '';
        }
    }

    // Remove Notification 
    if(isset($_POST['NotificationID'])){
        $id = $_POST['NotificationID'];
        $current_user->removeNotification($id);
    }


?>