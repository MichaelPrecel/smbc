<?php 
/* 
Template Name: About
*/
?>

<?php get_header(); ?>

<main class="about" id="main">
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
            echo wp_get_attachment_image( $image , 'full' );
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
      <div class="type-large type-white">
        <?= get_field('about_header') ?>
      </div>
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

  <div class="row-full-image ratio-box ratio--2-1">
    <?php 
      $image = get_field('about_banner');
      if ( $image ) {
        echo wp_get_attachment_image( $image , 'full', '', array("class" => "img-cover") );
      }
    ?>
  </div>

  <!-- Testimonials -->
  <section class="testimonials">
    <div class="owl-carousel owl-testimonials">
      <?php 
        $rows = get_field('testimonials'); 
        if ( $rows ) :
      ?>
      <?php foreach ( $rows as $row ) : ?>
        <div class="testimonial">
          <div class="testimonial__left bg-lightblue type-white inner-pad">
            <div class="type-med margin-btm--l text-block--max-width">
              <?= $row['quote'] ?>
            </div>
            <p class="type-small"><?= $row['name'] ?></p>
          </div>
          <div class="testimonial__right">
            <?php 
            $image = $row['image'];
              if ( $image ) {
                echo wp_get_attachment_image( $image, 'full', '', array("class" => "img-cover") );
              }
            ?>
          </div>
        </div>
      <?php endforeach; endif ?>
    </div>
  </section>

  <!-- Membership Levels -->
  <section class="about-memberships-outer type-small" id="membership">
    <h1 class="inner-pad type-large">Membership Levels</h1>
    <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; else: endif; ?>
  </section>
  <!-- <section class="membership bg-white" id="membership">
    <h1 class="inner-pad type-large">Membership Levels</h1>
    
    <div class="memberships-grid">

      <div class="membership__header inner-pad">
        <h1 class="type-med type-strong">Participant</h1>
      </div>
      <div class="membership__header inner-pad">
        <h1 class="type-med type-strong">Associate Membership</h1>
      </div>
      <div class="membership__header inner-pad">
        <h1 class="type-med type-strong">Premium Membership</h1>
      </div>
      <div class="membership__header inner-pad">
        <h1 class="type-med type-strong">Network Sponsorship</h1>
      </div>

      <div class="membership__body inner-pad">
        <div class="markdown type-small margin-btm--m">
          <p>Adipiscing iaculis magna tempus neque at volutpat augue facilisis eget. Turpis venenatis adipiscing facilisis massa porta. Dictum placerat fringilla vel lorem at suspendisse massa. Facilisis nibh suspendisse fringilla dolor et ut commodo posuere.</p>
        </div>
      </div>
      <div class="membership__body inner-pad">
        <div class="markdown type-small margin-btm--m">
          <p>Adipiscing iaculis magna tempus neque at volutpat augue facilisis eget. Turpis venenatis adipiscing facilisis massa porta. Dictum placerat fringilla vel lorem at suspendisse massa. Facilisis nibh suspendisse fringilla dolor et ut commodo posuere.</p>
        </div>
      </div>
      <div class="membership__body inner-pad">
        <div class="markdown type-small margin-btm--m">
          <p>Adipiscing iaculis magna tempus neque at volutpat augue facilisis eget. Turpis venenatis adipiscing facilisis massa porta. Dictum placerat fringilla vel lorem at suspendisse massa. Facilisis nibh suspendisse fringilla dolor et ut commodo posuere.</p>
        </div>
      </div>
      <div class="membership__body inner-pad">
        <div class="markdown type-small margin-btm--m">
          <p>Adipiscing iaculis magna tempus neque at volutpat augue facilisis eget. Turpis venenatis adipiscing facilisis massa porta. Dictum placerat fringilla vel lorem at suspendisse massa. Facilisis nibh suspendisse fringilla dolor et ut commodo posuere.</p>
        </div>
      </div>

      <div class="membership__features inner-pad">
        <ul class="type-small">
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
        </ul>
      </div>
      <div class="membership__features inner-pad">
        <ul class="type-small">
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
        </ul>
      </div>
      <div class="membership__features inner-pad">
        <ul class="type-small">
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
        </ul>
      </div>
      <div class="membership__features inner-pad">
        <ul class="type-small">
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
          <li>Attend sponsored events at no cost</li>
        </ul>
      </div>

      <div class="membership__footer inner-pad">
        <p class="type-small"><strong>$450 p/a</strong></p>
      </div>
      <div class="membership__footer inner-pad">
        <p class="type-small"><strong>$450 p/a</strong></p>
      </div>
      <div class="membership__footer inner-pad">
        <p class="type-small"><strong>$450 p/a</strong></p>
      </div>
      <div class="membership__footer inner-pad">
        <p class="type-small"><strong>$450 p/a</strong></p>
      </div>
    </div>
  </section> -->

  <?php if ( !(wp_get_current_user()->exists()) ) : ?>
    <div class="landing-banner border-top--blue">
      <div class="landing-banner__left bg-white">
        <p class="type-small">To discuss membership, get in contact with us at <a href="mailto:contacts@smbc.com.au">contacts@smbc.com.au</a></p>
      </div>
      <div class="landing-banner__right bg-lightblue flex-center">
        <p class="type-white type-small"><a class="link-arrow-right link-arrow-right--white" href="<?= get_permalink( get_page_by_title('Membership Checkout') ) ?>">Sign up now</a></p>
      </div>
    </div>
  <?php endif ?>
</main>

<?php get_footer(); ?>