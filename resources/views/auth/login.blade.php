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
                            Register with us and make your views about Australian products known, 
                            what’s your favorite, what you dislike, expose any false products claiming to be Australian,
                            A new type of Social Media experience where you can discuss with others in Australia and around the world your thoughts on Australian food, production and content, in an ever changing world, you should be aware, and make others aware, of what they are eating and supporting with their purchases.
                        </p>
                        <a href="{{route('register')}}" class="btn">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="wrapper_box">
                    <form method="POST" class="text-center" action="{{ route('login') }}">
                        @csrf
                        <h3>Login To Your Account</h3>
                        <div class="md-form">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="materialLoginFormEmail">E-mail</label>
                            @error('email')
                                <span class="invalid-feedback disp_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if(session('email-error'))
                                <span class="invalid-feedback disp_msg" role="alert">
                                    <strong>{{session('email-error')}}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="md-form">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="materialLoginFormPassword">Password</label>
                            @error('password')
                                <span class="invalid-feedback disp_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if(session('password-error'))
                                <span class="invalid-feedback disp_msg" role="alert">
                                    <strong>{{ session('password-error') }}</strong>
                                </span>
                            @endif
                        </div>

                         <div class="d-flex justify-content-around">
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="materialLoginFormRemember" />
                                    <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                                </div>
                            </div>
                            <div>
                                <a href="{{route('password.request')}}">Forgot password?</a>
                            </div>
                        </div>

                        <button class="btn btn_comman" type="submit">login</button>

                        <p>
                            Not a member?
                            <a href="{{(register)}}">Register</a>
                        </p>

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
