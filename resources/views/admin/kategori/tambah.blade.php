@extends('admin.master_layout')
@section('title', 'Tambah Kategori')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Kategori Baru</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Silahkan input kode kategori dengan format 3 Huruf, contoh "ABC"
                </div>
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input required type="text" class="form-control" name="kode_kategori" id="kode_kategori">
                </div>
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input required type="text" class="form-control" name="nama_kategori" id="nama_kategori">
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

            let csrf = $('meta[name="csrf-token"]').attr('content');
            let kode_kategori = $("#kode_kategori").val();
            let nama_kategori = $("#nama_kategori").val();
            $.ajax({
                type: 'POST',
                url: '{{ route('tambah-kategori') }}',
                data: {
                    kode_kategori,
                    nama_kategori
                },
                headers: {
                    'X-CSRF-Token': csrf
                },
                success: function (response) {
                    var data = response;
                    if (data.status == 'sukses') {
                        Swal.fire({
                            title: 'Sukses',
                            text: "Kategori berhasil ditambahkan, silahkan klik kembali untuk menambah kategori lainnya",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#5a6268',
                            confirmButtonText: 'Selesai',
                            cancelButtonText: 'Kembali'
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace('{{url('kategori')}}');
                            }
                        })
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
