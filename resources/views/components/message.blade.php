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
    <div class="alert alert-danger float-message" role="alert">
        <div>
            {{session('error')}}
        </div>
        <button type="button" class="close-message">
            <i class="fa fa-xmark"></i>
        </button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning float-message" role="alert">
        <div>
            {{session('warning')}}
        </div>
        <button type="button" class="close-message">
            <i class="fa fa-xmark"></i>
        </button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info float-message" role="alert">
        <div>
            {{session('info')}}
        </div>
        <button type="button" class="close-message">
            <i class="fa fa-xmark"></i>
        </button>
    </div>

@endif
