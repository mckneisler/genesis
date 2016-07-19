<div id="topnavL3" class="w3-topnav w3-theme-l4 w3-padding-0 w3-hide-small w3-small topnavL3">
	@if ($align == 'w3-right')
		@foreach (array_reverse($menu) as $item)
			@include('layouts.subitem', ['item' => $item, 'align' => $align, 'level' => 3])
		@endforeach
	@else
		@foreach ($menu as $item)
			@include('layouts.subitem', ['item' => $item, 'align' => $align, 'level' => 3])
		@endforeach
	@endif
</div>
