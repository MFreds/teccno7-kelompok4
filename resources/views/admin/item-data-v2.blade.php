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
            Grafik Penjualan
        </div>
        <div class="px-5 py-2 admin-nav mx-2 admin-nav-active">
            <a href="/admin/item/data"></a>
            Data Item
        </div>
        <div class="px-5 py-2 admin-nav mx-2">
            <a href="/admin/bundle/data"></a>
            Data Bundle
        </div>
    </div>
</div>
<div class="container mt-5 card p-3">
    <div class="d-flex my-2">
        <a class="px-5 py-1 btn btn-primary" href="/item/create">
            Buat Item Baru
        </a>
    </div>
    <table class="table table-bordered datatable">
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
    </table>
</div>

<!-- Edit Article Modal -->
<div class="modal" id="EditArticleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Article Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Article was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditArticleModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditArticleForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Article Modal -->
<div class="modal" id="DeleteArticleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Item Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Item?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteArticleForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
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

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            ajax: "{{ route('item.listv2') }}",
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

    // Get single article in EditModel
    $('.modelClose').on('click', function(){
        $('#EditArticleModal').hide();
    });
    var id;
    $('body').on('click', '#getEditArticleData', function(e) {
        // e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        id = $(this).data('id');
        $.ajax({
            url: "http://127.0.0.1:8000/item/"+id+"/edit",
            method: 'GET',
            // data: {
            //     id: id,
            // },
            success: function(result) {
                console.log(result);
                $('#EditArticleModalBody').html(result.html);
                $('#EditArticleModal').show();
            }
        });
    });

    // Update article Ajax request.
    $('#SubmitEditArticleForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "http://127.0.0.1:8000/item/"+id,
            method: 'PUT',
            data: {
                name: $('#editName').val(),
                description: $('#editDescription').val(),
                price: $('#editPrice').val(),
                stock: $('#editStock').val(),
                status: $('#editStatus').val(),
            },
            success: function(result) {
                if(result.errors) {
                    $('.alert-danger').html('');
                    $.each(result.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                } else {
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function(){
                        $('.alert-success').hide();
                        $('#EditArticleModal').hide();
                    }, 2000);
                }
            }
        });
    });

    // Delete article Ajax request.
    var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteArticleForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "http://127.0.0.1:8000/item/"+id+"/delete",
                method: 'POST',
                success: function(result) {
                    $('.datatable').DataTable().ajax.reload();
                    $('#DeleteArticleModal').hide();
                    $('.modal-backdrop').hide();
                }
            });
        });
</script>
@endsection
