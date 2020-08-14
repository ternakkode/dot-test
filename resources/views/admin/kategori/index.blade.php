@extends('admin.master_layout')
@section('title', 'Admin Kategori')
@section('content')
<div class="menu">
    <div class="awal" style="display:inline-block">
        <h2 class="section-title" style="margin-top:0">Kategori</h2>
        <p class="section-lead">Berikut adalah kategori-kategori yang digunakan untuk artikel.</p>
    </div>
    <a href="{{url('kategori/tambah') }}" type="button" class="btn btn-primary float-sm-right mb-3 btn-tambah">Tambah Kategori</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead style="text-align: center; vertical-align: middle;">
                            <tr>
                                <th>No</th>
                                <th>Kode Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                        @php $i=1 @endphp
                        @foreach($kategori as $k)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $k->kode_kategori }}</td>
                                <td>{{ $k->nama_kategori }}</td>
                                <td>
                                    <a href="{{ url('kategori/edit/'.$k->kode_kategori) }}" class="btn btn-primary">Ubah</a>
                                    <a href="{{ url('api/kategori/hapus/'.$k->kode_kategori.'?token='.session('token')) }}" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        @php $i++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    {{ $kategori->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
