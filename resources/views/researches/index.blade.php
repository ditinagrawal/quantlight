<!DOCTYPE html>
<html class="no-js" lang="zxx">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>QuantLight</title>
    <meta name="description" content="" />
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

                <!-- breadcrumb-section -->
                <section class="breadcrumb-section__area heading-bg">
                    <div class="breadcrumb-section__wrapper"
                        data-background="/quantlight/assets/img/bg.jpg">
                        <div class="container">
                            <div class="breadcrumb-section__content text_center breadcrumb-section__space">
                                <h3 class="breadcrumb-section__title">Researches & Capablilities</h3>
                               
                            </div>
                        </div>
                        <div class="breadcrumb-section__border"></div>
                    </div>
                </section>

          <!-- research-section -->
          <section class="service-section-2__area fix fade-wrapper">
            <div
              class="service-section-2__wrapper"
              data-background="/quantlight/assets/img/service/capabilities-bg.PNG"
            >
              <div class="service-section-2__bg"></div>
              <div class="container">
                <div class="row">
                  <div class="col-xl-4 col-lg-5">
                    <div class="service-section-2__thumb fix">
                      <img
                        data-speed="0.9"
                        src="/quantlight/assets/img/capabilities.jpg"
                        alt="image not found"
                      />
                    </div>
                  </div>
                  <div class="col-xl-8 col-lg-7">
                    <div class="service-section-2__text section-space-top">
                      <div class="section-heading__wrap_2">
                        <span class="section__subtitle rr-title-anim"
                          >Our Capabilities</span
                        >
                        <h3 class="section__title text_white rr-title-anim">
                          Cutting-Edge Studies in Structured Light & High
                          Harmonics
                        </h3>
                        <div class="fade-top">
                          <p class="text_white_7 mt-20">
                            Our exceptional experimental and technological
                            capabilities allow us to innovate new frontiers in
                            optics and photonics. Some of our expertise is
                            listed below as follows:
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
			</br>
			</br>
			</br>

            <div class="service-section-2__wrap section-space-bottom">
              <div class="container" id="capabilities">
                <div class="service-section-2__slider">
                  <div class="swiper service-section-2__active">
                    <div class="swiper-wrapper">
                      @foreach($researches as $index => $research)
                      <div class="swiper-slide">
                        <div class="service-section-2__item">
                          <div class="service-section-2__icon">
                            <img
                              src="{{ $research->image_url ?? '/quantlight/assets/img/capabilities/' . (($index % 7) + 1) . '.png' }}"
                              alt="{{ $research->title }}"
                              style="width: 100%"
                            />
                          </div>
                          <h3 class="service-section-2__title">
                            {{ $research->title }}
                          </h3>
                          <p class="text_white_7">
                            {{ Str::limit($research->excerpt, 150) }}
                          </p>
                          <div class="service-section-2__arrow">
                            <a href="/{{ $research->slug }}"
                              ><i class="fa-light fa-angle-right"></i
                            ></a>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
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
