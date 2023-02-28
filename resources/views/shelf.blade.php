@extends('layout.main')

@section('container')
<form id="form-shelf">
	@csrf
	<div class="row g-3">
		<div class="col-12">
			<label for="last_id_shelf" class="form-label">ID Shelf Terakhir</label>
			<input type="text" name="last_id_shelf" class="form-control mb-3" id="last_id_shelf" value="{{ $last_id_shelf->id_shelf }}">
			<div class="card">
				<div class="card-header">
					Lokasi Shelf Berdasarkan ID Shelf Terakhir
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Organisasi : <span id="info_organisasi">{{ $lokasi_shelf->nm_organisasi }} ({{ $lokasi_shelf->id_organisasi }})</span></li>
					<li class="list-group-item">Lokasi Penyimpanan : <span id="info_lokasi">{{ $lokasi_shelf->nm_lokasi_penyimpanan }} ({{ $lokasi_shelf->id_lokasi_penyimpanan }})</span></li>
					<li class="list-group-item">Rak : <span id="info_rak">{{ $lokasi_shelf->nm_rak }} ({{ $lokasi_shelf->id_rak }})</span></li>
					<li class="list-group-item">Shelf : <span id="info_shelf">{{ $lokasi_shelf->nm_shelf }} ({{ $lokasi_shelf->id_shelf }})</span></li>
				</ul>
			</div>
		</div>
		<div class="col-12">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" role="switch" name="range" value="1" id="range" checked>
				<label class="form-check-label" for="range">Range?</label>
			</div>
		</div>
		<div class="col-6" id="range_start_rak">
			<label for="start_id_rak" class="form-label">Dari ID Rak</label>
			<input type="text" name="start_id_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-6" id="range_end_rak">
			<label for="end_id_rak" class="form-label text-center">Sampai ID Rak</label>
			<input type="text" name="end_id_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-12" id="multiple_rak">
			<label for="start_shelf" class="form-label">Sebutkan ID Rak</label>
			<select name="id_raks[]" id="id_raks" class="form-control select2" multiple="multiple">
				<option value=""></option>
			</select>
		</div>
		<div class="col-6">
			<label for="start_shelf" class="form-label">Dari Shelf</label>
			<input type="text" name="start_shelf" class="form-control" placeholder="0">
		</div>
		<div class="col-6">
			<label for="end_shelf" class="form-label text-center">Sampai Shelf</label>
			<input type="text" name="end_shelf" class="form-control" placeholder="0">
		</div>
		<div class="col-12">
			<label for="tanggal" class="form-label">Kuota</label>
			<input type="text" name="kuota" class="form-control" id="kuota" placeholder="0">
		</div>
		<div class="col-12">
			<label for="tanggal" class="form-label">Tanggal</label>
			<input type="text" name="tanggal" class="form-control" id="tanggal">
		</div>
		<div class="col-12">
			<label for="user" class="form-label">Kode User</label>
			<input type="text" name="user" class="form-control" id="user" value="G428">
		</div>
		<div class="col-12 d-grid gap-2">
			<button type="submit" class="btn btn-primary">Generate Table</button>
		</div>
	</div>
	@section('datatable')
	<div class="row g-3 mt-3">
		<div class="col-12">
			<table class="table" id="shelf_table">
				<thead>
					<tr>
						<th>id_shelf</th>
						<th>id_rak</th>
						<th>nm_shelf</th>
						<th>cd_shelf</th>
						<th>max_box_kuota</th>
						<th>created_dttm</th>
						<th>created_user_id</th>
						<th>is_nullified</th>
						<th>nullified_dttm</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	@endsection
</form>
@endsection

@section('page-js')
<script type="text/javascript">
	$(document).ready(function() {
		initTodayDate('#tanggal');
		initDatatables('#shelf_table');
		$("#range").prop( "checked", true );
		$("#multiple_rak").hide();
	});

	$('#form-shelf').submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: 'shelf/generate',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('#shelf_table').DataTable().destroy();
            $('#shelf_table').find('tbody').html('');
            $('#shelf_table').find('tbody').append(data);
            initDatatables('#shelf_table');
        })

        e.preventDefault();
    });

    $('#last_id_shelf').keyup(function(e) {
        $.ajax({
            method: 'POST',
            url: 'shelf/find',
            data: {
            	"_token": "{{ csrf_token() }}",
            	"id": this.value,
            	"type": "shelf"
            }
        })
        .done(function(data) {
        	$('#info_organisasi').html('-');
            $('#info_lokasi').html('-');
            $('#info_rak').html('-');
            $('#info_shelf').html('-');

        	if (data !== '') {
        		$('#info_organisasi').html(data.nm_organisasi + ' (' + data.id_organisasi + ')');
	            $('#info_lokasi').html(data.nm_lokasi_penyimpanan + ' (' + data.id_lokasi_penyimpanan + ')');
	            $('#info_rak').html(data.nm_rak + ' (' + data.id_rak + ')');
	            $('#info_shelf').html(data.nm_shelf + ' (' + data.id_shelf + ')');
        	}
        })
    });

    $('#range').click(function() {
    	let speed = "fast";
		if ($("#range").is(':checked')) {
			$("#range_start_rak").show(speed);
			$("#range_end_rak").show(speed);
			$("#multiple_rak").hide(speed);
		} else {
			$("#range_start_rak").hide(speed);
			$("#range_end_rak").hide(speed);
			$("#multiple_rak").show(speed);
		}
    });
</script>
@endsection