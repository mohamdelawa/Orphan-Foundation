<div class="modal fade editRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form action="<?= route('update.role.details') ?>" method="post" id="update-role-form">
                    @csrf
                     <input type="hidden" name="id">
                     <div class="form-group">
                         <label for="">Role name</label>
                         <input type="text" class="form-control" name="name" placeholder="Enter Role name">
                         <span class="text-danger error-text name_error"></span>
                     </div>
                     <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                     </div>
                 </form>


            </div>
        </div>
    </div>
</div>
