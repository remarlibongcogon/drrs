@props(['response', 'color' => 'danger'])
@if(session($response))
    <div class="alert alert-{{ $color }} alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ session($response) }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif