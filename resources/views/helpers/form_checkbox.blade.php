<label class="custom-control custom-checkbox">
    {{-- <input type="checkbox" name="{{$name}}" value="" class="custom-control-input" --}}
    <input onchange="this.form.submit()" type="checkbox" value="{{$id}}" class="custom-control-input"
        @if ($skill)
            name="skills[{{$name}}]"
        @else
            name="{{$name}}"
        @endif
        @if(old('skills') && $skill)
            @if(array_key_exists($name, old('skills')))
                checked="checked"
            @endif
        @else
            @if(old($name))
                checked="checked"
            @endif
        @endif
    >
    <span class="custom-control-indicator"></span>
    <span class="custom-control-description">{!! $display !!}</span>
</label>
