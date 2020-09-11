<aside class="login-outer bg-lightblue inner-pad">
  <div class="login__header">
    <button class="type-tiny type-white login__close">Close</button>
  </div>
  <div class="login__body">
    <?php 
      $user = wp_get_current_user();
      if ( $user->exists() ) :
        echo '';
      else :
        echo '<p class="type-small type-white margin-btm--m">Sign in to our members directory to connect with other business members, access your profile, view community offers and access restricted content.</p>';
      endif;
    ?>

    <div class="login__form">
      <?= pmpro_shortcode_login(''); ?>
    </div>
  </div>
  <div class="login__footer text-block--border-top border--white">
    <p class="type-tiny type-white">Having trouble logging in? Get in contact with us at <a href="mailto:contacts@smbc.com.au">contacts@smbc.com.au</a></p>
  </div>
</aside>