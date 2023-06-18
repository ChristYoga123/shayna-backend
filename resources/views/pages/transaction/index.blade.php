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
                    <strong class="card-title">Data Transaksi</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Total Transaksi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->email }}</td>
                                    <td>{{ $transaction->phone_number }}</td>
                                    <td>{{ $transaction->total }}</td>
                                    <td>
                                        @if ($transaction->payment_status === "waiting")
                                            <span class="badge badge-warning">
                                        @elseif ($transaction->payment_status === "paid")
                                            <span class="badge badge-success">
                                        @elseif ($transaction->payment_status === "failed")
                                            <span class="badge badge-danger">
                                        @else
                                            <span>
                                        @endif
                                        {{ $transaction->payment_status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Modal Button --}}
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#transaction-modal" onclick="getDetailTransaction({{ $transaction->id }})">
                                            <i class="fa fa-eye"></i>
                                        </button>
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

<div class="modal fade" id="transaction-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <i class="fa fa-spinner fa-spin" id="loading"></i>
                <table class="table table-bordered d-none" id="modal-table">
                    <tr>
                        <th>Nama</th>
                        <td id="nama"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td id="telepon"></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td id="total"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="status"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="alamat"></td>
                    </tr>
                    <tr>
                        <th>Pembelian</th>
                        <td>
                            <table class="table table-bordered w-100">
                                <tr>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                </tr>
                                <tbody class="pembelian-row"></tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    // Get Detail Transaction
    function getDetailTransaction(id) {
        $.ajax({
            method: "GET",
            url: `{{ url("admin/transaksi") }}/${id}`,
            dataType: "json",
            beforeSend: function()
            {
                $("#loading").removeClass("d-none");
                $("#modal-table").addClass("d-none");
                $(".modal-title").html(`Detail Transaksi - <strong>Sedang mengambil data</strong>`)
            },
            success: function (response) {
                $("#loading").addClass("d-none");
                $("#modal-table").removeClass("d-none");
                $(".modal-title").html(`Detail Transaksi - <strong>${response.midtrans_booking_code}</strong>`)
                $("td#nama").html(`${response.name}`)
                $("td#email").html(`${response.email}`)
                $("td#telepon").html(`${response.phone_number}`)
                $("td#total").html(`${response.total}`)
                $("td#status").html(`${response.payment_status}`)
                $("td#alamat").html(`${response.shipping_address}`)
                let pembelianHtml = "";
                $.each(response.transaction_details, function(index,detail) {
                    pembelianHtml += `
                        <tr>
                            <td class="detail-nama">${detail.product.name}</td>
                            <td class="detail-tipe">${detail.product.type}</td>
                        </tr>
                    `;
                });

                $(".pembelian-row").html(pembelianHtml);
            }
        });
    }
</script>
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
    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        });
    </script>
@endpush