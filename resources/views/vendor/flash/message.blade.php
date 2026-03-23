
@if(session()->has('flash_notification'))
    @foreach (session('flash_notification') as $message)
        <div class="alert alert-{{ $message['level'] }} alert-dismissible fade show" role="alert">
            {!! $message['message'] !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endforeach
@endif