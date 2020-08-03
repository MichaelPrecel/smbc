<?php 
/* 
Template Name: Events
*/
?>

<?php get_header(); ?>

<main class="events" id="main">
  <!-- Landing Row -->
  <section class="landing">
    <div class="landing-intro">
      <div class="landing-intro__left bg-white">
        <div class="landing-intro__top text-block--max-width">
          <p class="type-med">Our events inspire, connect and ignite conversations between ambitious minds and industry mentors - in construction, property and finance.</p>
        </div>
        <div class="landing-intro__btm text-block--max-width">
          <p class="type-med">Become a member and join us at our upcoming events outlined below.</p>
        </div>
      </div>

      <div class="landing-intro__right">
        <img src="<?= get_template_directory_uri() .'/assets/images/ph/ph-shoes.jpeg' ?>" alt="">
      </div>
    </div>

    <div class="landing-banner">
      <div class="landing-banner__left bg-lightblue">
        <p class="type-white type-small">Great connections start with a great conversation.</p>
      </div>
      <div class="landing-banner__right bg-blue flex-center">
        <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="#">Become a member now</a></p>
      </div>
    </div>
  </section>

  <!-- Row Right -->
  <section class="row-right">
    <div class="col-left bg-blue inner-pad">
      <h1 class="type-large type-white">Exclusive Community Events</h1>
    </div>
    <div class="col-right bg-white inner-pad">
      <div class="col-right__inner text-block--max-width text-block--standard">
        <div class="type-med margin-btm--l">
          <p>All of our events are held at our Lakeside Stadium Precinct and feature insights from well-respected industry mentors and leaders in the finance, property and construction industries.</p>
        </div>
        <div class="type-small text-block--border-top">
          <p>So, rather than finding yourself off guard and offside, our events enable you to keep up-to-date with the latest industry innovation and initiatives. We’ll help you achieve introductions to connect with bright and the right minds, to help your business prosper.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Events -->
  <section class="events">
    <h1 class="bg-white inner-pad type-large border-top--blue">Upcoming Events</h1>

    <!-- Event -->
    <div class="event-outer">
      <div class="row-right border-top--blue">
        <div class="col-left bg-blue">
          <img class="img-cover" src="<?= get_template_directory_uri() .'/assets/images/ph/ph-shoes.jpeg' ?>" alt="">
        </div>
        <div class="col-right inner-pad bg-white">
          <div class="col-right__inner text-block--max-width">
            <div class="type-large margin-btm--l">
              <h2>Healthy Competition Can Drive your Business Further</h2>
            </div>
            <div class="type-med text-block--border-top">
              <div class="markdown margin-btm--l">
                <p>Viverra gravida et molestie maecenas bibendum consequat. Sagittis, laoreet sed gravida mattis ut eget dictum tellus. Ipsum.</p>
              </div>
  
              <div class="event__details">
                <div class="grid-item type-small border-top--blue">
                  <h3 class="type-strong">Date</h3>
                  <p class="type-lightblue">03 April 2020</p>
                </div>
                <div class="grid-item type-small border-top--blue">
                  <h3 class="type-strong">Time</h3>
                  <p class="type-lightblue">5:30pm</p>
                </div>
                <div class="grid-item type-small border-top--blue">
                  <h3 class="type-strong">Venue</h3>
                  <p class="type-lightblue">03 April 2020</p>
                </div>
              </div>
  
              <button class="type-small link-line link-arrow link-arrow--down acc-open">More details</button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Acc -->
      <div class="row-right event-panel">
        <div class="col-left bg-lightblue inner-pad event-panel__left">
          <button class="type-small link-line acc-close type-white link-arrow link-arrow--up">Close Panel</button>
        </div>
        
        <div class="col-right bg-white">
          <div class="col-right__inner text-block--max-width">
            <div class="type-small">
              <div class="event-panel-inner">
                <h3 class="type-strong type-small text-block--border-top">Speakers</h3>
                <div class="event__details margin-btm--l">
                  <div class="grid-item type-small">
                    <h4 class="type-strong">Sally Capp</h4>
                    <p class="type-lightblue type-italic">Lord Mayor</p>
                    <p class="type-lightblue">City of Melbourne</p>
                  </div>
                  <div class="grid-item type-small">
                    <h4 class="type-strong">Sally Capp</h4>
                    <p class="type-lightblue type-italic">Lord Mayor</p>
                    <p class="type-lightblue">City of Melbourne</p>
                  </div>
                  <div class="grid-item type-small">
                    <h4 class="type-strong">Sally Capp</h4>
                    <p class="type-lightblue type-italic">Lord Mayor</p>
                    <p class="type-lightblue">City of Melbourne</p>
                  </div>
                </div>  

                <div class="type-small text-block--border-top text-block--max-width">
                  <h3 class="type-strong margin-btm--s">About the event</h3>
                  <div class="markdown">
                    <p>At our Lakeside Stadium, we’re proudly launching the perfect arena to support leading businesses in the property, construction and finance game. Our events will attract and ignite conversations between ambitious minds and mentors. And, our community will support connecting our individual strengths to succeed together. Just as we see in sport.</p>
                  </div>
                </div>

                <a class="type-small link-line link-arrow-right link-arrow-right--blue" href="">Book Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

</main>

<?php get_footer(); ?>