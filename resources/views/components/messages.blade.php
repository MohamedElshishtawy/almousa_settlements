@if(session('success'))
    <div class="alert alert-success text-right my-4">{{session('success')}}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-right my-4">{{session('error')}}</div>
@endif

@if(session('message'))
    <div class="alert alert-info text-right my-4">{{session('message')}}</div>
@endif
