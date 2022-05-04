<div class="modal fade addImage" id="addImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافة صورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                  <form action="{{ route('add.image') }}" enctype="multipart/form-data" method="post" id="add-image-form" autocomplete="off">
                      @csrf
                      <input hidden type="text" name="orphan_id" value="{{$orphan->id}}">
                      <div class="form-group">
                                    <label for="">نوع لصورة</label>
                                    <select class="form-control" name="type_image" required>
                                        <option value="">اختر</option>
                                        @foreach($types_image as $type_image)
                                            <option value="{{$type_image->type}}">{{$type_image->type}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text type_image_error"></span>
                                </div>
                      <div class="form-group">
                              <label for="image" ><b> أضف صورة</b></label>
                              <div class="custom-file form-control " id="image">
                                  <input type="file" class="custom-file-input @error('image') is-valid @enderror " id="customFile" name="image" >
                                  <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                  @error('image')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                  @enderror
                              </div>
                          <script>
                              // Add the following code if you want the name of the file appear on select
                              $(".custom-file-input").on("change", function() {
                                  var fileName = $(this).val().split("\\").pop();
                                  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                              });
                          </script>

                      </div>

                      <div class="form-group">
                          <button type="submit" class="btn btn-block btn-success">حفظ</button>
                      </div>

                  </form>
            </div>
        </div>
    </div>
</div>
