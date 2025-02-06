@props(['type' => 'success', 'message' => 'تم'])

@if(session('success'))
    <div class="alert alert-success float-message" role="alert">
        <div>
            {{session('success')}}
        </div>
        <button type="button" class="close-message">
            <i class="fa fa-xmark"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-right my-4">{{session('error')}}</div>
@endif

@if(session('message'))
    <div class="alert alert-info text-right my-4">{{session('message')}}</div>
@endif
