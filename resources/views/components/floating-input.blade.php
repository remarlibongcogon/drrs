@props(['type', 'name', 'label'])
<div class="form-floating mb-3">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" class="form-control" placeholder="Username" autocomplete="off" required>
    <label for="floatingInput">{{ $label }}</label>
</div>