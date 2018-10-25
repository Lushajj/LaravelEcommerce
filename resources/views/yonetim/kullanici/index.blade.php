@extends('yonetim.layouts.master')
@section('title','Kullanici Yönetimi')
@section('content')
    <h1 class="page-header">Kullanici Yönetimi</h1>
    <h4 class="sub-header">Kullanıcı Listesi</h4>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.kullanici') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" name="search" id="search" placeholder="Adi Email Ara..." class="form-control form-control-sm" value="{{ old('search') }}">
                <button type="submit" name="button" class="btn btn-primary"> Ara</button>
                <a href="{{ route('yonetim.kullanici') }}" class="btn btn-primary">Temizle</a>
            </div>
        </form>
    </div>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Ad Soyad</th>
                    <th>E Mail</th>
                    <th>Aktif Mi ?</th>
                    <th>Yönetici mi ?</th>
                    <th>Kayıt Tarihi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (count($list) == 0)
                    <tr>
                        <td colspan="7" align="center"> Kayıt Bulunamadı !</td>
                    </tr>
                @endif
                @foreach ($list as $kullanici)
                    <tr>
                        <td>{{ $kullanici->id }}</td>
                        <td>{{ $kullanici->adsoyad }}</td>
                        <td>{{ $kullanici->email }}</td>
                        <td align="center">
                            @if ($kullanici->aktif_mi)
                                <span class='label label-success'> Aktif </span>
                            @else
                                <span class='label label-warning'> Pasif </span>
                            @endif
                        </td>
                        <td align="center">
                            @if ($kullanici->yonetici_mi)
                                <span class='label label-success'> Yönetici </span>
                            @else
                                <span class='label label-warning'> Müşteri </span>
                            @endif
                        </td>
                        <td>{{ $kullanici->olusturulma_tarihi }}</td>
                        <td style="width: 100px">
                            <a href="{{ route('yonetim.kullanici.duzenle',$kullanici->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="{{ route('yonetim.kullanici.sil',$kullanici->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Eminmisiniz ?')">
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
