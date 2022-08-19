









<div class="media">
	<a class="pull-left" href="#">
		<img class="media-object" src="{{$account->profile_pic}}" alt="{{$account->firstname}}_{{$account->lastname}}">

	</a>

	<div class="media-body">

		<span class="media-heading title">{{$account->firstname}} {{$account->lastname}}</span>

		<br/>
		<br/>


		<ul class="list-group">
			<li class="list-group-item">Last Seen: <span class="pull-right">{{$account->last_seen}}</span></li>
			<li class="list-group-item">Created at: <span class="pull-right">{{$account->created_at}}</span></li>



			@if ($showContact)
			<li class="list-group-item">Email: <span class="pull-right">{{$account->email}}</span></li>
			<li class="list-group-item">Cell Phone: <span class="pull-right">{{$account->cell_tel}}</span></li>
			<li class="list-group-item">Phone: <span class="pull-right">{{$account->tel}}</span></li>
			@endif







			@if($isAgent)

			<li class="list-group-item">Rating: <span class="pull-right">{{$account->rating}}</span></li>
			<li class="list-group-item">Company: <span class="pull-right">{{$account->company}}</span></li>

			<li class="list-group-item">license: <span class="pull-right">{{$account->license}}</span></li>
			<li class="list-group-item">Description: {{$account->description}}</li>

			<li class="list-group-item">

				@if ($showRatingLink)
				@if (Auth::user()->identity == 0)
				{{ Form::open(array('url'=>'account/rank', 'class'=>'')) }}
				{{ Form::hidden('agentId', $account->id) }}
				{{ Form::submit('Rank', array('class'=>'button_sm'))}}
				{{ Form::close() }}
				@endif
				@endif
				@endif
			</li>
		</ul>
	</div>
	<a class ='button_normal'  href="{{URL::previous()}}">Back</a>
</div>






