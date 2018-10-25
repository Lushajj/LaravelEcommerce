@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1 class="page-header">Kategori Yönetimi</h1>
    <h4 class="sub-header">Kategori Listesi</h4>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.kategori.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.kategori') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="search">Ara</label>
                <input type="text" name="search" id="search" placeholder="Kategori Ara..." class="form-control form-control-sm" value="{{ old('search') }}">
                <label for="ust_id"> Üst Kategori</label>
                <select class="form-control" name="ust_id">
                    <option value="">Seçiniz</option>
                    @foreach ($anakategoriler as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('ust_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->kategori_adi }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" name="button" class="btn btn-primary"> Ara</button>
            <a href="{{ route('yonetim.kategori') }}" class="btn btn-primary">Temizle</a>
        </form>
    </div>
    @include('layouts.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Üst Kategori</th>
                    <th>Slug</th>
                    <th>Kategori Adı</th>
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
                @foreach ($list as $kategori)
                    <tr>
                        <td>{{ $kategori->id }}</td>
                        <td>{{ $kategori->ust_kategori->kategori_adi }}</td>
                        <td>{{ $kategori->slug }}</td>
                        <td>{{ $kategori->kategori_adi }}</td>
                        <td>{{ $kategori->olusturulma_tarihi }}</td>
                        <td style="width: 100px">
                            <a href="{{ route('yonetim.kategori.duzenle',$kategori->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <a href="{{ route('yonetim.kategori.sil',$kategori->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Eminmisiniz ?')">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $list->links() }}
    </div>
@endsection
