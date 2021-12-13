@extends('layouts.app')

@section('styles')
<style>

    .helper {
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }

    .center-image {
        vertical-align: middle;
        /* max-height: 25px;
        max-width: 160px; */
    }
    .frame {
        /* height: 25px; */     /* equals max image height */
        /* width: 160px; */
        white-space: nowrap;

        text-align: center; margin: 1em 0;
    }
    .bigger-font {
        font-size: 20px;
    }
    textarea {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

        /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection

@section('content')
<div class="container" style="background-color: white">

    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <strong>Success!</strong>Berhasil menambahkan item ke keranjang.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="p-4" style="display: flex; justify-content: left;">
                <h1>{{ $bundle->name }}</h1>
            </div>

            <div class="pb-4" style="display: flex; justify-content: center;">
                <img src="{{ $bundle->photo }}" alt="" style="max-width: 100%">
            </div>
            <section>
                <div>
                    <p class="muted">Deskripsi Bundle</p>
                    <p>{{ $bundle->description }}</p>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="mx-3">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-md-5 m-2 px-3 pb-3" style="background-color: white;">
            <div class="row">
                <div style="width:100%;height:50px;">
                    <h3 style="width:100%;height:10%;text-align:center;position:relative;top:40%;">Apa sih isinya?</h3>
                </div>

                @foreach ($bundle_items as $item)
                <div class="col-md-12 my-2" style="padding:0; ">
                    <div class="row">
                        <div class="col-md-5 frame">
                            <span class="helper"></span>
                            <img class="center-image" src="{{ $item->photo }}" alt="" style="max-width: 100%">
                        </div>
                        <div class="col-md-5 pt-3">
                            <h4>{{ $item->name }}</h4>
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="col-md-5 m-2 p-3" style="background-color: white;">
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="col">Stok</th>
                        <th scope="col">{{ $bundle->stock }}</th>
                    </tr>
                  <tr>
                    <th scope="col">Status</th>
                    <th scope="col">
                        @if ($bundle->status == 'open')
                            <span class="badge badge-success">open for order</span>
                        @else
                            <span class="badge badge-danger">open for order</span>
                        @endif
                    </th>
                    </tr>
                        <tr>
                            <th scope="col">Harga per Bundle</th>
                            <th scope="col">Rp {{number_format($bundle->price, 2, ".", ",")}}</th>
                        </tr>
                </tbody>
                </table>
                <div>
                    @if (Auth::user() == null)
                        <div>
                            Sebelum beli, login dulu!
                        </div>
                    @else
                    <form action="">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h4>Beli bundle</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                                    </div>
                                    <input value="1" name="buy_amount" id="buy_amount_input" type="number" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-add">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h4>Total Harga</h4>
                            </div>
                            <div class="col-md-6">
                                <span class="bigger-font">Rp </span><span class="bigger-font" id="total_price_label">1000000</span>
                                <input id="total_price_input" name="total_price_input" type="text" value="100000" hidden>
                                <input type="text" name="bundle_id" id="bundle_id_input" value="{{$bundle->id}}" hidden>
                                <input type="text" name="item_type" id="item_type_input" value="bundle" hidden>
                                <input id="user_id_input" name="user_id" type="text" value="{{ Auth::user()->id }}" hidden>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="ml-4" for="additional_note_input">Note tambahan</label>
                            <textarea name="additional_note" id="additional_note_input" cols="50" rows="5"></textarea>
                        </div>
                        <button id="submitBeliBtn" type="submit" class="btn btn-primary btn-block mt-4">
                            Beli
                        </button>
                    </form>
                    @endif

                </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    function updateTotPrice(price) {
        $('#total_price_label').html(String(price).replace(/(.)(?=(\d{3})+$)/g,'$1,'))
        $('#total_price_input').attr('value', price)
    }

    let buy_am = 1
    let base_price = "{{ $bundle->price }}"
    updateTotPrice(base_price)

    $('#button-minus').click(function(e){
        if (--buy_am < 1) {
            buy_am = 1
            $('#buy_amount_input').attr('value', buy_am)
        } else {
            $('#buy_amount_input').attr('value', buy_am)
        }
        updateTotPrice(parseInt(base_price) * buy_am)
    });

    $('#button-add').click(function(e){
        $('#buy_amount_input').attr('value', ++buy_am)
        updateTotPrice(parseInt(base_price) * buy_am)
    });

    $('#submitBeliBtn').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('api.cart.addItemToCart') }}",
            method: 'post',
            data: {
                item_type: $('#item_type_input').val(),
                item_id: $('#bundle_id_input').val(),
                amount: $('#buy_amount_input').val(),
                price: base_price,
                total_price:  $('#total_price_input').val(),
                user_id:  $('#user_id_input').val(),
                additional_note: $('#additional_note_input').val()
            },
            success: function(result) {
                console.log(result)
                if(result.errors) {
                    $('.alert-danger').html('');
                    $.each(result.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                } else {
                    $(window).scrollTop(0);
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    setInterval(function(){
                        $('.alert-success').hide();
                        $('#CreateArticleModal').modal('hide');
                        location.reload();
                    }, 2000);
                }
            }
        });
    });
</script>
@endsection
