<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>@yield('title', 'Updates') | QuantLight</title>
  <meta name="description" content="@yield('description', 'Lab updates and discoveries from QuantLight')" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" type="image/x-icon" href="/quantlight/assets/img/favicon.png" />

  <link rel="stylesheet" href="/quantlight/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/animate.min.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/odometer.min.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/swiper.min.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/magnific-popup.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/fontawesome-pro.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/spacing.css" />
  <link rel="stylesheet" href="/quantlight/assets/css/main.css" />
  @stack('styles')
</head>
<body>
  <div id="preloader">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>

  <div id="header">{!! $quantlightHeaderHtml ?? '' !!}</div>

  <div id="smooth-wrapper">
    <div id="smooth-content">
      <main>
        @yield('content')
      </main>

      <div id="footer">{!! $quantlightFooterHtml ?? '' !!}</div>
    </div>
  </div>
  <div id="scroll-percentage"><span id="scroll-percentage-value"></span></div>

  <script src="/quantlight/assets/js/jquery-3.7.1.min.js"></script>
  <script src="/quantlight/assets/js/waypoints.min.js"></script>
  <script src="/quantlight/assets/js/bootstrap.bundle.min.js"></script>
  <script src="/quantlight/assets/js/meanmenu.min.js"></script>
  <script src="/quantlight/assets/js/swiper.min.js"></script>
  <script src="/quantlight/assets/js/gsap.js"></script>
  <script src="/quantlight/assets/js/ScrollSmoother.js"></script>
  <script src="/quantlight/assets/js/ScrollToPlugin.js"></script>
  <script src="/quantlight/assets/js/ScrollTrigger.js"></script>
  <script src="/quantlight/assets/js/SplitText.js"></script>
  <script src="/quantlight/assets/js/wow.js"></script>
  <script src="/quantlight/assets/js/nice-select.js"></script>
  <script src="/quantlight/assets/js/magnific-popup.min.js"></script>
  <script src="/quantlight/assets/js/odometer.min.js"></script>
  <script src="/quantlight/assets/js/main-no-fetch.js"></script>
  <script>
    // Fallback: if main-no-fetch.js fails to load, ensure page still works
    (function() {
      if (typeof jQuery !== 'undefined') {
        jQuery(function ($) {
          // Hide preloader (critical - prevents infinite loading)
          $(window).on("load", function (event) {
            $("#preloader").delay(1000).fadeOut(500);
          });
          
          // Sidebar/offcanvas bindings
          $(".offcanvas__close,.offcanvas__overlay").on("click", function () {
            $(".offcanvas__area").removeClass("info-open");
            $(".offcanvas__overlay").removeClass("overlay-open");
          });
          $(window).scroll(function () {
            if ($("body").scrollTop() > 0 || $("html").scrollTop() > 0) {
              $(".offcanvas__area").removeClass("info-open");
              $(".offcanvas__overlay").removeClass("overlay-open");
            }
          });
          $(".sidebar__toggle").on("click", function (e) {
            e.stopPropagation();
            $(".offcanvas__area").toggleClass("info-open");
          });
          $(document).on("click", function (e) {
            if (!$(e.target).closest(".offcanvas__area, .sidebar__toggle").length) {
              $(".offcanvas__area").removeClass("info-open");
            }
          });
        });
      } else {
        // Even without jQuery, hide preloader after page loads
        window.addEventListener('load', function() {
          var preloader = document.getElementById('preloader');
          if (preloader) {
            setTimeout(function() {
              preloader.style.display = 'none';
            }, 1000);
          }
        });
      }
    })();
  </script>
  @stack('scripts')
</body>
</html>
