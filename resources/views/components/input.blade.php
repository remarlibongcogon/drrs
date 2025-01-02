@props([
    'type', 
    'name', 
    'label', 
    'value' => '', 
    'required' => false, 
    'readOnly' => false, 
    'mdSize' => 6, 
    'accept' => '', 
    'minLength' => null, 
    'maxLength' => null,
    'min' => null, 
    'max' => null,
    'pattern' => null,
    'dNone' => false
])

<div class="col-12 col-md-{{ $mdSize }} mb-2 {{ $dNone ? 'd-none' : '' }}">
    <input 
        type="{{ $type }}" 
        class="form-control" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ $value }}" 
        @if($required) required @endif 
        {{ $readOnly ? 'readOnly' : ''}}  
        @if($accept) accept="{{ $accept }}" @endif
        @if($minLength) minlength="{{ $minLength }}" @endif
        @if($maxLength) maxlength="{{ $maxLength }}" @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($pattern) pattern="{{ $pattern }}" @endif
    >

    <small for="{{ $name }}" class="px-2 d-flex justify-content-start text-primary">{{ $label }}</small>

    <div class="invalid-feedback text-start">
        <i class="bi bi-exclamation-circle-fill"></i>
        @if($required)
            This field is required
        @else
            Incorrect value for mobile number
        @endif
    </div>
</div>