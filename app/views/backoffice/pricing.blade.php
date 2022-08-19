<span class="main-title">Pricing Management</span>
<br/>
<br/>


<span class="title">Scheme</span>
<br/>


<div class="two-col-panel">
    <div class="left-panel">


        <span class="sub-title">Create</span>
        <br/>
        <br/>
        <br/>

        <table class="form-table">

            <tbody>

            <tr>
                {{ Form::open(array('url'=>'adminPricing/createscheme', 'class'=>'')) }}
                <td>
                    Schemes
                </td>
                <td>
                    {{ Form::text('scheme', '', array('class'=>'form-control', 'placeholder'=>'Item')) }}
                </td>
            </tr>
            <tr>
                <td>
                    Multi
                </td>
                <td>
                    {{ Form::text('multi', '', array('class'=>'form-control', 'placeholder'=>'Price')) }}
                </td>
            </tr>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    {{ Form::text('period', '', array('class'=>'form-control', 'placeholder'=>'Days')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::submit('Create', array('class'=>'button_sm'))}}
                </td>
                {{ Form::close() }}
            </tr>
            </tbody>
        </table>


    </div>
    <div class="right-panel">


        <table class="form-table">

            <thead>
            <tr>
                <td>
                    Scheme
                </td>
                <td>
                    Multi
                </td>
                <td>
                    Period
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
            @foreach($schemes as $scheme)

            <tr>
                {{ Form::open(array('url'=>'adminPricing/editscheme', 'class'=>'')) }}
                <td>
                    {{ Form::text('scheme', $scheme->scheme, array('class'=>'form-control', 'placeholder'=>'Item'))
                    }}
                </td>
                <td>
                    {{ Form::text('multi', $scheme->multi, array('class'=>'form-control', 'placeholder'=>'Price'))
                    }}
                </td>
                <td>
                    {{ Form::text('period', $scheme->period, array('class'=>'form-control', 'placeholder'=>'Days'))
                    }}
                </td>
                <td>
                    {{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $scheme->active,
                    array('class' => 'form-control')) }}
                </td>
                <td>
                    {{ Form::hidden('id', $scheme->id) }}
                    {{ Form::submit('Update', array('class'=>'button_sm'))}}
                </td>
                {{ Form::close() }}

                <td>
                    {{ Form::open(array('url'=>'adminPricing/deletescheme', 'class'=>'')) }}
                    {{ Form::hidden('id', $scheme->id) }}
                    {{ Form::submit('Delete', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>

            @endforeach
            </tbody>


        </table>

    </div>
</div>


<hr/>

<div class="two-col-panel">
    <div class="left-panel">

        <span class="sub-title">Create</span>
        <br/>
        <br/>
        <br/>
        <table class="form-table">

            <tbody>

            <tr>
                {{ Form::open(array('url'=>'adminPricing/create', 'class'=>'')) }}
                <td>
                    Items
                </td>
                <td>
                    {{ Form::text('item', '', array('class'=>'form-control', 'placeholder'=>'Item')) }}
                </td>
            </tr>
            <tr>
                <td>
                    Price
                </td>
                <td>
                    {{ Form::text('price', '', array('class'=>'form-control', 'placeholder'=>'Price')) }}
                </td>
            </tr>
            <tr>
                <td>
                    Package
                </td>
                <td>
                    {{ Form::text('package', '', array('class'=>'form-control', 'placeholder'=>'Package')) }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::submit('Create', array('class'=>'button_sm'))}}
                </td>
                {{ Form::close() }}
            </tr>

            </tbody>
        </table>
    </div>
    <div class="right-panel">


        <span class="title">Summary</span>
        <br/>
        <table class="form-table">

            <thead>
            <tr>
                <td>
                    Items
                </td>
                <td>
                    Price
                </td>
                <td>
                    Package
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
            @foreach($items as $item)

            <tr>
                {{ Form::open(array('url'=>'adminPricing/edit', 'class'=>'')) }}
                <td>
                    {{ Form::text('item', $item->item, array('class'=>'form-control', 'placeholder'=>'Item')) }}
                </td>
                <td>
                    {{ Form::text('price', $item->price, array('class'=>'form-control', 'placeholder'=>'Price')) }}
                </td>
                <td>
                    {{ Form::text('package', $item->package, array('class'=>'form-control',
                    'placeholder'=>'Package')) }}
                </td>
                <td>
                    {{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $item->active, array('class'
                    => 'form-control')) }}
                </td>
                <td>
                    {{ Form::hidden('id', $item->id) }}
                    {{ Form::submit('Update', array('class'=>'button_sm'))}}
                </td>
                {{ Form::close() }}

                <td>
                    {{ Form::open(array('url'=>'adminPricing/delete', 'class'=>'')) }}
                    {{ Form::hidden('id', $item->id) }}
                    {{ Form::submit('Delete', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>

            @endforeach
            </tbody>


        </table>
    </div>
</div>

