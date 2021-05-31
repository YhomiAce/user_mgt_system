<?php
    require_once 'assets/php/header.php';
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mt-3">
                <?php if($verified == "Verified"): ?>
                    <div class="card border-primary">
                        <div class="card-header lead text-center bg-primary text-white">
                            Send Feedback To Admin!
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" class="px-4" id="feedback-form">
                                <div class="form-group">
                                    <input type="text" name="subject" placeholder="Write Your Subject" class="form-control form-control-lg rounded-0" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="feedback" id="" cols="30" rows="10" required class="form-control form-control-lg rounded-0" placeholder="Write Your Feedback here"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="feedbackBtn" id="feedbackBtn" value="Send Feedback" class="btn btn-primary btn-block rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <h1 class="text-center text-secondary mt-5">Verify your E-mail first to send Feedback to Admin</h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function(){
            // Send Feedback to Admin Ajax Request
            $('#feedbackBtn').click(e=>{
                if($('#feedback-form')[0].checkValidity()){
                    e.preventDefault()
                    $('#feedbackBtn').val('Please Wait...')
                    $.ajax({
                        url:'assets/php/process.php',
                        method:'post',
                        data:$('#feedback-form').serialize()+'&action=feedback',
                        success:function(res){
                            console.log(res)
                            $('#feedback-form')[0].reset()
                            $('#feedbackBtn').val('Send Feedback')
                            swal.fire({
                                title:'Feedback Sent Successfully',
                                icon:'success'
                            })
                        }
                    })
                }
            })

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
        })
    </script>
</body>
</html>