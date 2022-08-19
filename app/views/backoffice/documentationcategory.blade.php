
@include('backoffice.documentmenu')

<br/>
<span class="main-title">Documentation Category Management</span>
<br/>
<br/>


<div class="two-col-panel std-border white-bg std-padding">
	<div class="left-panel">

		<span class="title">Create Category</span>  
		<br/>
		<br/>
		<br/>
		<table class="form-table">

			<tbody>

				<tr>
					{{ Form::open(array('url'=>'adminDocumentation/createcategory', 'class'=>'')) }}
					<td>
						Category
					</td>
					<td>
						{{ Form::text('category', '', array('class'=>'input-block-level', 'placeholder'=>'Category')) }}
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


		<span class="title">Category Summary</span>  
		<br/>
		<table class="form-table">

			<thead>
				<tr>
					<td>
						Category
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
				@foreach($categories as $category)

				<tr>
					{{ Form::open(array('url'=>'adminDocumentation/editcategory', 'class'=>'')) }}
					<td>
						{{ Form::text('category', $category->category, array('class'=>'form-control', 'placeholder'=>'Category')) }}
					</td>
					<td>
						{{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $category->active,  array('class' => 'form-control')) }}
					</td>
					<td>
						{{ Form::hidden('id', $category->id) }}
						{{ Form::submit('Update', array('class'=>'button_sm'))}}
					</td>
					{{ Form::close() }}

					<td>
						{{ Form::open(array('url'=>'adminDocumentation/deletecategory', 'class'=>'')) }}
						{{ Form::hidden('id', $category->id) }}
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


