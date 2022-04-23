@extends('layout.app')
@section('title')
    اضافة يتيم
@endsection
@section('padding page')
    <div class="container" style="margin-top: 50px; text-align: right" >
        <div class="row" >
            @include('massege')
        </div>
        <div class="row" >
            <form class="form-group col-md-12"  method="POST" action="{{route('add.orphan')}}" enctype="multipart/form-data">
                @csrf
                <div class="card " style="direction: rtl">
                    <div class="card-header">
                        <h5>إضافة يتيم</h5>
                    </div>
                    <div class="card-body  ">
                        <div class="row text-right " style="direction: rtl" >
                            <div class="col-md-6" >
                                <div class="form-group row">
                                    <label for="orphanNumber " class="col-md-2"><b>رقم اليتيم </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3  @error('orphanNumber') is-invalid @enderror " required id="orphanNumber" name="orphanNumber" value="{{old('orphanNumber')}}">
                                    @error('orphanNumber')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="orphanName" class="col-md-2"><b>اسم اليتيم </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('orphanName') is-invalid @enderror " required id="orphanName" name="orphanName" value="{{old('orphanName')}}">
                                    @error('orphanName')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="orphanIdentity" class="col-md-2"><b>رقم هوية اليتيم </b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 @error('orphanIdentity') is-invalid @enderror " required id="orphanIdentity" name="orphanIdentity" value="{{old('orphanIdentity')}}">
                                    @error('orphanIdentity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="dob" class="col-md-2" ><b>تاريخ ميلاد اليتيم</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 @error('dob') is-invalid @enderror" required id="dob" name="dob" value="{{old('dob')}}">
                                    @error('dob')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-md-2"><b>الجنس</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="male" name="gender" value="male" checked  >
                                            <label class="custom-control-label @error('gender') is-invalid @enderror" for="male">ذكر</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="female" @if(old('gender')) checked @endif name="gender" value="female" >
                                            <label class="custom-control-label" for="female">أنثى</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                <div class="form-group row">
                                    <label for="mothersIdentity" class="col-md-2"><b>رقم هوية الأم</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 @error('mothersIdentity') is-invalid @enderror" required id="mothersIdentity" name="mothersIdentity" value="{{old('mothersIdentity')}}" >
                                    @error('mothersIdentity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="mothersName" class="col-md-2"><b>اسم الأم</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('mothersName') is-invalid @enderror" required id="mothersName" name="mothersName" value="{{old('mothersName')}}" >
                                    @error('mothersName')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerName" class="col-md-2"><b>اسم المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('breadwinnerName') is-invalid @enderror" required id="breadwinnerName" name="breadwinnerName" value="{{old('breadwinnerName')}}">
                                    @error('breadwinnerName')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="breadwinnerIdentity" class="col-md-2"><b>رقم هوية المعيل</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 @error('breadwinnerIdentity') is-invalid @enderror" required id="breadwinnerIdentity" name="breadwinnerIdentity" value="{{old('breadwinnerIdentity')}}">
                                    @error('breadwinnerIdentity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="relativeRelation" class="col-md-2"><b>صلة قرابة المعيل</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('relativeRelation') is-invalid @enderror" required id="relativeRelation" name="relativeRelation" value="{{old('relativeRelation')}}">
                                    @error('relativeRelation')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-md-2"><b>عنوان </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('address') is-invalid @enderror" required id="address" name="address" value="{{old('address')}}" >
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="phoneNumber" class="col-md-2"><b>رقم الجوال</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 @error('phoneNumber') is-invalid @enderror" required id="phoneNumber" name="phoneNumber" value="{{old('phoneNumber')}}">
                                    @error('phoneNumber')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="accountNumber" class="col-md-2"><b>رقم الحساب</b><span style="color: red">*</span></label>
                                    <input type="number" class="form-control col-md-5 mr-md-3 @error('accountNumber') is-invalid @enderror" required id="accountNumber" name="accountNumber" value="{{old('accountNumber')}}">
                                    @error('accountNumber')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="educationalLevel" class="col-md-2"><b>المرحلة الدراسية</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('educationalLevel') is-invalid @enderror" required id="educationalLevel" name="educationalLevel" value="{{old('educationalLevel')}}">
                                    @error('educationalLevel')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyType" class="col-md-2"><b>نوع الكفالة </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('guarantyType') is-invalid @enderror" required id="guarantyType" name="guarantyType" value="{{old('guarantyType')}}">
                                    @error('guarantyType')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="healthStatus" class="col-md-2"><b> الحالة الصحية </b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('healthStatus') is-invalid @enderror" required id="healthStatus" name="healthStatus" value="{{old('healthStatus')}}">
                                    @error('healthStatus')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="disease" class="col-md-2"><b> نوع المرض أو الإاقة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('disease') is-invalid @enderror" required id="disease" name="disease" value="{{old('disease')}}">
                                    @error('disease')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="educationalAttainmentLevel" class="col-md-2"><b>مستوى التحصيل العلمي</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('educationalAttainmentLevel') is-invalid @enderror" required id="educationalAttainmentLevel" name="educationalAttainmentLevel" value="{{old('educationalAttainmentLevel')}}">
                                    @error('educationalAttainmentLevel')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="fathersDeathDate" class="col-md-2"><b>تاريخ الوفاة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 @error('fathersDeathDate') is-invalid @enderror" required id="fathersDeathDate" name="fathersDeathDate" value="{{old('fathersDeathDate')}}">
                                    @error('fathersDeathDate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="causeOfDeath" class="col-md-2"><b>سبب الوفاة</b><span style="color: red">*</span></label>
                                    <input type="text" class="form-control col-md-5 mr-md-3 @error('causeOfDeath') is-invalid @enderror" required id="causeOfDeath" name="causeOfDeath" value="{{old('causeOfDeath')}}">
                                    @error('causeOfDeath')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-md-2"><b>الحالة</b><span style="color: red">*</span></label>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input @error('status') is-invalid @enderror" checked id="marketing" name="status" value="marketing"  >
                                            <label class="custom-control-label" for="marketing">للتسويق</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="guaranty" name="status" @if(old('guaranty')) checked @endif value="guaranty"  >
                                            <label class="custom-control-label" for="guaranty">مكفول</label>
                                        </div>
                                        @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marketingDate" class="col-md-2"><b>تاريخ التسويق</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 @error('marketingDate') is-invalid @enderror"  id="marketingDate" name="marketingDate" value="{{old('marketingDate')}}">
                                    @error('marketingDate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="guarantyDate" class="col-md-2"><b>تاريخ الكفالة</b><span style="color: red">*</span></label>
                                    <input type="date" class="form-control col-md-5 mr-md-3 @error('guarantyDate') is-invalid @enderror"  id="guarantyDate" name="guarantyDate" value="{{old('guarantyDate')}}">
                                    @error('guarantyDate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="custom-file row" style="margin: 10px;">
                                    <label for="personalPicture" class="col-md-3"><b> صورة شخصية</b></label>
                                    <div class="custom-file col-md-8 mr-md-2" id="personalPicture">
                                        <input type="file" class="custom-file-input @error('personalPicture') is-valid @enderror " id="customFile" name="personalPicture" >
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        @error('personalPicture')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="custom-file row" style="margin: 10px;">
                                    <label for="birthCertificate" class="col-md-3"><b>شهادة الميلاد</b></label>
                                    <div class="custom-file col-md-8 mr-md-2" id="birthCertificate">
                                        <input type="file" class="custom-file-input @error('birthCertificate') is-invalid @enderror" id="customFile" name="birthCertificate" >
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        @error('birthCertificate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    </div>
                                <div class="custom-file row" style="margin: 10px;">
                                    <label for="schoolCertificate" class="col-md-3"><b>شهادة المدرسة</b></label>
                                    <div class="custom-file col-md-8 mr-md-2" id="schoolCertificate">
                                        <input type="file" class="custom-file-input @error('schoolCertificate') is-invalid @enderror" id="customFile" name="schoolCertificate" >
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        @error('schoolCertificate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="custom-file row" style="margin: 10px;">
                                    <label for="OtherAttachments" class="col-md-3"><b>مرفقات أخرى</b></label>
                                    <div class="custom-file col-md-8 mr-md-2" id="OtherAttachments">
                                        <input type="file" class="custom-file-input  @error('otherAttachments') is-invalid @enderror" id="customFile" multiple   name="otherAttachments[]" >
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        @error('otherAttachments')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <script>
                                    // Add the following code if you want the name of the file appear on select
                                    $(".custom-file-input").on("change", function() {
                                        var fileName = $(this).val().split("\\").pop();
                                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                    });
                                </script>
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
