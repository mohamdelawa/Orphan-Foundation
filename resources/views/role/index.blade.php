@extends('layout.app')
@section('padding page')
        <div class="container">
            <div class="row" style="margin-top: 45px">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="text-align: right;">
                            <div class="col-md-1" >
                                <button class="btn btn-primary  " data-toggle="modal" data-target="#addRole"><i class="nav-icon fas fa-plus"></i></button>
                            </div>
                            <div class="col-md-11" >
                                <span>المناصب</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">
                            <table class="table table-hover table-condensed" id="roles-table" style="direction: rtl; text-align: center">
                                <thead>
                                <th style="text-align: center"><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">اسم المنصب</th>
                                <th style="text-align: center"> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('role.edit-role-modal')
    @include('role.add-role-modal')

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

            //ADD NEW Role
            $('#add-role-form').on('submit', function(e){
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
                            toastr.error(data.msg);
                        }
                        else{
                            $('.addRole').modal('hide');
                            $('.addRole').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#roles-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL ROLES
            var table =  $('#roles-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.roles.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'name', name:'name'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="role_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
            $(document).on('click','#editRoleBtn', function(){
                var role_id = $(this).data('id');
                $('.editRole').find('form')[0].reset();
                $('.editRole').find('span.error-text').text('');
                $.post('<?= route("get.role.details") ?>',{role_id:role_id}, function(data){
                        $('.editRole').find('input[name="id"]').val(data.details.id);
                        $('.editRole').find('input[name="name"]').val(data.details.name);
                        $('.editRole').modal('show');

                },'json');
            });
            //UPDATE ROLE DETAILS
            $('#update-role-form').on('submit', function(e){
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
                            toastr.error(data.msg);
                        }else{
                            $('#roles-table').DataTable().ajax.reload(null, false);
                            $('.editRole').modal('hide');
                            $('.editRole').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE ROLE RECORD
            $(document).on('click','#deleteRoleBtn', function(){
                var role_id = $(this).data('id');
                var url = '<?= route("delete.role") ?>';

                swal.fire({
                    title:'Are you sure?',
                    html:'You want to <b>delete</b> this role',
                    showCancelButton:true,
                    showCloseButton:true,
                    cancelButtonText:'Cancel',
                    confirmButtonText:'Yes, Delete',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
                }).then(function(result){
                    if(result.value){
                        $.post(url,{role_id:role_id}, function(data){
                            if(data.code == 1){
                                $('#roles-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="role_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="role_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="role_checkbox"]', function(){

                if( $('input[name="role_checkbox"]').length == $('input[name="role_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="role_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('Delete ('+$('input[name="role_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedRoles = [];
                $('input[name="role_checkbox"]:checked').each(function(){
                    checkedRoles.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.roles") }}';
                if(checkedRoles.length > 0){
                    swal.fire({
                        title:'Are you sure?',
                        html:'You want to delete <b>('+checkedRoles.length+')</b> roles',
                        showCancelButton:true,
                        showCloseButton:true,
                        confirmButtonText:'Yes, Delete',
                        cancelButtonText:'Cancel',
                        confirmButtonColor:'#556ee6',
                        cancelButtonColor:'#d33',
                        width:300,
                        allowOutsideClick:false
                    }).then(function(result){
                        if(result.value){
                            $.post(url,{role_ids:checkedRoles},function(data){
                                if(data.code == 1){
                                    $('#roles-table').DataTable().ajax.reload(null, true);
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
