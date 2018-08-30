@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1>404</h1>
            <h2>Aradığınız Sayfa Bulunamadı</h2>
            <p>{{ $exception->getMessage() }}</p>
            <a href="{{ route('anasayfa') }}" class="btn btn-primary">Anasayfa'ya Dön</a>
        </div>
    </div>
@endsection()