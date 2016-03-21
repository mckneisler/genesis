{include file="header.tpl"}

{if $isLoggedIn}
	{assign var="w1" value="40"}
	{assign var="w2" value="40"}
	{assign var="w3" value="5"}
	{assign var="w4" value="15"}
	{assign var="colspan" value="4"}
{else}
	{assign var="w1" value="40"}
	{assign var="w2" value="40"}
	{assign var="w3" value=""}
	{assign var="w4" value="20"}
	{assign var="colspan" value="3"}
{/if}
<script type="text/javascript">
<!--
function changeAlbumFav(albumId, checked) {
    $url = "{$urlRoot}ajaxAlbumFav.php?userId={$userId}&albumId=" + albumId + "&isFav=" + checked;
    $.ajax({
        type: "GET",
        url: $url,
        success: function(response) {
            $("#return_" + albumId).html(response);
            $("#return_" + albumId).removeClass("w3-hide");
        }
    });
}

function myFunction() {
    document.getElementById("Demo").classList.toggle("w3-show");
}

function showinfo() {
	var msg = "";
	msg += "table id: " + $("table").attr("id") + "\n";
	msg += "table width: " + $("table").width() + "\n";
	msg += "parent width: " + $("table").parent().width() + "\n";
	msg += "swipe id: " + $("[id^=" + $("table").attr("id") + "Swipe]").attr("id") + "\n";
	alert(msg);
}

// -->
</script>

<!---
<input type="button" class="w3-button" onclick="showinfo()" value="Info" />
--->
{if !$isLoggedIn}
<p>
	{$phrase.toSelectFavs} <a href="login.php">{$phrase.loggedIn}</a>
</p>
{/if}

<form name="songsForm" method="post">
	<div id="albumsTableSwipeTop" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>

	<div class="{$class.tableDiv}">
		<table id="albumsTable" class="w3-table w3-striped w3-bordered">
			<thead>
				<tr class="w3-theme-l3">
					<th style="width: {$w1}%">{$label.artist}</th>
					<th style="width: {$w2}%; min-width: 200px">{$label.album}</th>
{if $isLoggedIn}
					<th class="w3-center" style="width: {$w3}%">{$label.favorite}</th>
{/if}
					<th class="w3-center" style="width: {$w4}%">{$label.action}</th>
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
{if $albums}
				<tr>
					<td>
						{html_options name='artistId' options=$artists selected=$artistId}
<!---
				<div class="w3-dropdown-click">
					<button onclick="myFunction()" class="w3-btn">{$artists.$artistId}
		<div class="w3-border, w3-right">
			<i class="fa fa-sort"></i>
		</div>
					</button>
					<div id="Demo" class="w3-dropdown-content w3-card-4">
	{foreach from=$artists key=aId item=artist}
						<a href="#">({$aId}) {$artist}</a>
	{/foreach}
						<a href="#">Link 2</a>
						<a href="#">Link 3</a>
					</div>
				</div>

--->
					</td>
					<td>
						&nbsp;
					</td>
	{if $isLoggedIn}
					<td>
						&nbsp;
					</td>
	{/if}
					<td>
						&nbsp;
					</td>
				</tr>
	{foreach name="albums" from=$albums item=album}
				<tr class="w3-hover-theme-l4">
					<td>
						{$album.artistNameTxt}
					</td>
					<td>
						{$album.albumNameTxt}
					</td>
		{if $isLoggedIn}
					<td class="w3-center">
						<span>
							<input type="checkbox" class="w3-check" onclick="changeAlbumFav({$album.albumId}, this.checked);" {if $album.isFav} checked="checked"{/if} />
							<span class="w3-hide" id="return_{$album.albumId}">&nbsp;</span>
						</span>
					</td>
		{/if}
					<td class="w3-center">
						[<a href="songs.php?albumId={$album.albumId}">{$label.songs}</a>]
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

	<div id="albumsTableSwipeBottom" class="{$class.swipe}"><strong><<< {$phrase.swipe} >>></strong></div>
</form>

{include file="footer.tpl"}
