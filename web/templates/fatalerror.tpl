{* Smarty *}

{if !$isSetHeader}
	{include file="header.tpl"}
{/if}

<div class="{$class.form}">
	<div class="{$class.header} w3-red">
		<h3>{$heading.fatalError}</h3>
	</div>
	<div class="w3-container w3-padding">
		<div class="w3-container w3-section">
			<p class="w3-text-red">{$errorMSG}</p>
		</div>

		<div class="w3-container w3-section">
			<p>
				<a href="index.php">{$phrase.returnToHome}</a>
			</p>
		</div>
	</div>
</div>


{include file="footer.tpl"}
