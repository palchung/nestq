
@include('backoffice.documentmenu')
<br/>


<span class="main-title">Sub-Category Management</span>
<br/>
<br/>


<div class="two-col-panel">
    <div class="left-panel">

        @foreach ($activecategories as $activecategory)

        <ul>
            <li>
                <a class="button_normal" href="{{ url('adminDocumentation/subcategory/'. $activecategory->id )}}" role="button">{{$activecategory->category}}</a>
            </li>
        </ul>


        @endforeach


    </div>

    <div class="right-panel std-border white-bg std-padding">


        @if ($subcategories == null)


        @else


        <span class="title">Create Sub-Category</span>
        <br/>
        <br/>
        <table class="form-table">
            {{ Form::open(array('url'=>'adminDocumentation/createsubcategory', 'class'=>'')) }}
            <tbody>
            <tr>
                <td> Sub-Category</td>
                <td>
                    {{ Form::text('subcategory', '', array('class'=>'form-control', 'placeholder'=>'Sub-Category')) }}
                </td>
                <td>
                    {{ Form::hidden('categoryId', $category_id) }}
                    {{ Form::submit('Create', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>
            </tbody>
        </table>
        <hr/>


        <span class="title">Sub-categories Summary</span>
        <br/>
        <br/>
        <table class="form-table">

            <thead>
            <tr>
                <td>
                    Sub-Category
                </td>
                <td>
                    Status
                </td>
                <td>
                    modify
                </td>

                <td>
                    Delete
                </td>

            </tr>
            </thead>
            <tbody>
            @foreach($subcategories as $subcategory)

            <tr>
                {{ Form::open(array('url'=>'adminDocumentation/editsubcategory', 'class'=>'')) }}
                <td>
                    {{ Form::text('subcategory', $subcategory->sub_category, array('class'=>'form-control',
                    'placeholder'=>'Category')) }}
                </td>
                <td>
                    {{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $subcategory->active,
                    array('class' => 'form-control')) }}
                </td>
                <td>
                    {{ Form::hidden('id', $subcategory->id) }}
                    {{ Form::hidden('categoryId', $category_id) }}
                    {{ Form::submit('Update', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>


                <td>
                    {{ Form::open(array('url'=>'adminDocumentation/deletesubcategory', 'class'=>'')) }}
                    {{ Form::hidden('id', $subcategory->id) }}
                    {{ Form::hidden('categoryId', $category_id) }}
                    {{ Form::submit('Delete', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>

            @endforeach
            </tbody>


        </table>

        @endif



    </div>
</div>


<br/>




