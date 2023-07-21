<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/x-icon" />
  <title>Assets Management System | Login</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
</head>

<body>
  <section class="signin-section">
    <div class="container-fluid">
      <!-- ========== title-wrapper start ========== -->

      <!-- ========== title-wrapper end ========== -->

      <div class="row g-0 auth-row">
        <div class="col-lg-6">
          <div class="auth-cover-wrapper bg-primary-100">
            <div class="auth-cover">
              <div class="title text-center">
                <h1 class="text-primary mb-10">Selamat Datang</h1>
                <p class="text-medium">
                  Silahkan Login untuk mengakses Sistem Manajemen Asset 
                </p>
              </div>
              <div class="cover-image">
                <img src="assets/images/auth/signin-image.svg" alt="" />
              </div>
              <div class="shape-image">
                <img src="assets/images/auth/shape.svg" alt="" />
              </div>
            </div>
          </div>
        </div>
        <!-- end col -->
        <div class="col-lg-6">
          <div class="signin-wrapper">
            <div class="form-wrapper">
              <div class="text-center w-100">
                <img class='text-center' src="{{asset('images/logo/absensi.png')}}" width="150x" alt="logo">
              </div>
              <br>
              <br>
              <h6 class="mb-15 mt-20">Asset Management System</h6>
              <p class="text-sm mb-25">
                Silahkan Login untuk mengakses Sistem Manajemen Asset
              </p>
              <form action="{{route('login.post')}}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12">
                    <div class="input-style-1">
                      <label for="Username">Username</label>
                      <input type="text" placeholder="Username" id="Username" name="Username" required autofocus />
                    </div>
                  </div>
                  <!-- end col -->
                  <div class="col-12">
                    <div class="input-style-1">
                      <label for="Password">Password</label>
                      <input type="password" placeholder="Password" id="Password" name="Password" required autofocus />
                    </div>
                  </div>
                  <!-- end col -->

                  <!-- end col -->

                  <!-- end col -->
                  <div class="col-12">
                    <div class="
                            button-group
                            d-flex
                            justify-content-center
                            flex-wrap
                          ">
                      <button class="
                              main-btn
                              primary-btn
                              btn-hover
                              w-100
                              text-center
                            " type="submit">
                        Sign In
                      </button>
                    </div>
                  </div>
                </div>
                <!-- end row -->
              </form>
              <div class="singin-option pt-40">
                <p class="text-sm text-medium text-center text-gray">

                </p>
                <div class="
                        button-group
                        pt-40
                        pb-40
                        d-flex
                        justify-content-center
                        flex-wrap
                      ">
                  <!-- <button class="main-btn primary-btn-outline m-2">
                        <i class="lni lni-facebook-filled mr-10"></i>
                        Facebook
                      </button>
                      <button class="main-btn danger-btn-outline m-2">
                        <i class="lni lni-google mr-10"></i>
                        Google
                      </button> -->
                </div>
                <!-- <p class="text-sm text-medium text-dark text-center">
                      Don’t have any account yet?
                      <a href="signup.html">Create an account</a>
                    </p> -->
              </div>
            </div>
          </div>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
  </section>
  @include('sweetalert::alert')
</body>
</html>