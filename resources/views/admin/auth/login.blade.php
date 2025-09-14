<!DOCTYPE html>
<html lang="en">

<head>
    <title>ورود</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="assets/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/auth/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/auth/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/auth/assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/auth/assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/auth/assets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/auth/assets/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/auth/assets/css/main.css') }}">
    <!--===============================================================================================-->

</head>


<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('admin/auth/assets/images/img-01.png') }}" alt="IMG">
                </div>
                @error('email')
                    <div class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
                <form method="POST" action="{{ route('admin.login.store') }}" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title">
                        Admin Login
                    </span>

                    {{-- {{ $error }}
                    @if (!empty($error))
                        <div class="mb-2 alert alert-danger"> <small class="form-text text-danger">
                                {{ $error }}
                            </small> </div>
                    @endif --}}

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="{{ asset('forgot') }}">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="{{ url('login/customer') }}">
                            login as customer
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a><br>
                        <a class="txt2" href="{{ url('register') }}">
                            Create customer Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/auth/assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('admin/auth/assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('admin/auth/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/auth/"assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin/auth/assets/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script src="{{ asset('admin/auth/assets/js/main.js') }}"></script>

</body>

</html>
