@inject('menu', 'App\Http\Utilities\Menu')

<!-- Navbar fixed top -->
<div id="topnav" class="navbar navbar-default w3-theme" role="navigation">
    <div class="navbar-header">
      <button id="navButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar w3-theme-light"></span>
        <span class="icon-bar w3-theme-light"></span>
        <span class="icon-bar w3-theme-light"></span>
      </button>
      <a class="navbar-brand w3-theme" href="/">{{ config('custom.appName') }}</a>
    </div>
    <div class="navbar-collapse collapse">

	<!-- Left nav -->
	<ul id="leftnav" class="nav navbar-nav">
		@foreach ($menu::get('left') as $item)
			@include ('layouts.menu', ['item' => $item])
		@endforeach
	</ul>

	<!-- Right nav -->
	<ul id="rightnav" class="nav navbar-nav navbar-right">
		@foreach ($menu::get('right') as $item)
			@include ('layouts.menu', ['item' => $item])
		@endforeach
	</ul>

    </div><!--/.nav-collapse -->
</div>
@if (config('custom.showSubmenus'))
	@foreach ($menu::get('left') as $item)
		@if (Request::segment(1) == $item['id'] && array_has($item, 'submenu'))
			@include ('layouts.navbarL2', ['menu' => $item['submenu'], 'align' => 'navbar-left'])
		@endif
	@endforeach
	@foreach ($menu::get('right') as $item)
		@if (Request::segment(1) == $item['id'] && array_has($item, 'submenu'))
			@include ('layouts.navbarL2', ['menu' => $item['submenu'], 'align' => 'w3-right'])
		@endif
	@endforeach
@endif
