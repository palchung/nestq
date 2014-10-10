

<span class="title">賬號管理</span>



<div class="two-col-panel">


    <div class="left-panel">

        <p>

        </p>

    </div>








    <div class="right-panel">

        <div class="std-border white-bg std-padding">


            <a class="advanceSearch" href="#" ng-click="isCollapsed = !isCollapsed">
                <span class="searchbox-title std-bold">更改密碼</span></a>
                <br/>
                <br/>
                <div collapse="!isCollapsed">


                    <!-- change password -->

                    {{ Form::open(array('url'=>'account/changepassword', 'class'=>'form-horizontal')) }}


                    <div class="form-group">
                        <label for="existingPassword" class="col-sm-3 control-label">密碼</label>
                        <div class="col-sm-9">
                            {{ Form::password('existing', array('id' => 'existingPassword' , 'class'=>'form-control', 'placeholder'=>'輸入現時的密碼')) }}
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-3 control-label">新密碼</label>
                        <div class="col-sm-9">
                            {{ Form::password('newPassword', array('id' => 'inputPassword' , 'class'=>'form-control', 'placeholder'=>'輸入新密碼')) }}
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="inputConfirmPassword" class="col-sm-3 control-label">確認新密碼</label>
                      <div class="col-sm-9">
                        {{ Form::password('password_confirmation', array('id' => 'inputConfirmPassword' , 'class'=>'form-control', 'placeholder'=>'再輸入新密碼')) }}
                    </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    {{ Form::submit('變更', array('class'=>'button_normal'))}}
                    {{ Form::close() }}
                </div>
            </div>

            <hr/>

        </div>


        <span class="sub-title">個人資料</span>
        <br/>
        <br/>


        <div class="two-col-panel">


            <div class="left-panel center">

                @if($account->profile_pic)
                {{ HTML::image('profilepic/' . $account->profile_pic, $account->firstname . $account->lastname, array('class' => '')) }}
                @else
                <i class="icon-user-5x"></i>
                @endif

            </div>
            <div class="right-panel">
                <span class="std-bold">上傳頭像相片</span> <br/> <br/>
                {{ Form::open(array('url'=>'account/profilepic','files'=>true)) }}


                {{ Form::file('profilePic','',array('id'=>'','class'=>'')) }}
                <br/>
                <!-- submit buttons -->
                {{ Form::submit('儲存', array('class'=>'button_normal'))}}
                <!-- reset buttons -->
                {{ Form::reset('重設', array('class'=>'button_normal')) }}

                {{ Form::close() }}
            </div>
        </div>




        <hr/>

        {{ Form::open(array('url'=>'account/create', 'class'=>'form-horizontal')) }}



        <div class="form-group">
          <label for="inputFirstname" class="col-sm-2 control-label">名字</label>
          <div class="col-sm-4">
              {{Form::text('firstname', $account->firstname, array('id' => 'inputFirstname' , 'class'=>'form-control', 'placeholder'=>'名字'))}}
          </div>
          <label for="inputLastname" class="col-sm-2 control-label">姓名</label>
          <div class="col-sm-4">
            {{ Form::text('lastname', $account->lastname, array('id' => 'inputLastname' , 'class'=>'form-control', 'placeholder'=>'姓名')) }}
        </div>
    </div>


    <div class="form-group">
      <label for="inputEmail" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        {{ Form::text('email', $account->email, array('id' => 'inputEmail' , 'class'=>'form-control', 'placeholder'=>'email')) }}
    </div>
</div>

<div class="form-group">
  <label for="inputPhone" class="col-sm-2 control-label">電話</label>
  <div class="col-sm-10">
    {{ Form::text('tel', $account->tel, array('id' => 'inputPhone' , 'class'=>'form-control', 'placeholder'=>'號碼')) }}
</div>
</div>


@if( $account->identity == 1)



<div class="form-group">
  <label for="inputCellPhone" class="col-sm-2 control-label">手機</label>
  <div class="col-sm-10">
    {{ Form::text('cell_tel', $account->cell_tel, array('id' => 'inputCellPhone' , 'class'=>'form-control', 'placeholder'=>'號碼')) }}
</div>
</div>


<div class="form-group">
  <label for="inputLicense" class="col-sm-2 control-label">代理牌照</label>
  <div class="col-sm-10">
    {{ Form::text('license', $account->license, array('id' => 'inputLicense' , 'class'=>'form-control', 'placeholder'=>'牌照號碼')) }}
</div>
</div>


<div class="form-group">
  <label for="inputCompany" class="col-sm-2 control-label">公司 (opional)</label>
  <div class="col-sm-10">
    {{ Form::text('company', $account->company, array('id' => 'inputCompany' , 'class'=>'form-control', 'placeholder'=>'公司')) }}
</div>
</div>

<div class="form-group">
  <label for="inputDescription" class="col-sm-2 control-label">自我介紹</label>
  <div class="col-sm-10">
    {{ Form::textarea('description', $account->description, array('id' => 'inputDescription' , 'class'=>'form-control', 'placeholder'=>'入行年資 經驗 負責地區等')) }}
</div>
</div>




{{ Form::hidden('identity', 'agent') }}
@else
{{ Form::hidden('identity', 'user') }}
@endif

<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    {{ Form::submit('變更', array('class'=>'button_normal'))}}
    {{ Form::close() }}
</div>
</div>


</div>

</div>




</div>










