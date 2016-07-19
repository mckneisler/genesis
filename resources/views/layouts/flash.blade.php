@if (session()->has('flash_message'))
	<script type="text/javascript">
		swal({
			title: "{!! session('flash_message.title') !!}",
			text: "{!! session('flash_message.message') !!}",
			type: "{{ session('flash_message.level') }}",
			timer: 2500,
			showConfirmButton: false
		});
	</script>
@endif

@if (session()->has('flash_message_overlay'))
	<script type="text/javascript">
		swal({
			title: "{{ session('flash_message_overlay.title') }}",
			text: "{{ session('flash_message_overlay.message') }}",
			type: "{{ session('flash_message_overlay.level') }}",
			confirmButton: 'Okay'
		});
	</script>
@endif

@if ($errors->count())
	<script type="text/javascript">
		swal({
			title: "{{ trans('phrase.errorsFound') }}",
			text: "{!! trans_choice('phrase.errorsFoundCount', $errors->count(), [
				'count' => $errors->count(),
				'error' => trans_choice('object.error', $errors->count())
			]) !!} {!! trans('phrase.tryAgain') !!}",
			type: "error",
			timer: 2500,
			showConfirmButton: false
		});
	</script>
@endif
