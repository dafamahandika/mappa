@extends('layout.main')

@section('container')
<form id="form-rak">
	@csrf
	<div class="row g-3">
		<div class="col-12">
			<label for="last_id_rak" class="form-label">ID Rak Terakhir</label>
			<input type="text" name="last_id_rak" class="form-control mb-3" id="last_id_rak" value="{{ $last_id_rak->id_rak }}">
			<div class="card">
				<div class="card-header">
					Lokasi Rak Berdasarkan ID Rak Terakhir
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Organisasi : <span id="info_organisasi">{{ $lokasi_rak->nm_organisasi }} ({{ $lokasi_rak->id_organisasi }})</span></li>
					<li class="list-group-item">Lokasi Penyimpanan : <span id="info_lokasi">{{ $lokasi_rak->nm_lokasi_penyimpanan }} ({{ $lokasi_rak->id_lokasi_penyimpanan }})</span></li>
					<li class="list-group-item">Rak : <span id="info_rak">{{ $lokasi_rak->nm_rak }} ({{ $lokasi_rak->id_rak }})</span></li>
				</ul>
			</div>
		</div>
		<div class="col-12">
			<label for="id_lokasi_penyimpanan" class="form-label">ID Lok. Penyimpanan Terakhir</label>
			<input type="text" name="id_lokasi_penyimpanan" id="id_lokasi_penyimpanan" class="form-control mb-3" value="{{ $last_id_lokasi_penyimpanan->id_lokasi_penyimpanan }}">
			<div class="card">
				<div class="card-header">
					Nama Organisasi Berdasarkan ID Lokasi Terakhir
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Organisasi : <span id="info_organisasi_2">{{ $last_id_lokasi_penyimpanan->nm_organisasi }} ({{ $last_id_lokasi_penyimpanan->id_organisasi }})</span></li>
					<li class="list-group-item">Lokasi Penyimpanan : <span id="info_lokasi_2">{{ $last_id_lokasi_penyimpanan->nm_lokasi_penyimpanan }} ({{ $last_id_lokasi_penyimpanan->id_lokasi_penyimpanan }})</span></li>
				</ul>
			</div>
		</div>
		<div class="col-6">
			<label for="start_rak" class="form-label">Dari Rak</label>
			<input type="text" name="start_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-6">
			<label for="end_rak" class="form-label text-center">Sampai Rak</label>
			<input type="text" name="end_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-12">
			<label for="prefix" class="form-label">Prefix Nama Rak</label>
			<input type="text" name="prefix" class="form-control" id="prefix" placeholder="Contoh : Lemari">
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
			<table class="table" id="rak_table">
				<thead>
					<tr>
						<th>id_rak</th>
						<th>id_lokasi_penyimpanan</th>
						<th>nm_rak</th>
						<th>cd_rak</th>
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
		initDatatables('#rak_table');
	});

	$('#form-rak').submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: 'rak/generate',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('#rak_table').DataTable().destroy();
            $('#rak_table').find('tbody').html('');
            $('#rak_table').find('tbody').append(data);
            initDatatables('#rak_table');
        })

        e.preventDefault();
    });

    $('#last_id_rak').keyup(function(e) {
        $.ajax({
            method: 'POST',
            url: 'rak/find',
            data: {
            	"_token": "{{ csrf_token() }}",
            	"id": this.value,
            	"type" : "rak"
            }
        })
        .done(function(data) {
        	$('#info_organisasi').html('-');
            $('#info_lokasi').html('-');
            $('#info_rak').html('-');

        	if (data !== '') {
        		$('#info_organisasi').html(data.nm_organisasi + ' (' + data.id_organisasi + ')');
	            $('#info_lokasi').html(data.nm_lokasi_penyimpanan + ' (' + data.id_lokasi_penyimpanan + ')');
	            $('#info_rak').html(data.nm_rak + ' (' + data.id_rak + ')');
        	}
        })
    });

    $('#id_lokasi_penyimpanan').keyup(function(e) {
        $.ajax({
            method: 'POST',
            url: 'lokasi-penyimpanan/find',
            data: {
            	"_token": "{{ csrf_token() }}",
            	"id": this.value,
            	"type" : "lokasi_penyimpanan"
            }
        })
        .done(function(data) {
        	$('#info_organisasi_2').html('-');
            $('#info_lokasi_2').html('-');

        	if (data !== '') {
        		$('#info_organisasi_2').html(data.nm_organisasi + ' (' + data.id_organisasi + ')');
	            $('#info_lokasi_2').html(data.nm_lokasi_penyimpanan + ' (' + data.id_lokasi_penyimpanan + ')');
        	}
        })
    });
</script>
@endsection