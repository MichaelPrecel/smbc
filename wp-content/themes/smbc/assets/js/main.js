jQuery(document).ready(function(){
  jQuery(".owl-carousel").owlCarousel({
    loop: true,
    nav: false,
    margin: 0,
    items: 1,
    center: true
  });

  // Accordions
  accordions();

  function accordions() {
    // Open Accordion buttons
    jQuery('.acc-open, .acc-close').click(function(){
      let outer = jQuery(this).closest('.event-outer');
      let panel = outer.find('.event-panel').get(0);
  
      if ( panel.style.maxHeight ) {
        panel.style.maxHeight = null;
        outer.removeClass('active');
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        outer.addClass('active');
      }
    });
  }
});