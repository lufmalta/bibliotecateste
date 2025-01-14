<div class="table-filters">

	<form action="" method="get">
		<div class="row">
			<div class="col-8 col-md-9">
				<div class="form-group">
					<input type="text" name="search" class="form-control onchange-submit" placeholder="Pesquisar..." value="{{ Request::get('search') }}">
				</div>
			</div>
			<div class="col-4 col-md-3">
				<select class="form-control onchange-submit" name="display_qty">
					@foreach (getLimitValues() as $number)
						<option value="{{ $number }}" {{ $number == Request::get('limit_per_page') ? 'selected="selected"' : '' }}>{{ $number }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</form>

</div>
