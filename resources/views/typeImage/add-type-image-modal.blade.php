<div class="modal fade addTypeImage" id="addTypeImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة نوع صورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <form action="{{ route('add.type.image') }}" method="post" id="add-type-image-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="">نوع الصورة </label>
                        <input type="text" class="form-control" style="direction: rtl" name="type" placeholder="نوع صورة">
                        <span class="text-danger error-text type_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
