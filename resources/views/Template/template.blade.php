@include('sweetalert::alert')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    @stack('css')
  </head>
  <body>
    @include('Template.sidebar')
    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      @include('Template.navbar')
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->

      @yield('content')
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  <a
                    href="https://plainadmin.com"
                    rel="nofollow"
                    target="_blank"
                  >
                    PlainAdmin
                  </a>
                </p>
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div
                class="
                  terms
                  d-flex
                  justify-content-center justify-content-md-end
                "
              >
                <a href="#0" class="text-sm">Term & Conditions</a>
                <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->
    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    {{-- <script src="{{asset('js/Chart.min.js')}}"></script> --}}
    {{-- <script src="{{asset('js/dynamic-pie-chart.js')}}"></script> --}}
    {{-- <script src="{{asset('js/moment.min.js')}}"></script> --}}
    {{-- <script src="{{asset('js/fullcalendar.js')}}"></script> --}}
    {{-- <script src="{{asset('js/jvectormap.min.js')}}"></script> --}}
    {{-- <script src="{{asset('js/world-maerc.js')}}"></script> --}}
    {{-- <script src="{{asset('js/polyfill.js')}}"></script> --}}
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    @stack('js')
  </body>
</html>
