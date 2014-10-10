

<span class="main-title">注冊</span>
<br/>


<div class='two-col'>



    <div class='left'>

    <span class="title">幫助您搜尋丶傳遞物業資訊</span>
        <br/>
        <br/>

        會員均可享受到以下功能 :

        <ul>
            <li>發佈2則物業資訊</li>
            <li>找尋合適的物業代理</li>
            <li>免費使用即時通服務，更快地接洽買家丶物理代理</li>
        </ul>
  <br/>
        <div class="media">
          <a class="pull-left" href="{{ url('inquiry/guide')}}">
            <i class="icon-user-guide"></i>
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="{{ url('inquiry/guide')}}" ><span class="underline">用戶指南</span></a></h4>
            瀏覽用戶指南，了解更多！
        </div>
    </div>



</div>







<div class='right'>


    <span class="title">社交網絡注冊</span>
    <br/>
    <br/>
    <ul class="horizonal-list center">


        <li><a href="{{ url('oauth/facebook')}}" > <i class="icon-facebook-dark"></i><span class="std-bold"> facebook </span></a></li>
        <li class="std-bold">|</li>
        <li><a href="{{ url('oauth/google')}}" ><i class="icon-google-dark"></i><span class="std-bold"> google </span></a></li>
    </ul>
    <br/>
    <div class="center std-bold"> -- 或 -- </div>
    <br/>


    <span class="title">注冊表</span>


    {{ Form::open(array('url'=>'account/create', 'class'=>'form-horizontal')) }}

    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>



    <div class="form-group">
      <label for="inputFirstname" class="col-sm-2 control-label">名字</label>
      <div class="col-sm-4">
        {{Form::text('firstname', null, array('id' => 'inputFirstname' , 'class'=>'form-control', 'placeholder'=>'名字'))}}
    </div>
    <label for="inputLastname" class="col-sm-2 control-label">姓氏</label>
  <div class="col-sm-4">
    {{ Form::text('lastname', null, array('id' => 'inputLastname' , 'class'=>'form-control', 'placeholder'=>'姓氏')) }}
</div>
</div>


<div class="form-group">
  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
  <div class="col-sm-10">
    {{ Form::text('email', null, array('id' => 'inputEmail' , 'class'=>'form-control', 'placeholder'=>'email')) }}
</div>
</div>

<div class="form-group">
  <label for="inputPhone" class="col-sm-2 control-label">電話</label>
  <div class="col-sm-10">
    {{ Form::text('tel', null, array('id' => 'inputPhone' , 'class'=>'form-control', 'placeholder'=>'號碼')) }}
</div>
</div>

<div class="form-group">
  <label for="inputPassword" class="col-sm-2 control-label">密碼</label>
  <div class="col-sm-10">
    {{ Form::password('password', array('id' => 'inputPassword' , 'class'=>'form-control', 'placeholder'=>'密碼')) }}
</div>
</div>

<div class="form-group">
  <label for="inputConfirmPassword" class="col-sm-2 control-label">密碼確認</label>
  <div class="col-sm-10">
      {{ Form::password('password_confirmation', array('id' => 'inputConfirmPassword' , 'class'=>'form-control', 'placeholder'=>'重新輸入密碼')) }}
  </div>
</div>

<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    {{Form::hidden('identity', 'user')}}
    {{Form::submit('提交', array('class'=>'button_normal'))}}
    {{Form::close()}}
</div>
</div>






</div>


</div>