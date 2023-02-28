<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAPPA | Mapping Arsip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sc-2.0.7/sb-1.4.0/datatables.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">MAPPA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link {{ $page == 'rak' ? 'active' : '' }}" {{ $page == 'rak' ? 'aria-current="page"' : '' }} href="rak">Rak</a>
            <a class="nav-link {{ $page == 'shelf' ? 'active' : '' }}" {{ $page == 'shelf' ? 'aria-current="page"' : '' }} href="shelf">Shelf</a>
            <a class="nav-link {{ $page == 'box' ? 'active' : '' }}" {{ $page == 'box' ? 'aria-current="page"' : '' }} href="box">Box</a>
            <a class="nav-link {{ $page == 'dokumen_grup' ? 'active' : '' }}" {{ $page == 'dokumen_grup' ? 'aria-current="page"' : '' }} href="dokumen-grup">Dokumen Grup</a>
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-4 mb-4">
      <div class="row">
        <div class="col-6">
          <div class="card h-100">
            <div class="card-header">
              Mapping
            </div>
            <div class="card-body">
              @yield('container')
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card h-100">
            <div class="card-header">
              Cek ID
            </div>
            <div class="card-body">
              @include('cek')
            </div>
          </div>
        </div>
        <div class="col-12">
          @yield('datatable')
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sc-2.0.7/sb-1.4.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
    <script type="text/javascript">
      function initTodayDate(selector) {
        var currentdate = new Date(); 
        var datetime = currentdate.getFullYear() + "-" 
                    + ("0" + (currentdate.getMonth() + 1)).slice(-2) + "-"
                    + ("0" + currentdate.getDate()).slice(-2) + " "
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds() + ".000";
        $(selector).val(datetime);
      }

      function initSelect2(selector) {
        $(selector).select2({
          placeholder : 'Pilih salah satu',
          allowClear : true,
          theme : 'bootstrap-5'
        });
      }

      function initDatatables(selector) {
        let export_button = true;
        $(selector).DataTable({
          sDom: "<'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
          buttons: export_button ? [
            {
              extend: 'copy',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              } 
            },
            {
              extend: 'excel',
              orientation: 'landscape',
              pageSize: 'A4',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            },
            {
              extend: 'csv',
            },
            {
              extend: 'pdf',
              orientation: 'landscape',
              pageSize: 'A4',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            },
            {
              extend: 'print',
              orientation: 'landscape',
              pageSize: 'A4',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            }
          ] : [],
        });
      }

      $(document).ready(function() {
        $.ajax({
          url: 'organisasi/all'
        })
        .done(function(data) {
          $.each( data, function( key, value ) {
            let option = '<option value="'+value.id_organisasi+'">'+value.nm_organisasi+' ('+value.id_organisasi+')</option>';
            $('#organisasi').append(option);
          });
          initSelect2('.select2');
        })
      })

      $('#organisasi').on('change', function() {
        $.ajax({
          method: 'POST',
          url: 'lokasi-penyimpanan/find',
          data: { 
            "_token": "{{ csrf_token() }}",
            "id": this.value,
            "type": "organisasi" 
          }
        })
        .done(function(data) {
          $('#lokasi-penyimpanan').html('');
          $.each( data, function( key, value ) {
            let option = '<option value="'+value.id_lokasi_penyimpanan+'">'+value.nm_lokasi_penyimpanan+' ('+value.id_lokasi_penyimpanan+')</option>';
            $('#lokasi-penyimpanan').append(option);
            $('#lokasi-penyimpanan').trigger('change');
          });
          initSelect2('.select2');
        })
      });

      $('#lokasi-penyimpanan').on('change', function() {
        $.ajax({
          method: 'POST',
          url: 'rak/find',
          data: { 
            "_token": "{{ csrf_token() }}",
            "id": this.value,
            "type" : "lokasi_penyimpanan"
          }
        })
        .done(function(data) {
          $('#rak').html('');
          $('#id_raks').html('');
          $.each( data, function( key, value ) {
            let option_id = '<option value="'+value.id_rak+'">'+value.nm_rak+' ('+value.id_rak+')</option>';
            let option_name = '<option value="'+value.nm_rak+'">'+value.nm_rak+' ('+value.id_rak+')</option>';
            let page = '{{ Request::segment(1) }}';

            $('#rak').append(option_id);
            
            if (page == 'shelf') {
              $('#id_raks').append(option_id);
            } else if (page == 'box') {
              $('#id_raks').append(option_name);
            }
          });
        })
      });

      $('#rak').on('change', function() {
        $.ajax({
          method: 'POST',
          url: 'shelf/find',
          data: { 
            "_token": "{{ csrf_token() }}",
            "id": this.value,
            "type": "rak"
          }
        })
        .done(function(data) {
          $('#shelf').html('');
          $.each( data, function( key, value ) {
            let option = '<option value="'+value.id_shelf+'">'+value.nm_shelf+' ('+value.id_shelf+')</option>';
            $('#shelf').append(option);
          });
        })
      });
    </script>
    @yield('page-js')
  </body>
</html>
