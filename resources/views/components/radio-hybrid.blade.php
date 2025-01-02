@props(['datas', 'label', 'name' , 'fieldValues' => null ,'readOnly' => false])

<div class="col-12 col-md-6 mb-2">
    <h6>{{ $label }}</h6>

    @foreach ($datas as $data)
        <div class="form-check">
           
            <!-- Parent radio button -->
            <input class="form-check-input" type="radio" value="{{ $data['id'] }}" name="{{ $name }}" id="{{ strtolower($data['name']) }}" {{ $readOnly ? 'disabled' : '' }} {{ isset($fieldValues[strtolower($data['name'])]) && $fieldValues[strtolower($data['name'])] ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ strtolower($data['name']) }}">
                {{ $data['name'] }}
            </label>

            <!-- for broken -->
            @if ($data['name'] === 'Broken')
                <input class="form-control" type="text" name="{{ $name }}_broken" placeholder="" id="{{ strtolower($data['name']) }}_input" {{ isset($fieldValues['broken']) ? 'value=' . $fieldValues['broken'] : '' }}>
            @endif

            @isset($data['subdata'])
                <div class="sub-options ms-4"> 
                    
                    @foreach ($data['subdata'] as $subdata)
                        <div class="form-check ms-3">
                            <input class="form-check-input" type="radio" value="{{ $subdata['id'] }}" name="{{ $name }}_sub" id="{{ strtolower($subdata['name']) }}" {{ $readOnly ? 'disabled' : '' }}
                            {{ isset($fieldValues['vehicular']) && $fieldValues['vehicular'] == $subdata['id'] ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="{{ strtolower($subdata['name']) }}">
                                {{ $subdata['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endisset
        </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the "broken" radio and input elements
    const brokenRadio = document.getElementById('{{ strtolower($datas[3]['name']) }}'); 
    const brokenInput = document.getElementById('{{ strtolower($datas[3]['name']) }}_input');

    // Function to toggle the "broken" input field's disabled state
    function toggleBrokenInput() {
        if (brokenRadio.checked) {
            brokenInput.disabled = false;
            brokenInput.placeholder = "Specify Broken Part";
        } else {
            brokenInput.disabled = true;
            brokenInput.value = '';
            brokenInput.placeholder = "";
        }
    }

    // Get the "vehicular" radio button and the subtypes
    const vehicularRadio = document.getElementById('{{ strtolower($datas[0]['name']) }}'); 
    const vehicularSubTypes = document.getElementsByName('{{ $name }}_sub');
    console.log(vehicularSubTypes);

    function toggleVehicularSubTypes() {
        if (vehicularRadio.checked) {
            vehicularSubTypes.forEach(function(subType) {
                subType.disabled = false;  // Enable subtypes if vehicular radio is checked
            });
        } else {
            vehicularSubTypes.forEach(function(subType) {
                subType.disabled = true;   // Disable subtypes if vehicular radio is unchecked
                subType.checked = false;   // Uncheck subtypes when disabled
            });
        }
    }

    vehicularRadio.addEventListener('change', toggleVehicularSubTypes);

    toggleVehicularSubTypes();
    toggleBrokenInput();

    const radios = document.getElementsByName('{{ $name }}');
    radios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            toggleBrokenInput();       // Update broken input state
            toggleVehicularSubTypes(); // Update vehicular subtypes state
        });
    });
});
</script>

