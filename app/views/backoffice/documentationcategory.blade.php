
@include('backoffice.documentmenu')

<br/>
<div class="main-title">Documentation Category Management</div>
<br/>



<div class="two-col-panel">
	<div class="left-panel">

		<span class="title">Create Category</span>  
		<br/>
		<br/>
		<br/>
		<table class="form-table">

			<tbody>

				<tr>
					{{ Form::open(array('url'=>'adminDocumentation/createCategory', 'class'=>'')) }}
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
					{{ Form::open(array('url'=>'adminDocumentation/editCategory', 'class'=>'')) }}
					<td>
						{{ Form::text('category', $category->category, array('class'=>'input-block-level', 'placeholder'=>'Category')) }}
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
						{{ Form::open(array('url'=>'adminDocumentation/deleteCategory', 'class'=>'')) }}
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


<br/>




<br/>
<div class="main-title">Sub-Category Management</div>
<br/>



<div class="two-col-panel">
	<div class="left-panel">

		<span class="title">Create Sub-Category</span>  
		<br/>
		<br/>
		<br/>
		<table class="form-table">

			<tbody>

				<tr>
					{{ Form::open(array('url'=>'adminDocumentation/createSubCategory', 'class'=>'')) }}
					<td>
						Sub-Category
					</td>
					<td>
						{{ Form::text('subcategory', '', array('class'=>'input-block-level', 'placeholder'=>'Sub-Category')) }}
					</td>
				</tr>
				<tr>

					<td>
						Category
					</td>
					<td>
						{{ Form::select('categoryId', $activecategories, null, array('class' => 'form-control')) }}
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
						Sub-Category
					</td>
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
				@foreach($subcategories as $subcategory)

				<tr>
					{{ Form::open(array('url'=>'adminDocumentation/editSubCategory', 'class'=>'')) }}
					<td>
						{{ Form::text('subcategory', $subcategory->sub_category, array('class'=>'input-block-level', 'placeholder'=>'Category')) }}
					</td>
                    <td>
                        {{ Form::select('categoryId', $activecategories, $subcategory->category_id, array('class' => 'form-control')) }}
                    </td>
					<td>
						{{ Form::select('active', array('0' => 'Deactivated','1' => 'Active'), $subcategory->active,  array('class' => 'form-control')) }}
					</td>
					<td>
						{{ Form::hidden('id', $subcategory->id) }}
						{{ Form::submit('Update', array('class'=>'button_sm'))}}
					</td>
					{{ Form::close() }}

					<td>
						{{ Form::open(array('url'=>'adminDocumentation/deleteSubCategory', 'class'=>'')) }}
						{{ Form::hidden('id', $subcategory->id) }}
						{{ Form::submit('Delete', array('class'=>'button_sm'))}}
						{{ Form::close() }}
					</td>
				</tr>

				@endforeach
			</tbody>


		</table>
	</div>
</div>


<br/>




