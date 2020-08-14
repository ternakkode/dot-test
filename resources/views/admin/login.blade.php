<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Layanan Artikel Berita</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/components.css')}}">
</head>

<body>
    <section class="section">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-8">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>

                        <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" tabindex="1"
                                        required autofocus>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="submitLogin" tabindex="4">
                                        Login
                                    </button>
                                </div>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Created by Muhammad Firhan
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('js/stisla.js')}}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="{{ asset('js/custom.js')}}"></script>

    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- ajax -->
    <script>
        $(document).ready(function () {

            $("#submitLogin").on("click", function () {
                let username = $("#username").val();
                let password = $("#password").val();
                let csrf = $('meta[name="csrf-token"]').attr('content');

                if (username == "" || password == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Autentikasi Gagal',
                        text: 'Anda belum mengisi username atau password.',
                    })
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('/login')}}',
                        data: {
                            username: username,
                            password: password
                        },
                        headers: {
                            'X-CSRF-Token': csrf
                        },
                        success: function (response) {
                            var data = response;
                            if (data.status == true) {
                                localStorage.setItem('jwt_token', data.token);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses Login',
                                    text: 'Anda telah sukses login, akah dialihkan ke halaman dashboard.',
                                })
                                window.setTimeout(function() { location.href = '{{url('/')}}';}, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Autentikasi Gagal',
                                    text: 'Terjadi kesalahan',
                                })
                            }
                        }
                    })
                }
            });
        })

    </script>

    <!-- Page Specific JS File -->
</body>

</html>
