
@include('backoffice.documentmenu')

<br/>
<span class="title">Create new Documentation</span>

<br/>
<br/>

{{ Form::open(array('url'=>'adminDocumentation/createDocumentation', 'class'=>'')) }}


<div class="full-width">


    {{ Form::select('subcategoryId', $subcategories, null, array('class' => 'form-control')) }}
    <br/>
    {{ Form::text('title', null, array('class'=>'input-block-level full-width', 'placeholder'=>'Title')) }}
    <br/>
    <br/>
    {{ Form::textarea('content', null, array('class'=>'input-block-level full-width', 'placeholder'=>'Content goes here')) }}<br/>
    {{ Form::submit('Create', array('class'=>'button_normal'))}}

    {{ Form::close() }}


</div>


