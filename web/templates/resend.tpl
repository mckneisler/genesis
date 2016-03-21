{* Smarty *}

{include file="header.tpl"}

<!--begin resend template-->
<h2>Resend Signature Form</h2>

<form name="resend" action="" method="post">
{validate id="emailIsEmail" message="<span class='errorText'>E-Mail Address must be a valid address.</span><br />"}
<strong>E-Mail Address</strong>
<input type="text" name="email" size="60" value="{$email}" />

<div id="buttons">
<input type="submit" name="send" value="Send" />
<input type="submit" name="exit" value="Exit" />
</div>

</form>

{include file="footer.tpl"}