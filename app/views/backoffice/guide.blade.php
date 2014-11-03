<div id="cbp-hrmenu" class="cbp-hrmenu">
    <ul>
        @foreach ($categories as $category)
        <li>
            <a href="#">{{$category->category}}</a>

            <div class="cbp-hrsub">
                <div class="cbp-hrsub-inner">
                    <div>
                        @foreach ($subcategories as $subcategory)
                        @if ($category->id == $subcategory->category_id)
                        <h4>{{$subcategory->sub_category}}</h4>
                        <ul>
                            @foreach ($documents as $document)
                            @if ($document->sub_category_id == $subcategory->id)

                            <li>

                                @if (Auth::check() && Auth::user()->permission < 3)
                                <a class="" href="{{ url('adminDocumentation/index/' . $document->id )}}">{{$document->title}}</a>
                                @else
                                <a class="" href="{{ url('inquiry/guide/' . $document->id )}}">{{$document->title}}</a>
                                @endif

                            </li>

                            @endif
                            @endforeach

                        </ul>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>


<br/>

@if ($guide != null && $edit == false)

    <span>{{$guide->category}} >> {{$guide->subcategory}}</span>
    <br/>
    <br/>


    <span class="sub-title">{{$guide->title}}</span>

    @if (Auth::check() && Auth::user()->permission < 3)

    <br/>
    <br/>
    <ul class="list-inline">
        <li>
            <a class="button_normal" href="{{ url('adminDocumentation/index/' . $guide->id . '/edit')}}"
               role="button">Edit</a>
        </li>
        <li>
            {{ Form::open(array('url'=>'adminDocumentation/deletedocument', 'class'=>'')) }}
            {{ Form::hidden('documentId', $guide->id) }}
            {{ Form::submit('Delete', array('class'=>'button_normal_red'))}}
            {{ Form::close() }}
        </li>
    </ul>


    @endif


    <br/>


    <p class="std-padding">
        <small>最後更新 {{$guide->updated_at}}</small>
        <br/>
    <hr/>
    {{$guide->content}}
    </p>


@elseif ($guide != null && $edit == true && Auth::check() && Auth::user()->permission < 3)


    <h1 class="color-secondary">Edit : {{$guide->category}} >> {{$guide->subcategory}}</h1>
    <br/>


    {{ Form::open(array('url'=>'adminDocumentation/editdocumentation', 'class'=>'')) }}
    Title <br/>
    {{ Form::text('title', $guide->title, array('class'=>'form-control', 'placeholder'=>'Title')) }}
    <br/>
    Content <br/>
    {{ Form::textarea('content', $guide->content, array('class'=>'form-control', 'placeholder'=>'Content goes here')) }}
    <br/>
<ul class="list-inline">
    <li>
        {{ Form::hidden('documentId', $guide->id) }}
        {{ Form::submit('Update', array('class'=>'button_normal'))}}
        {{ Form::close() }}
    </li>
    <li>
        <a class="button_normal_red" href="{{ url('adminDocumentation/index/' . $guide->id )}}" role="button">取消</a>
    </li>
</ul>





@endif









<script type="text/javascript" src='{{ asset("js/libs/cbpHorizontalMenu.min.js")}}'></script>
<script>
    $(function () {
        cbpHorizontalMenu.init();
    });
</script>










