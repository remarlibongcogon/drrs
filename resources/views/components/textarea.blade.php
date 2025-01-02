@props(['label', 'name', 'value' => null])
<div class="col-12 mb-2">
    <label for="{{ $name }}" class="mb-2 d-flex justify-content-start text-primary">{{ $label }}</label>
    <textarea name="{{ $name }}" class="form-control" id="remarks" cols="30" rows="5" style="resize: none;">
        {{ $value }}
    </textarea>        
</div>