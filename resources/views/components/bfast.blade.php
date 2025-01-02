@props(['datas', 'label', 'namePrefix', 'bfastValues' => null, 'readOnly' => false])
<div class="col-12 col-md-6 mb-2">
    <div class="form-check">
        <h6>{{ $label }}</h6>
        @foreach ($datas as $data)
            <div class="form-check">
                <!-- General checkbox -->
                <input class="form-check-input" type="checkbox" value=1 id="{{ $data['name'] }}" name="{{ $namePrefix }}[{{ $data['name'] }}]" {{ $readOnly ? 'disabled' : ''}} {{ (isset($bfastValues[$data['name']]) && $bfastValues[$data['name']] == 1) ||(isset($bfastValues[$data['name']]) && $data['name'] == 'T' && !is_null($bfastValues['T'])) ? 'checked' : ''}}>
                <label class="form-check-label" for="{{ $data['name'] }}">
                    {{ $data['name'] }}
                </label>

                <!-- Show input field when "T" is selected -->
                @if ($data['name'] === 'T')
                    <div class="form-check ms-4">
                    <input 
                            class="form-control" 
                            type="time" 
                            name="{{ $namePrefix }}_T" 
                            placeholder="Specify T" 
                            id="{{ $data['name'] }}_input" 
                            {{ $readOnly ? 'readonly' : ''}}
                            value="{{ $bfastValues['T'] ?? '' }}"
                            {{ (!isset($bfastValues['T']) || empty($bfastValues['T'])) ? 'disabled' : '' }}
                        >
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tCheckbox = document.getElementById('T'); // Target the checkbox for "T"
        const tInputField = document.getElementById('T_input'); // Target the input field for "T"

        // Check if the "T" checkbox is selected on page load
        if (tCheckbox.checked) {
            tInputField.disabled = false; // Enable input if checked
        } else {
            tInputField.disabled = true; // Disable input if not checked
        }

        // Add event listener to toggle the disabled state based on checkbox selection
        tCheckbox.addEventListener('change', function () {
            if (tCheckbox.checked) {
                tInputField.disabled = false; // Enable input when checked
            } else {
                tInputField.disabled = true; // Disable input when unchecked
            }
        });
    });
</script>
