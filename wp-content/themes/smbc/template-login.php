<?php 
  /* 
  Template Name: Membership Login
  */
?>

<?php get_header() ?>
  <main class="main-default">
    <div class="landing membership-default">
      <section class="row-right">
        <div class="col-left bg-blue inner-pad">
          <h1 class="type-large type-white"><?= get_the_title() ?></h1>
        </div>
        <div class="col-right bg-lightblue inner-pad">
          <div class="col-right__inner text-block--max-width text-block--standard">
            <div class="type-small">
              <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>              
                <?php the_content(); ?>
              <?php endwhile; else: endif; ?>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php get_footer() ?>