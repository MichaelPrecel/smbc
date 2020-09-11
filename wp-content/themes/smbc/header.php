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

  <noscript>
    <h1>We're sorry, this site works best with Javascript enabled, so please turn it on if you can.</h1>
  </noscript>

  <header>
    <div class="logo-holder">
      <a href="<?= get_home_url() ?>">
        <?php get_template_part('includes/svg', 'logo-stacked') ?>
      </a>
    </div>
    <ul class="nav-items type-small">
      <li class="nav-item"><a href="<?php echo get_permalink( get_page_by_title('about') ) ?>">About</a></li>
      <li class="nav-item"><a href="<?php echo get_permalink( get_page_by_title('Events') ) ?>">Events</a></li>
      <li class="nav-item"><a href="#">News</a></li>
      <li class="nav-item"><a href="#">Join</a></li>
      <li class="nav-item"><button class="type-small login__open">Login</button></li>
    </ul>
  </header>

  <aside class="login-outer bg-lightblue inner-pad">
    <div class="login__header">
      <button class="type-tiny type-white login__close">Close</button>
    </div>
    <div class="login__body">
      <p class="type-small type-white margin-btm--m">Sign in to our members directory to connect with other business members, access your profile and view community offers.</p>

      <form action="" class="login__form">
        <input type="email" name="email" placeholder="Email Address"></input>
        <input type="email" name="text" placeholder="Password"></input>
        <input type="submit" value="Login">
      </form>
    </div>
    <div class="login__footer text-block--border-top border--white">
      <p class="type-tiny type-white">Having trouble logging in? Get in contact with us at <a href="mailto:contacts@smbc.com.au">contacts@smbc.com.au</a></p>
    </div>
  </aside>