<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="/images/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/images/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/images/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/images/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/images/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/images/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="/images/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/images/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/images/manifest.json">
	<link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/images/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <title>{{ Config::get('custom.appName') . ' ' . trans('phrase.title') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
 	<link href="/full-dev-only/css/app.css" rel="stylesheet" media="all">
 	<link href="/full-dev-only/css/sqlsyntax.css" rel="stylesheet" media="all">
 	<link href="/full-dev-only/css/middle.css" rel="stylesheet" media="all">

    <!-- Colors -->
 	<link rel="stylesheet" href="/css/w3-theme-{{ config('custom.theme') }}.css" media="all">

    <!-- Fonts -->
 	<link rel="stylesheet" href="/css/font-{{ config('custom.font') }}.css" media="all" />
<!--
    <link href="/full-dev-only/css/bootstrap.adjusted.navbar.breakpoint.css" rel="stylesheet">
    <link href="/full-dev-only/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
 	<link href="/full-dev-only/css/w3.css" rel="stylesheet" media="all">
 	<link href="/full-dev-only/css/app.css" rel="stylesheet" media="all">
 	<link href="/full-dev-only/css/sweetalert.css" rel="stylesheet" media="all">
 	<link href="/full-dev-only/css/sqlsyntax.css" rel="stylesheet" media="all">

	<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
-->

    <!-- JavaScripts -->
	<script type="text/javascript" src="/full-dev-only/js/sweetalert.min.js"></script>
</head>
<body id="app-layout">
	<div class="w3-theme-d4 row">
		<div id="heading_image" class="col-sm-3">
			<a href="/" title="{{ config('custom.appName') }}">
				<img style="width: 205px" src="\images\Recordly-Logo-white.png"></img>
			</a>
		</div>
		<div id="heading_text" class="w3-padding-left col-sm-9">
			<h1 class="middle">{{ trans('phrase.title') }}</h1>
		</div>
	</div>

	@include('layouts.navbar')

	@if (app()->isDownForMaintenance())
		<div class="w3-container w3-section">
			<div class="w3-container">
				<div class="alert alert-danger fade in">
					<strong>{{ trans('phrase.maintMode') }}</strong>:  {{ trans('phrase.maintDown') }}
				</div>
			</div>
		</div>
	@endif

	<div class="w3-container w3-section">
		@include('layouts.flash')

		@yield('content')
	</div>

    <!-- JavaScripts -->
	<script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>
	<script type="text/javascript" src="/full-dev-only/js/app.js"></script>

<!--
	<script type="text/javascript" src="/full-dev-only/js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="/full-dev-only/js/bootstrap.js"></script>
	<script type="text/javascript" src="/full-dev-only/js/jquery.smartmenus.js"></script>
	<script type="text/javascript" src="/full-dev-only/js/jquery.smartmenus.bootstrap.js"></script>
	<script type="text/javascript" src="/full-dev-only/js/app.js"></script>
-->
	<script type="text/javascript">
		$('div.alert').not('.alert-danger').not('.alert-warning').delay({{ config('custom.message_timer') }}).slideUp(300);
	</script>
	@yield('scripts')
	@yield('scriptsSelect')

	<div class="w3-container w3-small w3-theme">
		<div class="w3-row">
			<!-- Left -->
			<div class="w3-third w3-hide-small">
				<p>
					{{ trans('phrase.questions') }}
					{!! Html::mailto(config('custom.adminEmail'),
						trans('phrase.webmaster', ['appName' => config('custom.appName')]),
						['subject' => trans('phrase.emailSubject'),
							'class' => 'w3-theme underline'])
					!!}
				</p>
			</div>
			<!-- Center -->
			<div class="w3-third w3-center">
				<a href="https://github.com/mckneisler/genesis" class="w3-theme underline">Project Genesis</a>
			</div>
			<!-- Right -->
			<div class="w3-third text-right w3-hide-small">
				<p>{{ trans('object.version') }} {{ config('app.version') }}</p>
			</div>
		</div>
	</div>

</body>
</html>
