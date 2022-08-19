<span class="title">Edit Account</span>


<div class="two-col">


    <div class="left">

        <span class="sub-title">
            Some text here
        </span>

        <p>
            some text goes here
        </p>

    </div>


    <div class="right">


        <!-- change password -->

        {{ Form::open(array('url'=>'account/changepassword', 'class'=>'form-horizontal')) }}


        <div class="form-group">
            <label for="existingPassword" class="col-sm-3 control-label">Existing Password</label>

            <div class="col-sm-9">
                {{ Form::password('existing', array('id' => 'existingPassword' , 'class'=>'form-control',
                'placeholder'=>'existing Password')) }}
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword" class="col-sm-3 control-label">New Password</label>

            <div class="col-sm-9">
                {{ Form::password('newPassword', array('id' => 'inputPassword' , 'class'=>'form-control',
                'placeholder'=>'New Password')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputConfirmPassword" class="col-sm-3 control-label">Confirm Password</label>

            <div class="col-sm-9">
                {{ Form::password('password_confirmation', array('id' => 'inputConfirmPassword' ,
                'class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                {{ Form::submit('Change', array('class'=>'button_normal'))}}
                {{ Form::close() }}
            </div>
        </div>


        <hr/>


        <span class="sub-title">Basic Information</span>


        <!-- Basic information -->
        {{ Form::open(array('url'=>'account/create', 'class'=>'form-horizontal')) }}


        <div class="form-group">
            <label for="inputFirstname" class="col-sm-3 control-label">Firstname</label>

            <div class="col-sm-9">
                {{Form::text('firstname', $account->firstname, array('id' => 'inputFirstname' , 'class'=>'form-control',
                'placeholder'=>'First Name'))}}
            </div>
        </div>

        <div class="form-group">
            <label for="inputLastname" class="col-sm-3 control-label">Lastname</label>

            <div class="col-sm-9">
                {{ Form::text('lastname', $account->lastname, array('id' => 'inputLastname' , 'class'=>'form-control',
                'placeholder'=>'Last name')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-sm-3 control-label">Email</label>

            <div class="col-sm-9">
                {{ Form::text('email', $account->email, array('id' => 'inputEmail' , 'class'=>'form-control',
                'placeholder'=>'email')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputPhone" class="col-sm-3 control-label">Phone</label>

            <div class="col-sm-9">
                {{ Form::text('tel', $account->tel, array('id' => 'inputPhone' , 'class'=>'form-control',
                'placeholder'=>'Phone')) }}
            </div>
        </div>


        @if( $account->identity == 1)


        <div class="form-group">
            <label for="inputCellPhone" class="col-sm-3 control-label">Cell Phone</label>

            <div class="col-sm-9">
                {{ Form::text('cell_tel', $account->cell_tel, array('id' => 'inputCellPhone' , 'class'=>'form-control',
                'placeholder'=>'Cell Phone')) }}
            </div>
        </div>


        <div class="form-group">
            <label for="inputLicense" class="col-sm-3 control-label">License</label>

            <div class="col-sm-9">
                {{ Form::text('license', $account->license, array('id' => 'inputLicense' , 'class'=>'form-control',
                'placeholder'=>'License')) }}
            </div>
        </div>


        <div class="form-group">
            <label for="inputCompany" class="col-sm-3 control-label">Company (opional)</label>

            <div class="col-sm-9">
                {{ Form::text('company', $account->company, array('id' => 'inputCompany' , 'class'=>'form-control',
                'placeholder'=>'Company')) }}
            </div>
        </div>

        <div class="form-group">
            <label for="inputDescription" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-9">
                {{ Form::textarea('description', $account->description, array('id' => 'inputDescription' ,
                'class'=>'form-control', 'placeholder'=>'description')) }}
            </div>
        </div>


        {{ Form::hidden('identity', 'agent') }}
        @else
        {{ Form::hidden('identity', 'user') }}
        @endif

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                {{ Form::submit('Edit', array('class'=>'button_normal'))}}
                {{ Form::close() }}
            </div>
        </div>


    </div>


</div>










