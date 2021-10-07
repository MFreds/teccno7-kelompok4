@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>(banner) Selamat datang di merchoon</h1>

            <h1>Top Services</h1>
            <div class="row" id="topService">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('api.product.getAllServices') }}",
            method: 'post',
            success: function(result) {
                console.log(result)

                const data = result.data

                for (var i=0; i<data.length; i++) {
                    $('#topService').append(`
                    <div class="col-sm-4 my-2">
                        <div class="card">
                            <img src="` + data[i].photo + `" class="card-img-top card-images" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">` + data[i].name + `</h5>
                                <p class="card-text"> Rp` + data[i].price + `</p>
                                <a href="#" class="btn btn-primary">Lihat Barang</a>
                            </div>
                        </div>
                    </div>
                    `);
                }

                // if(result.errors) {
                //     $('.alert-danger').html('');
                //     $.each(result.errors, function(key, value) {
                //         $('.alert-danger').show();
                //         $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                //     });
                // } else {
                //     $('.alert-danger').hide();
                //     $('.alert-success').show();
                //     $('.datatable').DataTable().ajax.reload();
                //     setInterval(function(){
                //         $('.alert-success').hide();
                //         $('#CreateArticleModal').modal('hide');
                //         location.reload();
                //     }, 2000);
                // }
            }
        });
    });
</script>
@endsection
