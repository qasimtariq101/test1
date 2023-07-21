@if(session('success'))
<div class="alert ct-alert-1 style-02">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  @php echo html_entity_decode(session('success')) @endphp
</div>
@endif
@if(session('status') && !session('warning'))
<div class="alert ct-alert-1 style-02">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  @php echo html_entity_decode(session('status')) @endphp
</div>
@endif
@if(session('info'))
<div class="alert ct-alert-1 style-04">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  @php echo html_entity_decode(session('info')) @endphp
</div>
@endif
@if(session('warning'))
<div class="alert ct-alert-1 style-05">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  @php echo html_entity_decode(session('warning')) @endphp
</div>
@endif
@if (count($errors) == 1)
<div class="alert ct-alert-1 style-03">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
       @php echo html_entity_decode( $error ) @endphp
    @endforeach
</div>
@elseif(count($errors) > 1)
<div class="alert ct-alert-1 style-03">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
    @foreach ($errors->all() as $error)
        <li>@php echo html_entity_decode( $error ) @endphp</li>
    @endforeach
    </ul>
</div>
@endif
<div id="response" class="hidden"></div>