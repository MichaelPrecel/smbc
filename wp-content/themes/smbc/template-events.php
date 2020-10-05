<?php 
/* 
Template Name: Events
*/
?>

<?php get_header(); ?>

<main class="events" id="main">
  <!-- Landing Row -->
  <section class="landing border-btm--blue">
    <div class="landing-intro">
      <div class="landing-intro__left bg-white">
        <div class="landing-intro__top text-block--max-width type-med">
          <?= the_field('landing_header') ?>
        </div>
        <div class="landing-intro__btm text-block--max-width type-med">
          <?= the_field('landing_intro') ?>
        </div>
      </div>

      <div class="landing-intro__right">
        <?php 
          $image = get_field('landing_image');
          $size = 'full';
          if ( $image ) {
            echo wp_get_attachment_image( $image, $size, "", array("class" => "img-cover") );
          }
        ?>
      </div>
    </div>

    <?php if ( !(wp_get_current_user()->exists()) ) : ?>
      <div class="landing-banner">
        <div class="landing-banner__left bg-lightblue">
          <p class="type-white type-small">Great connections start with a great conversation.</p>
        </div>
        <div class="landing-banner__right bg-blue flex-center">
          <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="<?= get_permalink( get_page_by_title('about') ) ?>#membership">Become a member now</a></p>
        </div>
      </div>
    <?php endif ?>
  </section>

  <!-- Row Right -->
  <section class="row-right">
    <div class="col-left bg-blue inner-pad">
      <h1 class="type-large type-white"><?= the_field('about_header') ?></h1>
    </div>
    <div class="col-right bg-white inner-pad">
      <div class="col-right__inner text-block--max-width text-block--standard">
        <div class="type-med margin-btm--l">
          <?= the_field('about_intro') ?>
        </div>
        <div class="type-small text-block--border-top">
          <?= the_field('about_text') ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Events -->
  <section class="events">
    <h1 class="bg-white inner-pad type-large border-top--blue">Upcoming Events</h1>

    <!-- Event -->
    <div class="event-outer">
      <?php 
        $posts = get_posts(array(
          'post_type'       => 'event',
          'posts_per_page'  => -1,
          'orderby'         => 'meta_value',
          'meta_key'        => 'date',
          'meta_type'       => 'DATETIME',
          'order'           => 'ASC'
        ));

        if ( $posts ) : 
          foreach ( $posts as $post ) : 
            setup_postdata( $post );
      ?>
      <div class="event-block">
        <div class="row-right border-top--blue">
          <div class="col-left bg-blue">
            <?php 
              $image = get_field('feature_image');
              $size = 'full';
              if ( $image ) {
                echo wp_get_attachment_image( $image, $size, "", array("class" => "img-cover") );
              }
            ?>
          </div>
          <div class="col-right inner-pad bg-white">
            <div class="col-right__inner text-block--max-width">
              <div class="type-large margin-btm--l">
                <h2><?= get_the_title($post) ?></h2>
              </div>
              <div class="type-med text-block--border-top">
                <div class="markdown margin-btm--l">
                  <p><?= get_the_excerpt( $post ) ?></p>
                </div>
    
                <div class="event__details">
                  <div class="grid-item type-small border-top--blue">
                    <h3 class="type-strong">Date</h3>
                    <p class="type-lightblue">
                      <?php 
                        // $date_now = date('Y-m-d H:i:s');
                        // echo $date_now;
                        $date = date('j F, Y', strtotime(get_field('date')));
                        $date_time = date('g:i a', strtotime(get_field('date')));
                        echo $date . '<br>' . $date_time;
                      ?>
                    </p>
                  </div>
                  <div class="grid-item type-small border-top--blue">
                    <h3 class="type-strong">Time</h3>
                    <p class="type-lightblue"><?= get_field('time') ?></p>
                  </div>
                  <div class="grid-item type-small border-top--blue">
                    <h3 class="type-strong">Venue</h3>
                    <p class="type-lightblue">
                    <?php if ( get_field('venue_map') ) : ?><a href="<?= get_field('venue_map') ?>" target="_blank"><?php endif ?>
                      <?= get_field('venue') ?>
                    <?php if ( get_field('venue_map') ) : ?></a><?php endif ?>
                    </p>
                  </div>
                </div>
    
                <button class="type-small link-line link-arrow link-arrow--down acc-open">More details</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row-right event-panel">
          <div class="col-left bg-lightblue inner-pad event-panel__left">
            <button class="type-small link-line acc-close type-white link-arrow link-arrow--up">Close Panel</button>
          </div>
          
          <div class="col-right bg-white">
            <div class="col-right__inner text-block--max-width">
              <div class="type-small">
                <div class="event-panel-inner">

                  <?php 
                    $rows = get_field('guests'); 
                    if ( $rows ) :
                  ?>
                    <h3 class="type-strong type-small text-block--border-top margin-btm--s">Speakers</h3>
                    <div class="event__details margin-btm--l">
                      <?php foreach ( $rows as $row ) : ?>
                        <div class="grid-item type-small">
                          <div class="member__picture ratio-box ratio--1-1 margin-btm--s">
                            <?php 
                            $image = $row['guest_headshot'];
                              if ( $image ) {
                                echo wp_get_attachment_image( $image, 'full' );
                              }
                            ?>
                          </div>
                          <h4 class="type-strong"><?= $row['guest_name'] ?></h4>
                          <p class="type-lightblue"><?= $row['position'] ?></p>
                        </div>
                      <?php endforeach ?>
                    </div>  
                  <?php endif ?>

                  <div class="type-small text-block--border-top text-block--max-width">
                    <h3 class="type-strong margin-btm--s">About the event</h3>
                    <div class="markdown">
                      <?= get_field('about') ?>
                    </div>
                  </div>

                  <a class="type-small link-line link-arrow-right link-arrow-right--blue" href="<?= get_field('event_link') ?>">Book Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; endif ?>
    </div>

  </section>

</main>

<?php get_footer(); ?>