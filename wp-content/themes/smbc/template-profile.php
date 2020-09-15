<?php 
  /* 
  Template Name: Membership Profile
  */
?>

<?php get_header() ?>
  <main class="main-default">
    <div class="landing membership-default">
      <section class="row-right">
        <div class="col-left bg-lightblue inner-pad">
          <h1 class="type-large type-white"><?= get_the_title() ?></h1>
        </div>
        <div class="col-right bg-white inner-pad">
          <div class="col-right__inner text-block--max-width text-block--standard">
            <div class="type-small">
              <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>              
                <?php the_content(); ?>
              <?php endwhile; else: endif; ?>
            </div>

            <!-- Community Offers on Page -->
            <?php get_template_part('includes/snippet', 'offers-individual') ?>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php get_footer() ?>