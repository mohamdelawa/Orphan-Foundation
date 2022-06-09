<div class="modal fade addExcelOrphans" id="addExcelOrphans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة ايتام </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl; text-align: right">
                <form id="add-excel-orphans-form"  action="{{route('add.excel.orphans')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2">
                            <label for="file" ><b> أضف الملف</b></label>
                        </div>
                        <div class="form-group col-lg-5 col-md-5">
                            <div class="custom-file form-control " id="file">
                                <input class="custom-file-input " id="customFile" type="file" name="file">
                                <label class="custom-file-label " for="customFile" style="text-align: left">اختر ملف</label>
                                <span class="text-danger error-text file_error"></span>
                            </div>
                            <script>
                                // Add the following code if you want the name of the file appear on select
                                $(".custom-file-input").on("change", function() {
                                    var fileName = $(this).val().split("\\").pop();
                                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                });
                            </script>

                        </div>
                        <div class="form-group col-lg-1 col-md-2  mr-md-2">
                            <button type="submit"  class="btn btn-block btn-primary">حفظ</button>
                        </div>
                    </div>

                </form>
                <a href="{{ asset('/sample/orphans.xlsx') }}"><i class="nav-icon fas fa-download"></i> تنزيل مثال</a>
                <hr/>
                <div>
                    <ul id="errors_excel">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
