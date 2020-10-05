<!-- Built by Michael Precel (michaelprecel.com) -->

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->

  <!-- Initials -->
  <meta charset="UTF-8">
  <meta name="google" content="notranslate">
  <meta http-equiv="Content-Language" content="en">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <!-- Metadata -->
  <title></title>
  <meta property="og:title"              content="" />
  <meta property="og:url"                content="" />

  <meta name="description"             content="" />
  <meta property="og:description"      content="" />
  <meta property="og:image"              content="" />
  <meta property="og:site_name" content="">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Favicon -->

  <!-- Load CSS w Query Selectors -->
  <?php wp_head() ?>

</head>
<body>

  <?php $user = wp_get_current_user() ?>

  <noscript>
    <h1>We're sorry, this site works best with Javascript enabled, so please turn it on if you can.</h1>
  </noscript>

  <header class="fixed-header-desk">
    <div class="logo-holder">
      <a href="<?= get_home_url() ?>">
        <?php get_template_part('includes/svg', 'logo-stacked') ?>
      </a>
    </div>
    <ul class="nav-items type-small">
      <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('about') ) ?>">About</a></li>
      <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('Events') ) ?>">Events</a></li>
      <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('News') ) ?>">News</a></li>
      <?php if ( $user->exists() ) : ?>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Directory') ) ?>">Directory</a></li>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Profile') ) ?>">Profile</a></li>
      <?php else: ?>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Membership Checkout') ) ?>">Join</a></li>
      <?php endif ?>
      <li class="nav-item">
        <button class="type-small login__open type-lightblue">
          <?php 
            if ( $user->exists() ) :
              echo 'Logout';
            else:
              echo 'Login';
            endif;
          ?>
        </button>
      </li>
    </ul>
  </header>

<header class="mobile-nav">
    <div class="logo-holder">
      <a href="<?= get_home_url() ?>">
        <?php get_template_part('includes/svg', 'logo-stacked') ?>
      </a>
    </div>

       <div class="hamburger flex-center">
         <div class="line1"></div>
         <div class="line2"></div>
         <div class="line3"></div>
       </div>
       <div class="cross flex-center">
         <div class="rotateL"></div>
         <div class="rotateR"></div>
       </div>

  <div class="mobile-container">
   <div class="mobile-nav-hover">
    <ul class="nav-items type-med inner-pad--s">
    <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('about') ) ?>">About</a></li>
      <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('Events') ) ?>">Events</a></li>
      <li class="nav-item"><a href="<?= get_permalink( get_page_by_title('News') ) ?>">News</a></li>
      <?php if ( $user->exists() ) : ?>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Directory') ) ?>">Directory</a></li>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Profile') ) ?>">Profile</a></li>
      <?php else: ?>
        <li class="nav-item type-lightblue"><a href="<?= get_permalink( get_page_by_title('Membership Checkout') ) ?>">Join</a></li>
      <?php endif ?>
      <li class="nav-item">
        <button class="type-med login__open type-lightblue">
          <?php 
            if ( $user->exists() ) :
              echo 'Logout';
            else:
              echo 'Login';
            endif;
          ?>
        </button>
      </li>
    </ul>
   </div>
  </div>
</header>

  <?php get_template_part('includes/snippet', 'login') ?>