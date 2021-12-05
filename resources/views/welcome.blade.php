@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>(banner) Selamat datang di merchoon</h1>
        </div>
    </div>

    {{-- jasa --}}
    <div>
        <h2 class="font-weight-bold mb-2">Jasa oleh kami</h2>

        <p class="font-italic text-muted mb-4">
            Kami menyediakan berbagai macam jenis jasa!
        </p>
        <div class="row pb-3 mb-1" id="topService">

        </div>
    </div>

    {{--  top jasa --}}
    <div>
        <div class="row">

        </div>
    </div>

    {{-- hampers promo --}}
    <div>
        <h2 class="font-weight-bold mb-2">Hampers Promo!</h2>

        <p class="font-italic text-muted mb-4">
            Hampers yang sedang promo
        </p>
        <div class="row pb-3 mb-1" id="promoHampers">

        </div>
    </div>

    {{-- katalog button --}}
    <div>
        <div class="container row catalog-banner">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6">
                <h4 class="catalog-head">Cek katalog kami!</h4>
            </div>
            <div class="col-lg-3">
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        setupServices()
        setupPromoHampers()

        $('.catalog-banner').on('click', () => {
            window.location.href = "http://127.0.0.1:8000/catalog"
        })
    });

    const setupServices = () => {
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
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card rounded shadow-sm border-0">
                            <div class="card-body p-4"><img src="` + data[i].photo + `"
                                    alt="" class="img-fluid d-block mx-auto mb-3">
                                <h5> <a href="http://127.0.0.1:8000` + data[i].fixed_link + `" class="text-dark stretched-link">` + data[i].name + `</a></h5>
                                <p class="small text-muted font-italic">` + data[i].description + `
                                </p>
                            </div>
                        </div>
                    </div>
                    `);
                }
            }
        });
    }

    const setupPromoHampers = () => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('api.product.getPromoBundles') }}",
            method: 'post',
            success: function(result) {
                console.log(result)

                const data = result.data

                for (var i=0; i<data.length; i++) {
                    $('#promoHampers').append(`
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card rounded shadow-sm border-0">
                            <div class="card-body p-4"><img src="` + data[i].photo + `"
                                    alt="" class="img-fluid d-block mx-auto mb-3">
                                <h5> <a href="http://127.0.0.1:8000/bundle/details/` + data[i].uuid + `" class="text-dark stretched-link">` + data[i].name + `</a></h5>
                                <p class="small text-muted font-italic">` + data[i].description + `
                                </p>
                            </div>
                        </div>
                    </div>
                    `);
                }
            }
        });
    }
</script>
@endsection
