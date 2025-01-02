@props(['datas', 'label', 'namePrefix'])
<div class="col-12 col-md-6 mb-2">
    <div class="form-check">
        <h6>{{ $label }}</h6>
        @foreach ($datas as $data)
            <div class="form-check">
                <!-- General checkbox -->
                <input class="form-check-input" type="text" value=1 id="{{ $data['name'] }}" name="{{ $namePrefix }}[{{ $data['name'] }}]">
                <label class="form-check-label" for="{{ $data['name'] }}">
                    {{ $data['name'] }}
                </label>

                <!-- Show input field when "T" is selected -->
                @if ($data['name'] === 'T')
                    <div class="form-check ms-4">
                        <input class="form-control" type="time" name="{{ $namePrefix }}_T" placeholder="Specify T" id="{{ $data['name'] }}_input" disabled>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>