@extends('layouts.app')

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

            <div class="card">
                <div class="card-header">{{ __('Buat Item Baru') }}</div>

                <div class="card-body">
                    <form action="{{route('item.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row" id="itemSection">
                            <div class="col-sm-12 my-2 itemForm" id="1">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="item_name">Nama item</label><small class="text-danger">*</small>
                                            <input type="text" name="item_name" class="form-control" value="{{ old('item_name') }}"/>
                                            @if ($errors->has('item_name'))
                                                <br><span class="text-danger">{{ $errors->first('item_name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="item_photo">Foto item</label><small class="text-danger">*</small> <br>
                                            <input type="file" name="item_photo" value=" {{ old('item_photo') }} " data-img="item_photo_1" onchange="readURL(this);"/>
                                        </div>
                                        <div>
                                            <img id="item_photo_1" width="0" height="0" style="display: block;max-width:230px;max-height:95px;width: auto;height: auto;" src="#" alt="">
                                        </div>

                                        <div class="form-group">
                                            <label for="item_description">Deskripsi Item</label><small class="text-danger">*</small>
                                            <input type="text" name="item_description" class="form-control" value="{{ old('item_description') }}"/>
                                            @if ($errors->has('item_description'))
                                                <br><span class="text-danger">{{ $errors->first('item_description') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="item_price">Harga item (Rp)</label><small class="text-danger">*</small>
                                            <input type="text" name="item_price" class="form-control" value="{{ old('item_price') }}"/>
                                            @if ($errors->has('item_price'))
                                                <br><span class="text-danger">{{ $errors->first('item_price') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="item_stock">Stok Awal</label><small class="text-danger">*</small>
                                            <input type="text" name="item_stock" class="form-control" value="{{ old('item_stock') }}"/>
                                            @if ($errors->has('item_stock'))
                                                <br><span class="text-danger">{{ $errors->first('item_stock') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Buat Item
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

        $(document).ready(function() {

        });

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
    </script>
@endsection
