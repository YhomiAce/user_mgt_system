<?php
    require_once 'assets/php/header.php';
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-primary mt-3 rounded-0">
                    <div class="card-header border-primary">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Change Password</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Profile Tab Content Start -->
                            <div class="tab-pane container active" id="profile">
                                <div id="verifyEmailAlert"></div>
                                <div class="card-deck">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-light text-center">
                                            User ID: <?= $cid; ?>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>Name: <?= $cname; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>E-Mail: <?= $currentEmail; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>Gender: <?= $cgender; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>Date of Birth: <?= $cdob; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>Phone: <?= $cphone; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>Registered on: <?= $date; ?></b>
                                            </p>
                                            <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;">
                                                <b>E-Mail Verified: <?= $verified; ?></b>
                                                <?php if($verified == "Not Verified") : ?>
                                                    <a href="#" class="float-right" id="verify-email">Verify Now</a>
                                                <?php endif; ?>
                                            </p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="card border-primary align-self-center">
                                        <?php if(!$cphoto): ?>
                                        <img src="assets/images/profile.jpg" class="img-thumbnail img-fluid" width="508px" alt="Profile">
                                        <?php else : ?>
                                        <img src="assets/php/<?=$cphoto; ?>" class="img-thumbnail img-fluid" width="408px" alt="Profile">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Tab Content End -->
                            <!-- Edit Profile Tab Content Start -->
                            <div class="tab-pane container fade" id="editProfile">
                                <div class="card-deck">
                                    <div class="card border-danger align-self-center">
                                        <?php if(!$cphoto): ?>
                                        <img src="assets/images/profile.jpg" class="img-thumbnail img-fluid" width="508px" alt="Profile">
                                        <?php else : ?>
                                        <img src="assets/php/<?=$cphoto; ?>" class="img-thumbnail img-fluid" width="408px" alt="Profile">
                                        <?php endif; ?>
                                    </div>
                                    <div class="card border-danger">
                                        <form action="#" method="post" class="px-3 mt-2" id="profile-update-form" enctype="multipart/form-data">
                                            <input type="hidden" name="oldImage" id="oldImage" value="<?= $cphoto; ?>">
                                            <div class="form-group m-0">
                                                <label for="profilePhoto" class="m-1">Upload Profile Image</label>
                                                <input type="file" name="image" id="profilePhoto">
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="name" class="m-1">Name</label>
                                                <input type="text" name="name" id="name" value="<?= $cname; ?>" class="form-control">
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="gender" class="m-1">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="" disabled <?php if($cgender == null){echo "selected";} ?>>Select Gender</option>
                                                    <option value="Male" <?php if($cgender == "Male"){echo "selected";} ?>>Male</option>
                                                    <option value="Female" <?php if($cgender == "Female"){echo "selected";}?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group m-0">
                                                <label for="dob" class="m-1">Date of Birth</label>
                                                <input type="date" name="dob" value="<?= $cdob; ?>" class="form-control" id="dob">
                                            </div>
                                            <div class="form-group m-0 mb-2">
                                                <label for="phone" class="m-1">Phone Number</label>
                                                <input type="tel" name="phone" value="<?= $cphone; ?>" class="form-control" placeholder="Phone Number" id="phone">
                                            </div>
                                            <div class="form-group mt-2">
                                                <input type="submit" name="profile_update" id="profileUpdateBtn" class="btn btn-danger btn-block">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Profile Tab Content End -->

                            <!-- Change Password Tab Content Start -->
                            <div class="tab-pane container fade" id="changePass">
                                <div id="passAlert"></div>
                                <div class="card-deck">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-center text-white lead">
                                            Change Password
                                        </div>
                                        
                                        <form action="#" method="post" class="px-3 mt-2" id="change-pass-form">
                                            <div class="form-group">
                                                <label for="curpass">Enter Current Password</label>
                                                <input type="password" id="curpass" name="curpass" class="form-control form-control-lg" placeholder="Current Password" required minlength="5">
                                            </div>
                                            <div class="form-group">
                                                <label for="newpass">Enter New Password</label>
                                                <input type="password" id="newpass" name="newpass" class="form-control form-control-lg" placeholder="Enter New Password" required minlength="5">
                                            </div>
                                            <div class="form-group">
                                                <label for="cnewpass">Confirm New Password</label>
                                                <input type="password" id="cnewpass" name="cnewpass" class="form-control form-control-lg" placeholder="Confirm New Password" required minlength="5">
                                            </div>
                                            <div class="form-group">
                                                <p id="changePassAlert" class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Change Password" name="changePass" id="changePassBtn" class="btn btn-success btn-block btn-lg">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card border-success align-self-center">
                                        <img src="assets/images/password.jpg" class="img-thumbnail img-fluid" width="408px" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- Change Password Tab Content End -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

    <script>
        $(document).ready(function(){
            // Profile Update Ajax
            $('#profile-update-form').submit((e)=>{
                e.preventDefault()
                const image = $('#profilePhoto')[0].files;
                const name = $('#name').val()
                const gender = $('#gender').val()
                const dob = $('#dob').val()
                const phone = $('#phone').val()
                const oldImage = $('#oldImage').val()
                const fd = new FormData()
                fd.append('image',image[0])
                fd.append('name',name)
                fd.append('gender',gender)
                fd.append('dob',dob)
                fd.append('phone',phone)
                fd.append('oldImage',oldImage)
                $.ajax({
                    url:'assets/php/process.php',
                    method:'post',
                    processData:false,
                    contentType:false,
                    cache:false,
                    data: fd,
                    success:(res)=>{
                        location.reload()
                    }
                })
            })

            // Change Password Ajax Request
            $('#changePassBtn').click(e=>{
                if($('#change-pass-form')[0].checkValidity()){
                    e.preventDefault()
                    $('#changePassBtn').val('Please Wait...')

                    // check if new password match
                    if($('#newpass').val() != $('#cnewpass').val()){
                        $('#changePassAlert').text('Password did not match')
                        $('#changePassBtn').val('Change Password')
                        
                    }else{
                        $('#changePassAlert').text('')
                        $.ajax({
                            url:'assets/php/process.php',
                            method:'post',
                            data:$('#change-pass-form').serialize()+'&action=change_password',
                            success:(res)=>{
                                $('#passAlert').html(res)
                                $('#changePassBtn').val('Change Password')
                                $('#change-pass-form')[0].reset()
                            }
                        })
                    }
                }
            })

            // Verify Email ajax request
            $('#verify-email').click(e=>{
                e.preventDefault()
                $('#verify-email').text('Please Wait...')
                $.ajax({
                    url:'assets/php/process.php',
                    method:'post',
                    data:{action:'Verify_Email'},
                    success:(res)=>{
                        $('#verifyEmailAlert').html(res)
                        $('#verify-email').text('Verify Now')
                    }
                })
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