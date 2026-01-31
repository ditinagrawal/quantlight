<!DOCTYPE html>
<html class="no-js" lang="zxx">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ $research->title }} - QuantLight</title>
    <meta name="description" content="{{ $research->excerpt }}" />
    <meta name="author" content="QuantLight" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- favicon.icon -->
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="/quantlight/assets/img/favicon.png"
    />

    <!-- CSS here -->
    <link rel="stylesheet" href="/quantlight/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/animate.min.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/odometer.min.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/swiper.min.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/magnific-popup.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/fontawesome-pro.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/spacing.css" />
    <link rel="stylesheet" href="/quantlight/assets/css/main.css" />
  </head>

  <body>
    <!-- preloader start -->
    <div id="preloader">
      <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
      </div>
    </div>
    <!-- preloader start -->

    <!-- Header area start -->
    <div id="header"></div>
    <!-- Header area end -->

    <!-- Body main wrapper start -->
    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>
          <!-- about-section -->
          <section class="about-section-3__area section-space fade-wrapper">
            <div class="container">
              <div class="row">
                <div class="col-xl-5 col-lg-6" style="padding-top: 200px">
                  <div class="about-section-3__content">
                    <div class="section-heading__wrap_3">
                      <span class="section__subtitle rr-title-anim mb-15"
                        ><span></span> Project
                      </span>
                      <h3 class="section__title rr-title-anim">
                        {{ $research->title }}
                      </h3>
                    </div>
                    <div class="fade-top">
                      <p class="about-section-3__dec opacity_7">
                        {{ $research->excerpt }}
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                  <div class="about-section-3__thumb fix text_end">
                    @if($research->image_url)
                      <img
                        data-speed="0.9"
                        src="{{ $research->image_url }}"
                        alt="{{ $research->title }}"
                      />
                    @else
                      <img
                        data-speed="0.9"
                        src="/quantlight/assets/img/capabilities/1.png"
                        alt="{{ $research->title }}"
                      />
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- project-details -->
          <section class="project-details__area section-space fade-wrapper">
            <div class="container">
              <div class="project-details__wrapper">
                <div class="fade-top">
                  {!! $research->content !!}
                </div>
              </div>
            </div>
          </section>
        </main>
        <!-- Footer area start -->
        <div id="footer"></div>
        <!-- Footer area end -->
      </div>
    </div>
    <div id="scroll-percentage"><span id="scroll-percentage-value"></span></div>

    <!-- JS here -->
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
    <script src="/quantlight/assets/js/ajax-form.js"></script>
    <script src="/quantlight/assets/js/main.js"></script>
  </body>
</html>
