@if (
		session()->has('flash_message_embed')
		|| ( ! config('custom.show_popup_messages')
			&& (session()->has('flash_message')
				|| session()->has('flash_message_overlay')
			)
		)
		|| ( ! config('custom.show_popup_errors')
			&& $errors->count()
		)
	)
	@if (session()->has('flash_message_embed'))
		{? $message = session('flash_message_embed'); ?}
	@endif
	@if ( ! config('custom.show_popup_messages'))
		@if (session()->has('flash_message'))
			{? $message = session('flash_message'); ?}
		@endif
		@if (session()->has('flash_message_overlay'))
			{? $message = session('flash_message_overlay'); ?}
		@endif
	@endif
	@if ( ! config('custom.show_popup_errors') && $errors->count())
		{? $message['title'] = trans('phrase.errorsFound'); ?}
		{? $message['message'] = trans_choice('phrase.errorsFoundCount', $errors->count(), ['count' => $errors->count(), 'error' => trans_choice('object.error', $errors->count())]) . '  ' . trans('phrase.tryAgain'); ?}
		{? $message['level'] = 'danger'; ?}
	@endif
	@if ($message['level'] == 'error')
		{? $message['level'] = 'danger'; ?}
	@endif

	<div class="w3-container">
		<div class="alert alert-{{ $message['level'] }} fade in">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>{{ $message['title'] }}</strong>:  {{ $message['message'] }}
		</div>
	</div>
@endif

@if (session()->has('flash_message') && config('custom.show_popup_messages'))
	<script type="text/javascript">
		swal({
			title: "{!! session('flash_message.title') !!}",
			text: "{!! session('flash_message.message') !!}",
			type: "{{ session('flash_message.level') }}",
			timer: {{ config('custom.message_timer') }},
			showConfirmButton: false
		});
	</script>
@endif

@if (session()->has('flash_message_overlay') && config('custom.show_popup_messages'))
	<script type="text/javascript">
		swal({
			title: "{{ session('flash_message_overlay.title') }}",
			text: "{{ session('flash_message_overlay.message') }}",
			type: "{{ session('flash_message_overlay.level') }}",
			confirmButton: 'Okay'
		});
	</script>
@endif

@if ($errors->count() && config('custom.show_popup_messages'))
	<script type="text/javascript">
		swal({
			title: "{{ trans('phrase.errorsFound') }}",
			text: "{!! trans_choice('phrase.errorsFoundCount', $errors->count(), [
				'count' => $errors->count(),
				'error' => trans_choice('object.error', $errors->count())
			]) !!} {!! trans('phrase.tryAgain') !!}",
			type: "error",
			timer: {{ config('custom.message_timer') }},
			showConfirmButton: false
		});
	</script>
@endif
