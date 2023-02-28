@extends('layout.main')

@section('container')
<form id="form-box">
	@csrf
	<div class="row g-3">
		<div class="col-12">
			<label for="last_id_box_folder" class="form-label">ID Box Folder Terakhir</label>
			<input type="text" name="last_id_box_folder" class="form-control mb-3" id="last_id_box_folder" value="{{ $last_id_box_folder->id_box_folder }}">
			<div class="card">
				<div class="card-header">
					Lokasi Box Berdasarkan ID Box Terakhir
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Organisasi : <span id="info_organisasi">{{ $lokasi_box->nm_organisasi }} ({{ $lokasi_box->id_organisasi }})</span></li>
					<li class="list-group-item">Lokasi Penyimpanan : <span id="info_lokasi">{{ $lokasi_box->nm_lokasi_penyimpanan }} ({{ $lokasi_box->id_lokasi_penyimpanan }})</span></li>
					<li class="list-group-item">Rak : <span id="info_rak">{{ $lokasi_box->nm_rak }} ({{ $lokasi_box->id_rak }})</span></li>
					<li class="list-group-item">Shelf : <span id="info_shelf">{{ $lokasi_box->nm_shelf }} ({{ $lokasi_box->id_shelf }})</span></li>
					<li class="list-group-item">Box : <span id="info_box">{{ $lokasi_box->cd_box_folder }} ({{ $lokasi_box->id_box_folder }})</span></li>
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
			<label for="start_rak" class="form-label">Dari Rak</label>
			<input type="text" name="start_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-6" id="range_end_rak">
			<label for="end_rak" class="form-label text-center">Sampai Rak</label>
			<input type="text" name="end_rak" class="form-control" placeholder="0">
		</div>
		<div class="col-12" id="multiple_rak">
			<div class="alert alert-primary" role="alert">
				Jika input di bawah kosong, maka Anda harus memilih Organisasi dan Lokasi Penyimpanan pada kolom <b>Cek ID</b> disamping :)
			</div>
			<label for="start_shelf" class="form-label">Sebutkan Nomor Rak</label>
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
		<div id="shelf_pertama">
			<div class="col-12">
				<label for="id_shelfs" class="form-label">ID Shelf Pertama</label>
				<input type="text" name="id_shelfs[]" class="form-control" placeholder="0">
			</div>
		</div>
		<div class="col-12">
			<label for="kapasitas_box" class="form-label">Kapasitas Box per Shelf</label>
			<input type="text" name="kapasitas_box" class="form-control" id="kapasitas_box" placeholder="0">
		</div>
		<div class="col-12">
			<label for="tanggal" class="form-label">Tanggal</label>
			<input type="text" name="tanggal" class="form-control" id="tanggal">
		</div>
		<div class="col-12">
			<label for="user" class="form-label">Kode User</label>
			<input type="text" name="user" class="form-control" id="user" value="G428">
		</div>
		<div class="col-12">
			<label for="last_kode_pelaksana" class="form-label">Kode Pelaksana Terakhir</label>
			<input type="text" name="last_kode_pelaksana" class="form-control" id="last_kode_pelaksana" value="{{ $last_id_box_folder->cd_pelaksana }}" disabled>
		</div>
		<div class="col-12">
			<label for="kode_pelaksana" class="form-label">Kode Pelaksana</label>
			<input type="text" name="kode_pelaksana" class="form-control" id="kode_pelaksana" value="{{ $last_id_box_folder->cd_pelaksana }}">
		</div>
		<div class="col-12 d-grid gap-2">
			<button type="submit" class="btn btn-primary">Generate Table</button>
		</div>
	</div>
	@section('datatable')
	<div class="row g-3 mt-3">
		<div class="col-12">
			<table class="table" id="box_table">
				<thead>
					<tr>
						<th>id_box_folder</th>
						<th>id_shelf</th>
						<th>cd_pelaksana</th>
						<th>cd_box_folder</th>
						<th>is_penuh</th>
						<th>ket_box_folder</th>
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
		initDatatables('#box_table');
		$("#range").prop( "checked", true );
		$("#multiple_rak").hide();
	});

	$('#form-box').submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            method: 'POST',
            url: 'box/generate',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('#box_table').DataTable().destroy();
            $('#box_table').find('tbody').html('');
            $('#box_table').find('tbody').append(data);
            initDatatables('#box_table');
        })

        e.preventDefault();
    });

    $('#last_id_box_folder').keyup(function(e) {
        $.ajax({
            method: 'POST',
            url: 'box/find',
            data: {
            	"_token": "{{ csrf_token() }}",
            	"id": this.value
            }
        })
        .done(function(data) {
        	$('#info_organisasi').html('-');
            $('#info_lokasi').html('-');
            $('#info_rak').html('-');
            $('#info_shelf').html('-');
            $('#info_box').html('-');

        	if (data !== '') {
        		$('#info_organisasi').html(data.nm_organisasi + ' (' + data.id_organisasi + ')');
	            $('#info_lokasi').html(data.nm_lokasi_penyimpanan + ' (' + data.id_lokasi_penyimpanan + ')');
	            $('#info_rak').html(data.nm_rak + ' (' + data.id_rak + ')');
	            $('#info_shelf').html(data.nm_shelf + ' (' + data.id_shelf + ')');
	            $('#info_box').html(data.cd_box_folder + ' (' + data.id_box_folder + ')');
        	}
        })
    });

    $('#range').click(function() {
    	let speed = "fast";
    	let shelf_pertama = '<div class="col-12">' +
									'<label for="id_shelfs" class="form-label">ID Shelf Pertama</label>' +
									'<input type="text" name="id_shelfs[]" class="form-control" placeholder="0">' +
								'</div>';

    	$('#shelf_pertama').html('');
		if ($("#range").is(':checked')) {
			$("#range_start_rak").show(speed);
			$("#range_end_rak").show(speed);
			$("#multiple_rak").hide(speed);

			

			
			$('#shelf_pertama').append(shelf_pertama);
		} else {
			$("#range_start_rak").hide(speed);
			$("#range_end_rak").hide(speed);
			$("#multiple_rak").show(speed);
		}
    });

    $('#id_raks').change(function(e) {
        let value = $(this).val();
    	let count = $("#id_raks :selected").length;
    	let shelf_pertama = '<div class="col-12">' +
								'<label for="id_shelfs" class="form-label">ID Shelf Pertama Dari Rak ' + value[count - 1] + '</label>' +
								'<div class="input-group mb-3">' +
  									'<input type="text" name="id_shelfs[]" class="form-control" placeholder="0">' +
  									'<button class="btn btn-outline-danger button_hapus" type="button">' +
  										'<i class="fas fa-times">' +
  									'</button>' +
								'</div>' +
							'</div>';
		if (count == 0) {
			$('#shelf_pertama').html('');
		} else {
			$('#shelf_pertama').append(shelf_pertama);
		}
    });

    $(document).on("click", ".button_hapus", function(e) {
    	$(this).closest('.col-12').remove();
    });
</script>
@endsection