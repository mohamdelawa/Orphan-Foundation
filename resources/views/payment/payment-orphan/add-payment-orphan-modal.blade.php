<div class="modal fade addPaymentOrphan" id="addPaymentOrphan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافة صرفية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                    <form action="{{ route('add.payment.orphan') }}" method="post" id="add-payment-orphan-form" autocomplete="off">
                        @csrf
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label class="col-md-3" for=""> اسم الصرفية</label>
                                <select  class="form-control col-md-8"  name="paymentName" required>
                                    @isset($payments)
                                        @foreach($payments as $payment)
                                    <option value="{{$payment->name}}" >{{$payment->name.' - ('.$payment->paymentDate.')'}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                <span class="text-danger error-text paymentName_error col-md-8"></span>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3" for="">رقم هوية اليتيم</label>
                                <input type="number" class="form-control col-md-8" name="orphanIdentity" required>
                                <span class="text-danger error-text orphanIdentity_error col-md-8"></span>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3" for="">المبلغ</label>
                                <input type="number" step='0.01' class="form-control col-md-8" name="warrantyValue" required>
                                <span class="text-danger error-text warrantyValue_error col-md-8"></span>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn btn-block btn-primary col-md-2">حفظ</button>
                            </div>
                        </div>

                    </form>
                </div>
        </div>
    </div>
</div>
