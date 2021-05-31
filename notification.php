<?php
    require_once 'assets/php/header.php';
?>
    <div class="container">
        <div class="row justify-content-center my-2">
            <div class="col-lg-6 mt-4" id="showAllNotification">
                
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script>
        $(document).ready(function(){
            // fetch users Notification
            function fetchNotifications(){
                $.ajax({
                    url:'assets/php/process.php',
                    method:'post',
                    data:{action:'fetch_notification'},
                    success:(res)=>{
                        $('#showAllNotification').html(res)
                    }
                })
            }
            fetchNotifications()
            checkNotification()

            // Check notification
            function checkNotification(){
                $.ajax({
                    url:'assets/php/process.php',
                    type:'post',
                    data:{action:'check_notification'},
                    success:(res)=>{
                        $('#checkNotification').html(res)
                    }
                })
            }

            // remove Notification
            $("body").on('click','.close',function(e){
                e.preventDefault()
                const notification_id = $(this).attr('id');
                $.ajax({
                    url:'assets/php/process.php',
                    type:'post',
                    data:{NotificationID:notification_id},
                    success:(res)=>{
                        fetchNotifications()
                        checkNotification()
                    }
                })
            })
        })
    </script>
</body>
</html>