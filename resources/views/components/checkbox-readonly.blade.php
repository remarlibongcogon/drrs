@props(['label', 'datas', 'namePrefix', 'consciousnessStatus'])
<div class="col-12 col-md-6 mb-2">
    <div class="form-check">
        <h6>{{ $label }}</h6>
        @foreach ($datas as $data)
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    value="1" 
                    id="{{ $data['id'] }}" 
                    name="{{ $namePrefix }}[{{ $data['name'] }}]" 
                    @if(isset($consciousnessStatus[$data['name']]) && $consciousnessStatus[$data['name']] == 1) checked @endif 
                    disabled>
                <label class="form-check-label" for="{{ $data['id'] }}">
                    {{ $data['name'] }}
                </label>
            </div>
        @endforeach
    </div>
</div>
