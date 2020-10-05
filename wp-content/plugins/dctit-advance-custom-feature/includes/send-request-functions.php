<?php


function dctit_logged_out_user_naa(){
    $result['type'] = "Need to login";
    $result = json_encode($result);
    echo $result;
    die();
}
/**
 * send a request
 * https://portfolio.thedct.com/amc/website/smbc/wp-admin/admin-ajax.php?action=send_request&sender_id=1&recipient_id=2&connect_reason=bolbona&connect_message=balchal&connection_type=offer
 */
 
add_action("wp_ajax_send_request", "dctit_send_request");
add_action("wp_ajax_nopriv_send_request", "dctit_logged_out_user_naa");


function dctit_send_request(){
    
    //need to add nonce later
    
    
    $sender_id = wp_strip_all_tags($_REQUEST['sender_id']);
    $recipient_id = intval(wp_strip_all_tags($_REQUEST['recipient_id']));
    $connect_reason = wp_strip_all_tags($_REQUEST['reason_for_connection']);
    $connect_message = wp_strip_all_tags($_REQUEST['message']);
    $connection_type = wp_strip_all_tags($_REQUEST['post_type']);

    if(empty($connection_type)){
        $connection_type = "directory";
    }
    //set time zone
    $dt = new DateTime('now', new DateTimezone('Australia/Melbourne'));
    $date_time = $dt->format('F j, Y, g:i a');

    //get sender details
    $sender_name = get_the_author_meta('display_name',$sender_id);
    $sender_email = get_the_author_meta('user_email',$sender_id);
    
    //get recipient detrails
    $recipient_name = get_the_author_meta('display_name',$recipient_id);
    $recipient_email = get_the_author_meta('user_email',$recipient_id);
    
    $cp = get_user_meta($sender_id, 'user_cp_dct' , true);

    if($cp != 0){
        $cp =  $cp - 1;
        update_user_meta($sender_id, 'user_cp_dct', $cp);
    }
    
    global $wpdb;
    $table = $wpdb->prefix.'send_request_log';
    $data = array(
        'date_time' => $date_time, 
        'sender' => "$sender_name", 
        'recipient' => $recipient_name, 
        'sender_email' => $sender_email, 
        'recipient_email' => $recipient_email, 
        'message' => $connect_message, 
        'reason' => $connect_reason,
        'status' => "pending", 
        'connect_type' => $connection_type
        );


    $success = $wpdb->insert($table,$data);

    if($success){

        //email admin about this new entry
        $admin_email = get_option( 'admin_email' );
        $headers[] = 'From: SMBC <mahmud.2345@thedct.com>';
        $subject = "New Connect Request";
        $message = "There is a new connect request in SMBC. Please review it.";
        wp_mail( $admin_email, $subject, $message, $headers );

        $result['type'] = "success";
        
    }else{
        $result['type'] = "fail";
    }
    $result = json_encode($result);
    echo $result;
    die();
}