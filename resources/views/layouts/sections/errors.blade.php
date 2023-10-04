@if(Session::has('success'))
    <div class="col-md-12 m-1">
        <h5 class="alert alert-success text-muted">{{Session::get('success')}}</h5>
    </div>
@endif
@if(Session::has('failed'))
    <div class="col-md-12 m-1">
        <h5 class="alert alert-danger text-muted">{{Session::get('failed')}}</h5>
    </div>
@endif
