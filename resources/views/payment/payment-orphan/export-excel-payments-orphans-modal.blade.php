<div class="modal fade exportExcelPaymentsOrphans" id="exportExcelPaymentsOrphans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تصدير صرفية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                <form id="export-excel-payments-orphans-form"  action="{{route('export.excel.payments.orphans')}}" method="get">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12 row">
                            <label class="col-md-2" for=""> اسم الصرفية</label>
                            <select  class="form-control col-md-6"  name="paymentName[]" multiple required>
                                @isset($payments)
                                    @foreach($payments as $payment)
                                        <option value="{{$payment->name}}" >{{$payment->name.' - ('.$payment->paymentDate.')'}}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <span class="text-danger error-text paymentName_error col-md-8"></span>
                        </div>
                        <div class="form-group col-lg-12 row">
                            <label class="col-md-2" for=""> الترتيب حسب </label>
                            <select  class="custom-control custom-select col-md-6"  name="sortByColumn" required>
                                <option value="0" selected>رقم اليتيم</option>
                                <option value="1" >اسم اليتيم بالعربية</option>
                                <option value="2" >اسم اليتيم بالانجليزية</option>
                                <option value="3" >اسم المعيل بالعربية</option>
                                <option value="4" >اسم المعيل بالانجليزية</option>
                                <option value="5" >اسم الام</option>
                                <option value="6" >تاريخ ميلاد اليتيم</option>

                            </select>
                            <span class="text-danger error-text sortByColumn_error col-md-8"></span>
                        </div>
                        <div class = "form-group col-lg-12 row">
                            <label class="col-md-2"> الأعمدة الرئيسية </label>
                            <div class="custom-control custom-radio custom-control-inline ">
                                <input class="custom-control-input" type="radio" name="headerLanguage" id="ar" value="ar" checked>
                                <label class="custom-control-label" for="ar">عربي</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline" >
                                <input class="custom-control-input" type="radio" name="headerLanguage" id="en" value="en">
                                <label class="custom-control-label" for="en">English</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 row">
                            <label class="col-md-12" for=""> اختر الاعمدة  </label>

                            @isset($columns)
                                @foreach($columns as $key=> $value)
                            <div class="custom-control custom-checkbox col-md-3" style="margin: 10px" >
                                <input type="checkbox" class="custom-control-input" id="{{$key}}" @if($value['checked']) checked @endif name="columns[]" value="{{$key}}">
                                <label class="custom-control-label" for="{{$key}}">{{$value['name']['ar']}}</label>
                            </div>
                                @endforeach
                            @endisset
                        </div>

                    </div>
                   <div class="row">
                       <div class="form-group col-lg-1 col-md-2  mr-md-2">
                           <button type="submit"  class="btn btn-block btn-primary">حفظ</button>
                       </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
