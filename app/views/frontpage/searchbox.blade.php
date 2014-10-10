
<div class="searchbox-wrapper" ng-controller="searchboxCtrl">

	<div class="searchbox">搜尋器 / <small class="searchbox-title"> Search Box </small> </div>
	<br/>
	<br/>
	<br/>


	<ul>
		<li>

			{{ Form::open(array('url'=>'search/property', 'method' => 'get', 'class'=>'searchbox-form')) }}
			<div class="panel panel-default">
				<div class="panel-body">


					<table class="std-table">
						<tr>
							<td>



								@foreach($territories as $territory)

								<a href="#" ng-click="is{{$territory->name}}Collapsed = !is{{$territory->name}}Collapsed"><b>{{$territory->name}}</b></a>


								<div collapse="!is{{$territory->name}}Collapsed">

									<table class="searchbox-table">

										@foreach (array_chunk($regions->all(), 3) as $row)

										<span class='row'>
											<tr>
												@foreach($row as $region)

												@if($region->territory_id == $territory->id)
												<td>
													<div class="searchbox-label">{{ $region->name }}</div>
												</td>
												<td>
													{{ Form::checkbox('region[]', $region->id,  null, ['class'=>'std-checkbox', 'id' =>  'searchbox-region' . $region->id ]) }}<label class="checkbox-label" for= {{ 'searchbox-region' . $region->id }} ></label>
												</td>

												@endif


												@endforeach
											</tr>
										</span>


										@endforeach







									</table>


								</div>

								<br/>

								@endforeach


							</td>
						</tr>
					</table>



					<hr>



















				<table class="std-table">

					@foreach (array_chunk($categories->all(), 3) as $row)

					<span class='row'>
						<tr>
							@foreach($row as $category)
							<td>
								<div class="searchbox-label">{{ $category->name }}</div>
							</td>
							<td>
								{{ Form::checkbox('category[]', $category->id,  null, ['class'=>'std-checkbox', 'id' => 'searchbox-catgory' . $category->id]) }}<label class="checkbox-label" for={{'searchbox-catgory' . $category->id}}></label>
							</td>
							@endforeach
						</tr>
					</span>


					@endforeach

				</table>

				<hr>


				<table class="std-table">
					<tr>
						<td>
							<div class="searchbox-label std-bold">出租</div>
						</td>
						<td>
							{{ Form::checkbox('rent', 'rent',  null, ['id' => 'searchbox-rent','class'=>'std-checkbox']) }}
							<label for="searchbox-rent" class="checkbox-label"></label>
						</td>
						<td>
							<div class="searchbox-label std-bold">出售</div>
						</td>
						<td>
							{{ Form::checkbox('sale', 'sale',  null, ['id' => 'searchbox-sale','class'=>'std-checkbox']) }}
							<label for="searchbox-sale" class="checkbox-label"></label>

						</td>
					</tr>


				</table>


				<hr>









				{{ Form::label('售價') }}
				<span class="pull-right">
					{{ Form::text('price', null, array('class'=>'searchbox-input', 'placeholder'=>'售價 (萬)')) }}
					{{ Form::text('priceRange', null, array('class'=>'searchbox-input', 'placeholder'=>'區隔 +/-')) }}
				</span>
				<br/>
				<br/>

				{{ Form::label('租金') }}
				<span class="pull-right">
					{{ Form::text('rentprice', null, array('class'=>'searchbox-input', 'placeholder'=>'租金 (萬)')) }}
					{{ Form::text('rentpriceRange', null, array('class'=>'searchbox-input', 'placeholder'=>'區隔 +/-')) }}
				</span>
				<br/>
				<br/>

				{{ Form::label('實用面積') }}
				<span class="pull-right">
					{{ Form::text('actualsize', null, array('class'=>'searchbox-input', 'placeholder'=>'實用面積 (呎)')) }}
					{{ Form::text('sizeRange', null, array('class'=>'searchbox-input', 'placeholder'=>'區隔 +/-')) }}
				</span>
				<br/>
				<br/>


			</div>
		</div>

		<a class="underline advanceSearch" href="#" ng-click="isCollapsed = !isCollapsed">
        <span class="searchbox-title std-bold">進階搜尋</span>
        </a>
        <br/>
        <br/>
        <div collapse="isCollapsed">



         <div class="panel panel-default">
            <div class="panel-body">


               <table class="std-table">
                  <tr>
                     <td>
                        <div class="searchbox-label"><span class="std-bold">業主</span></div>
                    </td>
                    <td>
                        {{ Form::checkbox('user', 'user',  null, ['id' => 'searchbox-user','class'=>'std-checkbox']) }}
                        <label for="searchbox-user" class="checkbox-label"></label>
                    </td>
                    <td>
                        <div class="searchbox-label"><span class="std-bold">物業代理</span></div>
                    </td>
                    <td>
                        {{ Form::checkbox('agent', 'agent',  null, ['id' => 'searchbox-agent','class'=>'std-checkbox']) }}
                        <label for="searchbox-agent" class="checkbox-label"></label>

                    </td>
                </tr>
            </table>



            <hr>

            {{ Form::label('發佈時間') }}
            <span class="pull-right">
              {{ Form::select('period', array('all' => '所有','1' => '1 個月', '3' => '3 個月'), null,  array('class' => 'form-control searchbox-dropdown')) }}
          </span>

          <br/>
          <br/>

          {{ Form::label('房間數量') }}
          <span class="pull-right">
              {{ Form::select('nosroom', array('all' => '所有','1' => '1 房', '2' => '2 房', '3' => '3 房', '4' => '4 房以上' ), null,  array('class' => 'form-control searchbox-dropdown')) }}
          </span>

          <br/>
          <br/>

          {{ Form::label('客廳數量') }}
          <span class="pull-right">
              {{ Form::select('noslivingroom', array('all' => '所有','1' => '1 客廳', '2' => '2 客廳', '3' => '3 客廳', '4' => '4 客廳以上' ), null,  array('class' => 'form-control searchbox-dropdown')) }}
          </span>

          <hr>

          {{ Form::label('附近設施') }}
      </br>



      <table class="std-table">

       @foreach (array_chunk($facilities->all(), 3) as $row)

       <span class='row'>
          <tr>
             @foreach($row as $facility)



             <td>
                <div class="searchbox-label">{{ $facility->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('facility[]', $facility->id,  null, ['class'=>'std-checkbox', 'id' => 'searcbox-facility' . $facility->id]) }}<label class="checkbox-label" for={{'searcbox-facility' . $facility->id}}></label>
            </td>
            @endforeach
        </tr>
    </span>


    @endforeach

</table>

</div>
</div>




</div>





{{ Form::submit('搜尋', array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}



<br/>







</li>

</ul>





</div>