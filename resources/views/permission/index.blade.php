@extends('layout.app')
@section('padding page')
        <div class="container">
            <div class="row" style="margin-top: 45px">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row" style="text-align: right;">
                            <div class="col-md-1" >
                                @can('AddPermission')
                                <button class="btn btn-primary  " data-toggle="modal" data-target="#addPermission"><i class="nav-icon fas fa-plus"></i></button>
                                   @endcan
                            </div>
                            <div class="col-md-11" >
                                <span>الصلاحيات</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">
                            <table class="table table-hover table-condensed" id="permissions-table" style="direction: rtl; text-align: center">
                                <thead>
                                <th style="text-align: center"><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">اسم الصلاحية</th>
                                <th style="text-align: center">اسم الصلاحية (الإنجليزية) </th>
                                <th style="text-align: center">المجموعة</th>
                                <th style="text-align: center">اسم المستخدم</th>
                                <th style="text-align: center"> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('AddPermission')
    @include('permission.add-permission-modal')
    @endcan
        @can('EditPermission')
    @include('permission.edit-permission-modal')
@endcan
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
            $('#add-permission-form').on('submit', function(e){
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
                            $('.addPermission').modal('hide');
                            $('.addPermission').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#permissions-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL ROLES
            var table =  $('#permissions-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.permissions.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'name', name:'name'},
                    {data:'nameEn', name:'nameEn'},
                    {data:'group', name:'group'},
                    {data:'user_name', name:'user_name'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="permission_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
            $(document).on('click','#editPermissionBtn', function(){
                var permission_id = $(this).data('id');
                $('.editPermission').find('form')[0].reset();
                $('.editPermission').find('span.error-text').text('');
                $.post('<?= route("get.permission.details") ?>',{permission_id:permission_id}, function(data){
                    $('.editPermission').find('input[name="id"]').val(data.details.id);
                    $('.editPermission').find('input[name="name"]').val(data.details.name);
                    $('.editPermission').find('input[name="nameEn"]').val(data.details.nameEn);
                    $('.editPermission').find('input[name="group"]').val(data.details.group);
                        $('.editPermission').modal('show');

                },'json');
            });
            //UPDATE ROLE DETAILS
            $('#update-permission-form').on('submit', function(e){
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
                            $('#permissions-table').DataTable().ajax.reload(null, false);
                            $('.editPermission').modal('hide');
                            $('.editPermission').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE ROLE RECORD
            $(document).on('click','#deletePermissionBtn', function(){
                var permission_id = $(this).data('id');
                var url = '<?= route("delete.permission") ?>';

                swal.fire({
                    title:'حذف صلاحية',
                    html:'هل تريد <b>حذف</b> الصلاحية؟',
                    showCancelButton:true,
                    showCloseButton:true,
                    cancelButtonText:'إلغاء',
                    confirmButtonText:'نعم, حذف',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
                }).then(function(result){
                    if(result.value){
                        $.post(url,{permission_id:permission_id}, function(data){
                            if(data.code == 1){
                                $('#permissions-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="permission_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="permission_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="permission_checkbox"]', function(){

                if( $('input[name="permission_checkbox"]').length == $('input[name="permission_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="permission_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="permission_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedPermissions = [];
                $('input[name="permission_checkbox"]:checked').each(function(){
                    checkedPermissions.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.permissions") }}';
                if(checkedPermissions.length > 0){
                    swal.fire({
                        title:'حذف الصلاحيات',
                        html:'هل تريد حذف <b>('+checkedPermissions.length+')</b> الصلاحيات',
                        showCancelButton:true,
                        showCloseButton:true,
                        confirmButtonText:'نعم, حذف',
                        cancelButtonText:'إلغاء',
                        confirmButtonColor:'#556ee6',
                        cancelButtonColor:'#d33',
                        width:300,
                        allowOutsideClick:false
                    }).then(function(result){
                        if(result.value){
                            $.post(url,{permission_ids:checkedPermissions},function(data){
                                if(data.code == 1){
                                    $('#permissions-table').DataTable().ajax.reload(null, true);
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
