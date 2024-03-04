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
               <form method="POST" class="text-center" action="{{ route('password.email') }}">
                        @csrf
                        <h3>{{ __('Reset Password') }}</h3>
                         @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                             <div class="md-form">
                             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="materialLoginFormEmail">{{ __('E-Mail Address') }}</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

<!--                         <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->
                        <button class="btn btn_comman" type="submit">{{ __('Send Password Reset Link') }}</button>
                        <!-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div> -->
                    </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection