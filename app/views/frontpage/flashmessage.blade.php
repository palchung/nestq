

<!-- error message -->
@if (Session::has('flash_message'))



<!-- <div class="flash-message">
	<i class="icon-flesh-message"></i><b>{{ Session::get('flash_message') }}</b>
</div> -->




<div class="flash-message">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Hey! </strong> {{ Session::get('flash_message') }}
</div>





{{Session::forget('flash_message')}}
@endif