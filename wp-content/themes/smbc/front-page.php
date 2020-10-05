<?php get_header() ?>

  <main class="home" id="main">
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
            if ( $image ) {
              echo wp_get_attachment_image( $image, 'full' );
            }
          ?>
        </div>
      </div>

      <?php if ( !(wp_get_current_user()->exists()) ) : ?>
        <div class="landing-banner">
          <div class="landing-banner__left bg-lightblue">
            <p class="type-white type-small">As a member of our community, we'll connect you with the right people.</p>
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

          <a class="type-small link-line link-arrow-right link-arrow-right--blue" href="<?= get_permalink( get_page_by_title('about') ) ?>">Learn more about us</a>
        </div>
      </div>
    </section>

    <section class="row-right">
      <div class="col-left bg-blue">
        <?php 
          $image = get_field('membership_image');
            if ( $image ) {
              echo wp_get_attachment_image( $image, 'full', '', array("class" => "img-cover") );
            }
        ?>
      </div>
      <div class="col-right inner-pad bg-lightblue">
        <div class="col-right__inner text-block--max-width text-block--standard">
          <h1 class="type-large type-white margin-btm--l">Membership</h1>
          <div class="type-med margin-btm--l type-white">
            <?= the_field('membership_intro') ?>
          </div>
          <div class="type-small text-block--border-top type-white">
            <?= the_field('membership_text') ?>
          </div>

          <a class="type-small link-line link-arrow-right link-arrow-right--white type-white" href="<?= get_permalink( get_page_by_title('about') ) ?>#membership">Learn more about our membership model</a>
        </div>
      </div>
    </section>

    <!-- Events -->
    <?php 
      $posts = get_posts(array(
        'post_type'       => 'event',
        'posts_per_page'  => 6,
        'orderby'         => 'meta_value',
        'meta_key'        => 'date',
        'meta_type'       => 'DATETIME',
        'order'           => 'ASC'
      ));

      if ( $posts ) : 
    ?>
      <section class="home-events-rows bg-white">
        <h1 class="inner-pad type-large">Upcoming Events</h1>

        <?php 
          foreach ( $posts as $post ) : 
          setup_postdata( $post );
        ?>
        <a href="<?= the_permalink( get_page_by_title('events') ) ?>" class="home-event-row inner-pad">
          <div class="home-event-row__left">
            <h2 class="type-med"><?= get_the_title($post) ?></h2>
            <?php 
              $date = date('j F, Y', strtotime(get_field('date')));
              $date_time = date('g:i a', strtotime(get_field('date')));
            ?>
            <h3 class="type-med type-lightblue"><?= $date ?></h3>
          </div>
          <div class="home-event-row__right">
            <h2 class="type-med link-arrow-right link-arrow-right--blue" href="">See more</h2>
          </div>
        </a>
        <?php endforeach ?>

        <div class="landing-banner">
          <div class="landing-banner__left bg-white border-top--blue">
            <p class="type-small">We curate six annual events to inspire, connect and ignite conversation.</p>
          </div>
          <div class="landing-banner__right bg-lightblue flex-center">
            <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="<?= the_permalink( get_page_by_title('events') ) ?>">Browse all events</a></p>
          </div>
        </div>
      </section>
    <?php endif ?>

    <!-- News -->
    <?php 
    $args = array(
      'posts_per_page'   => 6,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'post',
      'suppress_filters' => true,
    );
    
      $my_query = new wp_query( $args );
    
      if( $my_query->have_posts() ) :
    ?>

      <section class="home-news bg-white">
        <h1 class="inner-pad type-large bg-blue type-white">News</h1>
        <div class="news-blocks">
          <?php 
            while( $my_query->have_posts() ):
              $my_query->the_post();
          ?>
            <div class="news-block">
              <a href="<?= the_permalink() ?>" class="ratio-box ratio--3-2">
                <?php if ( $image = get_field('hero_image') ) {
                  echo wp_get_attachment_image( $image, 'full', "", array("class" => "img-cover") );
                } 
                ?>
              </a>
              <div class="news-block__text inner-pad--s">
                <h1 class="type-med margin-btm--m"><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h1>
                <h2 class="type-small type-lightblue"><?= the_time('j M Y') ?></h2>
                <p class="type-small"><?= get_the_excerpt() ?></p>
              </div>
              <a class="type-small inner-pad--s link-arrow-right link-arrow-right--blue" href="<?= the_permalink() ?>">Read More</a>
            </div>
          <?php endwhile ?>

        <!-- <div class="landing-banner">
          <div class="landing-banner__left bg-lightblue border-top--blue">
            <p class="type-small type-white">Eu molestie feugiat tortor ac dis erat. Vel ultrices.</p>
          </div>
          <div class="landing-banner__right bg-blue flex-center">
            <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="#">Browse all events</a></p>
          </div>
        </div> -->
      </section>
    <?php endif; wp_reset_query(); ?>

    <div class="row-full-image ratio-box ratio--2-1">
      <?php 
        $image = get_field('events_banner_image');
        if ( $image ) {
          echo wp_get_attachment_image( $image, 'full', '', array("class" => "img-cover") );
        }
      ?>
    </div>
  
    <!-- Sponsors -->
    <section class="sponsors bg-white">
      <h1 class="inner-pad type-large">Sponsors</h1>
      <div class="sponsors-outer inner-pad">
        <div class="sponsors-intro border-top--blue type-small">
          <?= the_field('sponsors_text') ?>
        </div>

        <div class="sponsors-icons">

        <?php foreach ( get_field('sponsors') as $sponsor ) : ?>
          <div class="sponsors-icon">
            <?php if ( $sponsor['link'] ) : echo '<a href="' . $sponsor['link'] . '" target="_blank">'; endif ?>
              <div class="ratio-box ratio--3-2">
                <?php 
                  $image = $sponsor['logo'];
                  if ( $image ) {
                    echo wp_get_attachment_image( $image, 'full', '', array("class" => "img-cover") );
                  }
                ?>
              </div>
            <?php if ( $sponsor['link'] ) : echo '</a>'; endif ?>
          </div>
        <?php endforeach ?>
        </div>
      </div>
    </section>
  
  </main>

<?php get_footer() ?>