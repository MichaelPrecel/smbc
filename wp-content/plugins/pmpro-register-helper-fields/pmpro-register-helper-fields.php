<?php
/*
Plugin Name: Register Helper Example
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Register Helper Initialization Example
Version: .2
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
//we have to put everything in a function called on init, so we are sure Register Helper is loaded
function my_pmprorh_init()
{
	//don't break if Register Helper is not loaded
	if(!function_exists( 'pmprorh_add_registration_field' )) {
		return false;
	}
	
	//define the fields
	$fields = array();
	$fields[] = new PMProRH_Field(
		'company',						// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label'		=> 'Company',			// custom field label
			'class'		=> 'company',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> true,			  // make this field required
			// 'levels'		=> array(1,2)		// only levels 1 and 2 should have the company field
		)
  );
  $fields[] = new PMProRH_Field(
		'position',						// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label'		=> 'Position',			// custom field label
			'class'		=> 'position',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> true,			  // make this field required
		)
	);
  $fields[] = new PMProRH_Field(
		'phone',						// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label'		=> 'Phone',			// custom field label
			'class'		=> 'phone',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> true,			  // make this field required
		)
  );
  $fields[] = new PMProRH_Field(
		'linkedin',						// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label'		=> 'LinkedIn',			// custom field label
			'class'		=> 'linkedin',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> false,			  // make this field required
		)
  );
  $fields[] = new PMProRH_Field(
		'website',						// input name, will also be used as meta key
		'text',							// type of field
		array(
			'label'		=> 'Website',			// custom field labe
			'class'		=> 'website',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> false			  // make this field required
		)
  );
  $fields[] = new PMProRH_Field(
		'description',						// input name, will also be used as meta key
		'textarea',							// type of field
		array(
			'label'		=> 'What does your business do best?',			// custom field label
			'class'		=> 'description',			// custom class
			'profile'	=> true,			    // show in user profile
			'required'	=> true			  // make this field required
		)
  );
  // $fields[] = new PMProRH_Field(
	// 	'audio_intro',						// input name, will also be used as meta key
	// 	'file',							// type of field
	// 	array(
	// 		'label'		=> 'Audio introduction',			// custom field label
	// 		'class'		=> 'audio-intro',			// custom class
	// 		'profile'	=> true,			    // show in user profile
  //     'required'	=> false			  // make this field required
  //     'accept' => 'audio/*'
	// 	)
  // );
	
	//add the fields into a new checkout_boxes are of the checkout page
	foreach($fields as $field)
		pmprorh_add_registration_field(
			'checkout_boxes',				// location on checkout page
			$field						// PMProRH_Field object
		);
	//that's it. see the PMPro Register Helper readme for more information and examples.
}
add_action( 'init', 'my_pmprorh_init' );
