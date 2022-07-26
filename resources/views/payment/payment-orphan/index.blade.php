@extends('layout.app')
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
                                <option value="1" >اسم اليتيم</option>
                                <option value="2" >رقم اليتيم</option>
                                <option value="3" selected>رقم هوية اليتيم</option>
                                <option value="4">اسم المعيل</option>
                                <option value="5">رقم هوية المعيل</option>
                            </select>
                            <input type="search" class="form-control  col-md-4 col-sm-12"   id="valueSearch" style="margin: 5px" >
                            <select  class="form-control col-md-4"  id="paymentName"  style="margin: 5px">
                                @isset($payments)
                                    <option selected disabled>اختر</option>
                                <option value="allPayment">كل الصرفيات</option>
                                    @foreach($payments as $payment)
                                        <option value="{{$payment->name}}" >{{$payment->name.' - ('.$payment->paymentDate.')'}}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <button type="button" class="btn btn-warning col-sm-2 col-md-1"  id="btn-searchPaymentsOrphans" style="margin: 5px; color:white">بحث</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row " style="text-align: right;">

                        <div class="col-md-1" >
                            <div class="dropdown show">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon fas fa-plus"></i>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="text-align: right">
                                    @can('AddPaymentOrphan')
                                    <a class="dropdown-item" data-toggle="modal" data-target="#addPaymentOrphan"> إضافة صرفية ليتيم<i class="nav-icon fas fa-plus" style="margin: 5px"></i></a>
                                    @endcan
                                    @can('AddExcelPaymentOrphan')
                                        <a class="dropdown-item" data-toggle="modal" data-target="#addExcelPaymentsOrphans">استيراد من اكسل<i class="nav-icon fas fa-file-excel" style="margin: 5px"></i></a>
                                @endcan
                                        @can('ExportExcelPaymentOrphans')
                                            <a class="dropdown-item" data-toggle="modal" data-target="#exportExcelPaymentsOrphans"> تصدير اكسل <i class="nav-icon fas fa-file-download" style="margin: 5px"></i></a>
                                        @endcan
                                </div>
                            </div>
                            </div>
                        <div class="col-md-11" >
                            <span class="">صرفيات الأيتام</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive" style="text-align: right">

                        <table class="table table-hover table-condensed" id="payments-orphans-table" style="direction: rtl; text-align: center">
                            <thead><th style="text-align: center">#</th>
                            <th><input type="checkbox" name="main_checkbox"><label></label></th>
                            <th style="text-align: center">رقم اليتيم</th>
                            <th style="text-align: center">رقم هوية اليتيم </th>
                            <th style="text-align: center">اسم اليتيم</th>
                            <th style="text-align: center">اسم الصرفية</th>
                            <th style="text-align: center">سعر الصرف </th>
                            <th style="text-align: center"> العمولة </th>
                            <th style="text-align: center">المبلغ </th>
                            <th style="text-align: center">المبلغ(شيكل) </th>
                            <th style="text-align: center"> تاريخ الصرفية </th>
                            <th style="text-align: center">اسم المستخدم</th>
                            <th> <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">حذف الكل</button></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @can('AddPaymentOrphan')
    @include('payment.payment-orphan.add-payment-orphan-modal')
    @endcan
    @can('EditPaymentOrphan')
    @include('payment.payment-orphan.edit-payment-orphan-modal')
    @endcan
    @can('AddExcelPaymentOrphan')
    @include('payment.payment-orphan.add-excel-payments-orphans-modal')
    @endcan
    @can('ExportExcelPaymentOrphans')
        @include('payment.payment-orphan.export-excel-payments-orphans-modal')
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

            //ADD NEW Payment orphan
            $('#add-payment-orphan-form').on('submit', function(e){
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
                            $('.addPaymentOrphan').modal('hide');
                            $('.addPaymentOrphan').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#payments-orphans-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL Payments orphans
            var table =  $('#payments-orphans-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.payment.orphans.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'orphanNumber', name:'orphanNumber'},
                    {data:'orphanIdentity', name:'orphanIdentity'},
                    {data:'orphanName', name:'orphanName'},
                    {data:'name', name:'name'},
                    {data:'exchangeRate', name:'exchangeRate'},
                    {data:'commission', name:'commission'},
                    {data:'warrantyValue', name:'warrantyValue'},
                    {data:'warrantyValueConverted', name:'warrantyValueConverted'},
                    {data:'paymentDate', name:'paymentDate'},
                    {data:'user_name', name:'user_name'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ]
            }).on('draw', function(){
                $('input[name="payment_orphan_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });

            //search payment orphan
            $(document).on('click','#btn-searchPaymentsOrphans', function(){
                var typeSearch = document.getElementById('typeSearch').value;
                var valueSearch = document.getElementById('valueSearch').value;
                var paymentName = document.getElementById('paymentName').value;
                var table = $('#payments-orphans-table').DataTable();
                table.destroy();
                table =  $('#payments-orphans-table').DataTable({
                    processing:true,
                    info:true,
                    ajax:{
                        'url':"{{ route('searchPaymentOrphans') }}",
                        'data' :{
                            'typeSearch':typeSearch,
                            'valueSearch':valueSearch,
                            'paymentName':paymentName,
                        }
                    },
                    "pageLength":5,
                    "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                    columns:[
                        //  {data:'id', name:'id'},
                        {data:'DT_RowIndex', name:'DT_RowIndex'},
                        {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                        {data:'orphanNumber', name:'orphanNumber'},
                        {data:'orphanIdentity', name:'orphanIdentity'},
                        {data:'orphanName', name:'orphanName'},
                        {data:'name', name:'name'},
                        {data:'exchangeRate', name:'exchangeRate'},
                        {data:'commission', name:'commission'},
                        {data:'warrantyValue', name:'warrantyValue'},
                        {data:'warrantyValueConverted', name:'warrantyValueConverted'},
                        {data:'paymentDate', name:'paymentDate'},
                        {data:'user_name', name:'user_name'},
                        {data:'actions', name:'actions', orderable:false, searchable:false},
                    ]
                }).on('draw', function(){
                    $('input[name="payment_orphan_checkbox"]').each(function(){this.checked = false;});
                    $('input[name="main_checkbox"]').prop('checked', false);
                    $('button#deleteAllBtn').addClass('d-none');
                });
            });

            $(document).on('click','#editPaymentOrphanBtn', function(){
                var paymentOrphanId = $(this).data('id');
                $('.editPaymentOrphan').find('form')[0].reset();
                $('.editPaymentOrphan').find('span.error-text').text('');
                $.post('<?= route("get.payment.orphan.details") ?>',{paymentOrphanId:paymentOrphanId}, function(data){
                    $('.editPaymentOrphan').find('input[name="paymentOrphanId"]').val(data.details.id);
                    $('.editPaymentOrphan').find('input[name="orphanIdentity"]').val(data.orphanIdentity);
                    $('.editPaymentOrphan').find('input[name="orphanName"]').val(data.orphanName);
                    $('.editPaymentOrphan').find('input[name="warrantyValue"]').val(data.details.warrantyValue);
                    $('.editPaymentOrphan select').val(data.paymentName);
                    $('.editPaymentOrphan').modal('show');
                },'json');
            });
            //UPDATE Payment DETAILS
            $('#update-payment-orphan-form').on('submit', function(e){
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
                            $('#payments-orphans-table').DataTable().ajax.reload(null, false);
                            $('.editPaymentOrphan').modal('hide');
                            $('.editPaymentOrphan').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE Payment RECORD
            $(document).on('click','#deletePaymentOrphanBtn', function(){
                var payment_orphan_id = $(this).data('id');
                var url = '<?= route("delete.payment.orphan") ?>';

                swal.fire({
                    title:'',
                    html:'هل أنت متأكد من حذف صرفية اليتيم?',
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
                        $.post(url,{payment_orphan_id:payment_orphan_id}, function(data){
                            if(data.code == 1){
                                $('#payments-orphans-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="payment_orphan_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="payment_orphan_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="payment_orphan_checkbox"]', function(){

                if( $('input[name="payment_orphan_checkbox"]').length == $('input[name="payment_orphan_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="payment_orphan_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="payment_orphan_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedPaymentsOrphans = [];
                $('input[name="payment_orphan_checkbox"]:checked').each(function(){
                    checkedPaymentsOrphans.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.payments_orphans") }}';
                if(checkedPaymentsOrphans.length > 0){
                    swal.fire({
                        title:'',
                        html:'تريد حذف <b>('+checkedPaymentsOrphans.length+')</b> صرفيات الايتام',
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
                            $.post(url,{payment_orphan_ids:checkedPaymentsOrphans},function(data){
                                if(data.code == 1){
                                    $('#payments-orphans-table').DataTable().ajax.reload(null, true);
                                    toastr.success(data.msg);
                                }
                            },'json');
                        }
                    })
                }
            });

            $('#add-excel-payments-orphans-form').on('submit', function(e){
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
                            if(data.isAllAdded){
                                $('.addExcelPaymentsOrphans').modal('hide');
                                $('.addExcelPaymentsOrphans').find('form')[0].reset();
                                document.getElementsByClassName('custom-file-label')[0].innerHTML = 'اختر الملف';

                            }
                            $('#payments-orphans-table').DataTable().ajax.reload(null, true);
                        }
                    }
                });
            });

        });
    </script>
@endsection
