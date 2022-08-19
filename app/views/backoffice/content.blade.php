<section>
    @include('backoffice.contentmenu')
</section>
<hr/>


@if($toShow == 'index')
<p>
    Rule:
    1) Don't delete thing
</p>
@else


<span class="main-title">{{$toShow}}</span>
<br/>
<br/>


<div class="two-col-panel">

    <div class="left-panel">
        <span class="title">Create</span>
        <br/>
        <br/>


        {{ Form::open(array('url'=>'adminContent/create', 'class'=>'form-horizontal')) }}


        <div class="form-group">
            <label for="inputRegion" class="col-sm-4 control-label">{{$toShow}}</label>

            <div class="col-sm-8">
                {{ Form::text('data', '', array('id' => 'inputRegion' , 'class'=>'form-control',
                'placeholder'=>'Create')) }}
            </div>
        </div>


        <hr/>

        @if($toShow == 'region')


        <div class="form-group">
            <label for="inputTerritory" class="col-sm-4 control-label">Territory</label>

            <div class="col-sm-8">
                {{ Form::select('territoryId', $territories, null, array('id' => 'inputTerritory' , 'class' =>
                'form-control')) }}
            </div>
        </div>

        <hr/>
        @endif



        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                {{ Form::hidden('toCreate', $toShow) }}
                {{ Form::submit('Create', array('class'=>'button_sm'))}}
                {{ Form::close() }}
            </div>
        </div>

    </div>
    <div class="right-panel">

        <span class="title">Edit</span>
        <br/>

        <table class="form-table">
            <thead>
            <tr>
                <td>
                    {{$toShow}}
                </td>
                @if($toShow == 'region')
                <td>
                    territory
                </td>
                @endif
                <td>
                    Status
                </td>
                <td>
                    Modify
                </td>

                <td>
                    Delete
                </td>
            </tr>
            </thead>
            <tbody>
            @foreach($elements as $element)
            <tr>
                {{ Form::open(array('url'=>'adminContent/edit', 'class'=>'')) }}
                <td>
                    {{ Form::text('data', $element->name, array('class'=>'input-block-level', 'placeholder'=>'Edit')) }}
                </td>

                @if($toShow == 'region')
                <td>
                    {{ Form::select('territoryId', $territories, $element->territory_id, array('class' =>
                    'form-control'))
                    }}
                </td>
                @endif


                <td>
                    {{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $element->active,
                    array('class'
                    =>
                    'form-control')) }}
                </td>


                <td>
                    {{ Form::hidden('id', $element->id) }}
                    {{ Form::hidden('toEdit', $toShow) }}
                    {{ Form::submit('Update', array('class'=>'button_sm'))}}
                </td>
                {{ Form::close() }}

                <td>
                    {{ Form::open(array('url'=>'adminContent/delete', 'class'=>'')) }}
                    {{ Form::hidden('id', $element->id) }}
                    {{ Form::hidden('toEdit', $toShow) }}
                    {{ Form::submit('Delete', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>


    </div>
</div>

@endif





