<?php get_header() ?>

<main class="home" id="main">
  <!-- Landing Row -->
  <section class="landing border-btm--blue">
    <div class="landing-intro">
      <div class="landing-intro__left bg-white">
        <div class="landing-intro__top text-block--max-width">
          <p class="type-med"><?= get_the_title() ?></p>
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

  <?php 
    // Related Articles
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) :
      $tag_ids = array();
      foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
      $args=array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page'=>5, // Number of related posts that will be shown.
        'ignore_sticky_posts'=>1
      );
    
      $my_query = new wp_query( $args );
    
      if( $my_query->have_posts() ) :
  ?>
    <section class="home-news bg-white">
      <h1 class="inner-pad type-large bg-blue type-white">Related Articles</h1>

      <div class="news-blocks">
        <?php 
          while( $my_query->have_posts() ):
            $my_query->the_post();
        ?>

        <!-- <li>
          <div class="relatedthumb"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
            <div class="relatedcontent">
            <h3><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <?php the_time('M j, Y') ?>
            </div>
        </li> -->

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
      </div>
    </section>
  <?php 
    endwhile; 
    endif;
    endif;
    $post = $orig_post;
    wp_reset_query();
  ?>

  <div class="landing-banner">
    <div class="landing-banner__left bg-lightblue border-top--blue">
      <p class="type-small type-white">Eu molestie feugiat tortor ac dis erat. Vel ultrices.</p>
    </div>
    <div class="landing-banner__right bg-blue flex-center">
      <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="#">Back to News</a></p>
    </div>
  </div>
</main>

<?php get_footer() ?>