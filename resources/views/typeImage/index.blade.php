@extends('layout.app')
@section('padding page')
        <div class="container">
            <div class="row" style="margin-top: 45px">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row" style="text-align: right;">
                            <div class="col-md-1" >
                                @can('AddTypeImage')
                                <button class="btn btn-primary  " data-toggle="modal" data-target="#addTypeImage"><i class="nav-icon fas fa-plus"></i></button>
                            @endcan
                            </div>
                            <div class="col-md-11" >
                                <span>أنواع الصور</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">
                            <table class="table table-hover table-condensed" id="type-images-table" style="direction: rtl; text-align: center">
                                <thead>
                                <th style="text-align: center"><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">نوع الصورة </th>
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
 @can('AddTypeImage')
    @include('typeImage.add-type-image-modal')
    @endcan
        @can('EditTypeImage')
    @include('typeImage.edit-type-image-modal')
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

            //ADD NEW Type image
            $('#add-type-image-form').on('submit', function(e){
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
                            $('.addTypeImage').modal('hide');
                            $('.addTypeImage').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#type-images-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL type images
            var table =  $('#type-images-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.type.images.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'type', name:'type'},
                    {data:'user_name', name:'user_name'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="type_image_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
            $(document).on('click','#editTypeImageBtn', function(){
                var type_image_id = $(this).data('id');
                $('.editTypeImage').find('form')[0].reset();
                $('.editTypeImage').find('span.error-text').text('');
                $.post('<?= route("get.type.image.details") ?>',{type_image_id:type_image_id}, function(data){
                        $('.editTypeImage').find('input[name="id"]').val(data.details.id);
                        $('.editTypeImage').find('input[name="type"]').val(data.details.type);
                        $('.editTypeImage').modal('show');

                },'json');
            });
            //UPDATE ROLE DETAILS
            $('#update-type-image-form').on('submit', function(e){
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
                            $('#type-images-table').DataTable().ajax.reload(null, false);
                            $('.editTypeImage').modal('hide');
                            $('.editTypeImage').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE ROLE RECORD
            $(document).on('click','#deleteTypeImageBtn', function(){
                var type_image_id = $(this).data('id');
                var url = '<?= route("delete.type.image") ?>';

                swal.fire({
                    title:'حذف نوع صورة',
                    html:'هل تريد  <b>حذف</b> نوع صورة؟',
                    showCancelButton:true,
                    showCloseButton:true,
                    cancelButtonText:'إلغاء',
                    confirmButtonText:'نعم , حذف',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
                }).then(function(result){
                    if(result.value){
                        $.post(url,{type_image_id:type_image_id}, function(data){
                            if(data.code == 1){
                                $('#type-images-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="type_image_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="type_image_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="type_image_checkbox"]', function(){

                if( $('input[name="type_image_checkbox"]').length == $('input[name="type_image_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="type_image_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="type_image_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedTypeImages = [];
                $('input[name="type_image_checkbox"]:checked').each(function(){
                    checkedTypeImages.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.type.images") }}';
                if(checkedTypeImages.length > 0){
                    swal.fire({
                        title:'حذف أنواع الصور',
                        html:'هل تريد حذف <b>('+checkedTypeImages.length+')</b> أنواع صور',
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
                            $.post(url,{type_image_ids:checkedTypeImages},function(data){
                                if(data.code == 1){
                                    $('#type-images-table').DataTable().ajax.reload(null, true);
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
