@extends('yonetim.layouts.master')
@section('title','Sipariş Yönetimi')
@section('content')
    <h1 class="page-header">Sipariş Yönetimi</h1>
    <h4 class="sub-header">Sipariş Listesi</h4>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.siparis.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.siparis') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" name="search" id="search" placeholder="Sipariş Ara..." class="form-control form-control-sm" value="{{ old('search') }}">
                <button type="submit" name="button" class="btn btn-primary"> Ara</button>
                <a href="{{ route('yonetim.siparis') }}" class="btn btn-primary">Temizle</a>
            </div>
        </form>
    </div>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                <th>Siparis Kodu</th>
                    <th>Kullanıcı</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>Siparis Tarihi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (count($list) == 0)
                    <tr>
                        <td colspan="6" align="center"> Kayıt Bulunamadı !</td>
                    </tr>
                @endif
                @foreach ($list as $siparis)
                    <tr>
                        <td>SP-{{ $siparis->id }}</td>
                        <td>{{ $siparis->sepet->kullanici->adsoyad }}</td>
                        <td>{{ $siparis->siparis_tutari * ((100 + config('cart.tax')) / 100)}} ₺ </td>
                        <td>{{ $siparis->durum }}</td>
                        <td>{{ $siparis->olusturulma_tarihi }}</td>
                        <td style="width: 100px">
                            <a href="{{ route('yonetim.siparis.duzenle',$siparis->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="{{ route('yonetim.siparis.sil',$siparis->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Eminmisiniz ?')">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $list->appends('search', old('search'))->links() }}
    </div>
@endsection
