@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1 class="page-header">Ürün Yönetimi</h1>
    <h4 class="sub-header">Ürün Listesi</h4>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.urun.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.urun') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" name="search" id="search" placeholder="Ürün Ara..." class="form-control form-control-sm" value="{{ old('search') }}">
                <button type="submit" name="button" class="btn btn-primary"> Ara</button>
                <a href="{{ route('yonetim.urun') }}" class="btn btn-primary">Temizle</a>
            </div>
        </form>
    </div>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Resim</th>
                    <th>Slug</th>
                    <th>Ürün Adı</th>
                    <th>Fiyatı</th>
                    <th>Kayıt Tarihi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (count($list) == 0)
                    <tr>
                        <td colspan="6" align="center"> Kayıt Bulunamadı !</td>
                    </tr>
                @endif
                @foreach ($list as $urun)
                    <tr>
                        <td>{{ $urun->id }}</td>
                        <td>
                            <img src="{{$urun->detay->urun_resmi != null ?
                                asset('uploads/urunler/'. $urun->detay->urun_resmi):
                                'http://via.placeholder.com/640x400?text=UrunResmi'}}" class="img-responsive" style="width:150px;">
                        </td>
                        <td>{{ $urun->slug }}</td>
                        <td>{{ $urun->urun_adi }}</td>
                        <td>{{ $urun->fiyati }} ₺</td>
                        <td>{{ $urun->olusturulma_tarihi }}</td>
                        <td style="width: 100px">
                            <a href="{{ route('yonetim.urun.duzenle',$urun->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="{{ route('yonetim.urun.sil',$urun->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Eminmisiniz ?')">
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
