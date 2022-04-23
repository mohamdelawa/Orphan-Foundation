<div class="modal fade editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات المستخدم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                 <form action="<?= route('update.user.details') ?>" method="post" id="update-user-form">
                    @csrf
                     <input type="hidden" name="id">
                     <div class="form-group">
                         <label for="">اسم</label>
                         <input type="text" class="form-control" name="name" >
                         <span class="text-danger error-text name_error"></span>
                     </div>
                     <div class="form-group">
                         <label for="">رقم الجوال </label>
                         <input type="text" class="form-control" name="phone_number" >
                         <span class="text-danger error-text phone_number_error"></span>
                     </div>
                     <div class="form-group">
                         <label for="">اسم المستخدم</label>
                         <input type="text" class="form-control" name="user_name" >
                         <span class="text-danger error-text user_name_error"></span>
                     </div>
                     <div class="form-group">
                         <label for="">نوع المستخدم</label>
                         <select class="form-control" name="role_name">
                             <option value="">اختر</option>
                             @foreach($roles as $role)
                                 <option value="{{$role->name}}">{{$role->name}}</option>
                             @endforeach
                         </select>
                         <span class="text-danger error-text role_name_error"></span>
                     </div>
                     <div class="form-group">
                         <label for="">كلمة السر </label>
                         <input type="password" class="form-control" name="password" >
                         <span class="text-danger error-text password_error"></span>
                     </div>
                     <div class="form-group">
                         <label for=""> تأكيد كلمة السر </label>
                         <input type="password" class="form-control" name="confirm_password" >
                         <span class="text-danger error-text confirm_password_error"></span>
                     </div>
                     <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">حفظ التعديلات</button>
                     </div>
                 </form>


            </div>
        </div>
    </div>
</div>
