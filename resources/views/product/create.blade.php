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
                <div class="card-header">{{ __('Buat Service Baru') }}</div>

                <div class="card-body">
                    <form action="{{route('service.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label><small class="text-danger">*</small>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="photo">Foto</label><small class="text-danger">*</small> <br>
                            <input type="file" name="photo" value=" {{ old('photo') }} "/>
                            @if ($errors->has('photo'))
                                <br><span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label><small class="text-danger">*</small>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"/> <span>harga per gram</span>
                            @if ($errors->has('price'))
                                <br><span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="max_revision">Revisi maksimal</label><small class="text-danger">*</small>
                            <input type="number" name="max_revision" class="form-control" value="{{ old('max_revision') }}"/>
                            @if ($errors->has('max_revision'))
                                <br><span class="text-danger">{{ $errors->first('max_revision') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label><small class="text-danger">*</small>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}"/>
                            @if ($errors->has('description'))
                                <br><span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
