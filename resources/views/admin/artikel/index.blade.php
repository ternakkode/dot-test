@extends('admin.master_layout')
@section('title', 'Halaman Awal')
@section('content')
<div class="menu">
    <div class="awal" style="display:inline-block">
        <h2 class="section-title" style="margin-top:0">Artikel</h2>
        <p class="section-lead">Semua Artikel yang ditulis disini akan ditampilkan ke mahasiswa
            baru, jadi pastikan
            semua artikel yang kalian tulis tidak ada kesalahan.</p>
    </div>
    <a href="{{url('artikel/tambah') }}" type="button" class="btn btn-primary float-sm-right mb-3 btn-tambah">Tambah
        Artikel</a>
</div>
<div class="row">
    @foreach ($artikel as $a)
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <article class="article">
            <div class="article-header">
                <div class="article-image" style="background-image:url('{{ asset($a->headline) }}')">
                </div>
                <div class="article-title">
                    <h2><a href="#">{{ $a->judul }}</a></h2>
                </div>
            </div>
            <div class="article-details">
                <div class="article-cta">
                    <a href="{{ url('artikel/edit/'.$a->id_artikel) }}" class="btn btn-success">Edit</a>
                    <a href="{{ url('api/artikel/hapus/'.$a->id_artikel) }}" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </article>
    </div>
    @endforeach
</div>
<div class="text-right">
    <nav class="d-inline-block">
        {{ $artikel->links() }}
    </nav>
</div>
@endsection