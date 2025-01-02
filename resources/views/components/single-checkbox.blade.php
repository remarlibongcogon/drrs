@props(['label', 'name', 'mdSize' => 6, 'checked' => false])
<div class="col-12 col-md-{{ $mdSize }} ">
    <div class="form-check d-flex align-items-center">
        {{-- <h6>{{ $label }}</h6> --}}
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="{{ $name }}" name="{{ $name }}" @if($checked) checked @endif>
            <label class="form-check-label" for="{{ $name }}">
                {{ $label }}
            </label>
        </div>
    </div>
</div>
