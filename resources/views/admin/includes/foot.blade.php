<!-- SCRIPTS -->
@yield('before_scripts') 
<script src="{{url('js/jquery-3.3.1.min.js')}}"></script> 
<script src="{{url('mdb/js/popper.min.js')}}"></script> 
<script src="{{url('mdb/js/bootstrap.min.js')}}"></script> 
<script src="{{url('mdb/js/mdb.min.js')}}"></script> 
<script src="{{url('vendor/select2/select2.min.js')}}"></script> 
<script src="{{url('mdb/js/admin.min.js?v=1.1')}}"></script> 
@yield('after_scripts') 
<script type="text/javascript">
new WOW().init();   
$(document).ready(function() {
    $('.select2').select2();

});

@if(count($errors) > 0)
    @foreach($errors->getMessages() as $key => $message)
        if($('[name="{{$key}}"]').length > 0){
          $('[name="{{$key}}"]').addClass('is-invalid');
          $('[name="{{$key}}"]').parent().append('<div class="invalid-feedback">{{$message[0]}}</div>');
        }
    @endforeach
@endif
</script>
{!! html_entity_decode(config('settings.analytics_code')) !!}
{!! html_entity_decode(config('settings.footer_code')) !!}