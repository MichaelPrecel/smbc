<?php
/*
	This shortcode will display the members list and additional content based on the defined attributes.
*/
function pmpromd_shortcode($atts, $content=null, $code="")
{
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [pmpro_member_directory show_avatar="false" show_email="false" levels="1,2"]

	extract(shortcode_atts(array(
		'avatar_size' => '128',
		'fields' => NULL,
		'layout' => 'div',
		'level' => NULL,
		'levels' => NULL,
		'limit' => NULL,
		'link' => true,
		'order_by' => 'u.display_name',
		'order' => 'ASC',
		'show_avatar' => true,
		'show_email' => true,
		'show_level' => true,
		'show_search' => true,
		'show_startdate' => true,
		'avatar_align' => NULL
	), $atts, "pmpro_member_directory"));

	global $wpdb, $post, $pmpro_pages, $pmprorh_registration_fields;

	//some page vars
	if(!empty($pmpro_pages['directory'])) {
		$directory_url = get_permalink($pmpro_pages['directory']);
	}

	if(!empty($pmpro_pages['profile'])) {
		$profile_url = apply_filters( 'pmpromd_profile_url', get_permalink( $pmpro_pages['profile'] ) );
	}

	//turn 0's into falses
	if($link === "0" || $link === "false" || $link === "no" || $link === false)
		$link = false;
	else
		$link = true;

	//did they use level instead of levels?
	if(empty($levels) && !empty($level))
		$levels = $level;

	// convert array to string for levels when using the block editor.
	if ( is_array( $levels ) ) {
		$levels = implode( ',', $levels );
	}

	if($show_avatar === "0" || $show_avatar === "false" || $show_avatar === "no"  || $show_avatar === false)
		$show_avatar = false;
	else
		$show_avatar = true;

	if($show_email === "0" || $show_email === "false" || $show_email === "no" || $show_email === false )
		$show_email = false;
	else
		$show_email = true;

	if($show_level === "0" || $show_level === "false" || $show_level === "no" || $show_level === false)
		$show_level = false;
	else
		$show_level = true;

	if($show_search === "0" || $show_search === "false" || $show_search === "no" || $show_search === false )
		$show_search = false;
	else
		$show_search = true;

	if($show_startdate === "0" || $show_startdate === "false" || $show_startdate === "no" || $show_startdate === false )
		$show_startdate = false;
	else
		$show_startdate = true;

	if(isset($_REQUEST['ps']))
		$s = $_REQUEST['ps'];
	else
		$s = "";

	if(isset($_REQUEST['pn']))
		$pn = intval($_REQUEST['pn']);
	else
		$pn = 1;

	if(isset($_REQUEST['limit']))
		$limit = intval($_REQUEST['limit']);
	elseif(empty($limit))
		$limit = 15;

	$end = $pn * $limit;
	$start = $end - $limit;

// Build SQL into parts to make it easier to add in specific sections to the SQL.
$sql_parts = array();

$sql_parts['SELECT'] = "SELECT SQL_CALC_FOUND_ROWS u.ID, u.user_login, u.user_email, u.user_nicename, u.display_name, UNIX_TIMESTAMP(u.user_registered) as joindate, mu.membership_id, mu.initial_payment, mu.billing_amount, mu.cycle_period, mu.cycle_number, mu.billing_limit, mu.trial_amount, mu.trial_limit, UNIX_TIMESTAMP(mu.startdate) as startdate, UNIX_TIMESTAMP(mu.enddate) as enddate, m.name as membership, umf.meta_value as first_name, uml.meta_value as last_name FROM $wpdb->users u ";

$sql_parts['JOIN'] = "LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id LEFT JOIN $wpdb->usermeta um ON u.ID = um.user_id LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id ";

$sql_parts['WHERE'] = "WHERE mu.status = 'active' AND (umh.meta_value IS NULL OR umh.meta_value <> '1') AND mu.membership_id > 0 ";

$sql_parts['GROUP'] = "GROUP BY u.ID ";

$sql_parts['ORDER'] = "ORDER BY ". esc_sql($order_by) . " " . $order . " ";

$sql_parts['LIMIT'] = "LIMIT $start, $limit";

if( $s ) {
	$sql_parts['WHERE'] .= "AND (u.user_login LIKE '%" . esc_sql($s) . "%' OR u.user_email LIKE '%" . esc_sql($s) . "%' OR u.display_name LIKE '%" . esc_sql($s) . "%' OR um.meta_value LIKE '%" . esc_sql($s) . "%') ";
}

// If levels are passed in.
if ( $levels ) {
	$sql_parts['WHERE'] .= "AND mu.membership_id IN(" . esc_sql($levels) . ") ";
}

// Allow filters for SQL parts.
$sql_parts = apply_filters( 'pmpro_member_directory_sql_parts', $sql_parts, $levels, $s, $pn, $limit, $start, $end, $order_by, $order );

$sqlQuery = $sql_parts['SELECT'] . $sql_parts['JOIN'] . $sql_parts['WHERE'] . $sql_parts['GROUP'] . $sql_parts['ORDER'] . $sql_parts['LIMIT'];


	$sqlQuery = apply_filters("pmpro_member_directory_sql", $sqlQuery, $levels, $s, $pn, $limit, $start, $end, $order_by, $order);

	$theusers = $wpdb->get_results($sqlQuery);
	$totalrows = $wpdb->get_var("SELECT FOUND_ROWS() as found_rows");

	//update end to match totalrows if total rows is small
	if($totalrows < $end)
		$end = $totalrows;

	$theusers = apply_filters( 'pmpromd_user_directory_results', $theusers );

	ob_start();

  ?>
  
  <!-- Start template -->
  <section class="sidebar inner-pad">
      <div class="sidebar__intro margin-btm--s">
        <div class="login__header">
          <button class="type-tiny sidebar__close">Close</button>
        </div>
        <h2 class="type-small type-strong margin-btm--s">Search & Connect</h2>
        <p class="type-tiny">Looking for someone you met at one of our events, or need to connect with a new partner? Find them using the search box below by searching by name, business or even title.</p>
      </div>

      <div class="sidebar__search-outer margin-btm--l">
        <?php if(!empty($show_search)) { ?>
          <form role="search" method="post" class="pmpro_member_directory_search search-form sideabar__search">
            <label class="search-input__outer">
              <!-- <span class="screen-reader-text"><?php _e('Search for:','pmpromd'); ?></span> -->
              <input type="search" class="search-field search-input" placeholder="<?php _e('Search Members','pmpromd'); ?>" name="ps" value="<?php if(!empty($_REQUEST['ps'])) echo stripslashes( esc_attr($_REQUEST['ps']) );?>" title="<?php _e('Search Members','pmpromd'); ?>" />
              <input type="hidden" name="limit" value="<?php echo esc_attr($limit);?>" />
            </label>
            <div class="directory-search__submit">
              <input type="submit" class="search-submit" value="<?php _e('Search Members','pmpromd'); ?>">
            </div>
          </form>
        <?php } ?>
        <!-- <form action="" class="sidebar__search">
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
        </form> -->
      </div>

      <div class="sidebar__summary text-block--border-top margin-btm--l">
        <h2 class="type-small type-strong margin-btm--s">Profile Summary</h2>
        <ul class="type-tiny margin-btm--s">
          <?php
            $cur_u_i = get_current_user_id();
            $my_offers = dctit_list_offer($cur_u_i);
          ?>
          <li>Membership Level:<br><span class="type-lightblue">Premium Member</span></li>
          <li>Connections Remaining: <span class="type-lightblue"><?= get_user_meta($cur_u_i, 'user_cp_dct' , true); ?></span></li>
          <li>Current Community Offers: <span class="type-lightblue"><?= count( $my_offers ) ?></span></li>
        </ul>
        <a class="link-button type-tiny" href="<?= get_permalink( get_page_by_title('profile') ) ?>#ind-co">Community Offers</a>
      </div>

      <div class="sidebar__notices type-tiny">
        <p>Click <strong>‘Request to Connect’</strong> to have our <em>Business Releationships Manager</em> put you in touch with the SMBC member.</p>
        <p>For enquiries or connections, please get in contact with <a href="mailto:admin@smbc.com.au">admin@smbc.com.au</a></p>
        <p>We are always looking to make your community even better, please send us feedback or feature requests using the button below.</p>
        <a class="link-button margin-top--s" href="mailto:admin@smbc.com.au">Send Feedback</a>
      </div>
    </section>
    
    <!-- Main section -->
    <section class="main main-directory">
      <div class="stats type-tiny">
        <button class="type-tiny inner-pad--s sidebar__open"><span>Search & Summary</span></button>
        <div class="inner-pad--s">
          <h3 id="pmpro_member_directory_subheading">
            <?php if(!empty($s)) { ?>
              <?php printf(__('Profiles Within <em>%s</em>.','pmpromd'), stripslashes( ucwords(esc_html($s)))); ?>
            <?php } else { ?>
              <?php _e('<strong>Viewing All Profiles</strong><br>','pmpromd'); ?>
            <?php } ?>
            <?php if($totalrows > 0) { ?>
              <small class="muted">
                (<?php
                if($totalrows == 1)
                  printf(__('Showing 1 Result','pmpromd'), $start + 1, $end, $totalrows);
                else
                  printf(__('Showing %s-%s of %s Results','pmpromd'), $start + 1, $end, $totalrows);
                ?>)
              </small>
            <?php } ?>
          </h3>
        </div>
        <!-- <div class="inner-pad--s ">
          <div class="sort-by-box">
            <h4 class="type-tiny type-strong">Sort By:</h4>
            <select class="matter--body margin-bottom--remove" name="products-sort" id="products-sort">
              <option value="alph-reg">A—Z</option>
              <option value="alph-rev">Z—A</option>
              <option value="price-low">Registration (asc)</option>
              <option value="price-low">Registration (desc)</option>
            </select>
          </div>
        </div> -->
        <button class="type-tiny inner-pad--s community-offer__open" href="#"><span class="link-arrow link-arrow-right--blue">See Community Offers</span></button>
      </div>

      <div class="members inner-pad">
        <div class="members-grid-outer">
          <?php // get_template_part('includes/snippet', 'member') ?>
          
          <!-- Start User Loop -->
            <?php
              if(!empty($theusers))
              {

                if(!empty($fields))
                {
                  // Check to see if the Block Editor is used or the shortcode.
                  if ( strpos( $fields, "\n" ) !== FALSE ) {
                    $fields = rtrim( $fields, "\n" ); // clear up a stray \n
                    $fields_array = explode("\n", $fields); // For new block editor.
                  } else {
                    $fields = rtrim( $fields, ';' ); // clear up a stray ;
                    $fields_array = explode(";",$fields);
                  }

                  if(!empty($fields_array))
                  {
                    for($i = 0; $i < count($fields_array); $i++ )
                      $fields_array[$i] = explode(",", trim($fields_array[$i]));
                  }
                }
                else
                  $fields_array = false;

                // Get Register Helper field options
                $rh_fields = array();
                if(!empty($pmprorh_registration_fields)) {
                  foreach($pmprorh_registration_fields as $location) {
                    foreach($location as $field) {
                      if(!empty($field->options))
                        $rh_fields[$field->name] = $field->options;
                    }
                  }
                }
                ?>
                <div class="members-grid pmpro_member_directory<?php
                  if ( ! empty( $layout ) ) {
                    echo ' pmpro_member_directory-' . $layout;
                  }
                ?>">
                  <?php 
                  $shortcode_atts = array(
                    'avatar_size' => $avatar_size,
                    'fields' => $fields,
                    'layout' => $layout,
                    'level' => $level,
                    'levels' => $levels,
                    'limit' => $limit,
                    'link' => $link,
                    'order_by' => $order_by,
                    'order' => $order,
                    'show_avatar' => $show_avatar,
                    'show_email' => $show_email,
                    'show_level' => $show_level,
                    'show_search' => $show_search,
                    'show_startdate' => $show_startdate,
                    'avatar_align' => $avatar_align,				
                    'fields_array' => $fields_array
                  );

                  do_action( 'pmpro_member_directory_before', $sqlQuery, $shortcode_atts ); ?>
                  <?php
                  if($layout == "table")
                  {
                    ?><?php
                  }
                  else
                  {
                    foreach($theusers as $auser):
                      $auser = get_userdata($auser->ID);
                      $auser->membership_level = pmpro_getMembershipLevelForUser($auser->ID);
                      ?>
                      <div id="pmpro_member-<?php echo $auser->ID; ?>" class="pmpro_member_directory-item member">
                        <?php if(!empty($show_avatar)) { ?>
                          <div class="pmpro_member_directory_avatar member__picture-outer">
                            <?php if(!empty($link) && !empty($profile_url)) { ?>
                              <a class="<?php echo $avatar_align; ?> member__picture ratio-box ratio--1-1" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>">
                                <?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?>
                              </a>
                            <?php } else { ?>
                              <span class="<?php echo $avatar_align; ?>"><?php echo get_avatar($auser->ID, $avatar_size, NULL, $auser->display_name); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                        <div class="member__details">
                          <h3 class="pmpro_member_directory_display-name type-small type-strong">
                            <?php if(!empty($link) && !empty($profile_url)) { ?>
                              <a href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php echo esc_html( pmpro_member_directory_get_member_display_name( $auser ) ); ?></a>
                            <?php } else { ?>
                              <?php echo esc_html( pmpro_member_directory_get_member_display_name( $auser ) ); ?></a>
                            <?php } ?>
                          </h3>
                          
                          <?php if(!empty($show_email)) { ?>
                            <p class="pmpro_member_directory_email">
                              <strong><?php _e('Email Address', 'pmpromd'); ?></strong>
                              <?php echo $auser->user_email; ?>
                            </p>
                          <?php } ?>
                          <?php if(!empty($show_level)) { ?>
                            <p class="pmpro_member_directory_level">
                              <strong><?php _e('Level', 'pmpromd'); ?></strong>
                              <?php
                                $alluserlevels = pmpro_getMembershipLevelsForUser( $auser->ID );
                                $membership_levels = array();
                                if ( ! isset( $levels ) ) {
                                  // Show all the user's levels.
                                  foreach ( $alluserlevels as $curlevel ) {
                                    $membership_levels[] = $curlevel->name;
                                  }
                                } else {
                                  $levels_array = explode(',', $levels);
                                  // Show only the levels included in the directory.
                                  foreach ( $alluserlevels as $curlevel ) {
                                    if ( in_array( $curlevel->id, $levels_array) ) {
                                      $membership_levels[] = $curlevel->name;
                                    }
                                  }
                                }
                                $auser->membership_levels = implode( ', ', $membership_levels );
                                echo ! empty( $auser->membership_levels ) ? $auser->membership_levels : '';
                              ?>
                            </p>
                          <?php } ?>
                          <?php if(!empty($show_startdate)) { ?>
                            <p class="pmpro_member_directory_date">
                              <strong><?php _e('Start Date', 'pmpromd'); ?></strong>
                              <?php echo date(get_option("date_format"), $auser->membership_level->startdate); ?>
                            </p>
                          <?php } ?>
                          <?php
                          if(!empty($fields_array))
                          {
                            foreach($fields_array as $field)
                            {
                              if ( WP_DEBUG ) {
                                error_log("Content of field data: " . print_r( $field, true));
                              }

                              // Fix for a trailing space in the 'fields' shortcode attribute.
                              if ( $field[0] === '' ) {
                                break;
                              }

                              $meta_field = $auser->{$field[1]};
                              if(!empty($meta_field))
                              {
                                ?>
                                <p class="pmpro_member_directory_<?php echo $field[1]; ?>">
                                  <?php
                                  if(is_array($meta_field) && !empty($meta_field['filename']) )
                                  {
                                    //this is a file field
                                    ?>
                                    <strong><?php echo $field[0]; ?></strong>
                                    <?php echo pmpromd_display_file_field($meta_field); ?>
                                    <?php
                                  }
                                  elseif(is_array($meta_field))
                                  {
                                    //this is a general array, check for Register Helper options first
                                    if(!empty($rh_fields[$field[1]])) {
                                      foreach($meta_field as $key => $value)
                                        $meta_field[$key] = $rh_fields[$field[1]][$value];
                                    }
                                    ?>
                                    <strong><?php echo $field[0]; ?></strong>
                                    <?php echo implode(", ",$meta_field); ?>
                                    <?php
                                  }elseif( !empty($rh_fields[$field[1]]) && is_array($rh_fields[$field[1]]) ) {
                                ?>
                                  <strong><?php echo $field[0]; ?></strong>
                                  <?php echo $rh_fields[$field[1]][$meta_field]; ?>
                                  <?php
                                }
                                  elseif($field[1] == 'user_url')
                                  {
                                    ?>
                                    <a href="<?php echo $auser->{$field[1]}; ?>" target="_blank"><?php echo $field[0]; ?></a>
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <strong><?php echo $field[0]; ?></strong>
                                    <?php echo make_clickable($auser->{$field[1]}); ?>
                                    <?php
                                  }
                                  
                                  ?>
                                  
                                </p>
                                <?php
                              }
                            }
                          }
                          ?>
                          <?php if(!empty($link) && !empty($profile_url)) { ?>
                            <p class="pmpro_member_directory_link">
                              <a class="more-link" href="<?php echo add_query_arg('pu', $auser->user_nicename, $profile_url); ?>"><?php _e('View Profile','pmpromd'); ?></a>
                            </p>
                          <?php } ?>
                        </div>
                        <button class="member__footer bg-lightblue type-tiny type-white connection-request connection-request-toggle">Request to Connect</button>

                        <!-- Connect Box -->
                        <div class="connect-box">
                          <div class="inner-pad--s">
                            <p class="type-small margin-btm--s">Request to connect</p>
                            <div class="connect-box__form-outer">
                              <form class="connect-box__form" action="">
                                <input type="hidden" name="post_type" value="directory">
                                <input type="hidden" name="sender_id" value="<?php echo get_current_user_id(); ?>">
                                <input type="hidden" name="recipient_id" value="<?php echo $auser->ID; ?>">
                                <input type="text" name="reason_for_connection" placeholder="Reason for connection..." required>
                                <input class="margin-btm--s" type="text" name="message" placeholder="Message" required>
                                <?php if ( get_user_meta($cur_u_i, 'user_cp_dct' , true) == 0 ) : ?>
                                  <p class="pmpro_btn type-tiny margin-top--s" style="white-space:normal; margin-top: var(--s)">No connection points remaining</p>
                                <?php else: ?>
                                  <input type="submit" value="Send Request">
                                <?php endif ?>
                              </form>
                            </div>
                          </div>
                          <button class="member__footer bg-lightblue type-tiny type-white connection-request connection-request-toggle">Close</button>
                        </div>
                      </div> <!-- end pmpro_member_directory-item -->
                    <?php
                  endforeach;
                ?>
                </div> <!-- end pmpro_member_directory -->
                <?php

                do_action( 'pmpro_member_directory_after', $sqlQuery, $shortcode_atts );
                
                }
              }
              else
              {
                ?>
                <p class="pmpro_member_directory_message pmpro_message pmpro_error">
                  <?php _e('No matching profiles found','pmpromd'); ?>
                  <?php
                  if($s)
                  {
                    printf(__('within <em>%s</em>.','pmpromd'), stripslashes( ucwords(esc_html($s))) );
                    if(!empty($directory_url))
                    {
                      ?>
                      <a class="more-link" href="<?php echo $directory_url; ?>"><?php _e('View All Members','pmpromd'); ?></a>
                      <?php
                    }
                  }
                  else
                  {
                    echo ".";
                  }
                  ?>
                </p>
                <?php
              }

              //prev/next
            ?>
          <!-- End User Loop -->
          
        </div>
      </div>
    </section>
  
	<div class="pmpro_pagination">
		<?php
		//prev
		if ( $pn > 1 ) {
			$query_args = array(
				'ps' => $s,
				'pn' => $pn-1,
				'limit' => $limit,
			);
			$query_args = apply_filters( 'pmpromd_pagination_url', $query_args, 'prev' );
			?>
			<span class="pmpro_prev"><a href="<?php echo esc_url(add_query_arg( $query_args, get_permalink($post->ID)));?>">&laquo; <?php _e('Previous','pmpromd'); ?></a></span>
			<?php
		}
		//next
		if ( $totalrows > $end ) {
			$query_args = array(
				'ps' => $s,
				'pn' => $pn+1,
				'limit' => $limit,
			);
			$query_args = apply_filters( 'pmpromd_pagination_url', $query_args, 'next' );
			?>
			<span class="pmpro_next"><a href="<?php echo esc_url( add_query_arg( $query_args, get_permalink( $post->ID ) ) );?>"><?php _e( 'Next', 'pmpromd' ); ?> &raquo;</a></span>
			<?php
		}
		?>
  </div>

  <script>
    (function() {
      jQuery('.connect-box__form').each(function(i, form) {
        jQuery(form).on('submit', function(e) {
          e.preventDefault();
          let form = jQuery(e.currentTarget);
          console.log(form)

          var __messageFormData = {};

          jQuery.each(form.serializeArray(), function(i, field) {
            __messageFormData[field.name] = field.value;
          });
          console.log(__messageFormData);
          ajaxLoading();
          jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: myAjax.ajaxurl,
            data: {
              action: 'send_request',
              ...__messageFormData
            },
            success: function(response) {
              if (response.type === 'success') {
                ajaxSuccess();
                setTimeout(function() {
                  console.log('succeed')
                  location.reload();
                }, 1000);
              } else {
                console.log('Request Not Succeed')
              }
            }
          });
        });
      });
    }());
    // Loading animation when a request send
    function ajaxLoading() {
      var loadingOverlay = document.createElement('div');
      loadingOverlay.setAttribute('class', 'loading-overlay');

      let loadDiv = document.createElement('div');
      loadDiv.setAttribute('class', 'spinner')

      for (let i = 0; i < 8; i++) {
        let spinElm = document.createElement('div')
        loadDiv.append(spinElm);
      }

      jQuery(loadingOverlay).append(loadDiv);
      jQuery('.body.bg-white').append(loadingOverlay);
      jQuery('.loading-overlay').addClass('load');
    }

    // Success animation when a request succeed
    function ajaxSuccess() {
      jQuery('.spinner').remove();

      let success = document.createElement('div');
      success.setAttribute('class', 'success');

      let inner = document.createElement('div');
      inner.setAttribute('class', 'dct-icon dct-success animate');

      let content_1 = document.createElement('span');
      content_1.setAttribute('class', 'dct-line dct-tip animateSuccessTip');

      let content_2 = document.createElement('span');
      content_2.setAttribute('class', 'dct-line dct-long animateSuccessLong');

      let content_3 = document.createElement('div');
      content_3.setAttribute('class', 'dct-placeholder');

      let content_4 = document.createElement('div');
      content_4.setAttribute('class', 'dct-fix');

      inner.append(content_1);
      inner.append(content_2);
      inner.append(content_3);
      inner.append(content_4);
      success.append(inner);

      jQuery('.loading-overlay').append(success);

      jQuery(".dct-success").addClass("hide");
      setTimeout(function() {
        jQuery(".dct-success").removeClass("hide");
      }, 10);
    }
  </script>
  <style>
    .loading-overlay {
      position: fixed;
      top: 0;
      width: 100%;
      height: 100vh;
      background: #fff;
      display: none;
    }

    .loading-overlay.load {
      display: block;
      animation: fade-in 1s cubic-bezier(0.5, 0, 0.5, 1);
    }

    .spinner {
      display: inline-block;
      width: 80px;
      height: 80px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -100%);
    }

    .spinner div {
      animation: spine 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      transform-origin: 40px 40px;
    }

    .spinner div:after {
      content: " ";
      display: block;
      position: absolute;
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: rgb(31, 149, 255);
      margin: -4px 0 0 -4px;
    }

    .spinner div:nth-child(1) {
      animation-delay: -0.036s;
    }

    .spinner div:nth-child(1):after {
      top: 63px;
      left: 63px;
    }

    .spinner div:nth-child(2) {
      animation-delay: -0.072s;
    }

    .spinner div:nth-child(2):after {
      top: 68px;
      left: 56px;
    }

    .spinner div:nth-child(3) {
      animation-delay: -0.108s;
    }

    .spinner div:nth-child(3):after {
      top: 71px;
      left: 48px;
    }

    .spinner div:nth-child(4) {
      animation-delay: -0.144s;
    }

    .spinner div:nth-child(4):after {
      top: 72px;
      left: 40px;
    }

    .spinner div:nth-child(5) {
      animation-delay: -0.18s;
    }

    .spinner div:nth-child(5):after {
      top: 71px;
      left: 32px;
    }

    .spinner div:nth-child(6) {
      animation-delay: -0.216s;
    }

    .spinner div:nth-child(6):after {
      top: 68px;
      left: 24px;
    }

    .spinner div:nth-child(7) {
      animation-delay: -0.252s;
    }

    .spinner div:nth-child(7):after {
      top: 63px;
      left: 17px;
    }

    .spinner div:nth-child(8) {
      animation-delay: -0.288s;
    }

    .spinner div:nth-child(8):after {
      top: 56px;
      left: 12px;
    }

    @keyframes spine {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes fade-in {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .success {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -100%);
    }

    .hide {
      display: none;
    }

    .dct-icon {
      width: 80px;
      height: 80px;
      border: 4px solid gray;
      -webkit-border-radius: 40px;
      border-radius: 40px;
      border-radius: 50%;
      margin: 20px auto;
      padding: 0;
      position: relative;
      box-sizing: content-box;
    }

    .dct-icon.dct-success {
      border-color: rgb(31, 149, 255);
    }

    .dct-icon.dct-success::before,
    .dct-icon.dct-success::after {
      content: '';
      -webkit-border-radius: 40px;
      border-radius: 40px;
      border-radius: 50%;
      position: absolute;
      width: 60px;
      height: 120px;
      background: white;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .dct-icon.dct-success::before {
      -webkit-border-radius: 120px 0 0 120px;
      border-radius: 120px 0 0 120px;
      top: -7px;
      left: -33px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 60px 60px;
      transform-origin: 60px 60px;
    }

    .dct-icon.dct-success::after {
      -webkit-border-radius: 0 120px 120px 0;
      border-radius: 0 120px 120px 0;
      top: -11px;
      left: 30px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
      -webkit-transform-origin: 0px 60px;
      transform-origin: 0px 60px;
    }

    .dct-icon.sa-success .dct-placeholder {
      width: 80px;
      height: 80px;
      border: 4px solid rgba(76, 175, 80, .5);
      -webkit-border-radius: 40px;
      border-radius: 40px;
      border-radius: 50%;
      box-sizing: content-box;
      position: absolute;
      left: -4px;
      top: -4px;
      z-index: 2;
    }

    .dct-icon.dct-success .dct-fix {
      width: 5px;
      height: 90px;
      background-color: white;
      position: absolute;
      left: 28px;
      top: 8px;
      z-index: 1;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    .dct-icon.dct-success.animate::after {
      -webkit-animation: rotatePlaceholder 4.25s ease-in;
      animation: rotatePlaceholder 4.25s ease-in;
    }

    .dct-icon.dct-success {
      border-color: transparent\9;
    }

    .dct-icon.dct-success .dct-line.dct-tip {
      -ms-transform: rotate(45deg) \9;
    }

    .dct-icon.dct-success .dct-line.dct-long {
      -ms-transform: rotate(-45deg) \9;
    }

    .animateSuccessTip {
      -webkit-animation: animateSuccessTip 0.75s;
      animation: animateSuccessTip 0.75s;
    }

    .animateSuccessLong {
      -webkit-animation: animateSuccessLong 0.75s;
      animation: animateSuccessLong 0.75s;
    }

    @-webkit-keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      84% {
        width: 55px;
        right: 0px;
        top: 35px;
      }

      100% {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }

    @-webkit-keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }

      100% {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }

    @keyframes animateSuccessTip {
      0% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      54% {
        width: 0;
        left: 1px;
        top: 19px;
      }

      70% {
        width: 50px;
        left: -8px;
        top: 37px;
      }

      84% {
        width: 17px;
        left: 21px;
        top: 48px;
      }

      100% {
        width: 25px;
        left: 14px;
        top: 45px;
      }
    }

    @keyframes animateSuccessLong {
      0% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      65% {
        width: 0;
        right: 46px;
        top: 54px;
      }

      84% {
        width: 55px;
        right: 0px;
        top: 35px;
      }

      100% {
        width: 47px;
        right: 8px;
        top: 38px;
      }
    }

    .dct-icon.dct-success .dct-line {
      height: 5px;
      background-color: rgb(31, 149, 255);
      display: block;
      border-radius: 2px;
      position: absolute;
      z-index: 2;
    }

    .dct-icon.dct-success .dct-line.dct-tip {
      width: 25px;
      left: 14px;
      top: 46px;
      -webkit-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .dct-icon.dct-success .dct-line.dct-long {
      width: 47px;
      right: 8px;
      top: 38px;
      -webkit-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    @-webkit-keyframes rotatePlaceholder {
      0% {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
      }

      5% {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
      }

      12% {
        transform: rotate(-405deg);
        -webkit-transform: rotate(-405deg);
      }

      100% {
        transform: rotate(-405deg);
        -webkit-transform: rotate(-405deg);
      }
    }

    @keyframes rotatePlaceholder {
      0% {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
      }

      5% {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
      }

      12% {
        transform: rotate(-405deg);
        -webkit-transform: rotate(-405deg);
      }

      100% {
        transform: rotate(-405deg);
        -webkit-transform: rotate(-405deg);
      }
    }
  </style>
	<?php
	?>
	<?php
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_shortcode("pmpro_member_directory", "pmpromd_shortcode");
