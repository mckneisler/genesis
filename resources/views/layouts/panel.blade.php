@extends('layouts.app')

@section('content')
	<div class="{{ config('class.container') }}">
		<div class="{{ config('class.row') }}">
			<div class="col-md-8 col-md-offset-2">
					<div class="panel-body w3-text-theme">
						@yield('prePanelContent')
					</div>
			</div>
		</div>
	</div>

	<div class="{{ config('class.container') }}">
		<div class="{{ config('class.row') }}">
			<div class="col-md-8 col-md-offset-2">
				<div class="{{ config('class.panel') }}">
					<div class="{{ config('class.header') }}">
						<h3>{{ $title }}</h3>
					</div>
					<div class="panel-body w3-text-theme">

						@yield('panelContent')

					</div>
					<div class="{{ config('class.footer') }}">
						@yield('footerContent')
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
