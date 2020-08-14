@extends('admin.master_layout')
@section('title', 'Edit Kategori')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Kategori Baru</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Silahkan input Kode Kategori dengan format 3 Huruf, contoh "ABC"
                </div>
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input disabled type="text" class="form-control" name="kode_kategori" id="kode_kategori" value="{{$kategori->kode_kategori}}">
                </div>
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input required type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{$kategori->nama_kategori}}">
                </div>
            </div>
            <div class="card-footer text-right">
                <button id="simpanKategori" class="btn btn-success" type="submit">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $("#simpanKategori").on("click", function () {
            let jwt = localStorage.getItem("jwt_token");
            let csrf = $('meta[name="csrf-token"]').attr('content');
            let kode_kategori = $("#kode_kategori").val();
            let nama_kategori = $("#nama_kategori").val();
            $.ajax({
                type: 'PUT',
                url: '{{ route('edit-kategori') }}',
                data: {
                    kode_kategori,
                    nama_kategori
                },
                headers: {
                    'X-CSRF-Token': csrf,
                    'Authorization' : 'Bearer ' + jwt
                },
                success: function (response) {
                    var data = response;
                    if (data.status == 'sukses') {
                        Swal.fire(
                            'Berhasil',
                            'Perubahan kembali tersimpan, otomatis kembali ke halaman awal.',
                            'success')
                        window.setTimeout(function() {
                            location.href = '{{url('kategori')}}';
                        }, 2000);
                    } else {
                        Swal.fire(
                            'Gagal',
                            'Data tidak tersimpan, pastikan input yang anda masukkan telah sesuai.',
                            'error')
                    }
                }
            })
        });
    })

</script>
@endsection
