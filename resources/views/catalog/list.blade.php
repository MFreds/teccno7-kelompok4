@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="font-weight-bold mb-2">Semua hampers</h2>
    <p class="font-italic text-muted mb-4">
        Semua hampers kami!
    </p>

    <div class="row pb-3 mb-1">

        @foreach ($data['all'] as $bundle)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card rounded shadow-sm border-0">
                <div class="card-body p-4"><img src="{{$bundle->photo}}"
                        alt="" class="img-fluid d-block mx-auto mb-3">
                    <h5> <a href="http://127.0.0.1:8000/bundle/details/{{$bundle->uuid}}" class="text-dark stretched-link">{{$bundle->name}}</a></h5>
                    <p class="small text-muted font-italic">{{$bundle->description}}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2 class="font-weight-bold mb-2">Hampers lagi promo!</h2>
    <p class="font-italic text-muted mb-4">
        Hampers promo!
    </p>

    <div class="row pb-5 mb-4">

        @foreach ($data['promo'] as $bundle)
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card rounded shadow-sm border-0">
                <div class="card-body p-4"><img src="{{$bundle->photo}}"
                        alt="" class="img-fluid d-block mx-auto mb-3">
                    <h5> <a href="http://127.0.0.1:8000/bundle/details/{{$bundle->uuid}}" class="text-dark stretched-link">{{$bundle->name}}</a></h5>
                    <p class="small text-muted font-italic">{{$bundle->description}}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
