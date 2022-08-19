






<span class="main-title">注冊</span>
<br/>

<div class="two-col">


    <div class="left">

        <span class="title">幫助您促成交易</span>
        <br/>
        <br/>

        物業代理會員均可享受到以下功能 :

        <ul>
            <li>無限次發佈物業資訊</li>
            <li>直接於網上邀請業主放盤</li>
            <li>使用即時通服務，更快地接洽客戶丶業主</li>
        </ul>
        <br/>
        <p>
            Nestq 亦幫助您，主動地把物業資訊透過
            <span class="color-secondary">active mail</span>， <span class="color-secondary">active push</span> 功能推送給目標客群。
        </p>
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






    <div class="right">
        {{ Form::open(array('url'=>'account/create', 'class'=>'form-horizontal')) }}


        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>




        <div class="form-group">
            <label for="inputFirstname" class="col-sm-2 control-label">名字</label>
            <div class="col-sm-4">
                {{ Form::text('firstname', null, array('id' => 'inputFirstname' , 'class'=>'form-control', 'placeholder'=>'名字')) }}
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
            <label for="inputCellPhone" class="col-sm-2 control-label">手提電話</label>
            <div class="col-sm-4">
                {{ Form::text('cell_tel', null, array('id' => 'inputCellPhone' , 'class'=>'form-control', 'placeholder'=>'號碼')) }}
            </div>
            <label for="inputPhone" class="col-sm-2 control-label">電話</label>
            <div class="col-sm-4">
                {{ Form::text('tel', null, array('id' => 'inputPhone' , 'class'=>'form-control', 'placeholder'=>'號碼')) }}
            </div>
        </div>


        <div class="form-group">
            <label for="inputLicense" class="col-sm-2 control-label">代理牌照</label>
            <div class="col-sm-10">
                {{ Form::text('license', null, array('id' => 'inputLicense' , 'class'=>'form-control', 'placeholder'=>'牌照號碼')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputCompany" class="col-sm-2 control-label">公司 (opional)</label>
            <div class="col-sm-10">
                {{ Form::text('company', null, array('id' => 'inputCompany' , 'class'=>'form-control', 'placeholder'=>'公司')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputDescription" class="col-sm-2 control-label">自我介紹</label>
            <div class="col-sm-10">
                {{ Form::textarea('description', null, array('id' => 'inputDescription' , 'class'=>'form-control', 'placeholder'=>'入行年資 經驗 負責地區等')) }}
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
                {{ Form::hidden('identity', 'agent') }}
                {{ Form::honeypot('my_name', 'my_time') }}
                {{ Form::submit('提交', array('class'=>'button_normal'))}}
                {{ Form::close() }}
            </div>
        </div>


    </div>

</div>


