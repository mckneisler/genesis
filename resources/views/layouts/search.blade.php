<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'search_input' }}">
<div class="search-div pull-right">
	<input
		type="text"
		id="search_input"
		class="{{ config('class.search') }}"
		placeholder="{{ code('actions.search')->name }}..."
		onkeypress="search(event, this.value)"
		value="{{ request()->search }}"
	>
	<button
		id="search_icon"
		type="submit"
		class="{{ config('class.search_button') }}"
		onclick="refreshWith('search', $('#search_input').val())"
	>
		<i class="fa fa-btn fa-search"></i>
	</button>
</div>
