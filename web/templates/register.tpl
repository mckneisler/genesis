{include file="header.tpl"}

<div class="w3-row">
	<div class="{$class.form}">
		<div class="{$class.header}">
			<h3>{$heading.newUser}</h3>
		</div>
		<div class="w3-container w3-padding">
			<form name="registerForm" method="post">
				<p>
					<input type="text" name="emailTxt" id="emailTxt" class="{$class.input}" value="{$return.emailTxt}" />
					<label for="emailTxt" class="w3-text-theme">{$label.email}</label>
					{if isset($errors.emailTxt)}{$errors.emailTxt|error_text}{/if}
				</p>
				<p>
					<input type="password" name="passwordTxt" id="passwordTxt" class="{$class.input}" value="{$return.passwordTxt}" size="50" />
					<label for="passwordTxt" class="w3-text-theme">{$label.password} <span class="w3-small">{$phrase.passwordRules}</span></label>
					{if isset($errors.passwordTxt)}{$errors.passwordTxt|error_text}{/if}
				</p>
				<p>
					<input type="password" name="passwordTxt2" id="passwordTxt2" class="{$class.input}" value="{$return.passwordTxt2}" size="50" />
					<label for="passwordTxt2" class="w3-text-theme">{$label.reenterPassword}</label>
					{if isset($errors.passwordTxt2)}{$errors.passwordTxt2|error_text}{/if}
				</p>
				<input type="submit" name="register" class="{$class.button}" value="{$button.register}" /><br />
			</form>
		</div>
	</div>
</div>

<div class="w3-row">
	<div class="w3-half">
		<span>{$phrase.existingUser}</span>
		<a href="login.php">{$phrase.login}</a>
	</div>
</div>

{include file="footer.tpl"}
