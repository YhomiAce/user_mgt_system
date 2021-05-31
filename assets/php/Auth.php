<?php
    require_once "config.php";

    class Auth extends Database{
        // Register New User 
        public function register($name,$email,$password)
        {
            $sql = "INSERT INTO users(name,email,password) VALUES(:name,:email,:password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['name'=>$name,'email'=>$email,'password'=>$password]);
            return true;
        }

        // check if email exist
        public function userExist($email)
        {
            $sql = "SELECT email FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        // login existing user
        public function login($email)
        {
            $sql = "SELECT email, password FROM users WHERE email = :email AND deleted !=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }

        // retreiving current users detatil
        public function currentUser($email)
        {
            $sql = "SELECT * FROM users WHERE email = :email AND deleted !=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }

        // forgot password
        public function forgot_password($token,$email)
        {
            $sql='UPDATE users SET token = :token, token_expire = DATE_ADD(NOW(),INTERVAL 10 MINUTE) WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['token'=>$token,'email'=>$email]);
            return true;
        }

        //reset password
        public function resetPassword($email,$token)
        {
            $sql = "SELECT id FROM users WHERE email =:email AND token =:token AND token !='' AND token_expire > NOW() AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email,'token'=>$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }

        // Update Password
        public function updatePassword($pass,$email)
        {
            $sql = 'UPDATE users SET token="", password=:pass WHERE email=:email AND deleted !=0';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['pass'=>$pass,'email'=>$email]);
            return true;
        
        }

        // add new Note
        public function addNewNote($uid,$title,$note)
        {
            $sql= "INSERT INTO notes (uid,title,note) VALUES(:uid,:title,:note)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid,'title'=>$title,'note'=>$note]);
            return true;
        }

        // fetch all users Notes
        public function fetchUsersNote($uid)
        {
            $sql = "SELECT * FROM notes WHERE uid =:uid";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        // edit Note
        public function editNote($id)
        {
            $sql = "SELECT * FROM notes WHERE id =:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        // Update Note
        public function updateNote($id,$title,$note)
        {
            $sql = "UPDATE notes SET title =:title, note=:note, updated_at= NOW() WHERE id =:id ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['title'=>$title,'note'=>$note,'id'=>$id]);
            return true;
        }

        // delete Note
        public function deleteNote($id)
        {
            $sql = "DELETE FROM notes WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            return true;
        }

        // Update profile of a user
        public function updateProfile($name,$gender,$dob,$phone,$photo,$id)
        {
            $sql = "UPDATE users SET name =:name,gender=:gender,dob=:dob,phone=:phone,photo=:photo WHERE id=:id AND deleted !=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['name'=>$name,'gender'=>$gender,'dob'=>$dob,'phone'=>$phone,'photo'=>$photo,'id'=>$id]);
            return true;
        }

        // Change Password of a User
        public function changePassword($pass,$id)
        {
            $sql = "UPDATE users SET password =:pass WHERE id=:id AND deleted !=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['pass'=>$pass,'id'=>$id]);
            return true;
        }

        // Verify User
        public function verifyUser($email)
        {
            $sql = "UPDATE users SET verified = 1 WHERE email= :email AND deleted !=0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            return true;
        }

        // Send Feedback to Admin
        public function sendFeedback($subject,$feedback,$uid)
        {
            $sql = "INSERT INTO feedback(uid,subject,feedback) VALUES(?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$uid,$subject,$feedback]);
            return true;
        }

        // Insert Notification
        public function saveNotification($uid,$type,$message)
        {
            $sql = "INSERT INTO notifications(uid,type,message) VALUES(?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$uid,$type,$message]);
            return true;
        }

        // Fetch Notification
        public function fetchNotification($uid)
        {
            $sql = "SELECT * FROM notifications WHERE uid=:uid AND type='user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        // Remove Notification
        public function removeNotification($id)
        {
            $sql = "DELETE FROM notifications WHERE id=:id AND type='user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            return true;
        }

        public function timeInAgo($timeAgo)
        {
            date_default_timezone_set("Africa/Lagos");
            // convert time to seconds
            $timeAgo = strtotime($timeAgo) ? strtotime($timeAgo) : $timeAgo;
            // subtract time from current time
            $time = time() - $timeAgo;
            switch($time){
                // Seconds time
                case $time <= 60:
                    return 'Just Now';
                // Minutes
                case $time >= 60 && $time <=3600:
                    return (round($time/60) == 1)? 'a minute ago': round($time/60).' minutes ago';
                
                // Hours
                case $time >= 3600 && $time <=86400:
                    return (round($time/3600) == 1)? 'an hour ago': round($time/3600).' hours ago';
                // Days
                case $time >= 86400 && $time <=604800:
                    return (round($time/86400) == 1)? 'a day ago': round($time/86400).' days ago';
                
                // Weeks
                case $time >= 604800 && $time <=2600640:
                    return (round($time/604800) == 1)? 'a week ago': round($time/604800).' weeks ago';
                
                // Months
                case $time >= 2600640 && $time <=31207680:
                    return (round($time/2600640) == 1)? 'a month ago': round($time/2600640).' months ago';
                
                // Years
                case $time >= 31207680:
                    return (round($time/31207680) == 1)? 'a year ago': round($time/31207680).' years ago';
                
            }
        }

    }
?>