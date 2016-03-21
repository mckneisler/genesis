{include file="header.tpl"}

{if $isLoggedIn}
	{assign var="w1" value="70"}
	{assign var="w2" value="10"}
	{assign var="w3" value="20"}
	{assign var="colspan" value="3"}
{else}
	{assign var="w1" value="80"}
	{assign var="w2" value=""}
	{assign var="w3" value="20"}
	{assign var="colspan" value="2"}
{/if}
<script type="text/javascript">
<!--
function changeArtistFav(artistId, checked) {
	$url = "{$urlRoot}ajaxArtistFav.php?userId={$userId}&artistId=" + artistId + "&isFav=" + checked;
	$.ajax({
		type: "GET",
		url: $url,
		success: function(response) {
			$("#return_" + artistId).html(response);
			$("#return_" + artistId).removeClass("w3-hide");
		}
	});
}
// -->
</script>

{if !$isLoggedIn}
<p>
	{$phrase.toSelectFavs} <a href="login.php">{$phrase.loggedIn}</a>
</p>
{/if}

<div id="artistTableSwipeTop" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>

<div class="{$class.tableDiv}">

	<table id="artistTable" class="w3-table w3-striped w3-bordered">
		<thead>
			<tr class="w3-theme-l3">
				<th style="width: {$w1}%">{$label.artist}</th>
{if $isLoggedIn}
				<th class="w3-center" style="width: {$w2}%">{$label.favorite}</th>
{/if}
				<th class="w3-center" style="width: {$w3}%">{$label.action}</th>
			</tr>
		</thead>
		<tfoot>
			<tr class="w3-theme-l3">
				<td class="w3-center" colspan="{$colspan}">
					&nbsp;
				</td>
			</tr>
		</tfoot>
		<tbody>
{if $artists}
	{foreach name="artists" from=$artists item=artist}
			<tr class="w3-hover-theme-l4">
				<td>
					{$artist.nameTxt}
				</td>
		{if $isLoggedIn}
				<td class="w3-center">
					<span>
						<input type="checkbox" class="w3-check" onclick="changeArtistFav({$artist.artistId}, this.checked);" {if $artist.isFav} checked="checked"{/if} />
						<span class="w3-hide" id="return_{$artist.artistId}">&nbsp;</span>
					</span>
				</td>
		{/if}
				<td class="w3-center">
					[<a href="albums.php?artistId={$artist.artistId}">{$label.albums}</a>]
					[<a href="songs.php?artistId={$artist.artistId}">{$label.songs}</a>]
				</td>
			</tr>
	{/foreach}
{else}
			<tr>
				<td class="w3-center" colspan="{$colspan}">
					{$message.noRecords}
				</td>
			</tr>
{/if}
		</tbody>
	</table>

</div>

<div id="artistTableSwipeBottom" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>

{include file="footer.tpl"}
