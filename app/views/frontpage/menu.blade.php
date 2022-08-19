

<div class="main-menu">



	@if(!Auth::check())

	<div class='menu-col'>

		<div class="left">

			<a href="{{ url('account/login')}}" >

				<i class="icon-login"></i>
				<br/>

				登入

			</a>
		</div>

		<div class="middle">

			<a href="{{ url('account/agentregister')}}" >
				<i class="icon-agent-register"></i>
				<br/>

				代理會員注冊

			</a>
		</div>
		<div class="right">
			<a href="{{ url('account/userregister')}}" >
				<i class="icon-user-register"></i>
				<br/>

				業主會員注冊

			</a>
		</div>


	</div>




	@else


	<div class='menu-col'>

		<div class="left">

			<a href="{{ url('account/dashboard/property')}}" >

				<i class="icon-dashboard"></i>
				<br/>

				主看板

			</a>
		</div>

		<div class="middle">

			<a href="{{ url('property/addproperty')}}" >
				<i class="icon-add-property"></i>
				<br/>

				發佈物業

			</a>
		</div>
		<div class="right">
			<a href="{{ url('account/dashboard/account_setting')}}" >
				<i class="icon-account-setting"></i>
				<br/>

				設定

			</a>
		</div>


	</div>


	<div class='menu-col'>

		<div class="left">

			<a href="{{ url('account/dashboard/account_edit')}}" >

				<i class="icon-edit-account"></i>
				<br/>

				管理

			</a>
		</div>

		<div class="middle">

			<a href="{{ url('payment/pricepage')}}" >
				<i class="icon-purchase-center"></i>
				<br/>

				講買中心

			</a>
		</div>
		<div class="right">
			<a href="{{ url('account/logout')}}" >
				<i class="icon-logout"></i>
				<br/>

				登出

			</a>
		</div>


	</div>



	@endif




	<div class='menu-col'>
		<div class="left">
			<a href="{{ url('inquiry/about')}}" >
				<i class="icon-about-us"></i>
				<br/>
				關於我們
			</a>
		</div>
		<div class="middle">

			<a href="{{ url('inquiry/terms')}}" >
				<i class="icon-terms"></i>
				<br/>
				服務條約
			</a>
		</div>
		<div class="right">
			<a href="{{ url('inquiry/guide')}}" >
				<i class="icon-user-guide-white"></i>
				<br/>
				用戶指南
			</a>
		</div>
	</div>

</div>