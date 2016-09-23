<textarea name="{{$name}}" id="ckeditor" rows="10" cols="80" id="{{$name}}" placeholder="{{$placeholder}}">
  {{$content}}
</textarea>
<script>
    CKEDITOR.replace( 'ckeditor' );
</script>
