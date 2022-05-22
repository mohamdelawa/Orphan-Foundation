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
                        }else if(data.code == -1){
                            const list = document.getElementById('errors_excel');
                            $.each(data.errors, function(prefix, val){
                                var msg = 'اليتيم ال '+val['row']+' [ '+val['column']+' : '+val['msg']+' ].';
                                const entry = document.createElement('li');
                                entry.appendChild(document.createTextNode(msg));
                                entry.style.color='red';
                                list.appendChild(entry);
                            });
                            toastr.error(data.msg);
                        }
                        else{
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

        });
    </script>


@endsection
