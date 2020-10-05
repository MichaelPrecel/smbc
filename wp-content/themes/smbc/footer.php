<footer class="bg-blue type-white">
  <div class="footer-grid inner-pad">
    <div class="grid-item">
      <div class="logo-holder">
        <?php get_template_part('includes/svg', 'logo-stacked--white') ?>
      </div>
    </div>

    <div class="grid-item">
      <h1 class="type-tiny margin-btm--s type-strong">Quick Links</h1>
      <ul class="type-tiny"> 
        <li><a href="<?= get_permalink( get_page_by_title('about') ) ?>">About</a></li>
        <li><a href="<?= get_permalink( get_page_by_title('Events') ) ?>">Events</a></li>
        <li><a href="<?= get_permalink( get_page_by_title('News') ) ?>">News</a></li>
        <?php $user = wp_get_current_user() ?>
        <?php if ( $user->exists() ) : ?>
          <li class="type-lightblue"><a href="<?= get_permalink( get_page_by_title('Directory') ) ?>">Directory</a></li>
          <li class="type-lightblue"><a href="<?= get_permalink( get_page_by_title('Profile') ) ?>">Profile</a></li>
        <?php else: ?>
          <li class="type-lightblue"><a href="<?= get_permalink( get_page_by_title('Membership Checkout') ) ?>">Join</a></li>
        <?php endif ?>
        <li>
          <button class="type-tiny login__open type-lightblue">
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

    <div class="grid-item">
      <h1 class="type-tiny margin-btm--s type-strong">Contact Us</h1>
      <ul class="type-tiny"> 
        <li>Email <a href="mailto:admin@smfc.com.au">admin@smfc.com.au</a></li>
        <li>Phone <a href="tel:+61396459797">(+613) 9645 9797</a></li>
        <li>Fax (+613) 9645 9796</li>
      </ul>
    </div>

    <div class="grid-item">
      <h1 class="type-tiny type-strong">Proud part of the</h1>
      <p class="type-tiny margin-btm--s"><a href="https://www.smfc.com.au/">South Melbourne<br> Football Club</a></p>
      <p class="type-tiny"><a href="https://goo.gl/maps/ycXLNnenAtG3S8eK6" target="_blank">
      Lakeside Stadium<br>PO Box 1349<br>South Melbourne<br>Victoria, Australia 3205</a></p>

      <a href="#main" class="top-r footer-top type-tiny type-white ">Top</a>

    </div>

  </div>  

  <div class="footer-base inner-pad">
    <div class="top-non-r">
    <a href="#main" class=" footer-top type-tiny type-white">Top</a>
    </div>
    <p class="type-tiny">© <?php echo date("Y") ?> South Melbourne Business Community. 
    All rights reserved.</p>
  </div>
</footer>

<?php wp_footer() ?>
</body>
</html>
