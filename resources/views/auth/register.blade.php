@extends('web.layout.default')
@section('content')
<section class="login_section">
    <div class="container-fluid p-0 m-0">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="images_gallery" style="background-image: url({{url('public/web/img/banner_new01.png')}});">
                    <div class="login_contany">
                        <h1>Welcome To <br> True Blue Aussies</h1>
                        <p>
                            Login and make your views about Australian products known, 
                            what’s your favorite, what you dislike, expose any false products claiming to be Australian,
                            A new type of Social Media experience where you can discuss with others in Australia and around the world your thoughts on Australian food, production and content, in an ever changing world, you should be aware, and make others aware, of what they are eating and supporting with their purchases.
                        </p>
                        <a href="{{route('login')}}" class="btn">Login</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="wrapper_box">
                    <form method="POST" class="text-center" action="{{ route('register') }}">
                        @csrf
                        <h3>Register Your Account</h3>
                        <!-- Name -->
                        <div class="md-form">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="materialLoginFormname">Name</label>
                        </div>
                        <!-- Email -->
                        <div class="md-form">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <label for="materialLoginFormEmail">E-mail</label>
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <label for="materialLoginFormPassword">Password</label>
                        </div>
                        <div class="md-form">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <label for="materialLoginFormPassword">Confirm Password</label>
                        </div>
                        
                        <!-- <div class="d-flex"> -->
                            <!-- <div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="materialLoginFormRemember" />
                                    <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                                </div>
                            </div> -->
                            <!-- <div>
                                <a href="">Forgot password?</a>
                            </div> -->
                        <!-- </div> -->

                        <button class="btn btn_comman" type="submit">Register</button>
                        <!-- <p>
                            Not a member?
                            <a href="{{route('login')}}">Login</a>
                        </p> -->
                        
                       <!--  <p>or sign in with:</p>
                        <div class="social_floting">
                        <a type="button" class="btn-floating btn-fb btn-sm">
                            <i class="fab fa-facebook-f"></i> login with facebook
                        </a> -->
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
