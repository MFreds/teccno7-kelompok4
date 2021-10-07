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
                <div class="card-header">{{ __('Buat Bundle Baru') }}</div>

                <div class="card-body">
                    <form action="{{route('bundle.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label><small class="text-danger">*</small>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="photo">Foto</label><small class="text-danger">*</small> <br>
                            <input type="file" name="photo" value=" {{ old('photo') }} " data-img="bundle_photo" onchange="readURL(this);"/>

                            @if ($errors->has('photo'))
                                <br><span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                        <div>
                            <img id="bundle_photo" width="0" height="0" style="display: block;max-width:230px;max-height:95px;width: auto;height: auto;" src="#" alt="">
                        </div>



                        <div class="form-group">
                            <label for="price">Harga</label><small class="text-danger">*</small>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"/> <span>harga per gram</span>
                            @if ($errors->has('price'))
                                <br><span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label><small class="text-danger">*</small>
                            <input type="text" name="stock" class="form-control" value="{{ old('stock') }}" />
                            @if ($errors->has('stock'))
                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label><small class="text-danger">*</small>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}"/>
                            @if ($errors->has('description'))
                                <br><span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <h5>Item bundle</h5>

                        <button type="button" class="btn btn-primary btn-sm" id="addItemForm">Tambah Item</button>

                        <div class="row" id="itemSection">
                            <div class="col-sm-12 my-2 itemForm" id="1">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name_item[]">Nama item</label><small class="text-danger">*</small>
                                            <input type="text" name="name_item[]" class="form-control" value="{{ old('name_item[]') }}"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="photo_item[]">Foto item</label><small class="text-danger">*</small> <br>
                                            <input type="file" name="photo_item[]" value=" {{ old('photo_item[]') }} " data-img="item_photo_1" onchange="readURL(this);"/>
                                        </div>
                                        <div>
                                            <img id="item_photo_1" width="0" height="0" style="display: block;max-width:230px;max-height:95px;width: auto;height: auto;" src="#" alt="">
                                        </div>

                                        <div class="form-group">
                                            <label for="description_item[]">Deskripsi item</label><small class="text-danger">*</small>
                                            <input type="text" name="description_item[]" class="form-control" value="{{ old('description_item[]') }}"/>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Buat Bundle
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

        let item_count = 1

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

        function deleteItem(n) {
            console.log("n:" + n)
            $('.itemForm').each(function(){
                var id = $(this).attr('id')
                console.log("id:" +id)
                if (id==n) $('#' + id).remove()
            });
        }

        $('#addItemForm').click(function(e){
            item_count++
            e.preventDefault()

            $('#itemSection').append(`
            <div class="col-sm-12 my-2 itemForm" id=` + item_count + `>
                <div class="card">
                    <button type="button" class="btn btn-danger btn-sm" style="width: 100px;" onclick="deleteItem(` + item_count + `)">
                        Hapus
                    </button>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="name_item[]">Nama item</label><small class="text-danger">*</small>
                            <input type="text" name="name_item[]" class="form-control" value="{{ old('name_item[]') }}" />
                        </div>

                        <div class="form-group">
                            <label for="photo_item[]">Foto item</label><small class="text-danger">*</small> <br>
                            <input type="file" name="photo_item[]" value=" {{ old('photo_item[]') }}" data-img="` + "item_photo_" + item_count + `" onchange="readURL(this);"/>
                        </div>
                        <div>
                            <img id="`+ "item_photo_" + item_count + `" width="0" height="0" style="display: block;max-width:230px;max-height:95px;width: auto;height: auto;" src="#" alt="">
                        </div>

                        <div class="form-group">
                            <label for="description_item[]">Deskripsi item</label><small class="text-danger">*</small>
                            <input type="text" name="description_item[]" class="form-control" value="{{ old('description_item[]') }}"/>
                        </div>

                    </div>
                </div>
            </div>
            `);

        });
    </script>
@endsection
