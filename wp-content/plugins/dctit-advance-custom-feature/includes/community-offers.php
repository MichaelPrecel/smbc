<?php

/*create event custom post type. change $keyword and $slug to update CPT */
function dct_cpt_offers() {
	$keyword = 'Offer';
	$slug = 'coffers';
	$labels = array(
			'name' => $keyword .'s',
			'singular_name' => $keyword,
			'add_new' => 'Add New',
			'add_new_item' => 'Add New ' . $keyword,
			'edit' => 'Edit',
			'edit_item' => 'Edit ' . $keyword .'s',
			'new_item' => 'New ' . $keyword .'s',
			'all_items' => 'All ' . $keyword .'s',
			'view' => 'View',
			'view_item' => 'View ' . $keyword .'s',
			'search_items' => 'Search ' . $keyword .'s',
			'not_found' => 'No ' . $keyword . ' found',
			'not_found_in_trash' => 'No ' . $keyword . ' found in Trash',
			'parent' => 'Parent ' . $keyword,
			'menu_name' => $keyword .'s'
	);

	$args = array(
			'labels' => $labels,
			'public' => true,
			'menu_position' => '5.1',
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => $slug),
			'supports' => array( 'title', 'author' ),
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'map_meta_cap' => true,
			'register_meta_box_cb' => 'dctit_com_offer_status_metaboxes',
	);

	register_post_type( $slug, $args );	
	
	
}

function dctit_com_offer_status_metaboxes(){
    add_meta_box(
		'com_offer_status',
		'Offer Status',
		'dctit_com_offer_status',
		'coffers',
		'side',
		'high'
	);
	
	add_meta_box(
		'com_offer_details',
		'Offer Details',
		'dctit_com_offer_details',
		'coffers',
		'normal',
		'default'
	);
}

add_action( 'init', 'dct_cpt_offers' );


function dctit_com_offer_status() {
    global $post;
    $value = get_post_meta($post->ID, 'com_offer_status', true);
    ?>
    <select name="com_offer_status" id="com_offer_status" class="postbox">
        <option value="-1"<?php selected($value, '-1'); ?>>Pending</option>
        <option value="1" <?php selected($value, '1'); ?>>Accepted</option>
        <option value="0" <?php selected($value, '0'); ?>>Rejected</option>
    </select>
    <?php
}

function dctit_com_offer_details() {
    global $post;
    $value = get_post_meta($post->ID, 'com_offer_details', true);
    ?>
    <textarea style="width:100%;min-height:100px;" type="textarea" class="form-control" id="com_offer_details" name="com_offer_details" ><?php echo $value ?></textarea>
    <?php
}	

// save meta box
add_action('save_post', 'dctit_coffer_save_postdata');

function dctit_coffer_save_postdata($post_id)
{
    if (array_key_exists('com_offer_status', $_POST)) {
        update_post_meta(
            $post_id,
            'com_offer_status',
            $_POST['com_offer_status']
        );
    }
    
    if (array_key_exists('com_offer_details', $_POST)) {
        update_post_meta(
            $post_id,
            'com_offer_details',
            $_POST['com_offer_details']
        );
    }
    
}


// Add to our admin_init function
add_filter('manage_coffers_posts_columns', 'dctit_add_post_columns');

function dctit_add_post_columns($columns) {
    $columns['offer_details'] = 'Offer Details';
    $columns['offer_status'] = 'Offer Status';
    $columns['offer_avail'] = 'Availability';
    return $columns;
}

add_filter( 'manage_edit-coffers_sortable_columns', 'dctit_custom_column_sortable_columns');
function dctit_custom_column_sortable_columns( $columns ) {
   $columns['offer_status'] = 'com_offer_status';
   $columns['offer_avail'] = 'com_offer_availability';
  return $columns;
}

// Add to our admin_init function
add_action('manage_coffers_posts_custom_column', 'dctit_render_post_columns', 10, 2);

function dctit_render_post_columns($column_name, $id) {
    switch ($column_name) {
    case 'offer_details':
        // show my_field
        $offer_details = get_post_meta($id, 'com_offer_details', true);
        echo $offer_details;
        break;
    case 'offer_status':
        // show my_field
        $xoffer_status = get_post_meta($id, 'com_offer_status', true);
        $offer_status = intval($xoffer_status);
        if($offer_status == -1){ echo "Pending"; }
        elseif($offer_status == 1){ echo "Accepted"; }
        elseif($offer_status == 0){ echo "Rejected"; }
        else { echo "NA"; }
        break;
    case 'offer_avail':
        $xoffer_avail = get_post_meta($id, 'com_offer_availability', true);
        $offer_avail = intval($xoffer_avail);
        if($offer_avail == 1){ echo "Active"; }
        elseif($offer_avail == 0){ echo "Inactive"; }
        else { echo "NA"; }
        
    }
    
}

add_action( 'pre_get_posts', 'dctit_coffers_orderby' );
function dctit_coffers_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }
if ( in_array ( $query->get('post_type'), array('coffers') ) ) {
    if ( 'com_offer_status' === $query->get( 'orderby') ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_key', 'com_offer_status' );
        $query->set( 'meta_type', 'numeric' );
    }  
}
if ( in_array ( $query->get('post_type'), array('coffers') ) ) {
    if ( 'com_offer_availability' === $query->get( 'orderby') ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_key', 'com_offer_availability' );
        $query->set( 'meta_type', 'numeric' );
    }  
}

}