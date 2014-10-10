







<div class="jumbotron">
	<span class="main-title">Nestq</span>
	<p>
		{{ Form::open(array('url'=>'backoffice/login', 'class'=>'')) }}

		{{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
		{{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}

		{{ Form::submit('Login', array('class'=>'button_normal'))}}
		{{ Form::close() }}

	</p>

</div>





