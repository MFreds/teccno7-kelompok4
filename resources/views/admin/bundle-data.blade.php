@extends('layouts.app')

@section('styles')

<style>
    .admin-nav-active {
        background-color: #325D79 !important;
        color: #fff;
    }

    .admin-nav {
        background-color: #fff;
        border-radius: 25px;
        border: 1px #325D79 solid;
    }

    .admin-nav:hover {
        cursor: pointer;
        background-color: #475C7A;
        color: #fff;
        transition: background-color 100ms linear;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    <div class="d-flex flex-row justify-content-start">
        <div class="px-5 py-2 admin-nav mx-2" >
            <a href="/admin/home"></a>
            Penjualan
        </div>
        <div class="px-5 py-2 admin-nav mx-2">
            <a href="/admin/item/data"></a>
            Data Item
        </div>
        <div class="px-5 py-2 admin-nav mx-2 admin-nav-active">
            <a href="/admin/bundle/data"></a>
            Data Bundle
        </div>
    </div>
</div>
<div class="container mt-5 card p-3">
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>price</th>
                <th>stock</th>
                <th>status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $(".admin-nav").click(function() {
        window.location = $(this).find("a").attr("href");
        return false;
    });

    $(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bundle.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'stock', name: 'stock'},
            {data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });

  });
</script>
@endsection
