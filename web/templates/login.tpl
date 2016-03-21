{include file="header.tpl"}

<div class="w3-row">
	<div class="{$class.form}">
		<div class="{$class.header}">
			<h3>{$heading.login}</h3>
		</div>
		<div class="w3-container w3-padding">
			<form name="loginForm" method="post">
				<p>
					<input type="text" name="emailTxt" id="emailTxt" class="{$class.input}" value="{$return.emailTxt}" />
					<label for="emailTxt" class="w3-text-theme">{$label.email}</label>
					{if isset($errors.emailTxt)}{$errors.emailTxt|error_text}{/if}
				</p>
				<p>
					<input type="password" name="passwordTxt" id="passwordTxt" class="{$class.input}" value="{$return.passwordTxt}" size="50" />
					<label for="passwordTxt" class="w3-text-theme">{$label.password}</label>
					{if isset($errors.passwordTxt)}{$errors.passwordTxt|error_text}{/if}
				</p>
				<input type="submit" name="login" class="{$class.button}" value="{$button.login}" /><br />
			</form>
		</div>
	</div>
</div>

<div class="w3-row">
	<div class="w3-half">
		<span>{$phrase.newUser}</span>
		<a href="register.php">{$phrase.signUp}</a>
	</div>
</div>

{include file="footer.tpl"}
