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
        <div class="px-5 py-2 admin-nav mx-2 admin-nav-active">
            <a href="/admin/home"></a>
            Penjualan
        </div>
        <div class="px-5 py-2 admin-nav mx-2">
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
    <canvas id="myChart" width="400" height="200"></canvas>
</div>
<div class="container mt-5 card p-3">
    <table class="table table-bordered datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Invoice</th>
                <th>Total price</th>
            </tr>
        </thead>
    </table>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"
    integrity="sha256-D2tkh/3EROq+XuDEmgxOLW1oNxf0rLNlOwsPIUX+co4=" crossorigin="anonymous"></script>
@endsection

@section('script')
<script type="text/javascript">
    $(".admin-nav").click(function () {
        window.location = $(this).find("a").attr("href");
        return false;
    });
    $(function () {

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            ajax: "{{ route('order.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'Name'
                },
                {
                    data: 'email',
                    name: 'Email'
                },
                {
                    data: 'uuid',
                    name: 'Invoice'
                },
                {
                    data: 'total_price',
                    name: 'Total price'
                },
            ]
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('order.getPejualanData') }}",
        method: 'post',
        success: function (result) {

            const data = result.graph

            var _labels = []
            var _sum = []

            for (var i = 0; i < data.length; i++) {
                _labels.push(data[i].date)
                _sum.push(data[i].sum)
            }
            console.log(_labels, _sum)
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: _labels,
                    datasets: [{
                        label: 'Sales',
                        data: _sum,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            // 'rgba(54, 162, 235, 0.2)',
                            // 'rgba(255, 206, 86, 0.2)',
                            // 'rgba(75, 192, 192, 0.2)',
                            // 'rgba(153, 102, 255, 0.2)',
                            // 'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            // 'rgba(54, 162, 235, 1)',
                            // 'rgba(255, 206, 86, 1)',
                            // 'rgba(75, 192, 192, 1)',
                            // 'rgba(153, 102, 255, 1)',
                            // 'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                    }
                }
            });
        }
    });

</script>
@endsection
