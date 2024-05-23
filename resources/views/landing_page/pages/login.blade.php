<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('landing_page/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('landing_page/css/auth/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/auth/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('landing_page/css/auth/register/style.css') }}">

    <title>Login</title>
</head>

<body>



    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('landing_page/images/undraw_remotely_2j6y.svg') }}" alt="Image"
                        class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Sign In</h3>
                                <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur
                                    adipisicing.</p>
                            </div>
                            <form action="/login" method="post">
                                @csrf
                                <div class="form-group first">
                                    <label for="usernameUser">Email</label>
                                    <input type="email" class="form-control" id="emailUser" name="email">

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="passwordUser">Password</label>
                                    <input type="password" class="form-control" id="passwordUser" name="password">

                                </div>

                                <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0"><span class="caption">Remember
                                            me</span>
                                        <input type="checkbox" checked="checked" />
                                        <div class="control__indicator"></div>
                                    </label>
                                    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot
                                            Password</a></span>
                                </div>

                                <input type="submit" value="Log In" class="btn btn-block btn-primary">


                                {{-- <span class="d-block text-center my-2 text-muted">&mdash; or login with &mdash;</span>
                                <button type="submit" class="btn btn-block btn-primary text-dark"
                                    style="background-color:white; border: 1px solid grey;"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="35px"
                                        height="35px">
                                        <path fill="#FFC107"
                                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                                        <path fill="#FF3D00"
                                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                                        <path fill="#4CAF50"
                                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                                        <path fill="#1976D2"
                                            d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                                    </svg>Sign in with Google</button> --}}

                                <div class="text-left mt-3">Don't have an account? <a href="/register">Register here</a>
                                </div>
                                {{-- <div class="social-login">
                                    {{-- <a href="#" class="facebook">
                                        <span class="icon-facebook mr-3"></span>
                                    </a>
                                    <a href="#" class="twitter">
                                        <span class="icon-twitter mr-3"></span>
                                    </a> --}}
                                {{-- <a href="#" class="google">
                                        <span class="icon-google mr-3"></span>
                                    </a>
                                </div> --}}
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="{{ asset('landing_page/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/popper.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/main.js') }}"></script>
</body>

</html>
