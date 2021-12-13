@extends('layouts.app')

@section('styles')

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

            <div class="card">
                <div class="card-header">
                    Cart
                </div>
                <div class="card-body">

                    {{-- custom bundle --}}
                    <div class="row">

                        @foreach ($customBundle as $c)

                        <div class="col-12 row">
                            <div class="col-7">
                                <span><strong>Custom Hampers</strong></span>
                            </div>
                            <div class="col-3">
                                Rp {{ $c['total_price'] }}
                            </div>
                        </div>

                            @foreach ($c['data'] as $ci)

                            <div class="col-12 row mt-2">
                                <div class="col-1"></div>
                                <div class="col-4">
                                    <span>{{ $ci->item_name }}</span>
                                </div>
                                <div class="col-3">
                                    <span>x{{ $ci->amount }}</span>
                                </div>
                                <div class="col-3">
                                    <span>Rp {{ $ci->item_price }}</span>
                                </div>
                            </div>
                            <div class="col-12 row mt-1">
                                <div class="col-2"></div>
                                note tambahan:
                                <div class="col-6">
                                    @if ( $ci->note == null)
                                        -
                                    @else
                                        {{ $ci->note }}
                                    @endif
                                </div>
                            </div>

                            @endforeach

                        @endforeach

                    </div>

                    {{-- yang lain lanjut dibawah --}}
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    Summary pembelian
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 row">
                            <div class="col-1"></div>
                            <div class="col-6">
                                <span>Harga Total</span>
                                <span>Rp {{$total_price_all}}</span>
                                <input type="number" value="{{$total_price_all}}" hidden>
                            </div>
                        </div>

                        <form action="{{route('order.new')}}" method="POST">
                            @csrf

                            <div class="col-12 row mt-2">
                                <div class="col-6 offset-1 my-1">
                                    <label for="name">Nama Penerima</label>
                                    <input type="text" name="name" value="{{$account->name}}" readonly>
                                </div>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-5 offset-1 my-1">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="{{$account->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-5 offset-1 my-1">
                                    <label for="address">Alamat</label>
                                    <textarea name="address" id="" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-5 offset-1 my-1">
                                    <label for="City">Kota</label>
                                    <input type="text" name="city">
                                </div>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-5 offset-1 my-1">
                                    <label for="postal">Kode pos</label>
                                    <input type="text" name="postal">
                                </div>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-5 offset-1 my-1">
                                    <label for="phone">Nomor HP</label>
                                    <input type="text" name="phone">
                                </div>
                            </div>

                            <div class="col-12 row">
                                <div class="col-10 offset-1">
                                    <button type="submit" class="btn btn-primary btn-block mt-3">
                                        Bayar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection
