<div class="modal fade addPayment" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافة صرفية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                  <form action="{{ route('add.payment') }}" method="post" id="add-payment-form" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label for=""> اسم الصرفية</label>
                                    <input type="text" class="form-control" name="name" required>
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for=""> العملة </label>
                                    <input type="text" class="form-control" name="currency" required>
                                    <span class="text-danger error-text currency_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">سعر الصرف</label>
                                    <input type="number" step='any' class="form-control" name="exchangeRate" required>
                                    <span class="text-danger error-text exchangeRate_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">العمولة </label>
                                    <input type="number" step='0.0001' class="form-control" name="commission" required>
                                    <span class="text-danger error-text commission_error"></span>
                                </div>
                      <div class="form-group">
                          <label for="">تاريخ الصرفية </label>
                          <input type="date"  class="form-control" name="paymentDate" required>
                          <span class="text-danger error-text paymentDate_error"></span>
                      </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary">حفظ</button>
                                </div>

                            </form>
            </div>
        </div>
    </div>
</div>
