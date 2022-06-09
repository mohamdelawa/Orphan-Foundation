<div class="modal fade addPermission" id="addPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة صلاحية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <form action="{{ route('add.permission') }}" method="post" id="add-permission-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="">الصلاحية</label>
                        <input type="text" class="form-control" style="direction: rtl" name="name" placeholder="الصلاحية">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">الصلاحية (إنجليزي)</label>
                        <input type="text" class="form-control" style="direction: rtl" name="nameEn" placeholder="الصلاحية">
                        <span class="text-danger error-text nameEn_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">المجموعة</label>
                        <input type="text" class="form-control" style="direction: rtl" name="group" placeholder="الصلاحية">
                        <span class="text-danger error-text group_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
