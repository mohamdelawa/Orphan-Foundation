@extends('layout.app')
@section('padding page')
        <div class="container" style="margin-top: 50px;" >
            <div class="row" >
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row " style="text-align: right;">

                            <div class="col-md-1" >
                                <div class="dropdown show">
                                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="nav-icon fas fa-plus"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="text-align: right">
                                        @can('AddPayment')
                                            <a class="dropdown-item"  data-toggle="modal" data-target="#addPayment">إضافة صرفية<i class="nav-icon fas fa-plus" style="margin: 5px"></i></a>
                                        @endcan
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
                                <span class="">الصرفيات</span>
                            </div>
                        </div>
                        <div class="card-body table-responsive" style="text-align: right">

                            <table class="table table-hover table-condensed" id="payments-table" style="direction: rtl; text-align: center">
                                <thead><th style="text-align: center">#</th>
                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                <th style="text-align: center">اسم الصرفية</th>
                                <th style="text-align: center">العملة </th>
                                <th style="text-align: center">العمولة </th>
                                <th style="text-align: center">سعر الصرف </th>
                                <th style="text-align: center"> تاريخ الصرفية </th>
                                <th style="text-align: center">عدد الأيتام المستفيدين </th>
                                <th style="text-align: center">المبلغ الإجمالي(شيكل) </th>
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
        @can('AddPayment')
            @include('payment.add-payment-modal')
        @endcan
        @can('EditPayment')
            @include('payment.edit-payment-modal')
        @endcan
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

            //ADD NEW Payment
            $('#add-payment-form').on('submit', function(e){
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
                            $('.addPayment').modal('hide');
                            $('.addPayment').find('form')[0].reset();
                            //  alert(data.msg);
                            $('#payments-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //GET ALL Payments
            var table =  $('#payments-table').DataTable({
                processing:true,
                info:true,
                ajax:"{{ route('get.payments.list') }}",
                "pageLength":5,
                "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                columns:[
                    //  {data:'id', name:'id'},
                    {data:'DT_RowIndex', name:'DT_RowIndex'},
                    {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                    {data:'name', name:'name'},
                    {data:'currency', name:'currency'},
                    {data:'commission', name:'commission'},
                    {data:'exchangeRate', name:'exchangeRate'},
                    {data:'paymentDate', name:'paymentDate'},
                    {data:'countOrphansPayment', name:'countOrphansPayment'},
                    {data:'totalWarrantyValue', name:'totalWarrantyValue'},
                    {data:'user_name', name:'user_name'},
                    {data:'actions', name:'actions', orderable:false, searchable:false},
                ],
            }).on('draw', function(){
                $('input[name="payment_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
            $(document).on('click','#editPaymentBtn', function(){
                var payment_id = $(this).data('id');
                $('.editPayment').find('form')[0].reset();
                $('.editPayment').find('span.error-text').text('');
                $.post('<?= route("get.payment.details") ?>',{payment_id:payment_id}, function(data){
                    $('.editPayment').find('input[name="id"]').val(data.details.id);
                    $('.editPayment').find('input[name="name"]').val(data.details.name);
                    $('.editPayment').find('input[name="currency"]').val(data.details.currency);
                    $('.editPayment').find('input[name="commission"]').val(data.details.commission);
                    $('.editPayment').find('input[name="exchangeRate"]').val(data.details.exchangeRate);
                    $('.editPayment').find('input[name="paymentDate"]').val(data.details.paymentDate);
                    $('.editPayment').modal('show');
                },'json');
            });
            //UPDATE Payment DETAILS
            $('#update-payment-form').on('submit', function(e){
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
                            $('#payments-table').DataTable().ajax.reload(null, false);
                            $('.editPayment').modal('hide');
                            $('.editPaymemt').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                    }
                });
            });
            //DELETE Payment RECORD
            $(document).on('click','#deletePaymentBtn', function(){
                var payment_id = $(this).data('id');
                var url = '<?= route("delete.payment") ?>';

                swal.fire({
                    title:'',
                    html:'هل أنت متأكد من حذف الصرفية?',
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
                        $.post(url,{payment_id:payment_id}, function(data){
                            if(data.code == 1){
                                $('#payments-table').DataTable().ajax.reload(null, false);
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
                    $('input[name="payment_checkbox"]').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('input[name="payment_checkbox"]').each(function(){
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change','input[name="payment_checkbox"]', function(){

                if( $('input[name="payment_checkbox"]').length == $('input[name="payment_checkbox"]:checked').length ){
                    $('input[name="main_checkbox"]').prop('checked', true);
                }else{
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn(){
                if( $('input[name="payment_checkbox"]:checked').length > 0 ){
                    $('button#deleteAllBtn').text('حذف ('+$('input[name="payment_checkbox"]:checked').length+')').removeClass('d-none');
                }else{
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click','button#deleteAllBtn', function(){
                var checkedPayments = [];
                $('input[name="payment_checkbox"]:checked').each(function(){
                    checkedPayments.push($(this).data('id'));
                });

                var url = '{{ route("delete.selected.payments") }}';
                if(checkedPayments.length > 0){
                    swal.fire({
                        title:'',
                        html:'تريد حذف <b>('+checkedPayments.length+')</b> الصرفيات',
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
                            $.post(url,{payment_ids:checkedPayments},function(data){
                                if(data.code == 1){
                                    $('#payments-table').DataTable().ajax.reload(null, true);
                                    toastr.success(data.msg);
                                }
                            },'json');
                        }
                    })
                }
            });
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
                            $('#payments-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
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
                            $('#payments-table').DataTable().ajax.reload(null, true);
                        }
                    }
                });
            });
        });
    </script>


@endsection


