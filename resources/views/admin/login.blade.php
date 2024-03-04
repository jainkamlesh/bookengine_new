<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">

    <link rel="stylesheet" href="{{url('/')}}/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{url('/')}}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{url('/')}}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/aos.css">
    <link rel="stylesheet" href="{{url('/')}}/css/style.css">
    <link rel="stylesheet" href="{{url('/')}}/css/main.css">
    <link rel="stylesheet" href="{{url('/')}}/css/main.scss">
    <link rel="stylesheet" href="{{url('/')}}/css/responsive.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="site-login mt-0 site-wrap">
        <!-- login form -->
        <section class="login-block content-wrapper mt-0 p-0">
            <div class="container pr-0">
                <div class="row">
                     
                    <div class="col-md-12 col-sm-12 col-lg-12 login-sec ">
                        <h2 class="text-center">BookingEngine</h2>
                        @include('flash-message')
                         <form class="form-horizontal form-simple login-form pt-4" novalidate method="post">
                            @csrf
                            <div class="form-group position-relative">
                                <div class="group mb-0">
                                    <input type="text" id="profile_new_password" name="username" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label class="form-label">Username</label>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <div class="group mb-0">
                                    <input type="password" id="profile_new_password" name="password" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label class="form-label">Password</label>
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="select form-group mt-4">
                                <select class="select-text" name="language">
                                    <option value="it" selected>  Language</option>
                                     <option value="it">Italian</option>
                                    <option value="en">English</option>
                                    
                                </select>
                                <span class="select-highlight"></span>
                                <span class="select-bar"></span>
                            </div>
                            <!-- <a href="forgot_password.html" class="mt-1">Forgot Password</a> -->
                            <div class="form-check">
                                <button type="submit" class="btn-login">Login</button>
                            </div>
                        </form>
                    </div>
                     
                </div>
            </div>
        </section>
        <!-- end -->
    </div>
</body>

<script src="{{url('/')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{url('/')}}/js/jquery-ui.js"></script>
<script src="{{url('/')}}/js/popper.min.js"></script>
<script src="{{url('/')}}/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/js/owl.carousel.min.js"></script>
<script src="{{url('/')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{url('/')}}/js/aos.js"></script>
<script src="{{url('/')}}/js/main.js"></script>
</html>
