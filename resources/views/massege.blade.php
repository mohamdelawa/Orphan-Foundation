
@if(Session::has('success'))

        <div class="card bg-success col-md-12">
            <div class="card-tools ">
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body" >
                <h5  style="text-align: right">
                {{Session::get('success')}}
                </h5>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
@endif
@if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{Session::get('error')}}
    </div>
@endif
