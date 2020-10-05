<?php


function dctit_logged_out_user(){
    $result['type'] = "Need to login";
    $result = json_encode($result);
    echo $result;
}
/**
 * create an offer
 * https://portfolio.thedct.com/amc/website/smbc/wp-admin/admin-ajax.php?action=add_coffer&co_title=title1&co_details=details1&co_author_id=1
 */
 
add_action("wp_ajax_add_coffer", "dctit_add_coffers");
add_action("wp_ajax_nopriv_add_coffer", "dctit_logged_out_user");


function dctit_add_coffers(){
    
    //need to add nonce later
    
    
    $offer_title = wp_strip_all_tags($_REQUEST['co_title']);
    $offer_author_id = intval(wp_strip_all_tags($_REQUEST['co_author_id']));
    $offer_details = wp_strip_all_tags($_REQUEST['co_details']);
    
    
    $my_offer = array(
      'post_title'    => $offer_title,
      'post_content'  => "",
      'post_status'   => 'publish',
      'post_author'   => $offer_author_id,
      'post_type'     => 'coffers'
    );
     

    $action = wp_insert_post( $my_offer );
    if($action != 0){
        //offer successful
        $post_id = $action;
        add_post_meta($post_id, 'com_offer_details', $offer_details, true);
        //set the default status as pending(-1)
        add_post_meta($post_id, 'com_offer_status', '-1', true);
        //emable a offer by default
        add_post_meta($post_id, 'com_offer_availability', '1', true);
        
        //email admin about this new entry
        $admin_email = get_option( 'admin_email' );
        $headers[] = 'From: SMBC <mahmud.2345@thedct.com>';
        $subject = "New Offer Created in SMBC";
        $message = "There is a new offer in SMBC. Please review it.";
        wp_mail( $admin_email, $subject, $message, $headers );
        $result['type'] = "success";
        
    }else{
        $result['type'] = "fail";
    }
    $result = json_encode($result);
    echo $result;
    die();
}


/**
 * update an offer
 * https://portfolio.thedct.com/amc/website/smbc/wp-admin/admin-ajax.php?action=update_coffer&co_title=titlenew1&co_details=detailsnew1&co_author_id=4&co_id=144
 */
 
add_action("wp_ajax_update_coffer", "dctit_update_coffer");
add_action("wp_ajax_nopriv_update_coffer", "dctit_logged_out_user");

function dctit_update_coffer(){
    $offer_title = wp_strip_all_tags($_REQUEST['co_title']);
    $offer_details = wp_strip_all_tags($_REQUEST['co_details']);
    $author_id = intval(wp_strip_all_tags($_REQUEST['co_author_id']));
    $post_id = wp_strip_all_tags($_REQUEST['co_id']);
    if(dctit_is_author($post_id, $author_id)){
        $offer_q = array(
            'ID'           => $post_id,
            'post_title'   => $offer_title,
        );
        
        wp_update_post( $offer_q );
        update_post_meta($post_id, 'com_offer_details', $offer_details);
        update_post_meta($post_id, 'com_offer_status', '-1');
        //update_post_meta($post_id, 'com_offer_availability', '1');
        // Need to send notification by email
        $result['type'] = "success";
        
    }else{
        $result['type'] = "fail";
    }
    $result = json_encode($result);
    echo $result;
    die();
}


/**
 * set availability of the offer
 * $action should be 1 and 0. 1 = available/ 0 not available
 * https://portfolio.thedct.com/amc/website/smbc/wp-admin/admin-ajax.php?action=set_coffer_availability&co_id=146&co_author_id=1&co_avail=0
 */
 
add_action("wp_ajax_set_coffer_availability", "dctit_set_offer_availability");
add_action("wp_ajax_nopriv_set_coffer_availability", "dctit_logged_out_user");

function dctit_set_offer_availability(){
    $post_id = wp_strip_all_tags($_REQUEST['co_id']);
    $author_id = wp_strip_all_tags($_REQUEST['co_author_id']);
    $action = wp_strip_all_tags($_REQUEST['co_avail']);
    if(dctit_is_author($post_id, $author_id)){
        update_post_meta($post_id, 'com_offer_availability', $action);
        $result['type'] = "success";
        
    }else{
        //you don't have permission
        $result['type'] = "fail";
        
    }
    $result = json_encode($result);
    echo $result;
    die();
}
////not yet tested
////dctit_set_offer_availability();

