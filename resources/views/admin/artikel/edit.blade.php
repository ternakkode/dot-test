@extends('admin.master_layout')
@section('title', 'Edit Artikel')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Ubah Artikel</h4>
            </div>
            <form method="post" id="form_artikel" enctype="multipart/form-data">
            <input type="hidden" name="type" value='edit'>
            <div class="card-body">
                <div class="alert alert-info">
                    <b>Baca beberapa aturan sebelum membuat Artikel !</b>
                    <br><br>
                    1. Hindari typo dan salah penulisan<br>
                    2. Untuk Kategori bisa lebih dari 1 kategori dengan format Kategori1 Kategori2<br>
                    3. Silahkan cek list kategori melalui <a target="_blank" href="{{url('kategori')}}"
                        class="font-weight-bold">Link ini</a>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <input type="hidden" id="id_artikel" name="id_artikel" value="{{$artikel->id_artikel}}">
                    <input required type="text" class="form-control" name="judul" id="judul" value="{{ $artikel->judul }}">
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input required type="text" class="form-control" name="kategori" id="kategori" value="@foreach ($artikel->kategori as $k){{$k->kode_kategori. ' '}}@endforeach">
                </div>
                <div class="form-group">
                    <label>Foto Headline</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="headline" name="headline">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Isi Artikel</label>
                    <textarea name="isi_artikel" id="isi_artikel" class="editor">{{ $artikel->isi }}
                    </textarea>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-secondary mr-1" type="reset">Batal</button>
                <button id="simpanArtikel" class="btn btn-success " type="submit">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('js/ckeditor.js')}}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.editor'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'fontFamily',
                    'fontSize',
                    'fontBackgroundColor',
                    'fontColor',
                    'bold',
                    'italic',
                    'highlight',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'horizontalLine',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    'exportPdf'
                ]
            },
            simpleUpload: { // The URL that the images are uploaded to.
                uploadUrl: '{{ route('upload-photo') }}',
                withCredentials: true,

                // Headers sent along with the XMLHttpRequest to the upload server.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization' : 'Bearer ' + localStorage.getItem("jwt_token")
                }
            },
            language: 'id',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            licenseKey: '',

        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
    $(document).ready(function () {
        $('#form_artikel').on('submit', function (event) {
            event.preventDefault();
            let jwt = localStorage.getItem("jwt_token");
            let csrf = $('meta[name="csrf-token"]').attr('content');
            data = new FormData(this);
            data.append('isi',editor.getData());

            $.ajax({
                url: '{{ route('edit-artikel') }}',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'X-CSRF-Token': csrf,
                    'Authorization' : 'Bearer ' + jwt
                },
                success: function (response) {
                    var data = response;
                    if (data.status == 'sukses') {
                        Swal.fire(
                            'Berhasil',
                            'Berhasil melakukan perubahan.',
                            'success')
                        window.setTimeout(function() {
                            location.href = '{{url('artikel')}}';
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
