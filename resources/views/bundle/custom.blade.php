@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                Session::forget('success');
                @endphp
            </div>
            @endif

            <form action="{{route('cart.add.custom')}}" method="POST">
                @csrf

                <div class="mb-2">
                    <h5>Buat bundle sendiri!</h5>

                    <select class="item-selector" name="item" style="width: 200px;">

                    </select>

                    <button type="button" class="btn btn-primary btn-sm" id="addItemForm">Tambah Item</button>
                </div>


                <div class="card">

                    <div class="card-header">{{ __('Isi Hampers') }}</div>

                    <div class="card-body">

                        <div class="row" id="itemSection">

                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Total Harga</div>

                    <div class="card-body">
                        <div class="">
                            <span>Total Harga: Rp</span><span class="total-harga">0</span>
                            <input type="number" name="total_price" value="0" id="final_price" hidden>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-3">
                    Buat Bundle
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        setupSelect2()
    });

    const countChange = () => {
        var itemCounts = $("input[name='item_count[]']").map(function(){return $(this).val();}).get()
        var itemPrice = $("input[name='item_price[]']").map(function(){return $(this).val();}).get()

        var tmpTotalPrice = 0;

        for (var i=0; i<itemPrice.length; i++) {
            tmpTotalPrice += (parseInt(itemCounts[i]) * parseInt(itemPrice[i]))
            console.log((parseInt(itemCounts[i]) * parseInt(itemPrice[i])))
        }
        total_price = tmpTotalPrice
        $('.total-harga').html(numberWithCommas(tmpTotalPrice))
        $('#final_price').val(total_price)
    }

    function readURL(input) {
        var id = input.getAttribute('data-img')
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + id)
                    .attr('src', e.target.result)
                    .attr('width', 400)
                    .attr('height', 400);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }



    function deleteItem(n) {
        console.log("n:" + n)
        $('.itemCustom').each(function () {
            var id = $(this).attr('id')
            console.log("id:" + id)
            if (id == n) $('#' + id).remove()

            var uuidX = $(this).find('button')[0].getAttribute('data-uuid')
            const index = added.indexOf(uuidX)
            if (index > -1) {
                added.splice(index, 1)
            }
        });

    }

    let item_count = 1
    var added = []

    var total_price = 0

    $('#addItemForm').click(function (e) {
        item_count++
        e.preventDefault()

        var data = $(".item-selector option:selected").val()
        console.log(data)

        if (added.includes(data)) return
        added.push(data)


        var _url = `http://127.0.0.1:8000/api/app/item/getSingleItem/` + data

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: _url,
            method: 'get',
            success: function (result) {
                console.log(result)

                const data = result.data

                $('#itemSection').append(`
                <div class="col-md-12 my-2 itemCustom" style="padding:0;" id=` + item_count + `>
                    <button type="button" class="btn btn-danger btn-sm" style="width: 50px;" onclick="deleteItem(` +item_count + `)" data-uuid="` + data.uuid + `">
                        X
                    </button>
                    <div class="row">
                        <div class="col-md-5 frame">
                            <span class="helper"></span>
                            <img class="center-image"
                                src="` + data.photo + `"
                                alt="" style="max-width: 100%">
                        </div>
                        <div class="col-md-7 pt-3">
                            <h4>` + data.name + `</h4>
                            <p>` + data.description + `</p>
                        </div>
                        <div class="col-lg-12 row">
                            <div class="col-5">
                                <div>
                                    <span>Note tambahan:</span>
                                </div>
                                <textarea name="additional_note[]" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-3 ml-5">
                                <div>
                                    <span>Rp ` + numberWithCommas(data.price) + `</span><span>/item</span>
                                    <input class="form-control" type="text" hidden name="item_price[]" value="`+data.price+`">
                                </div>
                                <div>
                                    <span>stok: ` + numberWithCommas(data.stock) + `</span>
                                </div>
                                <div>
                                    <span>Jumlah</span>
                                    <input type="number" name="item_count[]" style="width: 50px" value="1" class="item-jumlah" onchange="countChange()">
                                    <input type="text" name="item_id[]" value="` + data.id + `" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><hr/>
                `);

                total_price += data.price
                $('.total-harga').html(numberWithCommas(total_price))
                $('#final_price').val(total_price)
            }
        });
    });

    const setupSelect2 = () => {
        $('.item-selector').select2();



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('api.item.getAllItem') }}",
            method: 'post',
            success: function (result) {
                console.log(result)

                const data = result.data

                console.log(data)

                for (var i = 0; i < data.length; i++) {
                    $('.item-selector').append(`
                        <option value="` + data[i].uuid + `">` + data[i].name + `</option>
                    `)
                }


            }
        });
    }

    const numberWithCommas = (x) => {
        var parts = x.toString().split(",");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return parts.join(",");
    }

</script>
@endsection
