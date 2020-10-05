<?php 
/* 
Template Name: News
*/
?>

<?php get_header(); ?>

<main class="news" id="main">
  <!-- Landing Row -->
  <section class="landing border-btm--blue">
    <div class="landing-intro">
      <div class="landing-intro__left bg-white">
        <div class="landing-intro__top text-block--max-width type-med">
          <?= the_field('landing_header', 124) ?>
        </div>
        <div class="landing-intro__btm text-block--max-width type-med">
          <?= the_field('landing_intro', 124) ?>
        </div>
      </div>

      <div class="landing-intro__right">
        <?php 
          $image = get_field('landing_image', 124);
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
          <p class="type-white type-small">As a member of our community, we'll connect you with the right people.</p>
        </div>
        <div class="landing-banner__right bg-blue flex-center">
          <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="<?= get_permalink( get_page_by_title('about') ) ?>#membership">Become a member now</a></p>
        </div>
      </div>
    <?php endif ?>
  </section>

  <?php 
    $args = array(
      'numberposts'      => -1,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'post',
      'suppress_filters' => true,
    );
    
      $my_query = new wp_query( $args );
    
      if( $my_query->have_posts() ) :
  ?>
    <section class="home-news bg-white">
      <h1 class="inner-pad type-large bg-blue type-white">Latest News</h1>

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
      </div>
    </section>

    <?= the_posts_pagination(); ?>
  <?php 
    endif;
    wp_reset_query();
  ?>

</main>

<?php get_footer(); ?>