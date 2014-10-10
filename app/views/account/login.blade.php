

<span class="main-title">登入</span>
<br/>

<div class="two-col">


	<div class="left">
		<span class="title">社交網絡登入</span>
		<br/>
		<br/>
		<ul class="horizonal-list center">
            <li><a href="{{ url('oauth/facebook')}}" > <i class="icon-facebook-dark"></i><span class="std-bold"> facebook </span></a></li>
            <li class="std-bold">|</li>
            <li><a href="{{ url('oauth/google')}}" ><i class="icon-google-dark"></i><span class="std-bold"> google </span></a></li>
        </ul>

    </div>



    <div class="right">


      <span class="title">Nestq 登入</span>
      <br/>
      <br/>

      {{ Form::open(array('url'=>'account/signin', 'class'=>'form-inline')) }}







      <div class="form-group">
         <label for="inputEmail" class="sr-only">Email</label>
         <div class="col-sm-9">
            {{ Form::text('email', null, array('id' => 'inputEmail' , 'class'=>'form-control', 'placeholder'=>'email')) }}
        </div>
    </div>

    <div class="form-group">
     <label for="inputPassword" class="sr-only">密碼</label>
     <div class="col-sm-9">
        {{ Form::password('password', array('id' => 'inputPassword' , 'class'=>'form-control', 'placeholder'=>'password')) }}
    </div>
</div>

<div class="form-group">
 <div class="col-sm-offset-3 col-sm-9">
    {{ Form::submit('登入', array('class'=>'button_normal'))}}
    {{ Form::close() }}
</div>
</div>


<br/>


{{ HTML::link('account/forgetpassword', '忘記密碼 ?') }}
</div>



</div>






