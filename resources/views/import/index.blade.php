@extends('layout.app')
@section('title')
    Users
@endsection
@section('padding page')
    <div class="container" style="margin-top: 50px;" >
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header  " style="text-align: right;">
                        <div style="display: flex; justify-content: end" >
                            <span class="">Imports</span>
                        </div>
                    </div>
                    <div class="card-body " style="display: flex; justify-content: start;text-align: right;direction: rtl">
                        <form  action="{{route('import.images.reports.orphan')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="image" ><b> أضف صورة</b></label>
                                    <div class="custom-file form-control " id="image">
                                        <input class="custom-file-input @error('files') is-valid @enderror " id="customFile" type="file" name="files[]"  multiple directory="" webkitdirectory="" moxdirectory=""  >
                                        <label class="custom-file-label " for="customFile" style="text-align: left">Choose file</label>
                                        @error('files')
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
                                <div class="form-group col-md-3 mr-md-2">
                                    <button type="submit" class="btn btn-block btn-success">حفظ</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
