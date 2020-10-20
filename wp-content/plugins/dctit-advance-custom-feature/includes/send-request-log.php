<?php 

//add menu page
add_action('admin_menu', 'dct_init_admin_menu');
function dct_init_admin_menu()
{
    add_menu_page('Connect Request', 'Connect Request', 'manage_options', 'onetoonelog-entries', '', '', 25);
    add_submenu_page('onetoonelog-entries', 'Entries', 'Entries', 'manage_options', 'onetoonelog-entries', 'dct_onetoonelog_entries');
}



/*************************************************************
 ****************One to one communication Log*****************
 *************************************************************/
function dct_onetoonelog_entries()
{

    global $wpdb;

    // set database table columns
    $dct_db_select_key_arr = array(
        'id','date_time', 'sender', 'recipient', 'sender_email', 'recipient_email', 'message', 'reason', 'status', 'connect_type'
    );
    // set column name in view
    $dct_db_select_name_arr = array(
        'ID', 'Date & Time', 'Sender', 'Recipient', 'Sender Email', 'Recipient Email', 'Message', 'Reason', 'Status', 'Connection Type'
    );

    //default scenario
    if (!isset($_GET['connect'])) {
        $dct_db_select_key_str = implode(', ', $dct_db_select_key_arr);
        $dct_query = "SELECT " . $dct_db_select_key_str . " FROM {$wpdb->base_prefix}send_request_log";
        $dct_array_key_size = count($dct_db_select_key_arr);

        $dct_table_title = 'All Entry List';
    }else{
       
        $dct_table_title = 'Connection Successful ( <a href="?page=onetoonelog-entries"> View All </a> )';
        $log_id = $_GET["connect"];
        $dct_db_select_key_str = implode(', ', $dct_db_select_key_arr);
        $dct_query = "SELECT " . $dct_db_select_key_str . " FROM {$wpdb->base_prefix}send_request_log WHERE id =".intval($log_id);
        $dct_array_key_size = count($dct_db_select_key_arr);
        $dct_connect_single_entry = $wpdb->get_results($dct_query, 'ARRAY_N');
        
        $sender_name = $dct_connect_single_entry[0][2];
        $sender_email = $dct_connect_single_entry[0][4];
        $sender_reason = $dct_connect_single_entry[0][7];
        $sender_message = $dct_connect_single_entry[0][6];
        $recipient_email = $dct_connect_single_entry[0][5];
        
        //connect two parties
        $admin_email = get_option( 'admin_email' );
        $headers[] = 'From: '.$sender_name.' <'.$sender_email.'>';
        $headers[] = 'Cc: Site Admin <'.$admin_email.'>';
        $subject = $sender_reason;
        $message = $sender_message;
        $success = wp_mail( $recipient_email, $subject, $message, $headers );
        if($success){
          //change the pending into connected.
          $data = [ 'status' => 'Connected' ]; // NULL value.
          $where = [ 'id' => intval($log_id) ]; // NULL value in WHERE clause.
          $wpdb->update( $wpdb->prefix . 'send_request_log', $data, $where ); // Also works in this case.
        }
        wp_reset_query();
    }
    

?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js" integrity="sha256-VAvG3sHdS5LqTT+5A/aeq/bZGa/Uj04xKxY8KM/w9EE=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>


    <script language='javascript' type='text/javascript'>
        $(document).ready(function() {
            $('#example').dataTable({
                dom: 'T<"clear">lfrtip',
                tableTools: {
                    "sSwfPath": "../swf/copy_csv_xls_pdf.swf"
                }
            });
        });
    </script>
    <style>
        #wpwrap {
            overflow: scroll
        }
        th:nth-child(1), td:nth-child(1) {
            width: 4% !important;
            text-align: center !important;
        }
        
        th:nth-child(2), td:nth-child(2) {
            width: 8% !important;
            text-align: center !important;
        }
        th:nth-child(3), td:nth-child(3) {
            width: 8% !important;
            text-align: center !important;
        }
        th:nth-child(4), td:nth-child(4) {
            width: 8% !important;
            text-align: center !important;
        }
        th:nth-child(5), td:nth-child(5) {
            width: 40% !important;
            text-align: center !important;
        }
        th:nth-child(6), td:nth-child(6) {
            width: 20% !important;
            text-align: center !important;
        }
        th:nth-child(7), td:nth-child(7) {
            width: 8% !important;
            text-align: center !important;
        }
        th:nth-child(7), td:nth-child(8) {
            width: 8% !important;
            text-align: center !important;
        }
        
        th, td{
            border: 1px solid #ccc
        }
        div#example_length {
            margin-bottom: 12px;
        }

    </style>



    <div class="wrap">
    

<?php
    //main query execution
    $dct_entry_data = $wpdb->get_results($dct_query, 'ARRAY_N');
    $dct_db_num_row = $wpdb->num_rows;





    echo '<h3>' . $dct_table_title . '</h3>';

    echo '<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>';
    for ($j = 0; $j < $dct_array_key_size; $j++) {
        if($j==4 || $j==5){
            continue;
            }
        echo '<th>';
        echo $dct_db_select_name_arr[$j];
        echo '</th>';
    }

    echo '</tr></thead><tfoot><tr>';
    for ($j = 0; $j < $dct_array_key_size; $j++) {
        if($j==4 || $j==5){
            continue;
            }
        echo '<th>';
        echo $dct_db_select_name_arr[$j];
        echo '</th>';
    }

    echo '</tr></tfoot><tbody>';
    for ($i = 0; $i < $dct_db_num_row; $i++) {
        echo '<tr>';
        for ($j = 0; $j < $dct_array_key_size; $j++) {
            if($j==4 || $j==5){
            continue;
            }elseif($j == 2){
                echo '<td>';
                echo "<a href='mailto:".$dct_entry_data[$i][$j+2]."'>".$dct_entry_data[$i][$j]."</a>";
                echo '</td>';  
                
            }elseif($j == 3){
                echo '<td>';
                echo "<a href='mailto:".$dct_entry_data[$i][$j+2]."'>".$dct_entry_data[$i][$j]."</a>";
                echo '</td>';  
                
            }elseif($j == 8){
                echo '<td>';
                if($dct_entry_data[$i][$j] == "pending"){
                    echo "<a href='?page=onetoonelog-entries&connect=".$dct_entry_data[$i][$j-8]."'>".$dct_entry_data[$i][$j]."</a>";
                }else{
                    echo $dct_entry_data[$i][$j];
                }
                echo '</td>';  
                
            }else{
                echo '<td>';
                echo $dct_entry_data[$i][$j];
                echo '</td>';    
            }

        }

        echo '</tr>';
    }
    echo '</tbody></table>';

    echo '</div>'; //end div (wrap)
}

