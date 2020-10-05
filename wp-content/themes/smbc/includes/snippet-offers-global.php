<aside class="community-outer bg-lightblue inner-pad type-small">
  <div class="login__header">
    <button class="type-tiny type-white community-offer__open co__close">Close</button>
  </div>
  <div class="co__header">
    <p class="type-tiny type-white">A bit about community offers bibendum pellentesque urna, vel. Nec lobortis eget id diam nisi, id amet. Felis eu libero luctus.</p>
  </div>

  <div class="co__body">
    <?php $com_offers = dctit_list_offer(); ?> 
    <?php foreach($com_offers as $com_offer){ ?>
      <!-- Start integrating PHP loop here to display all Community Offers -->
      <div class="co-block type-white">
        <div class="co-block__text">
          <h1 class="type-small type-strong margin-btm--s"><?php echo $com_offer['offer_title']; ?></h1>
          <p class="type-tiny"><?php echo $com_offer['offer_details']; ?></p>
        </div>
        <a class="co__view type-tiny" href="<?php echo $com_offer['offer_author_profile']; ?>#ind-co">View Offer</a>

        <div class="co-block__offerer type-tiny">
          <div>
            <p>Offered by:</p>
          </div>
          <div class="co-block__profile">
            <div class="co-block__pic">
              <?php echo get_wp_user_avatar(get_the_author_meta('ID'), 96); ?>
            </div>
            <div class="co-block__profile-text">
              <p><?php echo $com_offer['offer_author_name']; ?></p>
              <p><em><?php echo $com_offer['offer_author_position']; ?></em></p>
              <p><?php echo $com_offer['offer_author_company']; ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    

  </div>
  <!-- <div class="login__footer text-block--border-top border--white">
    <p class="type-tiny type-white">Having trouble logging in? Get in contact with us at <a href="mailto:contacts@smbc.com.au">contacts@smbc.com.au</a></p>
  </div> -->
</aside>