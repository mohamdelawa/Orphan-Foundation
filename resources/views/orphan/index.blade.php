@extends('layout.app')
@section('title')
   Orphans
@endsection
@section('padding page')
        <div class="container" style="margin-top: 50px;" >
            <div class="row" >
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header  " style="text-align: right;">
                                <span class="">البحث</span>
                        </div>
                        <div class="card-body  " style=" direction: rtl">
                            <div class="form-group  row ">
                                    <select id="typeSearch" class="form-control  col-md-3 col-sm-12" style="margin: 5px">
                                        <option value="1" selected>اسم اليتيم</option>
                                        <option value="2" selected>رقم اليتيم</option>
                                        <option value="3">رقم هوية اليتيم</option>
                                        <option value="4">اسم الأم</option>
                                        <option value="5">رقم هوية الأم</option>
                                        <option value="6">اسم المعيل</option>
                                        <option value="7">رقم هوية المعيل</option>
                                        <option value="8">للتسويق</option>
                                        <option value="9">مكفول</option>
                                    </select>
                                    <input type="search" class="form-control  col-md-4 col-sm-12"   id="valueSearch" style="margin: 5px" >

                                    <button type="button" class="btn btn-warning col-sm-2 col-md-2"  id="btn-searchOrphans" style="margin: 5px">بحث</button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row " style="text-align: right;">
                            <div class="col-md-1" >
                                <a href="{{route('form.add.orphan')}}"> <button class="btn btn-primary  " ><i class="nav-icon fas fa-plus"></i></button></a>
                            </div>
                            <div class="col-md-10" >
                                <span class="">الأيتام</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">

                            <table class="table table-hover table-condensed" id="orphans-table" style="direction: rtl; text-align: center">
                                <thead><th style="text-align: center">#</th>
                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">رقم اليتيم</th>
                                <th style="text-align: center">اسم اليتيم</th>
                                <th style="text-align: center">رقم الهوية</th>
                                <th> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                                </thead>
                                <tbody></tbody>
                            </table>
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

            //GET ALL USERS
            var table =  $('#orphans-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.orphans.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'orphanNumber', name:'orphanNumber'},
                    {data:'orphanName', name:'orphanName'},
                    {data:'orphanIdentity', name:'orphanIdentity'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="orphan_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
            //search orphan
            $(document).on('click','#btn-searchOrphans', function(){
                var typeSearch = document.getElementById('typeSearch').value;
                var valueSearch = document.getElementById('valueSearch').value;
                var table = $('#orphans-table').DataTable();
                table.destroy();
                 table =  $('#orphans-table').DataTable({
                    processing:true,
                    info:true,
                    ajax:{
                        'url':"{{ route('searchOrphans') }}",
                        'data' :{
                            'typeSearch':typeSearch,
                            'valueSearch':valueSearch,
                        }
                    },
                    "pageLength":5,
                    "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                    columns:[
                        //  {data:'id', name:'id'},
                        {data:'DT_RowIndex', name:'DT_RowIndex'},
                        {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                        {data:'orphanNumber', name:'orphanNumber'},
                        {data:'orphanName', name:'orphanName'},
                        {data:'orphanIdentity', name:'orphanIdentity'},
                        {data:'actions', name:'actions', orderable:false, searchable:false},
                    ]
                }).on('draw', function(){
                    $('input[name="orphan_checkbox"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#deleteAllBtn').addClass('d-none');
                });

            });
            //DELETE orphan RECORD
            $(document).on('click','#deleteOrphanBtn', function(){
                var orphan_id = $(this).data('id');
                var url = '<?= route("delete.orphan") ?>';

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
                        $.post(url,{orphan_id:orphan_id}, function(data){
                            if(data.code == 1){
                                $('#orphans-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="orphan_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="orphan_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="orphan_checkbox"]', function(){

                if( $('input[name="orphan_checkbox"]').length == $('input[name="orphan_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="orphan_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="orphan_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedOrphans = [];
                $('input[name="orphan_checkbox"]:checked').each(function(){
                    checkedOrphans.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.orphans") }}';
                if(checkedOrphans.length > 0){
                    swal.fire({
                        title:'',
                        html:'تريد حذف <b>('+checkedOrphans.length+')</b> مستخدمين',
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
                            $.post(url,{orphan_ids:checkedOrphans},function(data){
                                if(data.code == 1){
                                    $('#orphans-table').DataTable().ajax.reload(null, true);
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


