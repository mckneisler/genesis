<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

	<title>{$heading.title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" sizes="57x57" href="{$imgPath}apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="{$imgPath}apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="{$imgPath}apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="{$imgPath}apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="{$imgPath}apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="{$imgPath}apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="{$imgPath}apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="{$imgPath}apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="{$imgPath}favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="{$imgPath}favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="{$imgPath}favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="{$imgPath}manifest.json">
	<link rel="mask-icon" href="{$imgPath}safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="{$imgPath}mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<link type="text/css" rel="stylesheet" href="{$urlRoot}styles/genesis.css" media="all" />
	<link type="text/css" rel="stylesheet" href="{$urlRoot}styles/w3.css" media="all" />
 	<link type="text/css" rel="stylesheet" href="{$urlRoot}styles/font-{$custom.font}.css" media="all" />
 	<link type="text/css" rel="stylesheet" href="{$urlRoot}styles/w3-theme-{$custom.theme}.css" media="all" />
	<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

	<script type="text/javascript" src="{$urlRoot}js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="{$urlRoot}js/genesis.js"></script>

</head>

<body{if $onload} onload="{$onload}"{/if}{if $onkeypress} onkeypress="{$onkeypress}"{/if}>
	<input type="hidden" id="setFocusId" value="{$setFocusId}" />
	<div class="w3-theme-d4 w3-row">
		<div id="heading_image" class="w3-image fifth">
			<a href="http://chickenmadness.ro/recordly/" title="Original Recordly Website">
				<img style="width: 228px" src="{$imgPath}Recordly-Logo-white.png"></img>
			</a>
		</div>
		<div id="heading_text" class="w3-container w3-padding-left fourfifth">
			<h1 class="w3-margin-0 middle">{$heading.page}</h1>
		</div>
	</div>

	<div id="topnav" class="w3-topnav w3-theme w3-large w3-padding-0 topnav">
		<div class="w3-hide-medium w3-hide-large w3-left">
			<a href="javascript:void(0);" class="w3-hover-theme-l3 fa fa-bars" onclick="toggleSideNav()" title="Menu"></a>
		</div>
	{foreach from=$menu item=element}
		<a href="{$element.url}" class="w3-hide-small{if $element.id == $menuSelected} w3-theme-d3{else} w3-hover-theme-l3{/if}" title="{$element.title}">{$element.text}</a>
		{if $element.id == $menuSelected && $element.submenu}
			{assign var="submenu" value=$element.submenu}
		{/if}
	{/foreach}
	</div>
	{if $submenu}
	<div id="topnavsub" class="w3-topnav w3-theme-l5 w3-padding-0 w3-hide-small topnavsub">
		{foreach from=$submenu item=element}
		<a href="{$element.url}" class="{if $element.id == $submenuSelected}w3-theme-l3{else}w3-hover-theme-l4{/if}" title="{$element.title}">{$element.text}</a>
		{/foreach}
	</div>
	{/if}
	<div id="sidenav" class="w3-sidenav w3-theme-l5 w3-card-2 w3-hide">
	{foreach from=$menu item=element}
		<a class="{if $element.id == $menuSelected}w3-theme-d3{else}w3-hover-theme-l4{/if}" href="{$element.url}" title="{$element.title}">{$element.text}</a>
		{if $element.id == $menuSelected && $element.submenu}
			{foreach from=$submenu item=element}
				<a class="w3-margin-left{if $element.id == $submenuSelected} w3-theme-l3{else} w3-hover-theme-l4{/if}" href="{$element.url}" title="{$element.title}">{$element.text}</a>
			{/foreach}
		{/if}
	{/foreach}
	</div>
{*
<script type="text/javascript">
	function showInfo() {
		var topNav = $('#topnav');
		var topNavSub = $('#topnavsub');
		var msg = "";
		msg += "topNav top: " + topNav.css('top') + "\n";
		msg += "topNav height: " + topNav.height() + "\n";
		msg += "topNavSub top: " + topNavSub.css('top') + "\n";
		alert(msg);
	}
</script>
<br /><br /><br /><br /><br /><br />
<input type="button" class="w3-button" value="Show Info" onclick="showInfo()" />
	{$menu|@debug_print_var}
	{$submenu|@debug_print_var}
	{$languageFileDate|@debug_print_var}
	{$language|@debug_print_var}
*}
	<div class="w3-container w3-section">
{if !empty($smarty.session.errors.generalError)}
	{foreach from=$smarty.session.errors.generalError item=errorText}
		 <p class="w3-text-red">{$errorText}</p>
	{/foreach}
	{unset_errors}
{/if}
{assign var="isSetHeader" value="true" scope="global"}
