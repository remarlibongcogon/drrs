@props(['inputs', 'label', 'ErrorMessage'])
<div class="container d-flex row align-items-center">
   <label for="{{ $label }}" class="form-label col-12 text-start">
      {{ $label }}
      <span class="text-danger">&nbsp;*</span>
   </label>
   @foreach ($inputs as $input)
      <div class="col-{{ $input['size'] }} col-md-{{ $input['SizeMd'] }} mb-2">
         @switch ($input['type'])
            @case ('text')
            @case ('number')
               <input type="{{ $input['type'] }}" name="{{ $input['name'] }}" class="form-control" 
                      data-field
                      {{ isset($input['limit']) ? 'maxlength=' . $input['limit'] : '' }} 
                      {{ isset($input['required']) && $input['required'] ? 'required' : '' }}>
               <small class="text-primary d-flex justify-content-start">{{ $input['label'] }}</small>
               <div class="invalid-feedback">
               </div>
            @break
            @case ('select')
               <select name="{{ $input['name'] }}" id="{{ $input['name'] }}" class="form-select text-primary" data-field 
                       {{ isset($input['required']) && $input['required'] ? 'required' : '' }}>
                  <option value="" selected hidden disabled>Please Select</option>
                  @foreach ($input['options'] as $option)
                     <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                  @endforeach
               </select>
               <small class="text-primary">{{ $input['label'] }}</small>
               <div class="invalid-feedback">
               </div>
            @break
            @case ('date')
               <input type="{{ $input['type'] }}" name="{{ $input['name'] }}" class="form-control text-primary" data-field 
                      {{ isset($input['required']) && $input['required'] ? 'required' : '' }}>
               <small class="text-primary">{{ $input['label'] }}</small>
               <div class="invalid-feedback">
               </div>
            @break
         @endswitch
      </div> 
   @endforeach
</div>
