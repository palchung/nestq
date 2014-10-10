<!-- <div class="search-div">
	You can find almost all information about Nestq Here !<br/>
	<br/>
	{{ Form::open(array('url'=>'inquiry/search', 'class'=>'')) }}
	{{ Form::text('inquiry', null, array('class'=>'input-block-level', 'placeholder'=>'Search')) }}
	{{ Form::submit('Register', array('class'=>'button_normal'))}}
	{{ Form::close() }}
</div> -->

<span class="title">User Guide</span>
<br/>
<br/>
<table class="std-table">
	<tr>
		@foreach($categories as $category)
		<td>
			<a href="{{ url('inquiry/category/' . $category->id)}}"> 
				<div class="std-thumbnail std-border std-hover">
					<!-- <i class="icon-coffee"></i> -->
					<div class="std-caption">
						<br/>
						<h1>{{$category->category}}</h1><br/>

					</div>
				</div>
			</a>
		</td>

		@endforeach
	</tr>
</table>


<div class="inquiry-wrapper">

	@if(isset($subcategories))

	<div class="two-col-panel">

		<div class="left-panel">

			@foreach($subcategories as $subcategory)
			

			<a href="{{url('inquiry/document', array('categoryId' => $subcategory->category_id, 'subcategoryId' => $subcategory->id))}}" class=""> 
				{{$subcategory->sub_category}}
			</a>
			<br/>
			@endforeach

		</div>

		<div class="right-panel">




			@if(isset($documents))

			@foreach($documents as $document)

			<b>{{$document->title}}</b><br/>

			{{$document->content}}

			@endforeach

			@endif
			

		</div>


	</div>


	@else

	You can find anything here

	@endif


</div>