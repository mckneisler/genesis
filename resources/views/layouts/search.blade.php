<div class="search-div pull-right">
	<input
		type="search"
		id="search-input"
		class="{{ config('class.search') }}"
		placeholder="Search..."
		onkeypress="search(event, this.value)"
		value="{{ request()->search }}"
	>
	<button
		id="search-icon"
		type="submit"
		class="{{ config('class.search-button') }}"
		onclick="refreshWith('search', $('#search-input').val())"
	>
		<i class="fa fa-btn fa-search"></i>
	</button>
</div>
