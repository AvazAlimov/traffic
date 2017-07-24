@if(Auth::guard('web')->check())
	<p class="text-success">
		You are Logged in as <strong>User</strong>
	</p>
	@else
	<p class="text-danger">
		You are Logged out as <strong>User</strong>
	</p>
@endif

@if(Auth::guard('admin')->check())
	<p class="text-success">
		You are Logged in as <strong>Admin</strong>
	</p>
	@else
	<p class="text-danger">
		You are Logged out as <strong>Admin</strong>
	</p>
@endif

@if(Auth::guard('operator')->check())
	<p class="text-success">
		You are Logged in as <strong>Operator</strong>
	</p>
@else
	<p class="text-danger">
		You are Logged out as <strong>Operator</strong>
	</p>
@endif