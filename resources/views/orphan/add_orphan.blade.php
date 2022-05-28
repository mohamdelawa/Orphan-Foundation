@extends('layout.app')
@section('padding page')
    <div class="container" style="margin-top: 50px; text-align: right" >
        <div class="row" >
            @include('massege')
        </div>
        <div class="row" >
            <form id="add-orphan-form" class="form-group col-md-12"  method="POST" action="{{route('add.orphan')}}" enctype="multipart/form-data">
                @csrf
                <div class="card " style="direction: rtl">
                    <div class="card-header">
                        <h5>إضافة يتيم</h5>
                    </div>
                    <div class="card-body  ">
                        <div class="row text-right " style="direction: rtl" >
                            <div class="col-md-10" >
                                <div class="form-group row">
                                       <label for="orphanNumber " class="col-md-2"><b>رقم اليتيم </b><span style="color: red">*</span></label>
                                       <input type="text" class="form-control col-md-5 mr-md-3 "  id="orphanNumber" name="orphanNumber" >
                                    <span class="text-danger error-text orphanNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="orphanName" class="col-md-2"><b>اسم اليتيم </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="orphanName" name="orphanName" >
                                    <span class="text-danger error-text orphanName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="orphanIdentity" class="col-md-2"><b>رقم هوية اليتيم </b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="orphanIdentity" name="orphanIdentity" >
                                    <span class="text-danger error-text orphanIdentity_error"></span>

                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-md-2" ><b>تاريخ ميلاد اليتيم</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 " required id="dob" name="dob" >
                                    <span class="text-danger error-text dob_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-md-2"><b>الجنس</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="male" name="gender" value="male" checked  >
                                            <label class="custom-control-label" for="male">ذكر</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="female"  name="gender" value="female" >
                                            <label class="custom-control-label" for="female">أنثى</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text gender_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="mothersIdentity" class="col-md-2"><b>رقم هوية الأم</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="mothersIdentity" name="mothersIdentity"  >
                                    <span class="text-danger error-text mothersIdentity_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="mothersName" class="col-md-2"><b>اسم الأم</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="mothersName" name="mothersName" >
                                    <span class="text-danger error-text mothersName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerName" class="col-md-2"><b>اسم المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="breadwinnerName" name="breadwinnerName" >
                                    <span class="text-danger error-text breadwinnerName_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerIdentity" class="col-md-2"><b>رقم هوية المعيل</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="breadwinnerIdentity" name="breadwinnerIdentity" >
                                    <span class="text-danger error-text breadwinnerIdentity_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="relativeRelation" class="col-md-2"><b>صلة قرابة المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="relativeRelation" name="relativeRelation" >
                                    <span class="text-danger error-text relativeRelation_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-md-2"><b>عنوان </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="address" name="address"  >
                                    <span class="text-danger error-text address_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="phoneNumber" class="col-md-2"><b>رقم الجوال</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="phoneNumber" name="phoneNumber" >
                                    <span class="text-danger error-text phoneNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="accountNumber" class="col-md-2"><b>رقم الحساب</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 " required id="accountNumber" name="accountNumber" >
                                    <span class="text-danger error-text accountNumber_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="educationalLevel" class="col-md-2"><b>المرحلة الدراسية</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="educationalLevel" name="educationalLevel">
                                    <span class="text-danger error-text educationalLevel_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyType" class="col-md-2"><b>نوع الكفالة </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3" required id="guarantyType" name="guarantyType" >
                                    <span class="text-danger error-text guarantyType_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="healthStatus" class="col-md-2"><b> الحالة الصحية </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="healthStatus" name="healthStatus" >
                                    <span class="text-danger error-text healthStatus_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="disease" class="col-md-2"><b> نوع المرض أو الإاقة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="disease" name="disease" >
                                    <span class="text-danger error-text disease_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="educationalAttainmentLevel" class="col-md-2"><b>مستوى التحصيل العلمي</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="educationalAttainmentLevel" name="educationalAttainmentLevel" >
                                    <span class="text-danger error-text educationalAttainmentLevel_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="fathersDeathDate" class="col-md-2"><b>تاريخ الوفاة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 " required id="fathersDeathDate" name="fathersDeathDate">
                                    <span class="text-danger error-text fathersDeathDate_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="causeOfDeath" class="col-md-2"><b>سبب الوفاة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 " required id="causeOfDeath" name="causeOfDeath">
                                    <span class="text-danger error-text causeOfDeath_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-2"><b>الحالة</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" checked id="marketing" name="status" value="marketing"  >
                                            <label class="custom-control-label" for="marketing">للتسويق</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="guaranty" name="status"  value="guaranty"  >
                                            <label class="custom-control-label" for="guaranty">مكفول</label>
                                        </div>
                                        <span class="text-danger error-text status_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marketingDate" class="col-md-2"><b>تاريخ التسويق</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 "  id="marketingDate" name="marketingDate" >
                                    <span class="text-danger error-text marketingDate_error"></span>
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyDate" class="col-md-2"><b>تاريخ الكفالة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3"  id="guarantyDate" name="guarantyDate">
                                    <span class="text-danger error-text guarantyDate_error"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">حفظ</button>
                    </div>
                </div>
            </form>
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
            $('#add-orphan-form').on('submit', function(e){
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
                            console.log("error");
                            toastr.error(data.msg);
                        }
                        else{
                           // $('.addUser').find('form')[0].reset();
                            toastr.success(data.msg);
                            console.log("success");
                        }
                    }
                });
            });
        });
    </script>
@endsection
