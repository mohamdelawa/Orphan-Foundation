@extends('layout.app')
@section('padding page')
    <div class="container" style="margin-top: 50px;" >
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header  " style="text-align: right;">
                        <div style="display: flex; justify-content: end" >
                            <span class="">Imports</span>
                        </div>
                    </div>
                    <div class="card-body " style="text-align: right;direction: rtl">
                        <form id="add-excel-orphans-form"  action="{{route('add.excel.orphans')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-lg-1 col-md-2">
                                    <label for="file" ><b> أضف الملف</b></label>
                                </div>
                                <div class="form-group col-lg-4 col-md-5">
                                    <div class="custom-file form-control " id="file">
                                        <input class="custom-file-input " id="customFile" type="file" name="file">
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        <span class="text-danger error-text file_error"></span>
                                    </div>
                                    <script>
                                        // Add the following code if you want the name of the file appear on select
                                        $(".custom-file-input").on("change", function() {
                                            var fileName = $(this).val().split("\\").pop();
                                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                        });
                                    </script>

                                </div>
                                <div class="form-group col-lg-1 col-md-2  mr-md-2">
                                    <button type="submit"  class="btn btn-block btn-success">حفظ</button>
                                </div>
                            </div>

                        </form>
                        <a href="{{ url('/sample/test.xlsx') }}"><i class="nav-icon fas fa-download"></i> تنزيل مثال</a>
                          <hr/>
                        <div>
                            <ul id="errors_excel">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
            $('#add-excel-orphans-form').on('submit', function(e){
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
                        document.getElementById('errors_excel').innerHTML = '';
                    },
                    success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                            toastr.error(data.msg);
                        }else if(data.code == 1){
                            const list = document.getElementById('errors_excel');
                           list.innerHTML = data.errors;
                            toastr.success(data.msg);
                        }
                    }
                });
            });
        });
    </script>


@endsection
