@extends('layout.app')
@section('css')
    <style>
        .image-gallery{
            height: 150px;
            border-radius: 8px;
        }

    </style>
@endsection
@section('padding page')
    <div class="container" style="margin-top: 50px; text-align: right" >
        <div class="row" >
            <form id="update-orphan-form" class="form-group col-md-12"  method="POST" action="{{route('update.orphan',['id'=>$orphan->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="card " style="direction: rtl">
                    <div class="card-header">
                        <h5>عرض يتيم</h5>
                    </div>
                    <div class="card-body  ">
                        <div class="row text-right " style="direction: rtl" >
                            <div class="col-md-9" >
                                <div class="form-group row">
                                    <label for="orphanNumber " class="col-md-2"><b>رقم اليتيم </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 "  id="orphanNumber" name="orphanNumber" value="{{$orphan->orphanNumber}}" >
                                    <span class="text-danger error-text col-md-6 orphanNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="orphanName" class="col-md-2"><b>اسم اليتيم </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="orphanName" name="orphanName" value="{{$orphan->orphanName}}" >
                                    <span class="text-danger error-text col-md-6 orphanName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="orphanNameEn" class="col-md-2"><b>اسم اليتيم (الانجليزية)</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="orphanNameEn" name="orphanNameEn" value="{{$orphan->orphanNameEn}}" style="direction: ltr" >
                                    <span class="text-danger error-text col-md-6 orphanNameEn_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="orphanIdentity" class="col-md-2"><b>رقم هوية اليتيم </b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="orphanIdentity" name="orphanIdentity" value="{{$orphan->orphanIdentity}}" >
                                    <span class="text-danger error-text col-md-6 orphanIdentity_error"></span>

                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-md-2" ><b>تاريخ ميلاد اليتيم</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 " required id="dob" name="dob" value="{{$orphan->dob}}" >
                                    <span class="text-danger error-text col-md-6 dob_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-md-2"><b>الجنس</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="male" name="gender" value="male" checked  >
                                            <label class="custom-control-label" for="male">ذكر</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="female" @if($orphan->gender=='female') checked @endif name="gender" value="female" >
                                            <label class="custom-control-label" for="female">أنثى</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text col-md-6 gender_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="mothersIdentity" class="col-md-2"><b>رقم هوية الأم</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="mothersIdentity" name="mothersIdentity" value="{{$orphan->mothersIdentity}}" >
                                    <span class="text-danger error-text col-md-6 mothersIdentity_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="mothersName" class="col-md-2"><b>اسم الأم</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="mothersName" name="mothersName" value="{{$orphan->mothersName}}" >
                                    <span class="text-danger error-text col-md-6 mothersName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerName" class="col-md-2"><b>اسم المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="breadwinnerName" name="breadwinnerName" value="{{$orphan->breadwinnerName}}" >
                                    <span class="text-danger error-text col-md-6 breadwinnerName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerNameEn" class="col-md-2"><b>اسم المعيل(الانجليزية)</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="breadwinnerNameEn" name="breadwinnerNameEn" value="{{$orphan->breadwinnerNameEn}}" style="direction: ltr" >
                                    <span class="text-danger error-text col-md-6 breadwinnerNameEn_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerIdentity" class="col-md-2"><b>رقم هوية المعيل</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="breadwinnerIdentity" name="breadwinnerIdentity"  value="{{$orphan->breadwinnerIdentity}}">
                                    <span class="text-danger error-text col-md-6 breadwinnerIdentity_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="relativeRelation" class="col-md-2"><b>صلة قرابة المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="relativeRelation" name="relativeRelation" value="{{$orphan->relativeRelation}}">
                                    <span class="text-danger error-text col-md-6 relativeRelation_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-md-2"><b>عنوان </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="address" name="address"  value="{{$orphan->address}}">
                                    <span class="text-danger error-text col-md-6 address_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="phoneNumber" class="col-md-2"><b>رقم الجوال</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="phoneNumber" name="phoneNumber" value="{{$orphan->phoneNumber}}">
                                    <span class="text-danger error-text col-md-6 phoneNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="accountNumber" class="col-md-2"><b>رقم الحساب</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="accountNumber" name="accountNumber" value="{{$orphan->accountNumber}}" >
                                    <span class="text-danger error-text col-md-6 accountNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="educationalLevel" class="col-md-2"><b>المرحلة الدراسية</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="educationalLevel" name="educationalLevel" value="{{$orphan->educationalLevel}}">
                                    <span class="text-danger error-text col-md-6 educationalLevel_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyType" class="col-md-2"><b>نوع الكفالة </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="guarantyType" name="guarantyType" value="{{$orphan->guarantyType}}" >
                                    <span class="text-danger error-text col-md-6 guarantyType_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="healthStatus" class="col-md-2"><b> الحالة الصحية </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="healthStatus" name="healthStatus" value="{{$orphan->healthStatus}}">
                                    <span class="text-danger error-text col-md-6 healthStatus_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="disease" class="col-md-2"><b> نوع المرض أو الإاقة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="disease" name="disease" value="{{$orphan->healthStatus}}" >
                                    <span class="text-danger error-text col-md-6 disease_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="educationalAttainmentLevel" class="col-md-2"><b>مستوى التحصيل العلمي</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="educationalAttainmentLevel" name="educationalAttainmentLevel" value="{{$orphan->educationalAttainmentLevel}}">
                                    <span class="text-danger error-text col-md-6 educationalAttainmentLevel_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="fathersDeathDate" class="col-md-2"><b>تاريخ الوفاة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 " required id="fathersDeathDate" name="fathersDeathDate" value="{{$orphan->fathersDeathDate}}">
                                    <span class="text-danger error-text col-md-6 fathersDeathDate_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="causeOfDeath" class="col-md-2"><b>سبب الوفاة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="causeOfDeath" name="causeOfDeath" value="{{$orphan->causeOfDeath}}">
                                    <span class="text-danger error-text col-md-6 causeOfDeath_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-2"><b>الحالة</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" checked id="marketing" name="status" value="marketing"  >
                                            <label class="custom-control-label" for="marketing">للتسويق</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="guaranty" name="status" @if($orphan->status == 'guaranty') checked @endif  value="guaranty"  >
                                            <label class="custom-control-label" for="guaranty">مكفول</label>
                                        </div>
                                        <span class="text-danger error-text col-md-6 status_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marketingDate" class="col-md-2"><b>تاريخ التسويق</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 "  id="marketingDate" name="marketingDate" value="{{$orphan->marketingDate}}">
                                    <span class="text-danger error-text col-md-6 marketingDate_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyDate" class="col-md-2"><b>تاريخ الكفالة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3"  id="guarantyDate" name="guarantyDate" value="{{$orphan->guarantyDate}}">
                                    <span class="text-danger error-text col-md-6 guarantyDate_error"></span>
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <div class="custom-file row" style="margin: 10px;">
                                    <div class="row " style="margin-bottom: 10px; justify-content: center">
                                        @if($personalPicture)
                                            <img src="{{asset('images/'.$personalPicture)}}" class="rounded" alt="Cinque Terre" width="200" height="200">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @can('EditOrphan')
                        <button class="btn btn-primary" type="submit">حفظ</button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
        @can('ShowImagesTableForOrphan')
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row " style="text-align: right;">

                        <div class="col-md-1" >
                            <button class="btn btn-primary  " data-toggle="modal" data-target="#addImage"><i class="fa fa-image nav-icon mr-2"></i><i class="fa fa-plus nav-icon"></i></button>
                        </div>
                        <div class="col-md-11" >
                            <span class="">الصور</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive" style="text-align: right">

                        <table class="table table-hover table-condensed" id="images-table" style="direction: rtl; text-align: center">
                            <thead><th style="text-align: center">#</th>
                            <th><input type="checkbox" name="main_checkbox"><label></label></th>
                            <th style="text-align: center">الصورة</th>
                            <th style="text-align: center">نوع الصورة </th>
                            <th> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        @can('AddImageForOrphan')
            @include('orphan/add-image-modal')
            @endcan
        @can('EditImageForOrphan')
            @include('orphan/edit-image-modal')
            @endcan
        @endcan
    </div>

