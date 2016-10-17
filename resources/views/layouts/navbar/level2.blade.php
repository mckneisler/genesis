<div id="topnavL2" class="w3-topnav w3-theme-l2 w3-padding-0 w3-hide-small topnavL2">
	@if ($align == 'w3-right')
		@foreach (array_reverse($menu) as $item)
			@include('layouts.subitem', ['item' => $item, 'align' => $align, 'level' => 2])
		@endforeach
	@else
		@foreach ($menu as $item)
			@include('layouts.subitem', ['item' => $item, 'align' => $align, 'level' => 2])
		@endforeach
	@endif
</div>
@foreach ($menu as $item)
	@if (Request::segment(2) == $item['id'] && array_has($item, 'submenu'))
		@include ('layouts.navbar.level3', ['menu' => $item['submenu'], 'align' => $align])
	@endif
@endforeach
