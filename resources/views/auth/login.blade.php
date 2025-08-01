<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="shortcut icon" href="/assets/images/fevicon.ico.png" type="image/x-icon" />
      <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
      <title>LifeCare - Login</title>
      <!-- Custom styles for this template-->
      <link href="{{ asset('dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">

      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-178915398-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-178915398-1');
      </script>

   </head>
   <body class="">
      <div class="container">
         <!-- Outer Row -->
         <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
               <div class="card o-hidden border-0 shadow-lg my-5">
                  <div class="card-body p-0">
                     <!-- Nested Row within Card Body -->
                     <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                           <div class="p-5">
                              <div class="text-center">
                                 <h1 class="h4 text-gray-900 mb-4">{{ __('sentence.Welcome') }} LifeCare</h1>
                              </div>
                              <form method="POST" action="{{ route('login') }}" class="user">
                                 <div class="form-group">
                                    <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  aria-describedby="emailHelp" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                                 <div class="form-group">
                                    <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('sentence.Password') }}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                       <input class="custom-control-input" type="checkbox" name="remember" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                       {{ csrf_field() }}
                                       <label class="custom-control-label" for="customCheck">{{ __('sentence.Remember Me') }}</label>
                                    </div>
                                 </div>
                                 <button class="btn btn-primary btn-user btn-block" type="submit"> {{ __('sentence.Login') }}</button> 
                              </form>
                              <hr>
                              @if(Route::has('password.request'))
                              <div class="text-center">
                                 <a class="small" href="{{ route('password.request') }}"> {{ __('sentence.Forgot Your Password') }}</a>
                              </div>
                              @endif
                           </div>
                           <table class="table">
                              <tr>
                                 <!--<td align="center"><b>E-mail</b></td>-->
                                 <!--<td align="center"><b>Password</b></td>-->
                              </tr>
                              <!-- <tr>
                                 <td align="center">doctor@gmail.com</td>
                                 <td align="center">admin^123</td>
                              </tr> -->
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="{{ asset('js/app.js') }}" defer></script>
   </body>
</html>