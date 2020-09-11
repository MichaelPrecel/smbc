<?php 
/* 
Template Name: Directory
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
    <section class="sidebar inner-pad">
      <div class="sidebar__intro margin-btm--s">
        <h2 class="type-small type-strong margin-btm--s">Search & Connect</h2>
        <p class="type-tiny">Looking for someone you met at one of our events, or need to connect with a new supplier? Find them using the search box below by searching by name, business or even title.</p>
      </div>

      <div class="sidebar__search-outer margin-btm--l">
        <form action="" class="sidebar__search">
          <div class="search-input__outer">
            <input class="search-input" type="text" name="name" placeholder="Name">
          </div>
          <div class="search-input__outer">
            <input class="search-input" type="text" name="name" placeholder="Job Title">
          </div>
          <div class="search-input__outer">
            <input class="search-input" type="text" name="name" placeholder="Company">
          </div>
          <div class="search-input__outer">
            <input class="search-input" type="text" name="name" placeholder="Industry">
          </div>
          
          <div class="directory-search__submit">
            <input class="search-submit" type="submit" value="Search">
          </div>
        </form>
      </div>

      <div class="sidebar__summary text-block--border-top margin-btm--l">
        <h2 class="type-small type-strong margin-btm--s">Profile Summary</h2>
        <ul class="type-tiny margin-btm--s">
          <li>Membership Level:<br><span class="type-lightblue">Premium Member</span></li>
          <li>Connections Remaining: <span class="type-lightblue">3</span></li>
          <li>Current Community Offers: <span class="type-lightblue">1</span></li>
        </ul>
        <a class="link-button type-tiny" href="">Community Offers</a>
      </div>

      <div class="sidebar__notices type-tiny">
        <p>Click <strong>‘Request to Connect’</strong> to have our <em>Business Releationships Manager</em> put you in touch with the SMBC member.</p>
        <p>For enquiries or connections, please get in contact with <a href="mailto:contact@smbc.com.au">contacts@smbc.com.au</a></p>
        <p>We are always looking to make your community even better, please send us feedback or feature requests using the button below.</p>
        <a class="link-button margin-top--s" href="">Send Feedback</a>
      </div>
    </section>
    
    <section class="main">
      <div class="stats type-tiny">
        <div class="inner-pad--s">
          <p><strong>All Members</strong>: 120</p>
        </div>
        <div class="inner-pad--s ">
          <div class="sort-by-box">
            <h4 class="type-tiny type-strong">Sort By:</h4>
            <select class="matter--body margin-bottom--remove" name="products-sort" id="products-sort">
              <option value="alph-reg">A—Z</option>
              <option value="alph-rev">Z—A</option>
              <option value="price-low">Registration (asc)</option>
              <option value="price-low">Registration (desc)</option>
            </select>
          </div>
        </div>
        <a class="inner-pad--s" href="#"><span class="link-arrow link-arrow-right--blue">See Community Offers</span></a>
      </div>

      <div class="members inner-pad">
        <div class="members-grid">
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
          <?php get_template_part('includes/snippet', 'member') ?>
        </div>
      </div>
    </section>
  </div>

</main>

<?php get_footer(); ?>