/**
 * delete offer
 * https://portfolio.thedct.com/amc/website/smbc/wp-admin/admin-ajax.php?action=delete_co&co_id=146&co_author_id=1
 */
 
add_action("wp_ajax_delete_co", "dctit_delete_com_offer");
add_action("wp_ajax_nopriv_delete_co", "dctit_logged_out_user");

function dctit_delete_com_offer(){
    
    $post_id = wp_strip_all_tags($_REQUEST['co_id']);
    $author_id = wp_strip_all_tags($_REQUEST['co_author_id']);
    if(dctit_is_author($post_id, $author_id)){
        wp_delete_post($post_id);
        $result['type'] = "success";
        
    }else{
        $result['type'] = "fail";
    }
    $result = json_encode($result);
    echo $result;
    die();
    
}

/**
 * Validate if the author is valid for the post
 */
function dctit_is_author($post_id, $author_id){
    $this_post_author_id = get_post_field('post_author', $post_id);
    //verify post author
    if($this_post_author_id == intval($author_id)){
        return true;
    }else{
        return false;
    }
}

/**
 * Show all offer
 */
function dctit_list_offer($author_id = ""){
    if($author_id != ''){
        $id = intval($author_id);

        if($id == get_current_user_id()){
        
        $args = array(  
            'author' => $id,
            'post_type' => 'coffers',
            'post_status' => 'publish',
            'posts_per_page' => -1, 
            'orderby' => 'date', 
            'order' => 'ASC'
            
        );  
        

        }else{
        $args = array(  
            'author' => $id,
            'post_type' => 'coffers',
            'post_status' => 'publish',
            'posts_per_page' => -1, 
            'orderby' => 'date', 
            'order' => 'ASC', 
            'meta_query' => array(
                'relation' => 'AND',
                array(
                  'key' => 'com_offer_availability',
                  'value' => '1',
                  'compare' => '='
                ),
                array(
                  'key' => 'com_offer_status',
                  'value' => '1',
                  'compare' => '='
                )
            )
        );    
        }
               
    }else{
        $args = array(  
            'post_type' => 'coffers',
            'post_status' => 'publish',
            'posts_per_page' => -1, 
            'orderby' => 'date', 
            'order' => 'ASC', 
            'meta_query' => array(
                'relation' => 'AND',
                array(
                  'key' => 'com_offer_availability',
                  'value' => '1',
                  'compare' => '='
                ),
                array(
                  'key' => 'com_offer_status',
                  'value' => '1',
                  'compare' => '='
                )
            )
        );
    }


    $loop = new WP_Query( $args ); 
    $com_offer = array();
    $com_offers = array();
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $post_id = get_the_ID();
        
        $com_offer["offer_id"] = $post_id;
        $com_offer["offer_title"] = get_the_title();
        $com_offer["offer_details"] = get_post_meta($post_id, 'com_offer_details', true);
        $com_offer["offer_author_name"] = get_the_author_meta('display_name');
        $login_name = get_the_author_meta('user_login');
        $url_name = str_replace(' ', '-', $login_name);
        //need profile url from client to set this
        $com_offer["offer_author_id"] = get_the_author_meta('ID');
        $com_offer["offer_author_profile"] = get_site_url()."/membership-account/profile?pu=".$url_name;
        $com_offer["offer_author_position"] = get_the_author_meta('position');
        $com_offer["offer_author_company"] = get_the_author_meta('company');
        $com_offer["offer_availability"] = get_post_meta($post_id, 'com_offer_availability', true);
        $status = get_post_meta($post_id, 'com_offer_status', true);
        
        if($status == -1){
            $com_offer["offer_status"] = "Under Review";
        }elseif($status == 1){
            $com_offer["offer_status"] = "Accepted";
        }else{
            $com_offer["offer_status"] = "Rejected";
        }
        
        
        $com_offers[] = $com_offer;
    endwhile;

    wp_reset_postdata(); 
    return $com_offers;
}



