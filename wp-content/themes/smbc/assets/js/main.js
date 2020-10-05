jQuery(document).ready(function () {
  /*
  ==========================
    Owl Carousel
  ========================== */
  carousels();
  function carousels() {
    jQuery(".owl-carousel").owlCarousel({
      loop: true,
      nav: false,
      margin: 0,
      items: 1,
      center: true,
    });

    jQuery(".owl-testimonials").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      margin: 0,
      items: 1,
      center: true,
      autoplay: true
    });
  }

  /*
  ==========================
    Accordions
  ========================== */
  accordions();
  function accordions() {
    // Open Accordion buttons
    jQuery(".acc-open, .acc-close").click(function () {
      let outer = jQuery(this).closest(".event-block");
      let panel = outer.find(".event-panel").get(0);

      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        outer.removeClass("active");
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        outer.addClass("active");
      }
    });
  }

  /*
  ==========================
    Header
  ========================== */
  jQuery(".login__open, .login__close").click(function () {
    jQuery("body").toggleClass("login-active");
  });

  /*
  ==========================
    Mobile-nav
  ========================== */
  jQuery(".hamburger").click(function () {
    jQuery(this).hide();
    jQuery(".cross").show();
    jQuery(".mobile-nav-hover").toggle();
  });
  jQuery(".cross").click(function () {
    jQuery(this).hide();
    jQuery(".hamburger").show();
    jQuery(".mobile-nav-hover").toggle();
  });

  /*
  ==========================
    Members Directory
  ========================== */
  directory();
  function directory() {
    // Connection requests
    jQuery(".connection-request-toggle").click(function () {
      let box = jQuery(this).closest(".member").find(".connect-box");
      box.toggleClass("active");
    });

    // Toggle Community Offers
    jQuery('.community-offer__open').click(function(){
      jQuery('.community-outer').toggleClass('active');
    });

    // Toggle Search Sidebar
    jQuery('.sidebar__open, .sidebar__close').click(function(){
      jQuery('.sidebar').toggleClass('active');
    });
  }
});
