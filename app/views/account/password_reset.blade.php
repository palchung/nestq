


<span class="main-title">重設密碼</span>
<br/>
<br/>

<div class="two-col-panel">

<div class="left-panel">







        <div class="media">
              <a class="pull-left" href="{{ url('inquiry/guide')}}">
                <i class="icon-user-guide"></i>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a href="{{ url('inquiry/guide')}}" ><span class="underline">用戶指南</span></a></h4>
                如有疑問，可到我們的用戶指南了解更多。
            </div>
        </div>




</div>

<div class="right-panel">




                {{ Form::open(array('action' => 'RemindersController@postReset', 'method' => 'post','class'=>'form-horizontal', "autocomplete" => "off")) }}

                <div class="form-group">
                      <label for="inputEmail" class="col-sm-3 control-label">電郵地址</label>
                        <div class="col-sm-6">
                            {{ Form::text('email', null, array('id' => 'inputEmail' , 'class'=>'form-control', 'placeholder'=>'用以登入 Nestq 的電郵地址')) }}
                        </div>
                </div>

                <div class="form-group">
                      <label for="inputPassword" class="col-sm-3 control-label">密碼</label>
                        <div class="col-sm-6">
                            {{ Form::password('password', array('id' => 'inputPassword' , 'class'=>'form-control', 'placeholder'=>'輸入新密碼')) }}
                        </div>
                </div>

                <div class="form-group">
                      <label for="inputConfirmPassword" class="col-sm-3 control-label">確認新密碼</label>
                        <div class="col-sm-6">
                            {{ Form::password('password_confirmation', array('id' => 'inputConfirmPassword' , 'class'=>'form-control', 'placeholder'=>'再輸入新密碼')) }}
                        </div>
                </div>

                <hr/>

                <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                {{ Form::hidden('token', $token) }}
                                                {{ Form::submit('提交', array('class'=>'button_normal'))}}
                                                {{ Form::close() }}
                            </div>
                        </div>







</div>






</div>











