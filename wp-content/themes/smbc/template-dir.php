<?php 
/* 
Template Name: Directory Integrated
*/
?>

<?php get_header(); ?>



<main class="directory" id="main">
  <section class="header bg-blue inner-pad">
    <h1 class="type-large type-white">Members Directory</h1>
    <div>
      <img src="<?= get_template_directory_uri() .'/assets/images/svg/logo-ball--white.svg' ?>" alt="">
    </div>
  </section>  
  
  <div class="body bg-white">
    <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; else: endif; ?>
    
    <!-- Add in Sidebar -->
    <?php get_template_part('includes/snippet', 'offers-global') ?>
  </div>

</main>

<?php get_footer(); ?>