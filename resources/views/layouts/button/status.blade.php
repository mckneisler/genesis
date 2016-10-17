<div class="dropdown w3-margin-left pull-right">
	<button class="dropdown-toggle {{ config('class.button') }}" type="button" data-toggle="dropdown">
		{{ $status_text }} <span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		@foreach($statuses as $key => $value)
			<li><a class="w3-theme-l2 w3-hover-theme-l4" href="#" onclick="refreshWith('status', '{{ $key }}')">{{ $value }}</a></li>
		@endforeach
	</ul>
</div>
