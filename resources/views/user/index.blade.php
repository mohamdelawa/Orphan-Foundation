@extends('layout.app')
@section('title')
   Users
@endsection
@section('padding page')
        <div class="container" style="margin-top: 50px;" >
            <div class="row" >
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row " style="text-align: right;">

                            <div class="col-md-2" >
                                <button class="btn btn-primary  " data-toggle="modal" data-target="#addUser">اضافة مستخدم</button>
                            </div>
                            <div class="col-md-10" >
                                <span class="">المستخدمون</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">

                            <table class="table table-hover table-condensed" id="users-table" style="direction: rtl; text-align: center">
                                <thead><th style="text-align: center">#</th>
                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">الاسم</th>
                                <th style="text-align: center">رقم الجوال</th>
                                <th style="text-align: center">اسم المستخدم</th>
                                <th style="text-align: center">نوع المستخدم</th>
                                <th> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('user/add-user-modal')
        @include('user/edit-user-modal')
@endsection
@section('script')
    <script>
        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){

            //ADD NEW User
            $('#add-user-form').on('submit', function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                        $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);


                            });

                        }
                        else{
                            $('.addUser').modal('hide');
                            $('.addUser').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#users-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL USERS
            var table =  $('#users-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.users.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'name', name:'name'},
                    {data:'phone_number', name:'phone_number'},
                    {data:'user_name', name:'user_name'},
                    {data:'role', name:'role'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="user_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });


            $(document).on('click','#editUserBtn', function(){
                var user_id = $(this).data('id');
                $('.editUser').find('form')[0].reset();
                $('.editUser').find('span.error-text').text('');
                $.post('<?= route("get.user.details") ?>',{user_id:user_id}, function(data){
                    $('.editUser').find('input[name="id"]').val(data.details.id);
                    $('.editUser').find('input[name="name"]').val(data.details.name);
                    $('.editUser').find('input[name="user_name"]').val(data.details.user_name);
                    $('.editUser select').val(data.role_name);
                    $('.editUser').find('input[name="phone_number"]').val(data.details.phone_number);
                    $('.editUser').modal('show');
                },'json');
            });
            //UPDATE USER DETAILS
            $('#update-user-form').on('submit', function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend: function(){
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $('#users-table').DataTable().ajax.reload(null, false);
                            $('.editUser').modal('hide');
                            $('.editUser').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE USER RECORD
            $(document).on('click','#deleteUserBtn', function(){
                var user_id = $(this).data('id');
                var url = '<?= route("delete.user") ?>';

                swal.fire({
                    title:'',
                    html:'هل أنت متأكد من حذف مستخدم?',
                    showCancelButton:true,
                    showCloseButton:true,
                    confirmButtonText:'حذف',
                    cancelButtonText:'إلغاء',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
                }).then(function(result){
                    if(result.value){
                        $.post(url,{user_id:user_id}, function(data){
                            if(data.code == 1){
                                $('#users-table').DataTable().ajax.reload(null, false);
                                toastr.success(data.msg);
                            }else{
                                toastr.error(data.msg);
                            }
                        },'json');
                    }
                });

            });

            $(document).on('click','input[name="main_checkbox"]', function(){
                if(this.checked){
                    $('input[name="user_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="user_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="user_checkbox"]', function(){

                if( $('input[name="user_checkbox"]').length == $('input[name="user_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="user_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="user_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedUsers = [];
                $('input[name="user_checkbox"]:checked').each(function(){
                    checkedUsers.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.users") }}';
                if(checkedUsers.length > 0){
                    swal.fire({
                        title:'',
                        html:'تريد حذف <b>('+checkedUsers.length+')</b> مستخدمين',
                        showCancelButton:true,
                        showCloseButton:true,
                        confirmButtonText:'حذف',
                        cancelButtonText:'إلغاء',
                        confirmButtonColor:'#556ee6',
                        cancelButtonColor:'#d33',
                        width:300,
                        allowOutsideClick:false
                    }).then(function(result){
                        if(result.value){
                            $.post(url,{user_ids:checkedUsers},function(data){
                                if(data.code == 1){
                                    $('#users-table').DataTable().ajax.reload(null, true);
                                    toastr.success(data.msg);
                                }
                            },'json');
                        }
                    })
                }
            });
        });
    </script>


@endsection


