<?php
    require_once 'assets/php/header.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if($verified =='Not Verified'): ?>
                    <div class="alert alert-danger alert-dismissible text-center mt-2 m-0" >
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong class="text-center">Your E-mail is not verified. We have sent you an E-mail verification link. Check Your E-mail and verify</strong>
                    </div>
                <?php endif; ?>
                <h4 class="text-center text-primary mt-2">Write Your Notes Here And Access Anytime Anywhere!</h4>
            </div>
        </div>
        <div class="card border-primary">
            <h5 class="card-header bg-primary d-flex justify-content-between">
                <span class="text-light lead align-self-center">All Notes</span>
                <a href="" data-toggle="modal" data-target="#addNoteModal" class="btn btn-light"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Note</a>
            </h5>
            <div class="card-body">
                <div class="table-responsive" id="showNote">
                    <p class="text-center lead mt-5">Please wait...</p>
                        
                </div>
            </div>
        </div>
    </div>

    <!-- New Modal Start -->
    <div class="modal fade" id="addNoteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-light">Add New Note</h4>
                    <button class="close text-light" data-dismiss="modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="add-note-form" class="px-3">
                        <div class="form-group">
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                        </div>
                        <div class="form-group">
                            <textarea name="note" class="form-control form-control-lg" placeholder="Write Your Note Here..." required rows="7"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="addNote" id="addNoteBtn" value="Add Note" class="btn btn-success btn-lg btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- New modal End -->

    <!-- Edit Modal Start -->
    <div class="modal fade" id="editNoteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-light">Edit Note</h4>
                    <button class="close text-light" data-dismiss="modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="edit-note-form" class="px-3">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter Title" required>
                        </div>
                        <div class="form-group">
                            <textarea name="note" id="note" class="form-control form-control-lg" placeholder="Write Your Note Here..." required rows="7"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="editNote" id="editNoteBtn" value="Update Note" class="btn btn-info btn-lg btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit modal End -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function(){
            

            // Add New Note Ajax Request
            $('#addNoteBtn').click(e=>{
                if($('#add-note-form')[0].checkValidity()){
                    e.preventDefault()
                    $('#addNoteBtn').val('Please wait...')
                    $.ajax({
                        url:'assets/php/process.php',
                        method:'post',
                        data:$('#add-note-form').serialize()+'&action=add_note',
                        success:function(res){
                            $('#add-note-form')[0].reset()
                            $('#addNoteBtn').val('Add Note')
                            $('#addNoteModal').modal('hide')
                            swal.fire({
                                title:'Note Added Successfully',
                                icon:"success",
                                
                            })
                            fetchNotes()
                        }
                    })
                }
            })

            fetchNotes()

            // fetch all users note
            function fetchNotes(){
                $.ajax({
                    url:'assets/php/process.php',
                    method:'post',
                    data:{action:'fetch_notes'},
                    success:(res)=>{
                        $('#showNote').html(res)
                        $('table').DataTable({
                            order:[0,'desc']
                        })
                    }
                })
            }

            // edit note of user
            $('body').on('click','.editBtn',function(e){
                e.preventDefault()
                var edit_id = $(this).attr('id')
                $.ajax({
                    url:'assets/php/process.php',
                    method:'POST',
                    data:{editID:edit_id},
                    success:(res)=>{
                        var data = JSON.parse(res)
                        $('#title').val(data.title)
                        $('#id').val(data.id)
                        $('#note').val(data.note)
                    }
                })
            })

            // update note of user
            $('#editNoteBtn').click(e=>{
                if($('#edit-note-form')[0].checkValidity()){
                    e.preventDefault()
                    $('#editNoteBtn').val('Please Wait...')
                    $.ajax({
                        url:'assets/php/process.php',
                        method:'post',
                        data:$('#edit-note-form').serialize()+'&action=update_note',
                        success:(res)=>{
                            $('#edit-note-form')[0].reset()
                            $('#editNoteBtn').val('Add Note')
                            $('#editNoteModal').modal('hide')
                            swal.fire({
                                title:'Note Updated Successfully',
                                icon:"success",
                                
                            })
                            fetchNotes()
                        }
                    })
                }
            })

            // delet notes
            $('body').on('click','.deleteBtn',function(e){
                e.preventDefault()
                var del_id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:'assets/php/process.php',
                            method:'post',
                            data:{deleteID:del_id},
                            success:(res)=>{
                                Swal.fire(
                                'Deleted!',
                                'Note Deleted Successfully',
                                'success'
                                )
                                fetchNotes()
                            }
                        })
                        
                    }
                })
                
            })

            // view users notes
            $('body').on('click','.infoBtn',function(e){
                e.preventDefault()
                var info_id = $(this).attr('id')
                $.ajax({
                    url:'assets/php/process.php',
                    type:'post',
                    data:{infoID:info_id},
                    success:(res)=>{
                        var data = JSON.parse(res)
                        swal.fire({
                            title:`<strong>Note : ID(${data.id})</strong>`,
                            icon:'info',
                            html:`<b>Title: </b>${data.title}<br><br><b>Note: 
                            </b>${data.note}<br><br>
                            <b>Written on: </b>${data.created_at}
                            <br><br>
                            <b>Updated on: </b>${data.updated_at}`,
                            showCloseButton:true
                        })
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