@endsection

@section('script')
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
    <script>
        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){
            $('#update-orphan-form').on('submit', function(e){
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
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //ADD NEW IMAGE
            $('#add-image-form').on('submit', function(e){
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
                            $('.addImage').modal('hide');
                            $('.addImage').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#images-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL IMAGES
            var table =  $('#images-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.images.list',['id'=>$orphan->id]) }}",

                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'image', name:'image'},
                    {data:'type_image', name:'type_image'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="image_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });

            $(document).on('click','#editImageBtn', function(){

                var image_id = $(this).data('id');
                $('.editImage').find('form')[0].reset();
                $('.editImage').find('span.error-text').text('');
                $.post('<?= route("get.image.details") ?>',{image_id:image_id}, function(data){
                    if(data.code == 1){
                        $('.editImage').find('input[name="id"]').val(data.id);
                        $('.editImage select').val(data.type_image);
                        $('.editImage').modal('show');
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }

                },'json');

            });

            //UPDATE IMAGE DETAILS
            $('#update-image-form').on('submit', function(e){
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
                            $('#images-table').DataTable().ajax.reload(null, false);
                            $('.editImage').modal('hide');
                            $('.editImage').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    },

                });
            });
            //DELETE USER RECORD
            $(document).on('click','#deleteImageBtn', function(){
                var image_id = $(this).data('id');
                var url = '<?= route("delete.image") ?>';

                swal.fire({
                    title:'',
                    html:'هل أنت متأكد من حذف الصورة?',
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
                        $.post(url,{image_id:image_id}, function(data){
                            if(data.code == 1){
                                $('#images-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="image_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="image_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="image_checkbox"]', function(){

                if( $('input[name="image_checkbox"]').length == $('input[name="image_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="image_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="image_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedImages = [];
                $('input[name="image_checkbox"]:checked').each(function(){
                    checkedImages.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.images") }}';
                if(checkedImages.length > 0){
                    swal.fire({
                        title:'',
                        html:'تريد حذف <b>('+checkedImages.length+')</b> الصور',
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
                            $.post(url,{image_ids:checkedImages},function(data){
                                if(data.code == 1){
                                    $('#images-table').DataTable().ajax.reload(null, true);
                                    toastr.success(data.msg);
                                }else{
                                    toastr.error(data.msg);
                                }
                            },'json');
                        }
                    })
                }
            });
        });
    </script>


@endsection
