@include('backoffice.documentmenu')
<br/>

<span class="title">Create new Documentation</span>
<br/>
<br/>


<div class="two-col-panel">

    <div class="left-panel">

        @foreach ($activecategories as $activecategory)
        <ul>
            <li>
                <a class="button_normal" href="{{ url('adminDocumentation/new/'. $activecategory->id )}}"
                   role="button">{{$activecategory->category}}</a>
            </li>
        </ul>
        @endforeach

    </div>

    <div class="right-panel">

        @if ($subcategories == null)


        @else

        {{ Form::open(array('url'=>'adminDocumentation/createdocumentation', 'class'=>'')) }}

        {{ Form::select('subcategoryId', $subcategories, null, array('class' => 'form-control')) }}
        <br/>
        {{ Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) }}
        <br/>
        {{ Form::textarea('content', null, array('class'=>'form-control', 'placeholder'=>'Content goes here')) }}<br/>
        {{ Form::hidden('categoryId', $category_id) }}
        {{ Form::submit('Create', array('class'=>'button_normal'))}}

        {{ Form::close() }}


        @endif

    </div>
</div>















