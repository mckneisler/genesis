{if $error}
	<span>{$error}</span>
{else}
	{if $isFav == 'true'}
		<span>{$phrase.added}</span>
	{else}
		<span>{$phrase.removed}</span>
	{/if}
{/if}
