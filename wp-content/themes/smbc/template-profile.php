<?php 
  /* 
  Template Name: Membership Profile
  */
?>

<?php get_header() ?>
  <main class="main-default profile">
    <div class="landing membership-default">
      <section class="row-right">
        <div class="col-left inner-pad profile__left-col">
          <a class="profile__return type-small link--remove-hover" href="<?= get_permalink( get_page_by_title('directory') ) ?>">Return to Directory</a>
        </div>
        <div class="col-right bg-white inner-pad profile__main">
          <div class="profile__header">
            <h1 class="type-small type-strong type-white"><?= get_the_title() ?></h1>
          </div>
          <div class="col-right__inner text-block--standard">
            <div class="profile__main-inner text-block--max-width">
              <div class="type-tiny border-top--blue profile__text">
                <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>              
                  <?php the_content(); ?>
                <?php endwhile; else: endif; ?>
              </div>

              <!-- Community Offers on Page -->
              <?php get_template_part('includes/snippet', 'offers-individual') ?>
            </div>

          </div>
        </div>
      </section>
    </div>
  </main>
<?php get_footer() ?>