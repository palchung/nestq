







<span class="title">登入</span>
        <br/>
        <br/>

<div class="two-col-panel">

<div class="left-panel">
        {{ Form::open(array('url'=>'backoffice/login', 'class'=>'form-horizontal')) }}

        <div class="form-group">
            <label for="inputEmail" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                {{ Form::text('email', null, array('id' => 'inputEmail' , 'class'=>'form-control', 'placeholder'=>'email')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-sm-3 control-label">密碼</label>
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


  </div>

  <div class="right-panel">

  </div>




  </div>