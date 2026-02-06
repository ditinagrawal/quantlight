(function ($) {
  "use strict";
  var windowOn = $(window);

  /*-----------------------------------------------------------------------------------

        Template Name: Stravise - Business Consulting HTML5 Template
        Author: RRDevs
        Support: https://support.rrdevs.net
        Description: Stravis is a modern and professional HTML5 template specially designed for business consultants, corporate agencies, organizations, and startups. It is built with a clean design, responsive layout, and user-friendly structure that is easy to customize.
        Version: 1.0
        Developer: Mamun khan (https://github.com/mk-mamun-khan)

    -----------------------------------------------------------------------------------

      /*======================================
        Preloader activation
        ========================================*/

  $(window).on("load", function (event) {
    $("#preloader").delay(1000).fadeOut(500);

    $(".odometer").waypoint(
      function (direction) {
        if (direction === "down") {
          let countNumber = $(this.element).attr("data-count");
          $(this.element).html(countNumber);
        }
      },
      {
        offset: "80%",
      }
    );
  });

  $(".preloader-close").on("click", function () {
    $("#preloader").delay(0).fadeOut(500);

    $(".odometer").waypoint(
      function (direction) {
        if (direction === "down") {
          let countNumber = $(this.element).attr("data-count");
          $(this.element).html(countNumber);
        }
      },
      {
        offset: "80%",
      }
    );
  });

  /////////////////////////////////////////////////////

  //GSAP smooth animation
  gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin);

  if ($("#smooth-wrapper").length && $("#smooth-content").length) {
    gsap.config({
      nullTargetWarn: false,
    });

    let smoother = ScrollSmoother.create({
      smooth: 1.5,
      effects: true,
      smoothTouch: false,
      normalizeScroll: false,
      ignoreMobileResize: true,
    });
  }

  /*======================================
   Data Css js
   ========================================*/
  $("[data-background]").each(function () {
    $(this).css(
      "background-image",
      "url( " + $(this).attr("data-background") + "  )"
    );
  });

  $("[data-width]").each(function () {
    $(this).css("width", $(this).attr("data-width"));
  });

  $("[data-bg-color]").each(function () {
    $(this).css("background-color", $(this).attr("data-bg-color"));
  });

  // data color
  $("[data-color]").each(function () {
    $(this).css("color", $(this).attr("data-color"));
  });

  /*======================================
      Mobile Menu Js
      ========================================*/
  $("#mobile-menu").meanmenu({
    meanMenuContainer: ".mobile-menu",
    meanScreenWidth: "991",
    meanExpand: ['<i class="fa-regular fa-angle-right"></i>'],
  });

  /*======================================
      Sidebar Toggle
      ========================================*/
  // $(".offcanvas__close,.offcanvas__overlay").on("click", function () {
  //   $(".offcanvas__area").removeClass("info-open");
  //   $(".offcanvas__overlay").removeClass("overlay-open");
  // });
  // // Scroll to bottom then close navbar
  // $(window).scroll(function () {
  //   if ($("body").scrollTop() > 0 || $("html").scrollTop() > 0) {
  //     $(".offcanvas__area").removeClass("info-open");
  //     $(".offcanvas__overlay").removeClass("overlay-open");
  //   }
  // });
  // $(".sidebar__toggle").on("click", function () {
  //   $(".offcanvas__area").addClass("info-open");
  //   $(".offcanvas__overlay").addClass("overlay-open");
  // });

  /*======================================
      Body overlay Js
      ========================================*/
  $(".body-overlay").on("click", function () {
    $(".offcanvas__area").removeClass("opened");
    $(".body-overlay").removeClass("opened");
  });

  /*======================================
      grid isotope Js
      ========================================*/
  if ($(".grid").length != 0) {
    var $grid = $(".grid").imagesLoaded(function () {
      $(".grid").isotope({
        itemSelector: ".grid-item",
        percentPosition: true,
        masonry: {
          columnWidth: 1,
        },
      });

      $(".planning-section-3__list").on("click", "li", function () {
        var filterValue = $(this).attr("data-filter");
        $grid.isotope({ filter: filterValue });
      });
      $(".planning-section-3__list li").on("click", function (event) {
        $(this).siblings(".active").removeClass("active");
        $(this).addClass("active");
        event.preventDefault();
      });
    });
  }

  /*======================================
      MagnificPopup image view
      ========================================*/
  $(".popup-image").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  /*======================================
      MagnificPopup video view
      ========================================*/
  $(".popup-video").magnificPopup({
    type: "iframe",
  });

  /*======================================
        Nice Select Js
      ========================================*/
  $("select").niceSelect();

  /*======================================
      Wow Js
      ========================================*/
  if ($(".wow").length) {
    var wow = new WOW({
      boxClass: "wow",
      animateClass: "animated",
      offset: 0,
      mobile: false,
      live: true,
    });
    wow.init();
  }

  /*======================================
    Smoth animatio Js
    ========================================*/
  $(document).on("click", ".smoth-animation", function (event) {
    event.preventDefault();
    $("html, body").animate(
      {
        scrollTop: $($.attr(this, "href")).offset().top - 50,
      },
      300
    );
  });

  // Popup Search Box
  $(".search-open-btn").on("click", function () {
    $(".search__popup").addClass("search-opened");
  });

  $(window).scroll(function () {
    if ($("body").scrollTop() > 0 || $("html").scrollTop() > 0) {
      $(".search__popup").removeClass("search-opened");
    }
  });

  $(".search-close-btn").on("click", function () {
    $(".search__popup").removeClass("search-opened");
  });

  $("#contact__form").submit(function (event) {
    event.preventDefault();
    var form = $(this);
    $(".loading-form").show();

    setTimeout(function () {
      $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: form.serialize(),
      })
        .done(function (data) {
          $(".loading-form").hide();
          $(".contact__form").append(
            '<p class="success-message mt-3 mb-0">Your message has been sent successfully.</p>'
          );
        })
        .fail(function (data) {
          $(".loading-form").hide();
          $(".contact__form").append(
            '<p class="error-message mt-3 mb-0">Something went wrong. Please try again later.</p>'
          );
        });
    }, 1000);
  });

  $("#showlogin").on("click", function () {
    $("#checkout-login").slideToggle(400);
  });
  $("#showcoupon").on("click", function () {
    $("#checkout_coupon").slideToggle(400);
  });

  // Page Scroll Percentage
  function scrollTopPercentage() {
    const scrollPercentage = () => {
      const scrollTopPos = document.documentElement.scrollTop;
      const calcHeight =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      const scrollValue = Math.round((scrollTopPos / calcHeight) * 100);
      const scrollElementWrap = $("#scroll-percentage");

      scrollElementWrap.css(
        "background",
        `conic-gradient( var(--rr-theme-primary2) ${scrollValue}%, var(--rr-common-white) ${scrollValue}%)`
      );

      // ScrollProgress
      if (scrollTopPos > 100) {
        scrollElementWrap.addClass("active");
      } else {
        scrollElementWrap.removeClass("active");
      }

      if (scrollValue < 99) {
        $("#scroll-percentage-value").text(`${scrollValue}%`);
      } else {
        $("#scroll-percentage-value").html('TOP');
      }
    };
    window.onscroll = scrollPercentage;
    window.onload = scrollPercentage;

    // Back to Top
    function scrollToTop() {
      document.documentElement.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    }

    $("#scroll-percentage").on("click", scrollToTop);
  }

  scrollTopPercentage();

  // Register GSAP and ScrollTrigger plugins
  gsap.registerPlugin(ScrollTrigger);

  //button animation
  // ----------------------------------------------------------------------------
  // Button Effect
  var buttons = document.querySelectorAll(".default-btn, .hover-anim");
  const btnCheck = document.getElementsByClassName("hover-anim").length > 0;
  if (btnCheck) {
    buttons.forEach(function (button) {
      button.addEventListener("mouseenter", function (e) {
        var parentOffset = this.getBoundingClientRect(),
          relX = e.clientX - parentOffset.left,
          relY = e.clientY - parentOffset.top;
        if (this.querySelector(".hover-bg")) {
          this.querySelector(".hover-bg").style.top = relY + "px";
          this.querySelector(".hover-bg").style.left = relX + "px";
        }
      });

      button.addEventListener("mouseout", function (e) {
        var parentOffset = this.getBoundingClientRect(),
          relX = e.clientX - parentOffset.left,
          relY = e.clientY - parentOffset.top;
        if (this.querySelector(".hover-bg")) {
          this.querySelector(".hover-bg").style.top = relY + "px";
          this.querySelector(".hover-bg").style.left = relX + "px";
        }
      });
    });
  }

  // title - animation
  if (document.querySelectorAll(".rr-title-anim").length > 0) {
    document.addEventListener("DOMContentLoaded", () => {
      let titles = document.querySelectorAll(".rr-title-anim");

      titles.forEach((title) => {
        let split = new SplitText(title, { type: "chars, words" });

        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: title,
            start: "top bottom",
            toggleActions: "play none none reverse",
            onEnter: () => tl.timeScale(2.3),
            onLeaveBack: () => tl.timeScale(2.3).reverse(),
          },
        });

        tl.from(split.chars, {
          opacity: 0,
          y: 50,
          rotation: 1,
          duration: 2,
          ease: "back",
          stagger: 0.05,
        });
      });
    });
  }

  // Item fadeIN animation
  if (document.querySelectorAll(".fade-wrapper").length > 0) {
    $(".fade-wrapper").each(function () {
      var section = $(this);
      var fadeItems = section.find(".fade-top");

      fadeItems.each(function (index, element) {
        var delay = index * 0.1;

        gsap.set(element, {
          opacity: 0,
          y: 70,
        });

        ScrollTrigger.create({
          trigger: element,
          start: "top 95%",
          end: "bottom bottom",
          scrub: false,
          toggleActions: "play none none reverse",
          onEnter: function () {
            gsap.to(element, {
              opacity: 1,
              y: 0,
              duration: 0.5,
              delay: delay,
            });
          },
          onLeaveBack: function () {
            gsap.to(element, { opacity: 0, y: 70, duration: 0.3 });
          },
        });
      });
    });
  }

  // img - custom - anim
  if (document.querySelectorAll(".img-custom-anim-img").length > 0) {
    gsap.utils.toArray(".img-custom-anim-img").forEach((img) => {
      gsap.set(img, { opacity: 0, x: -50, clipPath: "inset(0 100% 0 0)" });

      ScrollTrigger.create({
        trigger: img,
        start: "top 95%",
        end: "bottom 5%",
        toggleActions: "play none none reverse",
        markers: false,
        onEnter: () => {
          gsap.to(img, {
            opacity: 1,
            x: 0,
            clipPath: "inset(0 0 0 0)",
            duration: 0.3,
            ease: "cubic-bezier(0.645, 0.045, 0.355, 1)",
          });
        },
        onLeaveBack: () => {
          gsap.to(img, {
            opacity: 0,
            x: -50,
            clipPath: "inset(0 100% 0 0)",
            duration: 0.3,
          });
        },
      });
    });
  }

  // Stravise Slide Js Start -----------------------------------------

  // team - section
  if (document.querySelector(".team-section__active")) {
    var swiperteam = new Swiper(".team-section__active", {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".team-section__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        992: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 3,
        },
      },
    });
  }

  // testimonial - section
  if (document.querySelector(".testimonial-section__active")) {
    var swiperteam = new Swiper(".testimonial-section__active", {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,
      autoplay: true,
      centerMode: true,
      speed: 400,
      navigation: {
        nextEl: ".testimonial-section__arrow__next",
        prevEl: ".testimonial-section__arrow__prev",
      },
      pagination: {
        el: ".testimonial-section__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        992: {
          slidesPerView: 2.5,
        },
        1200: {
          slidesPerView: 3,
        },
      },
    });
  }

  // banner - section
  if (document.querySelector(".banner-section__active")) {
    var swiperteam = new Swiper(".banner-section__active", {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,
      autoplay: true,
      centerMode: true,
      speed: 400,
      navigation: {
        nextEl: ".banner-section__arrow__next",
        prevEl: ".banner-section__arrow__prev",
      },
    });
  }

  // service - section - 2
  if (document.querySelector(".service-section-2__active")) {
    var swipertesti = new Swiper(".service-section-2__active", {
      slidesPerView: 4,
      spaceBetween: 30,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 500,
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        992: {
          slidesPerView: 2.5,
        },
        1200: {
          slidesPerView: 4,
        },
      },
    });
  }

  // brand - section
  if (document.querySelector(".brand-section__active")) {
    document.addEventListener("DOMContentLoaded", function () {
      const swiper = new Swiper(".brand-section__active", {
        slidesPerView: "auto",
        spaceBetween: 0,
        centeredSlides: true,
        speed: 5000,
        loop: true,
        freeMode: false,
        allowTouchMove: false,
        autoplay: {
          delay: 1,
        },
      });
    });
  }

  // title - slide - 2
  if (document.querySelector(".title-slide-2__active")) {
    document.addEventListener("DOMContentLoaded", function () {
      const swiper = new Swiper(".title-slide-2__active", {
        slidesPerView: "auto",
        spaceBetween: -2,
        centeredSlides: true,
        speed: 25000,
        loop: true,
        freeMode: false,
        allowTouchMove: false,
        autoplay: {
          delay: 1,
        },
      });
    });
  }

  // brand - section - 3
  if (document.querySelector(".brand-section-3__active")) {
    document.addEventListener("DOMContentLoaded", function () {
      const swiper = new Swiper(".brand-section-3__active", {
        slidesPerView: "auto",
        spaceBetween: 157,
        centeredSlides: true,
        speed: 3500,
        loop: true,
        freeMode: false,
        allowTouchMove: false,
        autoplay: {
          delay: 1,
        },
        breakpoints: {
          320: {
            spaceBetween: 50,
          },
          767: {
            spaceBetween: 80,
          },
          992: {
            spaceBetween: 100,
          },
          1200: {
            spaceBetween: 157,
          },
        },
      });
    });
  }

  // banner - slider 1
  var slider = new Swiper(".banner-slider__active", {
    slidesPerView: 1,
    centeredSlides: true,
    loop: true,
    speed: 1000,
    loopedSlides: 6,
    spaceBetween: 20,
    autoplay: true,
    pagination: {
      el: ".banner-slider__pagination",
      clickable: true,
    },
  });

  var thumbs = new Swiper(".banner-slider__gallery", {
    slidesPerView: "auto",
    spaceBetween: 9,
    centeredSlides: true,
    loop: true,
    slideToClickedSlide: true,
  });

  slider.controller.control = thumbs;
  thumbs.controller.control = slider;

  // testimonial - section - 2
  if (document.querySelector(".testimonial-section-2__active")) {
    var swiperteam = new Swiper(".testimonial-section-2__active", {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".testimonial-section-2__pagination",
        clickable: true,
      },
    });
  }

  // title - slide - 4
  if (document.querySelector(".title-slide-4__active")) {
    document.addEventListener("DOMContentLoaded", function () {
      const swiper = new Swiper(".title-slide-4__active", {
        slidesPerView: "auto",
        spaceBetween: -2,
        centeredSlides: true,
        speed: 25000,
        loop: true,
        freeMode: false,
        allowTouchMove: false,
        autoplay: {
          delay: 1,
        },
      });
    });
  }

  // service - section - 4
  if (document.querySelector(".service-section-4__active")) {
    var swiperteam = new Swiper(".service-section-4__active", {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".service-section-4__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        576: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 1.5,
        },
        992: {
          slidesPerView: 2.2,
        },
        1200: {
          slidesPerView: 3,
        },
      },
    });
  }

  // case -studies - 4
  if (document.querySelector(".case-studies-4__active")) {
    var swiperteam = new Swiper(".case-studies-4__active", {
      slidesPerView: 3,
      spaceBetween: 44,
      loop: true,
      centeredSlides: true,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".case-studies-4__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          centeredSlides: false,
        },
        767: {
          slidesPerView: 1.5,
          centeredSlides: false,
        },
        992: {
          slidesPerView: 2,
          centeredSlides: false,
        },
        1200: {
          slidesPerView: 3,
        },
      },
    });
  }

  // blog - section - 4
  if (document.querySelector(".blog-section-4__active")) {
    var swiperteam = new Swiper(".blog-section-4__active", {
      slidesPerView: 3,
      spaceBetween: 100,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".blog-section-4__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        576: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        768: {
          slidesPerView: 1.5,
          spaceBetween: 30,
        },
        992: {
          slidesPerView: 1.8,
          spaceBetween: 30,
        },
        1200: {
          slidesPerView: 2.2,
          spaceBetween: 50,
        },
        1400: {
          slidesPerView: 2.5,
          spaceBetween: 50,
        },
        1600: {
          slidesPerView: 3,
          spaceBetween: 50,
        },
        1900: {
          spaceBetween: 100,
        },
      },
    });
  }

  // blog - section - 5
  if (document.querySelector(".blog-section-5__active")) {
    var swiperteam = new Swiper(".blog-section-5__active", {
      slidesPerView: 2.4,
      spaceBetween: 30,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 1.5,
        },
        992: {
          slidesPerView: 1.8,
        },
        1200: {
          slidesPerView: 2.2,
        },
        1400: {
          slidesPerView: 2.4,
        },
      },
    });
  }

  // testimonial - section - 4
  if (document.querySelector(".testimonial-section-4__active")) {
    var swipertesti = new Swiper(".testimonial-section-4__active", {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      navigation: {
        nextEl: ".testimonial-section-4__arrow__next",
        prevEl: ".testimonial-section-4__arrow__prev",
      },
    });
  }

  // testimonial - section - 5
  if (document.querySelector(".testimonial-section-5__active")) {
    var swipertesti = new Swiper(".testimonial-section-5__active", {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      pagination: {
        el: ".testimonial-section-5__pagination",
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        767: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        992: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 3,
        },
      },
    });
  }

  // testimonial - section - 3
  if (document.querySelector(".testimonial-section-3__active")) {
    var swipertesti = new Swiper(".testimonial-section-3__active", {
      slidesPerView: 2,
      spaceBetween: 0,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      navigation: {
        nextEl: ".testimonial-section-3__arrow__next",
        prevEl: ".testimonial-section-3__arrow__prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        767: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        992: {
          slidesPerView: 2,
        },
        1200: {
          slidesPerView: 2,
        },
      },
    });
  }

  // project - section - 3
  if (document.querySelector(".project-section-3__active")) {
    var swipertesti = new Swiper(".project-section-3__active", {
      slidesPerView: 4,
      spaceBetween: 18,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 400,
      navigation: {
        nextEl: ".project-section-3__arrow__next",
        prevEl: ".project-section-3__arrow__prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 2.5,
        },
        992: {
          slidesPerView: 3,
        },
        1200: {
          slidesPerView: 4,
        },
      },
    });
  }

  // banner - section - 3
  if (document.querySelector(".banner-section-3__active")) {
    var swipertesti = new Swiper(".banner-section-3__active", {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      centeredSlides: false,
      autoplay: true,
      centerMode: true,
      speed: 1000,

      pagination: {
        el: ".banner-section-3__dots",
        type: "bullets",
        clickable: true,
      },

      on: {
        slideChange: function () {
          const current = this.realIndex + 1;
          const total = this.slides.length - this.loopedSlides * 2;
          const cur = current < 10 ? `0${current}` : current;
          const tot = total < 10 ? `0${total}` : total;
          document.querySelector(
            ".banner-section-3__custom-pagination"
          ).innerHTML = `${cur} <span>/${tot}</span>`;
        },
        init: function () {
          this.emit("slideChange");
        },
      },
    });
  }

  // project panel start
  gsap.registerPlugin(ScrollTrigger);

  if (window.innerWidth > 768) {
    let projectPanels = document.querySelectorAll(".project-panel");

    projectPanels.forEach((section) => {
      gsap.to(section, {
        scrollTrigger: {
          trigger: section,
          pin: true,
          scrub: 1,
          start: "top 5%",
          end: "bottom 95%",
          endTrigger: ".project-panel-area",
          pinSpacing: false,
          markers: false,
        },
      });
    });
  } else {
    console.log("Scroll animation is disabled for mobile devices.");
  }
  // project panel end

  //  hover-active
  let rightItems = document.querySelectorAll(
    ".service-section__wrap .service-section__content"
  );
  let leftItems = document.querySelectorAll(
    ".service-section__thumb .service-image"
  );

  rightItems.forEach((rightItem, index) => {
    rightItem.addEventListener("mouseenter", function () {
      handleHover(rightItem, leftItems[index]);
    });
  });

  function handleHover(rightItem, leftItem) {
    rightItems.forEach((item) => {
      item.classList.remove("active");
      item.classList.add("service-section__content");
    });
    leftItems.forEach((item) => {
      item.classList.remove("active");
      item.classList.add("service-image");
    });
    rightItem.classList.add("active");
    leftItem.classList.add("active");
  }

  // hover-active
  if (document.querySelector(".project-section__content")) {
    let rightItems = document.querySelectorAll(
      ".project-section__content .project-section__item"
    );
    let leftItems = document.querySelectorAll(
      ".project-section__thumb .project-section__image"
    );

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("project-section__item");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("project-section__image");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // our-award-4 hover-active
  if (document.querySelector(".our-award-4__content")) {
    let rightItems = document.querySelectorAll(
      ".our-award-4__content .our-award-4__item"
    );
    let leftItems = document.querySelectorAll(".our-award-4__thumb .image");

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("our-award-4__item");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("image");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // banner-section-5 hover-active
  if (document.querySelector(".banner-section-5__content")) {
    let rightItems = document.querySelectorAll(
      ".banner-section-5__content .banner-section-5__cat"
    );
    let leftItems = document.querySelectorAll(
      ".banner-section-5__gallery .banner-section-5__image"
    );

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("banner-section-5__cat");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("banner-section-5__image");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // service-section-5_2 hover-active
  if (document.querySelector(".service-section-5_2__content")) {
    let rightItems = document.querySelectorAll(
      ".service-section-5_2__content .service-section-5_2__item"
    );
    let leftItems = document.querySelectorAll(
      ".service-section-5_2__image__wrap .service-section-5_2__image"
    );

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("service-section-5_2__item");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("service-section-5_2__image");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // project-section-5 hover-active
  if (document.querySelector(".project-section-5__wrapper")) {
    let rightItems = document.querySelectorAll(
      ".project-section-5__wrapper .project-section-5__item"
    );
    let leftItems = document.querySelectorAll(
      ".project-section-5__item .project-section-5__thumb"
    );

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("project-section-5__item");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("project-section-5__thumb");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // our-capabilities-2 hover-active
  if (document.querySelector(".our-capabilities-2__tag")) {
    let rightItems = document.querySelectorAll(".our-capabilities-2__tag li");
    let leftItems = document.querySelectorAll(
      ".our-capabilities-2__thumb .image"
    );

    if (
      rightItems.length &&
      leftItems.length &&
      rightItems.length === leftItems.length
    ) {
      rightItems.forEach((rightItem, index) => {
        rightItem.addEventListener("mouseenter", function () {
          handleHover(rightItem, leftItems[index]);
        });
      });

      function handleHover(rightItem, leftItem) {
        rightItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("li");
        });
        leftItems.forEach((item) => {
          item.classList.remove("active");
          item.classList.add("image");
        });
        rightItem.classList.add("active");
        leftItem.classList.add("active");
      }
    }
  }

  // planning - section - 3 tab
  document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".planning-section-3__list li");
    const items = document.querySelectorAll(
      ".planning-section-3__image .grid-item"
    );

    tabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        tabs.forEach((t) => t.classList.remove("active"));

        this.classList.add("active");

        const filter = this.getAttribute("data-filter");
        items.forEach((item) => {
          if (item.classList.contains(filter.replace(".", ""))) {
            item.style.display = "block";
          } else {
            item.style.display = "none";
          }
        });
      });
    });
    document.querySelector(".planning-section-3__list li.active")?.click();
  });

  // Text Invert With Scroll
  const split = new SplitText(".text-invert", {
    type: "lines",
  });
  split.lines.forEach((target) => {
    gsap.to(target, {
      backgroundPositionX: 0,
      ease: "none",
      scrollTrigger: {
        trigger: target,
        scrub: 1,
        start: "top 70%",
        end: "bottom center",
      },
    });
  });

  // scroll - btn
  $(document).on("click", ".scroll-btn", function (e) {
    e.preventDefault();

    const targetSelector = $(this).data("target");
    const targetElement = document.querySelector(targetSelector);

    if (targetElement) {
      gsap.to(window, {
        duration: 0.8,
        scrollTo: {
          y: targetElement,
          offsetY: 70,
        },
        ease: "power2.out",
      });
    }
  });

  //  service-section-5 hover reveal start
  if (document.querySelectorAll(".service-section-5__active").length > 0) {
    const hoveritem = document.querySelectorAll(".service-section-5__active");

    function moveImage(e, hoveritem, index) {
      const item = hoveritem.getBoundingClientRect();
      const x = e.clientX - item.x;
      const y = e.clientY - item.y;
      if (hoveritem.children[index]) {
        hoveritem.children[index].style.transform = `translate(${x}px, ${y}px)`;
      }
    }
    hoveritem.forEach((item, i) => {
      item.addEventListener("mousemove", (e) => {
        setInterval(moveImage(e, item, 1), 50);
      });
    });
  }
  // hover reveal end

  // team-section-2 hover reveal start
  if (document.querySelectorAll(".team-section-2__active").length > 0) {
    const hoveritem = document.querySelectorAll(".team-section-2__active");

    function moveImage(e, hoveritem, index) {
      const item = hoveritem.getBoundingClientRect();
      const x = e.clientX - item.x;
      const y = e.clientY - item.y;
      if (hoveritem.children[index]) {
        hoveritem.children[index].style.transform = `translate(${x}px, ${y}px)`;
      }
    }
    hoveritem.forEach((item, i) => {
      item.addEventListener("mousemove", (e) => {
        setInterval(moveImage(e, item, 1), 50);
      });
    });
  }
  // hover reveal end

  // service-section-3 hover reveal start
  if (document.querySelectorAll(".service-section-3__active").length > 0) {
    const hoveritem = document.querySelectorAll(".service-section-3__active");

    function moveImage(e, hoveritem, index) {
      const item = hoveritem.getBoundingClientRect();
      const x = e.clientX - item.x;
      const y = e.clientY - item.y;
      if (hoveritem.children[index]) {
        hoveritem.children[index].style.transform = `translate(${x}px, ${y}px)`;
      }
    }
    hoveritem.forEach((item, i) => {
      item.addEventListener("mousemove", (e) => {
        setInterval(moveImage(e, item, 1), 50);
      });
    });
  }
  // hover reveal end

  // why - choose - us - 2
  if (window.innerWidth > 768) {
    if (document.querySelectorAll(".why-choose-us-3__wrapper").length > 0) {
      const box = document.getElementById("scrollBox");
      const content = document.getElementById("scrollContent");
      const border = document.querySelector(".border-line");

      let currentY = 0;
      let targetY = 0;
      let maxScroll = content.scrollHeight - box.clientHeight;

      const lerp = (a, b, n) => (1 - n) * a + n * b;

      const startColor = "#F4D39A";
      const endColor = "#F4D39A";

      function animateScroll() {
        currentY = lerp(currentY, targetY, 0.1);
        gsap.set(content, { y: -currentY });

        const progress = currentY / maxScroll;

        const interpolatedColor = gsap.utils.interpolate(
          startColor,
          endColor,
          progress
        );

        gsap.to(border, {
          height: `${progress * 100}%`,
          backgroundColor: interpolatedColor,
          duration: 0.3,
          ease: "power1.out",
        });

        requestAnimationFrame(animateScroll);
      }

      animateScroll();

      box.addEventListener("wheel", (e) => {
        e.preventDefault();
        targetY += e.deltaY;
        targetY = Math.max(0, Math.min(targetY, maxScroll));
      });
    }
  }
})(jQuery);

// Header & footer are rendered server-side; just bind sidebar/offcanvas
$(function () {
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
