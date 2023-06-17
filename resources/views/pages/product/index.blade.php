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
                    <strong class="card-title">Data Table</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Harga (Rp)</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        <a href="{{ route("admin.barang.show", $product->slug) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-picture-o"></i>
                                        </a>
                                        <a href="{{ route("admin.barang.edit", $product->slug) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route("admin.barang.destroy", $product->slug) }}" method="post" class="d-inline" id="hapus">
                                            @csrf
                                            @method("DELETE")
                                            <button type="button" class="btn btn-danger btn-sm" id="hapus">
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
            title: 'Apakah anda yakin untuk menghapus data ini? Ini akan menghapus data galeri juga',
            showDenyButton: true,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("form#hapus").submit();
            } else if (result.isDenied) {
                Swal.fire('Batal', 'Data batal dihapus', 'info')
            }
            });
        });
    </script>
@endpush