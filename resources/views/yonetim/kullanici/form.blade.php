@extends('yonetim.layouts.master')
@section('title','Kullanici Yönetimi')
@section('content')
    <h1 class="page-header">Kullanici Yönetimi</h1>
    <form method="post" action="{{ route('yonetim.kullanici.kaydet',@$entry->id) }}">
        {{ csrf_field() }}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{ @$entry->id > 0 ? "Güncelle" : "Kaydet" }}
            </button>
        </div>
        <h4 class="sub-header">Kullanıcı {{ @$entry->id > 0 ? "Düzenleme" : "Kayıt" }} Formu</h4>
        @include('layouts.partials.errors')
        @include('layouts.partials.alert')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" placeholder="Ad Soyad" name="adsoyad" value="{{ old('adsoyad', $entry->adsoyad) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">E Posta</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email', $entry->email) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sifre">Şifre</label>
                    <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" placeholder="Adres" name="adres" value="{{ old('adres', $entry->detay->adres) }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" placeholder="Telefon" name="telefon" value="{{ old('telefon', $entry->detay->telefon) }} ">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Cep Telefon</label>
                    <input type="text" class="form-control" id="ceptelefon" placeholder="Cep Telefon" name="ceptelefon" value="{{ old('ceptelefon', $entry->detay->ceptelefon) }}">
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="aktif_mi" value="1" {{ $entry->aktif_mi ? 'checked' : '' }}> Aktif Mi ?
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="yonetici_mi" value="1" {{ $entry->yonetici_mi ? 'checked' : '' }}> Yönetici Mi ?
            </label>
        </div>
    </form>
@endsection
