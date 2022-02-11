@extends('statamic::layout')
@section('title', __('Export order to CSV'))

@section('content')
	<div class="flex items-center justify-between">
		<h1>{{ __('Export orders') }}</h1>
	</div>

	<div class="mt-3 card">
		<form method="POST" action="{{ cp_route('utilities.export.download') }}" >
			@csrf

			<div class="mb-2 publish-field publish-field__label text-fieldtype field-w-1/2">
				<div class="field-inner">
					<label for="field_label" class="publish-field-label">
						<span>Start date</span>
					</label>
				</div>

				<div class="flex items-center">
					<div class="input-group">
						<input type="date" name="from" required class="input-text">
					</div>
				</div>
			</div>

			<div class="mb-2 publish-field publish-field__label text-fieldtype field-w-1/2">
				<div class="field-inner">
					<label for="field_label" class="publish-field-label">
						<span>End date (not included)</span>
					</label>
					<div class="help-block -t-1">
						<p>Try reducing the range if the export fails</p>
					</div>
				</div>

				<div class="flex items-center">
					<div class="input-group">
						<input type="date" name="until" required class="input-text">
					</div>
				</div>
			</div>

			@error('collection')
				<p class="text-red text-xs mt-1">{{ $message }}</p>
			@enderror

			<button type="submit" class="btn-primary mt-2">{{ __('Export orders') }}</button>
		</form>
	</div>
@stop



