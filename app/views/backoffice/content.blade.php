<div class="two-col-panel">

    <div class="left-panel">

        @include('backoffice.contentmenu')

    </div>


    <div class="right-panel">

        @if($toShow == 'index')
        <pre>
            Rule:
            1) Don't delete thing
        </pre>



        @else


        <span class="main-title">{{$toShow}}</span>
        <br/>
        <br/>


        <span class="title">Create</span>  
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
                        Create
                    </td>

                </tr>
            </thead>
            <tbody>

                <tr>
                    {{ Form::open(array('url'=>'adminContent/create', 'class'=>'')) }}
                    <td>
                        {{ Form::text('data', '', array('class'=>'input-block-level', 'placeholder'=>'Create')) }}
                    </td>
                    @if($toShow == 'region')
                    <td>
                        {{ Form::select('territoryId', $territories, null, array('class' => 'form-control')) }}
                    </td>
                    @endif
                    <td>

                        {{ Form::hidden('toCreate', $toShow) }}
                        {{ Form::submit('Create', array('class'=>'button_sm'))}}
                    </td>
                    {{ Form::close() }}

                </tr>

            </tbody>
        </table>




        <br/>
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
                        {{ Form::select('territoryId', $territories, $element->territory_id, array('class' => 'form-control')) }}
                    </td>
                    @endif


                    <td>
                        {{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $element->active,  array('class' => 'form-control')) }}
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






        @endif












    </div>


</div>