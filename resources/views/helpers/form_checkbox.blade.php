<label class="custom-control custom-checkbox">
  {{-- <input type="checkbox" name="{{$name}}" value="" class="custom-control-input" --}}
  <input type="checkbox" name="skills[{{$name}}]" value="{{$id}}" class="custom-control-input"
    @if(old('skills'))
      @if(array_key_exists($name, old('skills')))
        checked="checked"
      @endif
    @endif
    >
  <span class="custom-control-indicator"></span>
  <span class="custom-control-description">{{$display}}</span>
</label>
