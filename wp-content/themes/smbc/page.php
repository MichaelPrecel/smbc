<?php get_header() ?>
  <main class="main-default">
    <section class="landing">
      <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
  
        <?php the_content(); ?>
  
      <?php endwhile; else: endif; ?>
    </section>
  </main>
<?php get_footer() ?>