@extends('web.layout.default')
@section('title', 'Reset Password')
@section('content')

<section class="login_section">
   <div class="container-fluid p-0 m-0">
      <div class="row no-gutters">
         <div class="col-md-6">
            <div class="images_gallery" style="background-image: url({{url('public/web/img/banner_new01.png')}});">
               <div class="login_contany">
                  <h1>Welcome To<br> True Blue Aussies</h1>
                  <p>
                     Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                     it to make a type specimen book.
                  </p>
                  <a href="{{route('register')}}" class="btn">Register</a>
               </div>
            </div>
         </div>
            <div class="col-md-6">
                <div class="wrapper_box">
                    <form method="POST" class="text-center" action="{{ route('password.update') }}">
                        @csrf
                        <h3>{{ __('Reset Password') }}</h3>

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="md-form">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <label for="materialLoginFormEmail">E-mail</label>
                        </div>

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
                        
                        <button class="btn btn_comman" type="submit">{{ __('Reset Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
