<div>
    <span class="main-title">Account Management</span>

    <div class="pull-right">

        {{ Form::open(array('url'=>'adminAccount/search', 'class'=>'form-horizontal')) }}

            <div class="col-sm-9">
                {{ Form::text('email', '', array('class'=>'form-control width-100', 'placeholder'=>'Account Email')) }}
            </div>

            <div class="col-sm-2">
                {{ Form::submit('Search', array('class'=>'button_sm'))}}
                {{ Form::close() }}
            </div>



    </div>
</div>


<br/>

@if ($accounts !='')
@foreach ($accounts as $account)

<div class="two-col">
    <div class="left">


        <span class="title">Info</span>

        <div class="media">
            <a class="pull-left" href="#">

                @if($account->profile_pic)
                {{ HTML::image('profilepic/' . $account->profile_pic, $account->firstname . $account->lastname, array('class' => 'media-object')) }}
                @else
                <i class="icon-user-5x"></i>
                @endif
            </a>


            <div class="media-body">
                <span class="media-heading">{{$account->firstname}} {{$account->lastname}}<small>
                        {{$account->last_seen}}
                    </small></span>
                <table class="form-table">
                    <tr>
                        <td>
                            {{$account->email}}
                        </td>
                        <td>
                            {{$account->created_at}}
                        </td>
                        <td>
                            {{$account->identity}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$account->tel}}
                        </td>
                        <td>
                            {{$account->cell_tel}}
                        </td>
                        <td>
                            {{$account->rating}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$account->company}}
                        </td>
                        <td>
                            {{$account->license}}
                        </td>
                        <td>
                            {{$account->permission}}
                        </td>
                    </tr>
                </table>
                <table class="form-table">
                    <tr>
                        <td>
                            {{$account->description}}
                        </td>
                        <td>
                            {{$account->template}}
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="right">

        <span class="title">Setting</span><br/>
        @foreach($settings as $setting)
        <table class="form-table">
            <tr>
                <td>
                    agent request
                </td>
                <td>
                    {{$setting->agent_request}}
                </td>
            </tr>
            <tr>
                <td>
                    promotion email
                </td>
                <td>
                    {{$setting->promotion_email}}
                </td>
            </tr>
            <tr>
                <td>
                    disclose_contact
                </td>
                <td>
                    {{$setting->disclose_contact}}
                </td>
            </tr>
        </table>

        @endforeach


    </div>

</div>
<br/>
<span class="title">Property</span>
<table class="form-table">
    <thead>
    <tr>
        <td>
            Category
        </td>
        <td>
            Region
        </td>
        <td>
            Territory
        </td>
        <td>
            Property Name
        </td>
        <td>
            Sold or rent
        </td>
        <td>
            Publish
        </td>
        <td>
            Create date
        </td>
        <td>
            Update date
        </td>
    </tr>
    </thead>
    <tbody>
    @foreach($properties as $property)
    <tr>

        <td>
            {{$property->property_category}}
        </td>
        <td>
            {{$property->property_region}}
        </td>
        <td>
            {{$property->property_territory}}
        </td>
        <td>
            {{$property->property_name}}
        </td>
        <td>

            @if($property->property_soldorrent == 0)
            Rent
            @elseif($property->property_soldorrent == 1)
            Sales
            @elseif($property->property_soldorrent == 2)
            Sales & Rent
            @endif

        </td>
        <td>

            @if($property->property_publish == 0)
            not publish
            @elseif($property->property_publish == 1)
            Published
            @endif
        </td>
        <td>
            {{$property->property_created_at}}
        </td>
        <td>
            {{$property->property_updated_at}}
        </td>
    <tr>
        @endforeach
    </tbody>
</table>


@endforeach
@endif



