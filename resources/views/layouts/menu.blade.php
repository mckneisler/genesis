@if ( ! array_has($item, 'condition') || $item['condition'])
	<li>
		@include('layouts.menu.item', ['item' => $item, 'level' => 1])
		@if (array_has($item, 'submenu'))
			<ul class="dropdown-menu w3-theme-l5">
				@foreach ($item['submenu'] as $itemL2)
					@if ( ! array_has($itemL2, 'condition') || $itemL2['condition'])
						<li>
							@include('layouts.menu.item', ['item' => $itemL2, 'level' => 2])
							@if (array_has($itemL2, 'submenu'))
								<ul class="dropdown-menu">
									@foreach ($itemL2['submenu'] as $itemL3)
										@if ( ! array_has($itemL3, 'condition') || $itemL3['condition'])
											<li>
												@include('layouts.menu.item', ['item' => $itemL3, 'level' => 3])
											</li>
										@endif
									@endforeach
								</ul>
							@endif
						</li>
					@endif
				@endforeach
			</ul>
		@endif
	</li>
@endif
