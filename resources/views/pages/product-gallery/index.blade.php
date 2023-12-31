@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset("assets/css/lib/datatable/dataTables.bootstrap.min.css") }}">   
<script src="{{ asset("sweetalert2/dist/sweetalert2.all.min.js") }}"></script> 
@endpush

@section('content')

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Galeri Produk</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Foto</th>
                                <th>Default</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_galleries as $product_gallery)
                                <tr>
                                    <td>{{ $product_gallery->Product->name }}</td>
                                    <td>
                                        <img src="/storage/{{ ($product_gallery->image) }}" alt="" width="150px">
                                    </td>
                                    <td>{{ $product_gallery->is_default ? 'Ya' : 'Tidak' }}</td>
                                    <td>
                                        <form action="{{ route('admin.galeri.destroy', $product_gallery->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" id="hapus" class="btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
@push('script')
<script src="{{ asset("assets/js/lib/data-table/datatables.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/dataTables.bootstrap.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/buttons.bootstrap.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/jszip.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/vfs_fonts.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/buttons.html5.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/buttons.print.min.js") }}"></script>
    <script src="{{ asset("assets/js/lib/data-table/buttons.colVis.min.js") }}"></script>
    <script src="{{ asset("assets/js/init/datatables-init.js") }}"></script>

    @if (session("success"))
    <script>
        Swal.fire(
            "Sukses",
            `{{ session("success") }}`,
            "success"
        );
    </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        });

        $("button#hapus").on("click", function () {
            Swal.fire({
            title: 'Apakah anda yakin untuk menghapus data ini?',
            showDenyButton: true,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("form").submit();
            } else if (result.isDenied) {
                Swal.fire('Batal', 'Data batal dihapus', 'info')
            }
            });
        });
    </script>
@endpush