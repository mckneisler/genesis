{include file="header.tpl"}

{if $isLoggedIn}
	{assign var="w1" value="30"}
	{assign var="w2" value="30"}
	{assign var="w3" value="30"}
	{assign var="w4" value="10"}
	{assign var="colspan" value="4"}
{else}
	{assign var="w1" value="30"}
	{assign var="w2" value="30"}
	{assign var="w3" value="40"}
	{assign var="w4" value=""}
	{assign var="colspan" value="3"}
{/if}
<script type="text/javascript">
<!--
function changeSongFav(songId, checked) {
    $url = "{$urlRoot}ajaxSongFav.php?userId={$userId}&songId=" + songId + "&isFav=" + checked;
    $.ajax({
        type: "GET",
        url: $url,
        success: function(response) {
            $("#return_" + songId).html(response);
            $("#return_" + songId).removeClass("w3-hide");
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

<form name="songsForm" method="post">
	<div id="songTableSwipeTop" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>

	<div class="{$class.tableDiv}">
		<table id="songTable" class="w3-table w3-striped w3-bordered">
			<thead>
				<tr class="w3-theme-l3">
					<th style="width: {$w1}%">{$label.artist}</th>
					<th style="width: {$w2}%">{$label.album}</th>
					<th style="width: {$w3}%; min-width: 200px">{$label.song}</th>
{if $isLoggedIn}
					<th class="w3-center" style="width: {$w4}%">{$label.favorite}</th>
{/if}
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
{if $songs}
				<tr>
					<td>
						{html_options name='artistId' options=$artists selected=$artistId}
					</td>
					<td>
						{html_options name='albumId' options=$albums selected=$albumId}
					</td>
					<td>
						&nbsp;
					</td>
	{if $isLoggedIn}
					<td>
						&nbsp;
					</td>
	{/if}
				</tr>
    {foreach name="songs" from=$songs item=song}
				<tr class="w3-hover-theme-l4">
					<td>
						{$song.artistNameTxt}
					</td>
					<td>
						{$song.albumNameTxt}
					</td>
					<td>
						{$song.songNameTxt}
					</td>
		{if $isLoggedIn}
					<td class="w3-center">
						<span>
							<input type="checkbox" class="w3-check" onclick="changeSongFav({$song.songId}, this.checked);" {if $song.isFav} checked="checked"{/if} />
							<span class="w3-hide" id="return_{$song.songId}">&nbsp;</span>
						</span>
					</td>
		{/if}
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

	<div id="songTableSwipeBottom" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>

</form>

{include file="footer.tpl"}
