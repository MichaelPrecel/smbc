<?php get_header() ?>

<main class="home" id="main">
  <!-- Landing Row -->
  <section class="landing">
    <div class="landing-intro">
      <div class="landing-intro__left bg-white">
        <div class="landing-intro__top text-block--max-width">
          <p class="type-med">Article header incidunt id tellus sed integer erat. Interdum amet quis ut mi quisque pulvinar accumsan sit egestas.</p>
        </div>
        <div class="landing-intro__btm text-block--max-width">
          <p class="type-med"><?php the_field('intro');?></p>
        </div>
      </div>

      <div class="landing-intro__right">
        <?php 
          $image = get_field('landing_image');
          $size = 'full';
          if ( $image ) {
            echo wp_get_attachment_image( $image, $size );
          }
        ?>
      </div>
    </div>

    <div class="landing-banner">
      <div class="landing-banner__left bg-lightblue">
        <p class="type-white type-small">As a member of our community, we'll connect you with the right people.</p>
      </div>
      <div class="landing-banner__right bg-blue flex-center">
        <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="#">Become a member now</a></p>
      </div>
    </div>
  </section>

  <article class="article-grid bg-white inner-pad">
    <?php 
      $image = get_field('hero_image');
      $size = 'full';
      if ( $image ):
    ?>
      <div class="article__header-img ratio-box ratio--2-1">
        <?php echo wp_get_attachment_image( $image, $size ); ?>
      </div>
    <?php endif ?>
    
    <div class="article__sticky type-tiny">
      <div class="article__sticky-inner">
        <p class=""><strong>Published:</strong> 02.02.20</p>
        <p class="margin-btm--xs"><strong>Author:</strong> Ashley</p>
        
        <p class="margin-btm--xxs"><strong>Share:</strong></p>
        <?php get_template_part('includes/snippet', 'sharebox') ?>
      </div>
    </div>

    <div class="article__body markdown type-small">
      <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
        <?php echo the_content(); ?>
      <?php endwhile; else: endif; ?>
    </div>
  </article>
  
  <section class="home-news bg-white">
    <h1 class="inner-pad type-large bg-blue type-white">Related Articles</h1>
    <div class="news-blocks">
      
      <div class="news-block">
        <a href="#" class="ratio-box ratio--3-2">
          <img class="img-cover" src="<?= get_template_directory_uri() .'/assets/images/ph/ph-shoes.jpeg' ?>" alt="">
        </a>
        <div class="news-block__text inner-pad--s">
          <h1 class="type-med margin-btm--m"><a href="#">Consequat, volutpat, fermentum non dictum.</a></h1>
          <h2 class="type-small type-lightblue">29 March 2020</h2>
          <p class="type-small">Elementum gravida convallis purus commodo eu. Pellentesque sed quisque massa lorem eu blandit. In consectetur fames nunc leo. Diam sapien.</p>
        </div>
        <a class="type-small inner-pad--s link-arrow-right link-arrow-right--blue" href="#">Read More</a>
      </div>

      <div class="news-block">
        <a href="#" class="ratio-box ratio--3-2">
          <img class="img-cover" src="<?= get_template_directory_uri() .'/assets/images/ph/ph-shoes.jpeg' ?>" alt="">
        </a>
        <div class="news-block__text inner-pad--s">
          <h1 class="type-med margin-btm--m"><a href="#">Consequat, volutpat, fermentum non dictum.</a></h1>
          <h2 class="type-small type-lightblue">29 March 2020</h2>
          <p class="type-small">Elementum gravida convallis purus commodo eu. Pellentesque sed quisque massa lorem eu blandit. In consectetur fames nunc leo. Diam sapien.</p>
        </div>
        <a class="type-small inner-pad--s link-arrow-right link-arrow-right--blue" href="#">Read More</a>
      </div>

      <div class="news-block">
        <a href="#" class="ratio-box ratio--3-2">
          <img class="img-cover" src="<?= get_template_directory_uri() .'/assets/images/ph/ph-shoes.jpeg' ?>" alt="">
        </a>
        <div class="news-block__text inner-pad--s">
          <h1 class="type-med margin-btm--m"><a href="#">Consequat, volutpat, fermentum non dictum.</a></h1>
          <h2 class="type-small type-lightblue">29 March 2020</h2>
          <p class="type-small">Elementum gravida convallis purus commodo eu. Pellentesque sed quisque massa lorem eu blandit. In consectetur fames nunc leo. Diam sapien.</p>
        </div>
        <a class="type-small inner-pad--s link-arrow-right link-arrow-right--blue" href="#">Read More</a>
      </div>
    </div>

    <div class="landing-banner">
      <div class="landing-banner__left bg-lightblue border-top--blue">
        <p class="type-small type-white">Eu molestie feugiat tortor ac dis erat. Vel ultrices.</p>
      </div>
      <div class="landing-banner__right bg-blue flex-center">
        <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="#">Back to News</a></p>
      </div>
    </div>
  </section>
</main>

<?php get_footer() ?>